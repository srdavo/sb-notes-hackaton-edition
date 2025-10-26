<?php
class Feeling extends ActiveRecord {
    protected static $table = "feelings";

    protected static $columns = [
        "id",
        "user_id",
        "note_id",
    ];

    public $id;
    public $user_id;
    public $note_id;

    public function __construct($args = []) {
        $this->id = $args["id"] ?? NULL;
        $this->user_id = $args["user_id"] ?? "";
        $this->note_id = $args["note_id"] ?? NULL;
    }

    /**
     * Auto-detect available columns for feelings
     */
    private static function getAvailableColumns() {
        $columns = [];
        foreach (static::$columns as $column) {
            $columns[$column] = "f.$column";
        }
        return $columns;
    }

    /**
     * Build base query with common filters (user and row_status)
     */
    private static function buildBaseQuery($data_array, $select_clause) {
        $query = "SELECT $select_clause FROM feelings AS f";

        // Base conditions
        $params = [$data_array['user_id']];
        $types = "i";

        // Some tables/models include a row_status column for soft-deletes;
        // feelings may not always have that column, so only include it when available.
        if (in_array('row_status', static::$columns)) {
            $query .= " WHERE f.user_id = ? AND f.row_status = 1";
        } else {
            $query .= " WHERE f.user_id = ?";
        }

        // Apply additional filters
        [$query, $params, $types] = self::applyFilters($query, $params, $types, $data_array);

        return [$query, $params, $types];
    }

    /**
     * Execute prepared statement and return results
     */
    private static function executeQuery($query, $params, $types, $fetch_all = true) {
        $stmt = self::$db->prepare($query);
        if (!$stmt) {
            throw new Exception("An unexpected error occurred. Please try again later.", 1);
        }

        $stmt->bind_param($types, ...$params);
        if (!$stmt->execute()) {
            throw new Exception("An error occurred while processing your request. Please try again later.", 1);
        }

        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("An unexpected error occurred. Please try again later.", 1);
        }

        return $fetch_all ? $result->fetch_all(MYSQLI_ASSOC) : $result->fetch_assoc();
    }

    /**
     * Post-process feelings data for sanitization and typing
     */
    private static function postProcessFeelings($feelings, $is_single = false) {
        if ($is_single) {
            $feelings = [$feelings];
        }

        foreach ($feelings as &$feeling) {
            if (isset($feeling['id'])) {
                $feeling['id'] = (int) $feeling['id'];
            }
            if (isset($feeling['user_id'])) {
                $feeling['user_id'] = (int) $feeling['user_id'];
            }
            if (isset($feeling['note_id'])) {
                $feeling['note_id'] = (int) $feeling['note_id'];
            }
        }

        return $is_single ? $feelings[0] : $feelings;
    }

    /**
     * Apply filters to query (row_status override, search)
     */
    private static function applyFilters($query, $params, $types, $data_array) {
        // Row status override (only if the model/table actually has row_status)
        if (in_array('row_status', static::$columns)) {
            if (isset($data_array['filter_row_status']) && $data_array['filter_row_status'] !== 1) {
                $query = str_replace('f.row_status = 1', 'f.row_status = ?', $query);
                $params[] = $data_array['filter_row_status'];
                $types .= 'i';
            }
        }

        // Search filter across note relations (if provided)
        if (isset($data_array['filter_search']) && !empty($data_array['filter_search'])) {
            $search = "%" . $data_array['filter_search'] . "%";
            // feelings table itself doesn't have textual columns; join on notes could be used, but support basic search where note_id matches numeric search
            if (is_numeric($data_array['filter_search'])) {
                $query .= " AND (f.note_id = ? )";
                $params[] = (int)$data_array['filter_search'];
                $types .= 'i';
            } else {
                // no-op: keeping structure in case higher-level caller uses text searches; safely ignore non-numeric searches for feelings
            }
        }

        return [$query, $params, $types];
    }

    /**
     * Get feelings with optional column selection, pagination and sorting
     */
    public static function getFeelings($data_array) {
        $available_columns = self::getAvailableColumns();
        $select_columns = [];

        // Always include id
        $select_columns[] = 'f.id';

        if (isset($data_array['columns']) && is_array($data_array['columns'])) {
            foreach ($data_array['columns'] as $column) {
                if (isset($available_columns[$column]) && $column !== 'id') {
                    $select_columns[] = $available_columns[$column];
                }
            }
        } else {
            $default_columns = ['id', 'user_id', 'note_id'];
            foreach ($default_columns as $column) {
                if (isset($available_columns[$column])) {
                    $select_columns[] = $available_columns[$column];
                }
            }
        }

        $select_clause = implode(', ', $select_columns);
        [$query, $params, $types] = self::buildBaseQuery($data_array, $select_clause);

        // Sorting & pagination
        $order_by = isset($data_array['order_by']) && in_array($data_array['order_by'], ['note_id', 'id'])
            ? $data_array['order_by']
            : 'id';
        $order_direction = isset($data_array['order_direction']) && in_array(strtoupper($data_array['order_direction']), ['ASC', 'DESC'])
            ? strtoupper($data_array['order_direction'])
            : 'ASC';

        $query .= " ORDER BY f.$order_by $order_direction LIMIT ? OFFSET ?";
        $params[] = $data_array['limit'];
        $params[] = $data_array['offset'];
        $types .= 'ii';

        $feelings = self::executeQuery($query, $params, $types, true);
        return self::postProcessFeelings($feelings);
    }

    /**
     * Get total rows for feelings matching filters
     */
    public static function getTotalRows($data_array) {
        [$query, $params, $types] = self::buildBaseQuery($data_array, "COUNT(f.id) as total");
        $result = self::executeQuery($query, $params, $types, false);
        return (int)$result['total'];
    }

    /**
     * Get statistics for feelings (total, active, inactive)
     */
    public static function getStats($data_array) {
        // If the table has a row_status column, provide active/inactive breakdowns.
        if (in_array('row_status', static::$columns)) {
            $select_clause = 
                "COUNT(f.id) as total_feelings,"
                . " SUM(CASE WHEN f.row_status = 1 THEN 1 ELSE 0 END) as count_active,"
                . " SUM(CASE WHEN f.row_status = 0 THEN 1 ELSE 0 END) as count_inactive";

            $query = "SELECT $select_clause FROM feelings AS f WHERE f.user_id = ?";
            $params = [$data_array['user_id']];
            $types = 'i';

            // Apply search filter numeric only
            if (isset($data_array['filter_search']) && !empty($data_array['filter_search']) && is_numeric($data_array['filter_search'])) {
                $query .= " AND f.note_id = ?";
                $params[] = (int)$data_array['filter_search'];
                $types .= 'i';
            }

            $result = self::executeQuery($query, $params, $types, false);

            return [
                'total_feelings' => (int)$result['total_feelings'],
                'count_active' => (int)$result['count_active'],
                'count_inactive' => (int)$result['count_inactive']
            ];
        }

        // Fallback for tables without row_status: only total is available.
        $query = "SELECT COUNT(f.id) as total_feelings FROM feelings AS f WHERE f.user_id = ?";
        $params = [$data_array['user_id']];
        $types = 'i';

        if (isset($data_array['filter_search']) && !empty($data_array['filter_search']) && is_numeric($data_array['filter_search'])) {
            $query .= " AND f.note_id = ?";
            $params[] = (int)$data_array['filter_search'];
            $types .= 'i';
        }

        $result = self::executeQuery($query, $params, $types, false);

        return [
            'total_feelings' => (int)$result['total_feelings'],
            // Without row_status we cannot distinguish active/inactive; assume all active
            'count_active' => (int)$result['total_feelings'],
            'count_inactive' => 0
        ];
    }

    /**
     * Get a single feeling by id
     */
    public static function getFeelingData($data_array) {
        $query = "SELECT f.* FROM feelings f WHERE f.id = ? AND f.user_id = ?";
        $params = [$data_array['feeling_id'], $data_array['user_id']];
        $types = 'ii';

        $stmt = self::$db->prepare($query);
        if (!$stmt) {
            throw new Exception("An unexpected error occurred. Please try again later.", 1);
        }

        $stmt->bind_param($types, ...$params);
        if (!$stmt->execute()) {
            throw new Exception("An error occurred while processing your request. Please try again later.", 1);
        }

        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("An unexpected error occurred. Please try again later.", 1);
        }

        $data = $result->fetch_assoc();
        if ($data) {
            $data = self::postProcessFeelings($data, true);
        }

        return $data ?: [];
    }

    /**
     * Legacy compatibility method
     */
    public static function getRowsCount($user_id, $filters) {
        $data_array = [
            'user_id' => $user_id,
            'filter_search' => $filters['search'] ?? null,
            'filter_row_status' => $filters['row_status'] ?? 1
        ];

        return ['count' => self::getTotalRows($data_array)];
    }
}

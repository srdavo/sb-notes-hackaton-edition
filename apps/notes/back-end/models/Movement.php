<?php
class Movement extends ActiveRecord {
    protected static $table = "movements";

    protected static $columns = [
        "id",
        "user_id",
        "note_id",
        "quantity",
        "create_date",
        "update_date",
        "row_status",
    ];

    public $id;
    public $user_id;
    public $note_id;
    public $quantity;
    public $create_date;
    public $update_date;
    public $row_status;

    public function __construct($args = []) {
        $this->id = $args["id"] ?? NULL;
        $this->user_id = $args["user_id"] ?? "";
        $this->note_id = $args["note_id"] ?? NULL;
        $this->quantity = $args["quantity"] ?? NULL;
        $this->create_date = $args["create_date"] ?? NULL;
        $this->update_date = $args["update_date"] ?? NULL;
        $this->row_status = $args["row_status"] ?? NULL;
    }

    /**
     * Auto-detect available columns for movements
     */
    private static function getAvailableColumns() {
        $columns = [];
        foreach (static::$columns as $column) {
            $columns[$column] = "m.$column";
        }
        return $columns;
    }

    /**
     * Build base query with common filters (user and optional row_status)
     */
    private static function buildBaseQuery($data_array, $select_clause) {
        $query = "SELECT $select_clause FROM movements AS m";

        // Base conditions
        $params = [$data_array['user_id']];
        $types = "i";

        if (in_array('row_status', static::$columns)) {
            $query .= " WHERE m.user_id = ? AND m.row_status = 1";
        } else {
            $query .= " WHERE m.user_id = ?";
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
     * Post-process movements data for sanitization and typing
     */
    private static function postProcessMovements($movements, $is_single = false) {
        if ($is_single) {
            $movements = [$movements];
        }

        foreach ($movements as &$movement) {
            if (isset($movement['id'])) {
                $movement['id'] = (int) $movement['id'];
            }
            if (isset($movement['user_id'])) {
                $movement['user_id'] = (int) $movement['user_id'];
            }
            if (isset($movement['note_id'])) {
                $movement['note_id'] = (int) $movement['note_id'];
            }
            if (isset($movement['quantity'])) {
                // preserve integers or floats
                $movement['quantity'] = is_numeric($movement['quantity']) ? (0 + $movement['quantity']) : $movement['quantity'];
            }
            // Optional: format dates to ISO if present
            if (isset($movement['create_date']) && !empty($movement['create_date'])) {
                $movement['create_date'] = $movement['create_date'];
            }
            if (isset($movement['update_date']) && !empty($movement['update_date'])) {
                $movement['update_date'] = $movement['update_date'];
            }
        }

        return $is_single ? $movements[0] : $movements;
    }

    /**
     * Apply filters to query (row_status override, search, by note_id, date range)
     */
    private static function applyFilters($query, $params, $types, $data_array) {
        // Row status override (only if the model/table actually has row_status)
        if (in_array('row_status', static::$columns)) {
            if (isset($data_array['filter_row_status']) && $data_array['filter_row_status'] !== 1) {
                $query = str_replace('m.row_status = 1', 'm.row_status = ?', $query);
                $params[] = $data_array['filter_row_status'];
                $types .= 'i';
            }
        }

        // Search filter: numeric -> match note_id or quantity; date string -> match create_date
        if (isset($data_array['filter_search']) && !empty($data_array['filter_search'])) {
            $searchVal = $data_array['filter_search'];

            if (is_numeric($searchVal)) {
                $query .= " AND (m.note_id = ? OR m.quantity = ?)";
                $params[] = (int)$searchVal;
                $params[] = $searchVal + 0;
                $types .= 'ii';
            } else {
                // try to match date-like strings against create_date
                $query .= " AND (m.create_date LIKE ?)";
                $params[] = "%$searchVal%";
                $types .= 's';
            }
        }

        // Filter by explicit note_id
        if (isset($data_array['note_id']) && !empty($data_array['note_id'])) {
            $query .= " AND m.note_id = ?";
            $params[] = (int)$data_array['note_id'];
            $types .= 'i';
        }

        // Date range filters (optional)
        if (isset($data_array['date_from']) && !empty($data_array['date_from'])) {
            $query .= " AND m.create_date >= ?";
            $params[] = $data_array['date_from'];
            $types .= 's';
        }
        if (isset($data_array['date_to']) && !empty($data_array['date_to'])) {
            $query .= " AND m.create_date <= ?";
            $params[] = $data_array['date_to'];
            $types .= 's';
        }

        return [$query, $params, $types];
    }

    /**
     * Get movements with optional column selection, pagination and sorting
     */
    public static function getMovements($data_array) {
        $available_columns = self::getAvailableColumns();
        $select_columns = [];

        // Always include id
        $select_columns[] = 'm.id';

        if (isset($data_array['columns']) && is_array($data_array['columns'])) {
            foreach ($data_array['columns'] as $column) {
                if (isset($available_columns[$column]) && $column !== 'id') {
                    $select_columns[] = $available_columns[$column];
                }
            }
        } else {
            $default_columns = ['id','user_id','note_id','quantity','create_date','update_date'];
            foreach ($default_columns as $column) {
                if (isset($available_columns[$column])) {
                    $select_columns[] = $available_columns[$column];
                }
            }
        }

        $select_clause = implode(', ', $select_columns);
        [$query, $params, $types] = self::buildBaseQuery($data_array, $select_clause);

        // Sorting & pagination
        $order_by = isset($data_array['order_by']) && in_array($data_array['order_by'], ['create_date','id','quantity'])
            ? $data_array['order_by']
            : 'create_date';
        $order_direction = isset($data_array['order_direction']) && in_array(strtoupper($data_array['order_direction']), ['ASC','DESC'])
            ? strtoupper($data_array['order_direction'])
            : 'DESC';

        $query .= " ORDER BY m.$order_by $order_direction LIMIT ? OFFSET ?";
        $params[] = $data_array['limit'];
        $params[] = $data_array['offset'];
        $types .= 'ii';

        $movements = self::executeQuery($query, $params, $types, true);
        return self::postProcessMovements($movements);
    }

    /**
     * Get total rows for movements matching filters
     */
    public static function getTotalRows($data_array) {
        [$query, $params, $types] = self::buildBaseQuery($data_array, "COUNT(m.id) as total");
        $result = self::executeQuery($query, $params, $types, false);
        return (int)$result['total'];
    }

    /**
     * Get statistics for movements (total, active, inactive)
     */
    public static function getStats($data_array) {
        if (in_array('row_status', static::$columns)) {
            $select_clause = 
                "COUNT(m.id) as total_movements,"
                . " SUM(CASE WHEN m.row_status = 1 THEN 1 ELSE 0 END) as count_active,"
                . " SUM(CASE WHEN m.row_status = 0 THEN 1 ELSE 0 END) as count_inactive";

            $query = "SELECT $select_clause FROM movements AS m WHERE m.user_id = ?";
            $params = [$data_array['user_id']];
            $types = 'i';

            if (isset($data_array['note_id']) && !empty($data_array['note_id'])) {
                $query .= " AND m.note_id = ?";
                $params[] = (int)$data_array['note_id'];
                $types .= 'i';
            }

            $result = self::executeQuery($query, $params, $types, false);

            return [
                'total_movements' => (int)$result['total_movements'],
                'count_active' => (int)$result['count_active'],
                'count_inactive' => (int)$result['count_inactive']
            ];
        }

        $query = "SELECT COUNT(m.id) as total_movements FROM movements AS m WHERE m.user_id = ?";
        $params = [$data_array['user_id']];
        $types = 'i';
        if (isset($data_array['note_id']) && !empty($data_array['note_id'])) {
            $query .= " AND m.note_id = ?";
            $params[] = (int)$data_array['note_id'];
            $types .= 'i';
        }

        $result = self::executeQuery($query, $params, $types, false);

        return [
            'total_movements' => (int)$result['total_movements'],
            'count_active' => (int)$result['total_movements'],
            'count_inactive' => 0
        ];
    }

    /**
     * Get a single movement by id
     */
    public static function getMovementData($data_array) {
        $query = "SELECT m.* FROM movements m WHERE m.id = ? AND m.user_id = ?";
        $params = [$data_array['movement_id'], $data_array['user_id']];
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
            $data = self::postProcessMovements($data, true);
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

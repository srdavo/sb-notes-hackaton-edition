<?php
class Note extends ActiveRecord {
    protected static $table = "notes";
    protected static $columns = [
        "id",
        "user_id",
        "note_name",
        "note_content",
        "row_status",
    ];

    public $id;
    public $user_id;
    public $note_name;
    public $note_content;
    public $row_status;

    public function __construct($args = []) {
        $this->id = $args["id"] ?? null;
        $this->user_id = $args["user_id"] ?? "";
        $this->note_name = $args["note_name"] ?? "";
        $this->note_content = $args["note_content"] ?? "";
        $this->row_status = $args["row_status"] ?? 1;
    }

    /**
     * Auto-detects available columns with their SQL expressions
     * This method automatically includes all note columns
     */
    private static function getAvailableColumns() {
        $columns = [];
        
        // Auto-detect note columns (exclude internal columns if needed)
        foreach (static::$columns as $column) {
            if ($column !== 'row_status') { // Exclude internal columns
                $columns[$column] = "n.$column";
            }
        }
        
        return $columns;
    }

    /**
     * Builds the common query structure shared between getNotes and getTotalRows
     */
    private static function buildBaseQuery($data_array, $select_clause) {
        $query = "SELECT $select_clause FROM notes AS n";
        
        // Base conditions
        $query .= " WHERE n.user_id = ? AND n.row_status = 1";
        $params = [$data_array['user_id']];
        $types = "i";
        
        // Apply filters
        [$query, $params, $types] = self::applyFilters($query, $params, $types, $data_array);
        
        return [$query, $params, $types];
    }

    /**
     * Executes a prepared statement with error handling
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
     * Post-processes note data for security and usability
     * Handles sanitization and type casting
     */
    private static function postProcessNotes($notes, $is_single = false) {
        // Handle single note vs array of notes
        if ($is_single) {
            $notes = [$notes];
        }

        foreach ($notes as &$note) {
            // Sanitize note name (only if field exists in the data)
            if (isset($note["note_name"]) && !empty($note["note_name"])) {
                $note["note_name"] = htmlspecialchars($note["note_name"], ENT_QUOTES, 'UTF-8');
            }
            
            // Sanitize note content (only if field exists in the data)
            if (isset($note["note_content"]) && !empty($note["note_content"])) {
                $note["note_content"] = htmlspecialchars($note["note_content"], ENT_QUOTES, 'UTF-8');
            }
            
            // Type casting for numeric fields
            if (isset($note["id"])) {
                $note["id"] = (int) $note["id"];
            }
            if (isset($note["user_id"])) {
                $note["user_id"] = (int) $note["user_id"];
            }
        }

        return $is_single ? $notes[0] : $notes;
    }

    /**
     * Applies all filters to the query - centralized filter logic
     */
    private static function applyFilters($query, $params, $types, $data_array) {
        // Row status filter (allows overriding default row_status = 1)
        if (isset($data_array["filter_row_status"]) && $data_array["filter_row_status"] !== 1) {
            // Override the default row_status = 1 condition
            $query = str_replace("n.row_status = 1", "n.row_status = ?", $query);
            $params[] = $data_array["filter_row_status"];
            $types .= "i";
        }

        // Search filter
        if (isset($data_array["filter_search"]) && !empty($data_array["filter_search"])) {
            $search = "%" . $data_array["filter_search"] . "%";
            $query .= " AND (n.note_name LIKE ? OR n.note_content LIKE ?)";
            $params[] = $search;
            $params[] = $search;
            $types .= "ss";
        }
        
        return [$query, $params, $types];
    }

    /**
     * Gets notes with advanced filtering, pagination and column selection
     */
    public static function getNotes($data_array){
        // --- COLUMN SELECTION ---
        $available_columns = self::getAvailableColumns();
        $select_columns = [];

        // Always include id for functionality
        $select_columns[] = 'n.id';

        if (isset($data_array['columns']) && is_array($data_array['columns'])) {
            foreach ($data_array['columns'] as $column) {
                if (isset($available_columns[$column]) && $column !== 'id') {
                    $select_columns[] = $available_columns[$column];
                }
            }
        } else {
            // Default columns if no filter specified - for backward compatibility
            $default_columns = ['id', 'user_id', 'note_name', 'note_content'];
            foreach ($default_columns as $column) {
                if (isset($available_columns[$column])) {
                    $select_columns[] = $available_columns[$column];
                }
            }
        }

        // --- BUILD QUERY ---
        $select_clause = implode(', ', $select_columns);
        [$query, $params, $types] = self::buildBaseQuery($data_array, $select_clause);

        // --- SORTING & PAGINATION ---
        $order_by = isset($data_array['order_by']) && in_array($data_array['order_by'], ['note_name', 'id']) 
            ? $data_array['order_by'] 
            : 'note_name';
        
        $order_direction = isset($data_array['order_direction']) && in_array(strtoupper($data_array['order_direction']), ['ASC', 'DESC']) 
            ? strtoupper($data_array['order_direction']) 
            : 'ASC';
        
        $query .= " ORDER BY n.$order_by $order_direction LIMIT ? OFFSET ?";
        
        $params[] = $data_array['limit'];
        $params[] = $data_array['offset'];
        $types .= "ii";
        
        // --- EXECUTE QUERY ---
        $notes = self::executeQuery($query, $params, $types, true);
        
        // --- POST-PROCESS DATA ---
        return self::postProcessNotes($notes);
    }

    /**
     * Gets total number of rows matching the filters
     */
    public static function getTotalRows($data_array) {
        // --- BUILD QUERY ---
        [$query, $params, $types] = self::buildBaseQuery($data_array, "COUNT(n.id) as total");
        
        // --- EXECUTE QUERY ---
        $result = self::executeQuery($query, $params, $types, false);
        return (int)$result['total'];
    }

    /**
     * Gets note statistics
     * Returns counts for active, inactive and total notes
     */
    public static function getStats($data_array) {
        // Create a copy of data_array without row_status filter for accurate counts
        $stats_data = $data_array;
        unset($stats_data["filter_row_status"]); // Remove status filter to get all statuses
        
        // --- BUILD QUERY ---
        $select_clause = "
            COUNT(n.id) as total_notes,
            SUM(CASE WHEN n.row_status = 1 THEN 1 ELSE 0 END) as count_active,
            SUM(CASE WHEN n.row_status = 0 THEN 1 ELSE 0 END) as count_inactive
        ";
        
        $query = "SELECT $select_clause FROM notes AS n WHERE n.user_id = ?";
        $params = [$data_array['user_id']];
        $types = "i";
        
        // Apply search filter if present
        if (isset($data_array["filter_search"]) && !empty($data_array["filter_search"])) {
            $search = "%" . $data_array["filter_search"] . "%";
            $query .= " AND (n.note_name LIKE ? OR n.note_content LIKE ?)";
            $params[] = $search;
            $params[] = $search;
            $types .= "ss";
        }
        
        // --- EXECUTE QUERY ---
        $result = self::executeQuery($query, $params, $types, false);
        
        // --- RETURN STATISTICS WITH PROPER TYPE CASTING ---
        return [
            'total_notes' => (int)$result['total_notes'],
            'count_active' => (int)$result['count_active'],
            'count_inactive' => (int)$result['count_inactive']
        ];
    }

    /**
     * Gets a single note by ID
     */
    public static function getNoteData($data_array){
        $query = "SELECT n.* FROM notes n WHERE n.id = ? AND n.user_id = ?";
        $params = [$data_array["note_id"], $data_array["user_id"]];
        $types = "ii";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { 
            throw new Exception("An unexpected error occurred. Please try again later.", 1);
        }

        $stmt->bind_param($types, ...$params);
        if(!$stmt->execute()){
            throw new Exception("An error occurred while processing your request. Please try again later.", 1);
        }

        $result = $stmt->get_result();
        if (!$result) {
            throw new Exception("An unexpected error occurred. Please try again later.", 1);
        }

        $data = $result->fetch_assoc();
        
        // Post-process the single note data
        if ($data) {
            $data = self::postProcessNotes($data, true);
        }

        return $data ?: [];
    }

    /**
     * Legacy method for backward compatibility
     * @deprecated Use getTotalRows() instead
     */
    public static function getRowsCount($user_id, $filters){
        $data_array = [
            'user_id' => $user_id,
            'filter_search' => $filters['search'] ?? null,
            'filter_row_status' => $filters['row_status'] ?? 1
        ];
        
        return ['count' => self::getTotalRows($data_array)];
    }
}
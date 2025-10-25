<?php
class Note extends ActiveRecord {
    protected static $table = "notes";
    protected static $columns = [
        "id",
        "note_id",
        "note_name",
        "note_content",
        "note_status",
    ];

    public $id;
    public $note_id;
    public $note_name;

    public function __construct($args = []) {
        $this->id = $args["id"] ?? NULL;
        $this->note_id = $args["note_id"] ?? "";
        $this->note_name = $args["note_name"] ?? NULL;
        $this->note_content = $args["note_content"] ?? NULL;
        $this->note_status = $args["note_status"] ?? NULL;
    }

    public static function getRowsCount($note_id, $filters){
        $query = "SELECT COUNT(*) as count FROM notes WHERE note_id = ?";
        $params = [$note_id];

        if(!empty($filters["search"])){
            $query .= " AND note_name LIKE ?";
            $params[] = "%".$filters["search"]."%";
        }
        if(isset($filters["note_status"])){
            $query .= " AND note_status = ?";
            $params[] = $filters["note_status"];
        }else{
            $query .= " AND note_status = 1";
        }

        $stmt = self::$db->prepare($query);
        if (!$stmt || !$stmt->execute($params)) { return false; }
        $result = $stmt->get_result();
        if (!$result) { return false;}
        return $result->fetch_assoc();
    }

    public static function getPatients($data_array){
        $note_id = $data_array["note_id"];
        $filters = $data_array["filters"];
        $limit = $data_array["limit"];
        $offset = $data_array["offset"];

        $query = "SELECT * FROM notes WHERE note_id = ?";
        $params = [$note_id];

        if(!empty($filters["search"])){
            $query .= " AND note_name LIKE ?";
            $params[] = "%".$filters["search"]."%";
        }

        if(!empty($filters["status"]) && $filters["status"] !== 'all_status'){
            $query .= " AND patient_status = ?";
            $params[] = $filters["status"];
        }

        if(isset($filters["row_status"])){
            $query .= " AND row_status = ?";
            $params[] = $filters["row_status"];
        }else{
            $query .= " AND row_status = 1";
        }

        if(!empty($filters["order"]) && !empty($filters["order_by"])){
            $allowedColumns = ['note_name', 'patient_birthdate', 'patient_status'];
            $allowedOrders = ['ASC', 'DESC'];
            
            $orderBy = in_array($filters["order_by"], $allowedColumns) ? $filters["order_by"] : 'note_name';
            $order = in_array(strtoupper($filters["order"]), $allowedOrders) ? strtoupper($filters["order"]) : 'ASC';
            
            $query .= " ORDER BY " . $orderBy . " " . $order;
        } else {
            $query .= " ORDER BY note_name ASC";
        }

        $query .= " LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        $stmt = self::$db->prepare($query);
        if (!$stmt) { return false; }
        if (!$stmt->execute($params)) { return false; }
        $result = $stmt->get_result();
        if (!$result) { return false; }
        return $result->fetch_all(MYSQLI_ASSOC);
        
    }

    public static function getStats($data_array){
        $filters = $data_array["filters"] ?? [];
        $query = "SELECT 
            SUM(CASE WHEN patient_status = '1' THEN 1 ELSE 0 END) as count_active,
            SUM(CASE WHEN patient_status = '2' THEN 1 ELSE 0 END) as count_discharged,
            SUM(CASE WHEN patient_status = '3' THEN 1 ELSE 0 END) as count_inactive
            FROM notes WHERE note_id = ?";
        $params = [$data_array["note_id"]]; 

        if(!empty($filters["search"])){
            $query .= " AND note_name LIKE ?";
            $params[] = "%".$filters["search"]."%";
        }
        if(isset($filters["row_status"])){
            $query .= " AND row_status = ?";
            $params[] = $filters["row_status"];
        }else{
            $query .= " AND row_status = 1";
        }

        $stmt = self::$db->prepare($query);
        if (!$stmt || !$stmt->execute($params)) { return false; }
        $result = $stmt->get_result();
        if (!$result) { return false;}
        return $result->fetch_assoc();
    }


}
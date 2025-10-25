<?php
class Suggestions extends Connect {
    public function send_suggestion($data_array){
        $connect = parent::Conection();
        $sql = "INSERT INTO suggestions
            (user_id, page_name, suggestion)
            VALUES (?, ?, ?)
        ";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(1, $data_array["user_id"], PDO::PARAM_INT);
        $stmt->bindParam(2, $data_array["page_name"], PDO::PARAM_STR);
        $stmt->bindParam(3, $data_array["suggestion"], PDO::PARAM_STR);

        try {
            $stmt->execute();
            $response = [
                'success' => true,
            ];
            return $response;
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            return $response;
        }
    }
}

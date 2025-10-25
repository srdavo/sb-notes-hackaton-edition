<?php
require_once ("../controllers/users.controller.php");
require_once("../config/cookies.php");

class User_page_access extends Connect{
    public function registerAccess($user_id, $page, $device, $ip_address){
        $connect=parent::Conection();
        
        try {
            $sql = "INSERT INTO user_page_access (user_id, page_name, device_type, ip_address) VALUES (?, ?, ?, ?);";
            $stmt = $connect->prepare($sql);
            
            $stmt->bindParam(1, $user_id);
            $stmt->bindParam(2, $page);
            $stmt->bindParam(3, $device);
            $stmt->bindParam(4, $ip_address);
            
            $result = $stmt->execute();
            return $result;
            return ($result !== false) ? $result : false;
        } catch (PDOException $e) {
            // Manejar la excepción aquí (por ejemplo, imprimir el mensaje de error)
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
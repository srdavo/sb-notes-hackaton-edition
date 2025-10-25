<?php
require_once("../config/connect.php");
require_once("../models/Movement.php");
require_once("../../../../back-end/config/session.php");
require_once("../helpers/Pagination.php");


$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);


switch ($data["op"]){
    case "movement_save":
        $data_array = [
            "id" => isset($data["id"]) && is_numeric($data["id"]) ? intval($data["id"]) : null,
            "user_id" => isset($data["user_id"]) ? intval($data["user_id"]) : $userid,
            "note_id" => isset($data["note_id"]) ? intval($data["note_id"]) : null,
            "quantity" => isset($data["quantity"]) ? intval($data["quantity"]) : null,
            "create_date" => isset($data["create_date"]) 
                ? $data["create_date"] 
                : date('Y-m-d H:i:s'),
            "update_date" => isset($data["update_date"]) 
                ? $data["update_date"] 
                : date('Y-m-d H:i:s'),
            "row_status" => isset($data["row_status"]) ? intval($data["row_status"]) : 1,
        ];


        try {
            $db->autocommit(false);

            // Crea el objeto Movement y guarda
            $Movement = new Movement($data_array);
            $result = $Movement->save();

            // Normalize result: create returns array with 'ok' and 'id', update returns boolean
            $savedOk = false;
            $savedId = null;

            if (is_array($result)) {
                $savedOk = !empty($result['ok']);
                $savedId = $result['id'] ?? null;
            } else {
                // boolean result from update
                $savedOk = ($result === true || $result === 1);
                // if updating, prefer provided id
                $savedId = $data_array['id'] ?? null;
            }

            if (!$savedOk) {
                throw new Exception('Failed to save movement');
            }

            // Commit de la transacción
            $db->commit();

            $response = [
                "success" => true,
                "message" => isset($data_array["id"]) && $data_array["id"] ? "Movement updated successfully" : "Movement created successfully",
                "note_id" => $savedId ?? $Movement->id
            ];

        } catch (Exception $e) {
            $db->rollback();

            $response = [
                "success" => false,
                "message" => $e->getMessage(),
                "details" => [
                    "result" => $result ?? null
                ]
            ];
        }

        echo json_encode($response);
        break;
}
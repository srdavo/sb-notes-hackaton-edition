<?php
require_once("../config/connect.php");
require_once("../models/Feeling.php");
require_once("../../../../back-end/config/session.php");
require_once("../helpers/Pagination.php");


$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);


switch ($data["op"]){
    case "feeling_save":

        // If an id is provided, we'll treat this as an update. Otherwise a create.
        $data_array = [
            "id" => isset($data["id"]) && is_numeric($data["id"]) ? intval($data["id"]) : null,
            "user_id" => isset($data["user_id"]) ? intval($data["user_id"]) : $userid,
            "note_id" => isset($data["note_id"]) ? intval($data["note_id"]) : null
        ];

        try {
            $db->autocommit(false);

            // Crea el objeto Feeling y guarda
            $Feeling = new Feeling($data_array);
            $result = $Feeling->save();

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
                throw new Exception('Failed to save feeling');
            }

            // Commit de la transacción
            $db->commit();

            $response = [
                "success" => true,
                "message" => isset($data_array["id"]) && $data_array["id"] ? "Feeling updated successfully" : "Feeling created successfully",
                "note_id" => $savedId ?? $Feeling->id
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
<?php
require_once("../config/connect.php");
require_once("../models/Feeling.php");
require_once("../../../../back-end/config/session.php");
require_once("../helpers/Pagination.php");


$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);


switch ($data["op"]){
    case "feeling_save":

        $data_array = [
            "id" => null,
            "user_id" => isset($data["user_id"]) ? intval($data["user_id"]) : $userid,
            "note_id" => isset($data["note_id"]) ? intval($data["note_id"]) : null
        ];

        try {
            $db->autocommit(false);

            // Crea el objeto Feeling y guarda
            $Feeling = new Feeling($data_array);
            $result = $Feeling->save();

            if (!$result) {
                throw new Exception('Failed to save note');
            }

            // Commit de la transacción
            $db->commit();

            $response = [
                "success" => true,
                "message" => "Feeling created successfully",
                "note_id" => $Feeling->id
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
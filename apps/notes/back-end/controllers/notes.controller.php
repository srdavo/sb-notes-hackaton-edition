<?php
require_once("../config/connect.php");
require_once("../models/Note.php");
require_once("../../../../back-end/config/session.php");
require_once("../helpers/Pagination.php");


$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);


switch ($data["op"]){
      case "note_create":

        // 1. Define data array and log array
        $data_array = [
            "id" => null,
            "user_id" => $userid,
            "note_name" => htmlspecialchars($data["note_name"], ENT_QUOTES, 'UTF-8'),
            "note_content" => htmlspecialchars($data["note_content"], ENT_QUOTES, 'UTF-8'),
            "row_status" => 1
        ];
        // 2. start process with transaction
        try {
            $db->autocommit(false);

            // 1. execute the action
            $Note = new Note($data_array);
            $result = $Note->save();
            if(!$result){ throw new Exception('Failed to save note'); }

            // 2. commit transaction
            $db->commit();
            $response = [
                "success" => true,
                "message" => "note created successfully",
                "note_id" => $result['id']
            ];

        } catch (Exception $e) {
            $db->rollback();
            $response = [
                "success" => false,
                "message" => $e->getMessage(),
                "details" => [
                    "result" => $result ?? "No result",
                ]
            ];
        }

        echo json_encode($response);
        break;
}
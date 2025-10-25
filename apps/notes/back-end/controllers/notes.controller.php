<?php
require_once("../config/connect.php");
require_once("../models/Note.php");
require_once("../../../../config/session.php");
require_once("../helpers/Pagination.php");


$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);


switch ($data["op"]){
      case "note_create":

        // 1. Define data array and log array
        $data_array = [
            "id" => null,
            "notes_id" => $userid,
            "note_name" => htmlspecialchars($data["note_name"], ENT_QUOTES, 'UTF-8'),
            "note_content" => htmlspecialchars($data["note_content"], ENT_QUOTES, 'UTF-8'),
            "note_status" => 1
        ];

        $log = [
            "notes_id" => $notes_id,
            "action_id" => $data_array["action_id"],
            "target_type" => "notes"
        ];

        // 2. start process with transaction
        try {
            $db->autocommit(false);

            // 1s. execute the action
            $Note = new Note($data_array);
            $result = $note->save();
            if(!$result){ throw new Exception('Failed to save note'); }

            // 5. save action log
            $log['target_id'] = $result['id'];
            $log['owner_id'] = $data_array['owner_id'] ?? $userid;
            $log_result = ActionLog::saveLog($log);
            if(!$log_result){ throw new Exception('Failed to save action log'); }

            // 6. commit transaction
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
                    "permissions" => $permissions ?? "No permissions",
                    "result" => $result ?? "No result",
                    "log_result" => $log_result ?? "No log"
                ]
            ];
        }

        echo json_encode($response);
        break;
}
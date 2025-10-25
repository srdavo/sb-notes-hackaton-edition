<?php
require_once("../config/connect.php");
require_once("../models/Suggestions.php");
require_once("../config/session.php");
$suggestions = new suggestions();

// Data
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

switch ($data["op"]) {
    case "send_suggestion":
        $data_array = [
            "user_id" => $userid,
            "page_name" => $data["page_name"],
            "suggestion" => $data["suggestion"],
        ];
        $send_suggestion = $suggestions->send_suggestion($data_array);
        if($send_suggestion["success"]){
            echo json_encode([
                "success" => true,
                "message" => "Suggestion sent"
            ]);
            exit;
        } else {
            echo json_encode([
                "success" => false,
                "message" => $send_suggestion["message"]
            ]);
            exit; 
        }

        break;

    default:
        echo json_encode([
            "success" => false,
            "message" => "Invalid operation"
        ]);
        break;
}
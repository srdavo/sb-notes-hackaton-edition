<?php
$CSRF_TOKEN = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
if($CSRF_TOKEN){
    if(isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] === $CSRF_TOKEN){
    }else{
        echo json_encode(["success" => false, "message" => "CSRF token mismatch", "csrf_token" => $_SESSION["csrf_token"] ?? null]);
        // http_response_code(403); // Forbidden
        exit;
    }
}else{
    echo json_encode(["success" => false, "message" => "CSRF token missing"]);
    // http_response_code(403); // Forbidden
    exit;
}
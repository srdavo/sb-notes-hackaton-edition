<?php
require_once 'config.php';

ini_set('session.use_only_cookies', 1);
ini_set('session.user_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 86400,
    'domain' => $_ENV["domain"],
    'path' => '/',
    'secure' => true,
    'httponly' => true,
]);

session_name($_ENV["SESSION_NAME"]);
session_start();

// session id regeneration is off for now because it makes the app stop working ->
    // if(!isset($_SESSION["last_regeneration"])){
    //     session_regenerate_id(true);
    //     $_SESSION["last_regeneration"] = time();
    // } else {
    //     $interval = 60 * 60;
    //     if(time() - $_SESSION["last_regeneration"] >= $interval){
    //         session_regenerate_id(true);
    //         $_SESSION["last_regeneration"] = time();
    //     }
    // }

if(!isset($_SESSION["csrf_token"])){
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

if(isset($_SESSION["id"])){$userid = $_SESSION["id"];}
?>
<?php
require_once 'config.php';

error_log("[SESSION] Configurando sesión con dominio: " . $_ENV["domain"]);

ini_set('session.use_only_cookies', 1);
ini_set('session.user_strict_mode', 1);
session_name($_ENV["SESSION_NAME"]);

error_log("[SESSION] Iniciando sesión con nombre: " . $_ENV["SESSION_NAME"]);
session_start();
error_log("[SESSION] Sesión iniciada - ID: " . session_id());

if(!isset($_SESSION["csrf_token"])){
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
    error_log("[SESSION] Token CSRF generado para sesión: " . session_id());
} else {
    error_log("[SESSION] Token CSRF ya existe para sesión: " . session_id());
}

if(isset($_SESSION["id"])){
    $userid = $_SESSION["id"];
    error_log("[SESSION] Usuario autenticado - ID: " . $userid . " - Sesión: " . session_id());
} else {
    error_log("[SESSION] No hay usuario autenticado - Sesión: " . session_id());
}

error_log("[SESSION] Datos de sesión activos: " . count($_SESSION) . " elementos");
?>
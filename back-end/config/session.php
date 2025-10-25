<?php
require_once 'config.php';

// Log session configuration
error_log("[SESSION] Configurando sesión con dominio: " . $_ENV["domain"]);

ini_set('session.use_only_cookies', 1);
ini_set('session.user_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 86400,
    'domain' => $_ENV["domain"],
    'path' => '/',
    // enable Secure flag only when using HTTPS to avoid losing cookies on local HTTP dev
    'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    'httponly' => true,
]);

session_name($_ENV["SESSION_NAME"]);

// Log session start
error_log("[SESSION] Iniciando sesión con nombre: " . $_ENV["SESSION_NAME"]);
session_start();
error_log("[SESSION] Sesión iniciada - ID: " . session_id());

// Generate CSRF token if not exists
if(!isset($_SESSION["csrf_token"])){
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
    error_log("[SESSION] Token CSRF generado para sesión: " . session_id());
} else {
    error_log("[SESSION] Token CSRF ya existe para sesión: " . session_id());
}

// Set user ID if logged in
if(isset($_SESSION["id"])){
    $userid = $_SESSION["id"];
    error_log("[SESSION] Usuario autenticado - ID: " . $userid . " - Sesión: " . session_id());
} else {
    error_log("[SESSION] No hay usuario autenticado - Sesión: " . session_id());
}

// Log session data (excluding sensitive information)
error_log("[SESSION] Datos de sesión activos: " . count($_SESSION) . " elementos");
?>
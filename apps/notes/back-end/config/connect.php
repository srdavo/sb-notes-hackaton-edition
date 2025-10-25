<?php
require_once __DIR__ . '/../models/ActiveRecord.php';
require_once __DIR__ . '/../../../../back-end/config/config.php';
$db = mysqli_connect($_ENV["db_host"], $_ENV["db_user_hackaton"], $_ENV["db_password_hackaton"], $_ENV['db_name_hackaton']);

if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "error de depuración: " . mysqli_connect_error();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
} else {
    // echo "Conexión exitosa a la base de datos.";
}
ActiveRecord::setDB($db);
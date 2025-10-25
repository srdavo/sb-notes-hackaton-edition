<?php
require_once __DIR__ . '/../models/ActiveRecord.php';
require_once __DIR__ . '/config.php';
// $db = mysqli_connect('localhost', 'root', '', 'cocounut_sb');
$db = mysqli_connect($_ENV["db_host"], $_ENV["db_user"], $_ENV["db_password"], $_ENV['db_name']);

if (!$db) {
    error_log("Error de conexión a MySQL: " . mysqli_connect_error());
    echo "Lo sentimos, no se pudo conectar a la base de datos. Intente más tarde.";
    exit;
}
ActiveRecord::setDB($db);

class Connect {
    protected function Conection(){
        $serverName = $_ENV["db_host"];
        $dbUsername = $_ENV["db_user"];$dbPassword = $_ENV["db_password"];$bNamed = $_ENV['db_name'];
        // $dbUsername = "root";$dbPassword = "";$bNamed = "cocounut_sb";
        try {
            $connect = new PDO("mysql:host=$serverName;dbname=$bNamed", $dbUsername, $dbPassword);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connect; // Agrega esta línea para devolver la conexión
        } catch (Exception $e) {
            print "¡Error BD!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}

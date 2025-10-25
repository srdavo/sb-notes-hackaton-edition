<?php
require_once ("../controllers/users.controller.php");
require_once("../config/cookies.php");

class Users extends Connect {

    public function login($username, $pwd, $cookie_uid, $cookie_pwd, $google_auth = false) {   
        deleteCookies($cookie_uid, $cookie_pwd); // Delete cookies if they exist before login    
        $connect = parent::Conection();
        $userExists = $this->validateUserExists($connect, $username, $username);
    
        if ($userExists === false) {
            echo json_encode("user_doesnt_exist");
            exit;
        }

        if ($google_auth == true) {
            require_once '../config/google-api-php-client/vendor/autoload.php';

            $client = new Google\Client();
            $client->setClientId($client_id);
            $client->setClientSecret($client_secret);
            $client->setRedirectUri("http://localhost");

            $payload = $client->verifyIdToken($pwd);
            if ($payload === false) {
                return false;
            }
        }else{
            $pwdHashed = $userExists["pwd"];
            $checkPwd = password_verify($pwd, $pwdHashed);
            if ($checkPwd === false && $pwd !== $pwdHashed) {
                echo json_encode("wrong_password");
                exit();
            }
        }
    
    
        // Si llegamos aquí, el usuario existe y la contraseña (si se proporcionó) es correcta
        include_once("../config/session.php");
        // Setting cookies
        setcookie($cookie_uid, "$username",  time() + (10 * 365 * 24 * 60 * 60), "/");
        $_SESSION["id"] = $userExists["id"];
        $_SESSION["user"] = $userExists["name"];
        setcookie($cookie_pwd, $userExists["pwd"], time() + (10 * 365 * 24 * 60 * 60), "/");
    
        $additional_data = $this->getAdditionalUserData();
        $_SESSION["additional_data"] = $additional_data;
        return true;
    }
    
    public function validateUserExists($connect, $name, $email){
        try {
            $sql = "SELECT * FROM users WHERE name = :name OR email = :email;";
            $sql = $connect->prepare($sql);
            $sql->bindParam(':name', $name, PDO::PARAM_STR);
            $sql->bindParam(':email', $email, PDO::PARAM_STR);
            $sql->execute();
        
            $result = $sql->fetch(PDO::FETCH_ASSOC);
            // if(count($result) > 0){
            //     return $result;
            // }else{
            //     return false;
            // }
            return ($result !== false) ? $result : false;
        } catch (PDOException $e) {
            // Manejar la excepción aquí (por ejemplo, imprimir el mensaje de error)
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function generateToken(){
        $length = 8; 
        $token = bin2hex(random_bytes($length / 2));
        return $token;
    }
    public function signup($email, $pwd, $google_auth = false){
        $connect=parent::Conection();
        $name = null;
        $userExists = $this->validateUserExists($connect, $name, $email);

        if ($userExists !== false) {
            echo json_encode("user_already_exists");
            exit;
        }
        if($pwd == null){
            $pwd = $this->generateToken();
        }

        $user_token = $this->generateToken();
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
        
        $sql_users = "INSERT INTO users (email, pwd) VALUES (?, ?);";
        if($google_auth != false){ $sql_users = "INSERT INTO users (name, email, pwd) VALUES (?, ?, ?);"; }
        $sql_tokens = "INSERT INTO users_data (user_id, user_token) VALUES (?, ?);";
        if($google_auth != false){ $sql_tokens = "INSERT INTO users_data (user_id, user_token, google_id, profile_picture) VALUES (?, ?, ?, ?);"; }

        $stmt_users = $connect->prepare($sql_users);
        $stmt_tokens = $connect->prepare($sql_tokens);

        $stmt_users->bindParam(1, $email);
        $stmt_users->bindParam(2, $hashedPwd);
        if($google_auth != false){
            $stmt_users->bindParam(1, $google_auth["name"]);
            $stmt_users->bindParam(2, $email);
            $stmt_users->bindParam(3, $hashedPwd);
        }

        $stmt_tokens->bindParam(1, $user_id);
        $stmt_tokens->bindParam(2, $user_token);
        if($google_auth != false){
            $stmt_tokens->bindParam(3, $google_auth["google_id"]);
            $stmt_tokens->bindParam(4, $google_auth["profile_picture"]);
        }
        
        try {
            $stmt_users->execute();
            $user_id = $connect->lastInsertId();
            $stmt_tokens->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }

    }
    public function getUserData($userid) {
        $connect = parent::Conection();
    
        $sql = "SELECT id, name, email FROM users WHERE id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(1, $userid);
    
        try {
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC); // Corrected method
    
            return array(
                "id" => $row["id"],
                "name" => $row["name"],
                "email" => $row["email"]
            );
        } catch (PDOException $e) {
            return false;
        }
    }
    public function modifyUserData($name, $userid){
        $connect = parent::Conection();

        $email = null;
        $userExists = $this->validateUserExists($connect, $name, $email);

        if ($userExists !== false) {
            echo json_encode("user_already_exists");
            exit;
        }

        $sql = "UPDATE users SET name = ? WHERE id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $userid);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    private function getAdditionalUserData(){
        $connect = parent::Conection();
        $sql = "SELECT * FROM users_data WHERE user_id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(1, $_SESSION["id"]);
        try {
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function ValidatePassword($userid, $password){
        $connect = parent::Conection();
        $sql = "SELECT pwd FROM users WHERE id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(1, $userid);
        try {
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $pwdHashed = $row["pwd"];
            $checkPwd = password_verify($password, $pwdHashed);
            return $checkPwd;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Google auth functions
    public function checkEmailTaken($email){
        $connect = parent::Conection();
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(1, $email);
        try {
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result){
                return true;
            }else{
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function checkNameTaken($name){
        $connect = parent::Conection();
        $sql = "SELECT * FROM users WHERE name = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(1, $name);
        try {
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result){
                return true;
            }else{
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function generateUniqueName($name){
        $username = preg_replace("/[^A-Za-z0-9]/", '', $name);
        $username_base = strtolower($username);
        $unique_username = $username_base;
        $token = $this->generateToken();
        while ($this->checkNameTaken($unique_username)) {
            $unique_username = $username_base ."-". $token;
        }
        return $unique_username;
    }

}
?>

<?php
class Account extends ActiveRecord {

    public static function checkEmailTaken($email){
        $query = "SELECT COUNT(*) as count FROM users WHERE email = ?";
        $params = [$email];
        $types = "s";
    
        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $result = $stmt->get_result();
        if (!$result) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}
        $result = $result->fetch_assoc();

        return $result["count"] > 0 ? true : false;
    }

    public static function checkUsernameTaken($username){
        $query = "SELECT COUNT(*) as count FROM users WHERE name = ?";
        $params = [$username];
        $types = "s";
    
        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $result = $stmt->get_result();
        if (!$result) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}
        $result = $result->fetch_assoc();

        return $result["count"] > 0 ? true : false;
    }

    public static function signUp($data_array){
        $hashed_password = password_hash($data_array["pwd"], PASSWORD_BCRYPT, ["cost" => 10]);
        $query  = "INSERT INTO users (name, email, pwd) VALUES (?, ?, ?)";
        $params = [$data_array['name'] ?? "", $data_array["email"], $hashed_password];
        $types  = "sss";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $inserted_id = self::$db->insert_id;
        return $inserted_id;
    }

    public static function setUserData($user_id){
        $user_token = bin2hex(random_bytes(32));
        $query = "INSERT INTO users_data (user_id, user_token) VALUES (?, ?)";
        $params = [$user_id, $user_token];
        $types = "is";

        $stmt = self::$db->prepare($query); 
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        return true;
    }

    public static function setCompleteUserData($user_id, $data_array){
        $user_token = bin2hex(random_bytes(32));
        $query = "INSERT INTO users_data (user_id, user_token, google_id, profile_picture) VALUES (?, ?, ?, ?)";
        $params = [$user_id, $user_token, $data_array["google_id"] ?? "", $data_array["profile_picture"] ?? ""];
        $types = "isss";

        $stmt = self::$db->prepare($query); 
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        return true;
    }

    public static function getUserHashedPassword($email){
        $query = "SELECT pwd FROM users WHERE email = ?";
        $params = [$email];
        $types = "s";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $result = $stmt->get_result();
        if (!$result) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}
        $user = $result->fetch_assoc();

        return $user["pwd"];
    }

    public static function getUserId($email){
        $query = "SELECT id FROM users WHERE email = ?";
        $params = [$email];
        $types = "s";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $result = $stmt->get_result();
        if (!$result) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}
        $user = $result->fetch_assoc();

        return $user["id"];
    }

    public static function getUserName($user_id){
        $query = "SELECT name FROM users WHERE id = ?";
        $params = [$user_id];
        $types = "i";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $result = $stmt->get_result();
        if (!$result) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}
        $user = $result->fetch_assoc();

        return $user["name"];
    }

    public static function getUserData($user_id){
        $query = "SELECT ud.permissions, ud.profile_picture, ud.user_token, u.name, u.id, u.email FROM users_data ud JOIN users u ON ud.user_id = u.id WHERE ud.user_id = ?";
        $params = [$user_id];
        $types = "i";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $result = $stmt->get_result();
        if (!$result) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}
        $user = $result->fetch_assoc();

        return $user;
    }

    public static function logIn($user_data){
        session_regenerate_id(true);
        $_SESSION["csrf_token"] = bin2hex(random_bytes(32));

        // $check_user_subscription = self::checkUserSubscription($user_data["id"]);
        // $_SESSION["subscription_status"] = $check_user_subscription;

        $_SESSION["id"] = $user_data["id"];
        $_SESSION["user"] = $user_data["name"];
        $_SESSION["email"] = $user_data["email"];
        $_SESSION["additional_data"] = [
            "permissions" => $user_data["permissions"],
            "profile_picture" => $user_data["profile_picture"],
            "user_token" => $user_data["user_token"],
        ];
        return true;
    }

    public static function rememberMe($user_id){

        $token_id = bin2hex(random_bytes(16));

        $token = bin2hex(random_bytes(32));
        $hashed_token = password_hash($token, PASSWORD_BCRYPT, ["cost" => 10]);
        $expiration_date = date("Y-m-d H:i:s", strtotime("+1 month"));

        $query = "INSERT INTO user_tokens (user_id, token_id, token, expiration_date) VALUES (?, ?, ?, ?)";
        $params = [$user_id, $token_id, $hashed_token, $expiration_date];
        $types = "isss";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $token = $token_id . ":" . $token;

        setcookie('codemelon-remember_me', $token, [
            'expires'  => time() + 60 * 60 * 24 * 30, // 30 days
            'path'     => '/',
            'domain'   => $_ENV["domain"],
            'secure'   => true,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);

        setcookie('codemelon-remember_me_js_accessible', $token, [
            'expires'  => time() + 60 * 60 * 24 * 30, // 30 days
            'path'     => '/',
            'domain'   => $_ENV["domain"],
            'secure'   => true,
            'samesite' => 'Lax'
        ]);



        return true;
    }
    
    public static function validateRememberMeToken($token_id_from_cookie, $token_from_cookie){
        $query = "SELECT user_id, token, expiration_date, is_valid
            FROM user_tokens 
            WHERE token_id = ?
            AND is_valid = 1
            AND expiration_date > NOW()
            ";
        $params = [$token_id_from_cookie];
        $types = "s";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}
        
        $result = $stmt->get_result();
        if (!$result) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}
        $token_data = $result->fetch_assoc();

        if(!$token_data){throw new Exception("invalid_token_180");}

        if(!password_verify($token_from_cookie, $token_data["token"])){throw new Exception("Invalid token 182");}

        return $token_data["user_id"];
    }

    public static function invalidateRememberMeTokenById($token_id_from_cookie){
        $query = "UPDATE user_tokens SET is_valid = 0 WHERE token_id = ?";
        $params = [$token_id_from_cookie];
        $types = "s";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        return true;
    }

    public static function generateUniqueName($name){
        $name = strtolower($name);
        $name = str_replace(" ", "-", $name);
        $name = preg_replace("/[^a-z0-9-]/", "", $name);
        $name = substr($name, 0, 20);
        $name = $name . "-" . bin2hex(random_bytes(4));
        return $name;
    }

    public static function checkGoogleId($email){
        $query = "SELECT COUNT(*) as count FROM users_data ud JOIN users u ON ud.user_id = u.id WHERE u.email = ? AND ud.google_id IS NOT NULL";
        $params = [$email];
        $types = "s";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $result = $stmt->get_result();
        if (!$result) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}
        $result = $result->fetch_assoc();

        return $result["count"] > 0 ? true : false;
    }

    public static function modifyUserData($user_id, $data_array){
        $query = "UPDATE users SET name = ? WHERE id = ?";
        $params = [$data_array["name"], $user_id];
        $types = "si";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $_SESSION["user"] = $data_array["name"];

        return true;
    }

    public static function registerAccess($data_array){
        $query = "INSERT INTO user_page_access (user_id, page_name, device_type, ip_address) VALUES (?, ?, ?, ?)";
        $params = [$data_array["user_id"], $data_array["app"], $data_array["device"], $data_array["ip_address"]];
        $types = "isss";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        return true;
    }

    public static function checkIfEmailOrNumberAlreadyRequestedDemo($data_array){
        $query = "SELECT COUNT(*) as count FROM user_demo_request WHERE email = ? OR phone = ?";
        $params = [$data_array["email"], $data_array["phone"]];
        $types = "ss";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $result = $stmt->get_result();
        if (!$result) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}
        $result = $result->fetch_assoc();

        return $result["count"] > 0 ? true : false;
    }

    public static function appRequestDemo($data_array){
        $query = "INSERT INTO user_demo_request (email, phone, privacy_policy) VALUES (?, ?, ?)";
        $params = [$data_array["email"], $data_array["phone"], $data_array["checkbox"]];
        $types = "sss";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        return true;
    }

    public static function checkUserSubscription($user_id){
        $query = "SELECT subscription_status FROM subscriptions WHERE user_id = ? ORDER BY id DESC LIMIT 1";
        $params = [$user_id];
        $types = "i";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $result = $stmt->get_result();
        if (!$result) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}
        $result = $result->fetch_assoc();

        if(!$result){return "inactive";} // No subscription found
        if($result["subscription_status"] === "active" || $result["subscription_status"] === "trialing"){
            return "active"; // Subscription found and active
        }else{
            return "inactive"; // subscription found but not active
        }
    }

    public static function insertPasswordResetRequest($data_array){
        $query = "UPDATE users_data SET reset_password_token = ?, reset_password_token_expiration = ? WHERE user_id = ?";
        $params = [$data_array["reset_password_token"], $data_array["token_expiry"], $data_array["user_id"]];
        $types = "ssi";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        return true;
    }

    public static function getUserResetPasswordRequest($data_array){
        $query = "SELECT reset_password_token, reset_password_token_expiration FROM users_data WHERE user_id = ?";
        $params = [$data_array["user_id"]];
        $types = "i";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $result = $stmt->get_result();
        if (!$result) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}
        $result = $result->fetch_assoc();

        return $result;
    }

    public static function updatePassword($data_array){
        $hashed_password = password_hash($data_array["password"], PASSWORD_BCRYPT, ["cost" => 10]);
        $query = "UPDATE users SET pwd = ? WHERE id = ?";
        $params = [$hashed_password, $data_array["user_id"]];
        $types = "si";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        return true;
    }

    public static function deleteResetPasswordRequest($data_array){
        $query = "UPDATE users_data SET reset_password_token = NULL, reset_password_token_expiration = NULL WHERE user_id = ?";
        $params = [$data_array["user_id"]];
        $types = "i";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        return true;
    }

    public static function setGoogleTokens($data_array){
        $query = "UPDATE users_data SET google_refresh_token = ?, google_access_token = ?, google_token_expiry_date = ? WHERE user_id = ?";
        $params = [
            $data_array["google_refresh_token"],
            $data_array["google_access_token"],
            $data_array["google_token_expiry_date"],
            $data_array["user_id"]
        ];
        $types = "sssi";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params); // Bind the parameters
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        return true;
    }
    
    public static function updateUserGoogleAccessToken($user_id, $encrypted_access_token, $expiry_date) {
        // Esta función ya usa la conexión correcta a la BD de usuarios (self::$db)
        $query = "UPDATE users_data SET google_access_token = ?, google_token_expiry_date = ? WHERE user_id = ?";
        $params = [$encrypted_access_token, $expiry_date, $user_id];
        $types = "ssi";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { 
            throw new Exception("An unexpected error occurred while preparing statement.", 1);
        }

        $stmt->bind_param($types, ...$params);
        if(!$stmt->execute()){ 
            throw new Exception("An unexpected error occurred while updating tokens.", 1); 
        }
    }
}
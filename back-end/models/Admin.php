<?php
class Admin extends ActiveRecord{

    public static function getUsers($data_array){
        $query = "SELECT *
            FROM users JOIN users_data ON users.id = users_data.user_id ORDER BY users.id DESC 
            LIMIT ? OFFSET ?
        ";
        $params = [$data_array["limit"], $data_array["offset"]];
        $types = "ii";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params);
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $result = $stmt->get_result();
        if (!$result) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $users = $result->fetch_all(MYSQLI_ASSOC);

        // Apply htmlspecialchars to each value in the $users array
        foreach ($users as &$user) {
            foreach ($user as &$value) {
                $value = htmlspecialchars($value);
            }
        }

        return $users;
    }

    public static function getUsersRowsCount(){
        $query = "SELECT COUNT(*) as total_rows FROM users";
        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $result = $stmt->get_result();
        if (!$result) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $data = $result->fetch_assoc();
        return $data["total_rows"];
    }

    public static function getAccess($data_array){
        $query = "SELECT users.name, users_data.profile_picture, user_page_access.* FROM user_page_access JOIN users ON user_page_access.user_id = users.id JOIN users_data ON users.id = users_data.user_id ORDER BY user_page_access.id DESC LIMIT ? OFFSET ?";
        $params = [$data_array["limit"], $data_array["offset"]];
        $types = "ii";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params);
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $result = $stmt->get_result();
        if (!$result) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $access = $result->fetch_all(MYSQLI_ASSOC);

        // Apply htmlspecialchars to each value in the $access array
        foreach ($access as &$row) {
            foreach ($row as &$value) {
                $value = htmlspecialchars($value);
            }
        }

        return $access;
    }

    public static function getAccessRowsCount(){
        $query = "SELECT COUNT(*) as total_rows FROM user_page_access";
        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $result = $stmt->get_result();
        if (!$result) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $data = $result->fetch_assoc();
        return $data["total_rows"];
    }

    public static function getSuggestions($data_array){
        $query = "SELECT suggestions.*, users.name, users_data.profile_picture FROM suggestions JOIN users ON suggestions.user_id = users.id JOIN users_data ON users.id = users_data.user_id ORDER BY suggestions.id DESC LIMIT ? OFFSET ?";
        $params = [$data_array["limit"], $data_array["offset"]];
        $types = "ii";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params);
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $result = $stmt->get_result();
        if (!$result) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $suggestions = $result->fetch_all(MYSQLI_ASSOC);

        // Apply htmlspecialchars to each value in the $suggestions array
        foreach ($suggestions as &$suggestion) {
            foreach ($suggestion as &$value) {
                $value = htmlspecialchars($value);
            }
        }

        return $suggestions;
    }

    public static function getSuggestionsRowsCount(){
        $query = "SELECT COUNT(*) as total_rows FROM suggestions";
        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $result = $stmt->get_result();
        if (!$result) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $data = $result->fetch_assoc();
        return $data["total_rows"];
    }


    public static function getPaidUsers($data_array){
        $query = "SELECT
            u.id, u.name, u.email, ud.profile_picture, s.subscription_status
            FROM users u
            JOIN users_data ud ON u.id = ud.user_id
            JOIN subscriptions s ON u.id = s.user_id
            WHERE s.id IS NOT NULL
            ORDER BY u.id DESC
            LIMIT ? OFFSET ?
        ";
        $params = [$data_array["limit"], $data_array["offset"]];
        $types = "ii";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $stmt->bind_param($types, ...$params);
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $result = $stmt->get_result();
        if (!$result) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $paid_users = $result->fetch_all(MYSQLI_ASSOC);

        // Apply htmlspecialchars to each value in the $paid_users array
        foreach ($paid_users as &$user) {
            foreach ($user as &$value) {
                $value = htmlspecialchars($value);
            }
        }

        return $paid_users;
    }

    public static function getPaidUsersRowsCount(){
        $query = "SELECT COUNT(*) as total_rows 
            FROM users u
            JOIN subscriptions s ON u.id = s.user_id
            WHERE s.id IS NOT NULL
        ";
        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}

        $result = $stmt->get_result();
        if (!$result) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}

        $data = $result->fetch_assoc();
        return $data["total_rows"];
    }



    public static function getPaidUserData($user_id){
        $query = "SELECT
                u.id AS user_id,
                u.name AS user_name,
                u.email AS user_email,
                ud.*, -- Selects all columns from users_data
                s.amount_total AS subscription_amount_total,
                s.created_at AS subscription_created_at,
                s.mode AS subscription_mode,
                s.subscription_status,
                s.current_period_start,
                s.current_period_end,
                s.plan_interval,
                s.plan_amount,
                s.trial_start,
                s.trial_end,
                s.updated_date AS subscription_updated_date,
                upa.page_name AS last_page_accessed,
                upa.access_timestamp AS last_access_timestamp,
                upa.device_type AS last_access_device_type,
                upa.ip_address AS last_access_ip_address
            FROM
                users u
            JOIN
                users_data ud ON u.id = ud.user_id
            JOIN
                subscriptions s ON u.id = s.user_id
            LEFT JOIN
                user_page_access upa ON u.id = upa.user_id
                AND upa.access_timestamp = (
                    SELECT MAX(upa_inner.access_timestamp)
                    FROM user_page_access upa_inner
                    WHERE upa_inner.user_id = u.id -- Subconsulta correlacionada
                )
            WHERE
                u.id = ?;
        ";
        $params = [$user_id];
        $types = "i";

        $stmt = self::$db->prepare($query);
        if (!$stmt) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}
        $stmt->bind_param($types, ...$params);
        if(!$stmt->execute()){throw new Exception("An error occurred while processing your request. Please try again later.", 1);}
        $result = $stmt->get_result();
        if (!$result) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}
        $user_data = $result->fetch_assoc();
        if (!$user_data) { throw new Exception("An unexpected error occurred. Please try again later.", 1);}
        // Apply htmlspecialchars to each value in the $user_data array
        foreach ($user_data as &$value) {
            $value = htmlspecialchars($value);
        }
        return $user_data;
    }


    // Métodos para consultar user_special_data de la base de datos 'mind'
    private static function getMindDbConnection(){
        require_once __DIR__ . '/../config/config.php';
        $db_mind = mysqli_connect($_ENV["db_host"], $_ENV["db_user_mind"], $_ENV["db_password_mind"], $_ENV['db_name_mind']);
        
        if (!$db_mind) {
            throw new Exception("An error occurred while connecting to the mind database.", 1);
        }
        
        return $db_mind;
    }

    public static function getTherapists($data_array){
        // Paso 1: Obtener datos de user_special_data de la BD 'mind'
        $db_mind = self::getMindDbConnection();
        
        $query = "SELECT * 
            FROM user_special_data
            WHERE user_is_therapist = 1
            ORDER BY id DESC 
            LIMIT ? OFFSET ?
        ";
        $params = [$data_array["limit"], $data_array["offset"]];
        $types = "ii";

        $stmt = $db_mind->prepare($query);
        if (!$stmt) { 
            mysqli_close($db_mind);
            throw new Exception("An unexpected error occurred. Please try again later.", 1);
        }

        $stmt->bind_param($types, ...$params);
        if(!$stmt->execute()){
            mysqli_close($db_mind);
            throw new Exception("An error occurred while processing your request. Please try again later.", 1);
        }

        $result = $stmt->get_result();
        if (!$result) { 
            mysqli_close($db_mind);
            throw new Exception("An unexpected error occurred. Please try again later.", 1);
        }

        $therapists_data = $result->fetch_all(MYSQLI_ASSOC);
        mysqli_close($db_mind);

        // Si no hay terapeutas, retornar array vacío
        if (empty($therapists_data)) {
            return [];
        }

        // Paso 2: Extraer los user_ids
        $user_ids = array_column($therapists_data, 'user_id');
        
        // Paso 3: Obtener datos de usuarios de la BD principal
        $placeholders = implode(',', array_fill(0, count($user_ids), '?'));
        $query_users = "SELECT 
                u.id,
                u.name, 
                u.email,
                ud.profile_picture
            FROM users u
            JOIN users_data ud ON u.id = ud.user_id
            WHERE u.id IN ($placeholders)
        ";
        
        $stmt_users = self::$db->prepare($query_users);
        if (!$stmt_users) { 
            throw new Exception("An unexpected error occurred. Please try again later.", 1);
        }

        // Crear el tipo de parámetros dinámicamente (todos son integers)
        $types_users = str_repeat('i', count($user_ids));
        $stmt_users->bind_param($types_users, ...$user_ids);
        
        if(!$stmt_users->execute()){
            throw new Exception("An error occurred while processing your request. Please try again later.", 1);
        }

        $result_users = $stmt_users->get_result();
        if (!$result_users) { 
            throw new Exception("An unexpected error occurred. Please try again later.", 1);
        }

        $users_data = $result_users->fetch_all(MYSQLI_ASSOC);

        // Paso 4: Crear un mapa de usuarios para acceso rápido
        $users_map = [];
        foreach ($users_data as $user) {
            $users_map[$user['id']] = $user;
        }

        // Paso 5: Combinar los datos
        $therapists = [];
        foreach ($therapists_data as $therapist) {
            $user_id = $therapist['user_id'];
            
            // Combinar datos de ambas bases de datos
            $combined = array_merge($therapist, [
                'name' => $users_map[$user_id]['name'] ?? '',
                'email' => $users_map[$user_id]['email'] ?? '',
                'profile_picture' => $users_map[$user_id]['profile_picture'] ?? ''
            ]);
            
            // Apply htmlspecialchars
            foreach ($combined as $key => $value) {
                if ($value !== null) {
                    $combined[$key] = htmlspecialchars($value);
                }
            }
            
            $therapists[] = $combined;
        }

        return $therapists;
    }

    public static function getTherapistsRowsCount(){
        $db_mind = self::getMindDbConnection();
        
        $query = "SELECT COUNT(*) as total_rows 
            FROM user_special_data 
            WHERE user_is_therapist = 1
        ";
        $stmt = $db_mind->prepare($query);
        if (!$stmt) { 
            mysqli_close($db_mind);
            throw new Exception("An unexpected error occurred. Please try again later.", 1);
        }

        if(!$stmt->execute()){
            mysqli_close($db_mind);
            throw new Exception("An error occurred while processing your request. Please try again later.", 1);
        }

        $result = $stmt->get_result();
        if (!$result) { 
            mysqli_close($db_mind);
            throw new Exception("An unexpected error occurred. Please try again later.", 1);
        }

        $data = $result->fetch_assoc();
        mysqli_close($db_mind);
        return $data["total_rows"];
    }


}
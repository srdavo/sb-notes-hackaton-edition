<?php
require_once("../config/connect.php");
require_once("../models/Account.php");
require_once("../config/session.php");
require_once("../config/csrf_verification.php");

$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);
switch ($data["op"]) {
    case 'sign_up':

        if(!isset($data["email"]) || !isset($data["password"]) || !isset($data["password_repeat"])){
            $response = ["success" => false, "message" => "Invalid data"];
            echo json_encode($response);
            exit;
        }
        
        $data_array = [
            // "name" => $data["name"],
            "email" => $data["email"],
            "pwd" => $data["password"],
            "repeat_pwd" => $data["password_repeat"],
            "remember_me" => $data["remember_me"],
        ];

        try {
            $db->autocommit(false);

            if(isset($_SESSION["id"])){throw new Exception("Session already exists");}

            // Validations
            if(isset($data["email"]) && !filter_var($data["email"], FILTER_VALIDATE_EMAIL)){
                throw new Exception("Invalid email");
            }
            if($data["password"] !== $data["password_repeat"]){
                throw new Exception("Passwords do not match");
            }
        

            $check_email_taken = Account::checkEmailTaken($data_array["email"]);
            if($check_email_taken){throw new Exception("email_taken");}

            $create_account = Account::signUp($data_array); // Returns the user_id
            $set_user_data = Account::setUserData($create_account, $data_array["terms"]);

            // Login user
            $user_id = $create_account;
            $user_data = Account::getUserData($user_id);
            $user_data["email"] = $data_array["email"];
            $user_data["id"] = $user_id;

            $login = Account::logIn($user_data);

            if($data_array["remember_me"]){
                $remember_me = Account::rememberMe($user_id);
            }

            $db->commit();
            $response = [
                "success" => true, 
                "message" => "Account created successfully",
                "debug" => $check_email_taken
            ];
        } catch (Exception $e) {
            $db->rollback();
            $response = ["success" => false, "message" => $e->getMessage()];
        }


        echo json_encode($response);
        break;
    case "log_in":
        
        if(!isset($data["email"]) || !isset($data["password"])){
            $response = ["success" => false, "message" => "Invalid data"];
            echo json_encode($response);
            exit;
        }

        $data_array = [
            "email" => $data["email"],
            "pwd" => $data["password"],
            "remember_me" => $data["remember_me"],
            "terms" => $data["terms"],
        ];

        try{
            $db->autocommit(false);

            if(isset($_SESSION["id"])){throw new Exception("Session already exists");}

            // Validations
            if(isset($data["email"]) && !filter_var($data["email"], FILTER_VALIDATE_EMAIL)){
                throw new Exception("Invalid email");
            }
            if(!$data["terms"]){
                throw new Exception("You must accept the terms and conditions");
            }


            $check_email_taken = Account::checkEmailTaken($data_array["email"]);
            if(!$check_email_taken){throw new Exception("Invalid login");}

            $is_google_account = Account::checkGoogleId($data_array["email"]);
            if($is_google_account){throw new Exception("google_account", 1);}

            $user_hashed_password = Account::getUserHashedPassword($data_array["email"]);
            if(!password_verify($data_array["pwd"], $user_hashed_password)){throw new Exception("invalid_credentials");}

            $user_id = Account::getUserId($data_array["email"]);
            $user_data = Account::getUserData($user_id);
            $user_data["email"] = $data_array["email"];
            $user_data["id"] = $user_id;

            $login = Account::logIn($user_data);

            if($data_array["remember_me"]){
                $remember_me = Account::rememberMe($user_id);
            }

            $db->commit();
            $response = [
                "success" => true, 
                "message" => "Logged in successfully",
                "remember_me" => $data_array["remember_me"]
            ];
        } catch (Exception $e) {
            $db->rollback();
            $response = ["success" => false, "message" => $e->getMessage()];
        }
        
        echo json_encode($response);
        break;

    case "remember_me":

        if(!isset($data["token"])){
            $response = ["success" => false, "message" => "Invalid data"];
            echo json_encode($response);
            exit;
        }

        try{
            $db->autocommit(false);

            if(isset($_SESSION["id"])){throw new Exception("Session already exists");}

            if (strpos($data["token"], ":") === false) {
                throw new Exception("Invalid token format", 1);
            }

            list($token_id_from_cookie, $token_from_cookie) = explode(":", $data["token"], 2);
            if(!$token_id_from_cookie || !$token_from_cookie){throw new Exception("Invalid token 127", 1);}

            $validate_token = Account::validateRememberMeToken($token_id_from_cookie, $token_from_cookie);
            // this has the user id

            // validation true: log in user
            $user_data = Account::getUserData($validate_token);
            $login = Account::logIn($user_data);

            // invalid token
            Account::invalidateRememberMeTokenById($token_id_from_cookie);

            // generate new token
            Account::rememberMe($validate_token);
            
            $db->commit();
            $response = ["success" => true, "message" => "Remember Me login successful"];
        } catch (Exception $e) {
            $db->rollback();
            $response = ["success" => false, "message" => $e->getMessage()];
        }

        echo json_encode($response);
        break;

    case "check_session":
    
        if(!isset($_SESSION["id"])){ // **Use $_SESSION["id"] for consistency (or $_SESSION["user_id"] - just be consistent)**
            $response = ["success" => true, "message" => "No session", "session" => false]; // Success: true for API call itself
        } else {
            $response = ["success" => true, "message" => "Session active", "session" => true]; // **Add "session active" response!**
        }
        echo json_encode($response);
        break;
    case "log_out":
        
        try {
            $db->autocommit(false);
            
            // if(!isset($_SESSION["id"])){ throw new Exception("No session", 1);}

            if(isset($_COOKIE["codemelon-remember_me"])){

                if(strpos($_COOKIE["codemelon-remember_me"], ":") === false){throw new Exception("Invalid token 199", 1);}
                list($token_id_from_cookie, $token_from_cookie) = explode(":", $_COOKIE["codemelon-remember_me"], 2);
                if(!$token_id_from_cookie || !$token_from_cookie){throw new Exception("Invalid token 201", 1);}

                // invalid token
                Account::invalidateRememberMeTokenById($token_id_from_cookie);

                // delete cookie
                unset($_COOKIE["codemelon-remember_me"]);
                setcookie("codemelon-remember_me", "", time() - 3600, "/", $_ENV["domain"], true, true);

                unset($_COOKIE["codemelon-remember_me_js_accessible"]);
                setcookie("codemelon-remember_me_js_accessible", "", time() - 3600, "/", $_ENV["domain"], true, true);

            }
            $db->commit();

            

            session_unset();
            session_destroy();

            $response = ["success" => true, "message" => "Logged in successfully",];
        } catch (Exception $e) {
            $db->rollback();
            $response = ["success" => false, "message" => $e->getMessage()];
        }

        echo json_encode($response);
        break;
    case "google_auth":

        try {
            if(isset($_SESSION["id"])){throw new Exception("Session already exists");}

            if(!isset($data["credential"])){throw new Exception("Invalid data", 1);}

            if(!$data["terms"]){throw new Exception("Por favor acepta los términos y condiciones", 1);}

            list($header, $payload, $signature) = explode (".", $data["credential"]);
            $responsePayload = json_decode(base64_decode($payload));

            if(empty($responsePayload)){throw new Exception("Invalid credential", 1);}

            $email = $responsePayload->email;
            $name = $responsePayload->name;
            $google_id = $responsePayload->sub;
            $profile_picture = $responsePayload->picture;

            require_once '../config/google-api-php-client/vendor/autoload.php';
            $client_id = $_ENV["google_client_id"];
            $client_secret = $_ENV["google_client_secret"];

            $client = new Google\Client();
            $client->setClientId($client_id);
            $client->setClientSecret($client_secret);
            $client->setRedirectUri("http://localhost");

            // verify token
            $payload = $client->verifyIdToken($data["credential"]);
            if(!$payload){throw new Exception("Invalid token 259", 1);}

            // now that we verified the token, we can proceed to log or signup of the user
            $check_email_taken = Account::checkEmailTaken($email);
            if($check_email_taken){

                // check if the account is a google id account, if not, throw an error, suggest to log in with email and password
                $check_google_id = Account::checkGoogleId($email);
                if(!$check_google_id){throw new Exception("not_a_google_account", 1);}

                // login user
                $user_id = Account::getUserId($email);
                $user_data = Account::getUserData($user_id);
                $login = Account::logIn($user_data);
                $remember_me = Account::rememberMe($user_id);
            }else{

                // check if the username is taken and generate a unique one if it is
                // $check_username_taken = Account::checkUsernameTaken($name);
                // if($check_username_taken){ $name = Account::generateUniqueName($name);}

                // create account with google account data
                $random_password = bin2hex(random_bytes(16)); // Generate secure random password
                $create_account = Account::signUp(["email" => $email, "pwd" => $random_password, "name" => $name]);
                $set_user_data = Account::setCompleteUserData($create_account, ["google_id" => $google_id, "profile_picture" => $profile_picture, "terms" => $data["terms"]]);

                // login user
                $user_id = $create_account;
                $user_data = Account::getUserData($user_id);
                $login = Account::logIn($user_data);
                $remember_me = Account::rememberMe($user_id);
            }

            $db->commit();
            $response = ["success" => true, "message" => "Google Auth successful",];

        } catch (Exception $e) {
            $db->rollback();
            $response = ["success" => false, "message" => $e->getMessage()];
            // $response = ["success" => false, "message" => $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine()];
        }

        echo json_encode($response);
        break;
    case "get_user_data":

        if(!isset($_SESSION["id"])){
            $response = ["success" => false, "message" => "No session"];
            echo json_encode($response);
            exit;
        }

        echo json_encode([
            "success" => true, 
            "email" => htmlspecialchars($_SESSION["email"]), 
            "name" => htmlspecialchars($_SESSION["user"]), 
            // "name" => $_SESSION["user"], 
            "id" => $_SESSION["id"]
        ]);
        break;
    case "modify_user_data":

        try {
            $db->autocommit(false);

            if(!isset($data["name"])){throw new Exception("Invalid data", 1);}
            if(!isset($_SESSION["id"])){throw new Exception("No session", 1);}
            if($data["name"] === $_SESSION["user"]){throw new Exception("Same name", 1);}

            $check_username_taken = Account::checkUsernameTaken($data["name"]);
            if($check_username_taken){throw new Exception("name_taken", 1);}

            $data_array = [
                "name" => $data["name"],
                // this is where i would add more fields to update in the future
            ];


            $modify_user_data = Account::modifyUserData($userid, $data_array);

            $db->commit();
            $response = ["success" => true, "message" => "User data modified successfully"];
        } catch (Exception $e) {
            $db->rollback();
            $response = ["success" => false, "message" => $e->getMessage()];
        }
        
        echo json_encode($response);
        break;
    case "register_access":
        try {
            $db->autocommit(false);

            if(!isset($data["app"]) || !isset($data["device"])){throw new Exception("Invalid data", 1);}
            if(!isset($_SESSION["id"])){throw new Exception("No session", 1);}

            $ip_address = $_SERVER['REMOTE_ADDR'];


            $data_array = [
                "user_id" => $userid,
                "app" => $data["app"],
                "device" => $data["device"],
                "ip_address" => $ip_address,
            ];

            $register_access = Account::registerAccess($data_array);

            $db->commit();
            $response = ["success" => true];
        } catch (Exception $e) {
            $db->rollback();
            $response = ["success" => false, "message" => $e->getMessage()];
        }
        
        echo json_encode($response);
        break;
    case "insert_request":
        try {
            $db->autocommit(false);

            // if(!isset($data["email"]) || isset($data["phone"]) || !isset($data["checkbox"])){throw new Exception("Invalid data", 1);}
            if($data["checkbox"] !== true){throw new Exception("Es necesario aceptar la política de privacidad", 1);}

            $data_array = [
                "email" => $data["email"],
                "phone" => $data["phone"],
                "checkbox" => $data["checkbox"],
            ];


            $exists = Account::checkIfEmailOrNumberAlreadyRequestedDemo($data_array);
            if($exists){throw new Exception("Ya hemos recibido tus datos antes", 1);}

            $app_request_demo = Account::appRequestDemo($data_array);

            $db->commit();
            $response = ["success" => true];
        } catch (Exception $e) {
            $db->rollback();
            $response = ["success" => false, "message" => $e->getMessage()];
        }

        echo json_encode($response);
        break;
    case "send_password_reset_request":

        require_once(__DIR__ . "/../models/Email.php");
        
        $data_array = [
            "email" => $data["email"],
        ];

        try {
            $db->autocommit(false);
            if(!isset($data_array["email"])){throw new Exception("Invalid data", 1);}

            // validations
            if(!filter_var($data_array["email"], FILTER_VALIDATE_EMAIL)){throw new Exception("Invalid email", 1);}

            $check_email_taken = Account::checkEmailTaken($data_array["email"]);
            if(!$check_email_taken){throw new Exception("El correo no existe", 1);}

            $check_is_google_account = Account::checkGoogleId($data_array["email"]);
            if($check_is_google_account){throw new Exception("Tu cuenta está conectada a Google. Para cambiar tu contraseña, hazlo desde tu cuenta de Google", 1);}

            $user_id = Account::getUserId($data_array["email"]);
            $user_name = Account::getUserName($user_id);

            $data_array["user_id"] = $user_id;
            $data_array["reset_password_token"] = bin2hex(random_bytes(4)); // 64 character hex string
            $data_array["token_expiry"] = date('Y-m-d H:i:s', strtotime('+15 minutes'));
            
            $insert_reset_request = Account::insertPasswordResetRequest($data_array);

            $email_service = new Email();
            $email_service->send(
                $data_array["email"],
                $user_name,
                "=?UTF-8?B?".base64_encode("Solicitud de cambio de contraseña")."?=",
                '
                    <!DOCTYPE html>
                    <html lang="es">
                    <head>
                    <meta charset="UTF-8">
                    <title>Reseteo de Contraseña</title>
                    </head>
                    <body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">

                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                        <td align="center" style="padding: 20px 0; background-color: #f4f4f4;">

                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <tr>
                                <td style="padding: 30px 40px; text-align: left; color: #333333;">

                                <h1 style="font-size: 24px; margin-top: 0;">Hola '. htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8'). ',</h1>

                                <p style="font-size: 16px; line-height: 1.5;">Recibimos una solicitud para restablecer la contraseña de tu cuenta.</p>

                                <div style="background-color: #f8f9fa; border: 2px dashed #dee2e6; border-radius: 8px; padding: 20px; margin: 25px 0; text-align: center;">
                                    <p style="font-size: 14px; color: #666; margin: 0 0 10px 0;">Tu código de verificación es:</p>
                                    <div style="font-size: 32px; font-weight: bold; color: #333; letter-spacing: 8px; font-family: \'Dm mono\', monospace;">
                                        '. htmlspecialchars($data_array["reset_password_token"], ENT_QUOTES, 'UTF-8'). '
                                    </div>
                                </div>

                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin: 20px 0; font-size: 16px;">
                                    <tr>
                                    <td style="padding: 8px 0;">⏰ <strong>Válido por:</strong> 15 minutos</td>
                                    </tr>
                                </table>

                                <hr style="border: none; border-top: 1px solid #e0e0e0; margin: 30px 0;">

                                <p style="font-size: 13px; color: #999;">Este mensaje se envió automáticamente como medida de seguridad.<br>
                                Por favor, no respondas a este correo. Si necesitas ayuda, contacta a nuestro equipo de soporte.</p>

                                </td>
                            </tr>
                            </table>

                        </td>
                        </tr>
                    </table>

                    </body>
                    </html>
                '
            );

            $db->commit();
            $response = [
                "success" => true,      
            ];

        } catch (Exception $e) {
            $db->rollback();
            $response = ["success" => false, "message" => $e->getMessage()];
        }

        echo json_encode($response);
        break;
    case "send_forgot_password_token":

        $data_array = [
            "token" => $data["token"],
            "email" => $data["email"]
        ];

        try {
            $db->autocommit(false);
            if(!isset($data_array["token"]) || !isset($data_array["email"])){throw new Exception("Invalid data", 1);}

            // validations
            if(!filter_var($data_array["email"], FILTER_VALIDATE_EMAIL)){throw new Exception("Invalid email", 1);}

            $check_email_taken = Account::checkEmailTaken($data_array["email"]);
            if(!$check_email_taken){throw new Exception("El correo no existe", 1);}

            $check_is_google_account = Account::checkGoogleId($data_array["email"]);
            if($check_is_google_account){throw new Exception("Tu cuenta está conectada a Google. Para cambiar tu contraseña, hazlo desde tu cuenta de Google", 1);}

            $data_array["user_id"] = Account::getUserId($data_array["email"]);

            $get_user_reset_password_request = Account::getUserResetPasswordRequest($data_array);
            if(!$get_user_reset_password_request){throw new Exception("No reset password request found", 1);}
            if($get_user_reset_password_request["reset_password_token"] !== $data_array["token"]){ throw new Exception("El código es incorrecto", 1); }
            if(strtotime($get_user_reset_password_request["reset_password_token_expiration"]) < time()){ throw new Exception("El código ha expirado", 1); }

            // if we reach this point, the token is valid, we can proceed to reset the password
            $db->commit();
            $response = ["success" => true];

        } catch (Exception $e) {
            $db->rollback();
            $response = ["success" => false, "message" => $e->getMessage()];
        }

        echo json_encode($response);
        break;
    case "update_password":
        $data_array = [
            "password" => $data["password"],
            "password_repeat" => $data["password_repeat"],
            "email" => $data["email"],
            "token" => $data["token"],
        ];

        try {
            $db->autocommit(false);
            if(!isset($data_array["password"]) || !isset($data_array["password_repeat"]) || !isset($data_array["email"]) || !isset($data_array["token"])){throw new Exception("Invalid data", 1);}

            // validations
            if(!filter_var($data_array["email"], FILTER_VALIDATE_EMAIL)){throw new Exception("Invalid email", 1);}
            if($data_array["password"] !== $data_array["password_repeat"]){throw new Exception("Las contraseñas no coinciden", 1);}

            $check_email_taken = Account::checkEmailTaken($data_array["email"]);
            if(!$check_email_taken){throw new Exception("El correo no existe", 1);}

            $check_is_google_account = Account::checkGoogleId($data_array["email"]);
            if($check_is_google_account){throw new Exception("Tu cuenta está conectada a Google. Para cambiar tu contraseña, hazlo desde tu cuenta de Google", 1);}

            $data_array["user_id"] = Account::getUserId($data_array["email"]);

            $get_user_reset_password_request = Account::getUserResetPasswordRequest($data_array);
            if(!$get_user_reset_password_request){throw new Exception("No reset password request found", 1);}
            if($get_user_reset_password_request["reset_password_token"] !== $data_array["token"]){ throw new Exception("El código es incorrecto", 1); }
            if(strtotime($get_user_reset_password_request["reset_password_token_expiration"]) < time()){ throw new Exception("El código ha expirado", 1); }

            // update password
            $update_password = Account::updatePassword($data_array);

            // delete reset password request
            Account::deleteResetPasswordRequest($data_array);

            $db->commit();
            $response = ["success" => true];

        } catch (Exception $e) {
            $db->rollback();
            $response = ["success" => false, "message" => $e->getMessage()];
        }

        echo json_encode($response);
        break;
    default:
        $response = [
            "success" => false,
            "message" => "Invalid Operation",
        ];
        echo json_encode($response);
        break;
}

// if (!hash_equals($_SESSION['csrf_token'], $csrfToken)) {
//     http_response_code(403);
//     echo json_encode("CSRF token mismatch");
//     exit;
// }
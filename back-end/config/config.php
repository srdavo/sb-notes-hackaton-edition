<?php
// $env_path = dirname(__DIR__) . '/../../.env';
$env_path = dirname(__DIR__) . '/../../sb.env'; // Production

define('ROOT_PATH', dirname(__DIR__, 4));


if (file_exists($env_path)) {
    $env_vars = parse_ini_file($env_path);
    if ($env_vars === false) {
        die("Failed to parse .env file. Check file format."); // Handle parsing errors
    }

    // Access environment variables from the $env_vars array
    $_ENV['db_host'] = $env_vars['DB_HOST'] ?? 'localhost'; // Default to 'localhost' if not found
    $_ENV['db_user'] = $env_vars['DB_USER_MAIN'] ?? '';
    $_ENV['db_password'] = $env_vars['DB_PASSWORD_MAIN'] ?? '';
    $_ENV['db_name'] = $env_vars['DB_NAME_MAIN'] ?? '';
    $_ENV['google_client_id'] = $env_vars['GOOGLE_CLIENT_ID'] ?? '';
    $_ENV['google_client_secret'] = $env_vars['GOOGLE_CLIENT_SECRET'] ?? '';
    $_ENV['domain'] = $env_vars['DOMAIN'] ?? '';
    $_ENV['db_user_mind'] = $env_vars['DB_USER_MIND'] ?? '';
    $_ENV['db_password_mind'] = $env_vars['DB_PASSWORD_MIND'] ?? '';
    $_ENV['db_name_mind'] = $env_vars['DB_NAME_MIND'] ?? '';
    $_ENV['STRIPE_SECRET_KEY'] = $env_vars['STRIPE_SECRET_KEY'] ?? '';
    $_ENV['STRIPE_PUBLIC_KEY'] = $env_vars['STRIPE_PUBLIC_KEY'] ?? '';
    $_ENV['STRIPE_WEBHOOK_SECRET'] = $env_vars['STRIPE_WEBHOOK_SECRET'] ?? '';
    $_ENV['STRIPE_PRODUCT_ID'] = $env_vars['STRIPE_PRODUCT_ID'] ?? '';
    $_ENV['encryption_password'] = $env_vars['ENCRYPTION_PASSWORD'] ?? '';
    $_ENV['email_password'] = $env_vars['EMAIL_PASSWORD'] ?? '';
    $_ENV["verifactu_service_key"] = $env_vars['VERIFACTU_SERVICE_KEY'] ?? '';
    $_ENV["whatsapp_api_key"] = $env_vars['WHATSAPP_API_KEY'] ?? '';

} else {
    die(".env file not found at: " . $env_path . ". Please create it outside the web root."); // Handle missing .env file
}

$_ENV["APP_NAME"] = "Codemelon";


// backend variables
$_ENV["SESSION_NAME"] = "codemelon-session";


// Time zone
date_default_timezone_set('UTC');// Set the default timezone
<?php
define('ROOT_PATH', dirname(__DIR__, 4));
define('BASE_URL', '/');

// =====================
// DATABASES
// =====================
$_ENV['db_host']              = 'localhost';
$_ENV['db_user']              = 'lesly';
$_ENV['db_password']          = '!14L02R30T:3';
$_ENV['db_name']              = 'cocounut_sb';

$_ENV['db_user_mind']         = 'lesly';
$_ENV['db_password_mind']     = '!14L02R30T:3';
$_ENV['db_name_mind']         = 'sb_mind';

$_ENV['db_user_calories']     = 'lesly';
$_ENV['db_password_calories'] = '!14L02R30T:3';
$_ENV['db_name_calories']     = 'sb_calories';

$_ENV["db_user_hackaton"]     = "lesly";
$_ENV["db_password_hackaton"] = "!14L02R30T:3";
$_ENV['db_name_hackaton']     = 'hackaton';

// =====================
// GOOGLE OAUTH
// =====================

// =====================
// DOMAIN
// =====================
$_ENV['domain']               = 'localhost';

// =====================
// STRIPE KEYS
// =====================

// =====================
// ENCRYPTION / EMAIL
// =====================
$_ENV['encryption_password']  = 'ghrbyfntv';

// =====================
// EXTERNAL SERVICES
// =====================

// =====================
// APP CONFIG
// =====================
$_ENV['APP_NAME']             = 'stepbro';
$_ENV['SESSION_NAME']         = 'stepbro-session';

// =====================
// TIMEZONE
// =====================
date_default_timezone_set('America/Monterrey');
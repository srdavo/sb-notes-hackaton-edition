<?php
// No longer uses .env — all values are defined directly here.

define('ROOT_PATH', dirname(__DIR__, 4));

// =====================
// DATABASES
// =====================
$_ENV['db_host']              = 'localhost';
$_ENV['db_user']              = 'root';
$_ENV['db_password']          = 'sdqxeacwz';
$_ENV['db_name']              = 'cocounut_sb';

$_ENV['db_user_mind']         = 'root';
$_ENV['db_password_mind']     = 'sdqxeacwz';
$_ENV['db_name_mind']         = 'sb_mind';

$_ENV['db_user_calories']     = 'root';
$_ENV['db_password_calories'] = 'sdqxeacwz';
$_ENV['db_name_calories']     = 'sb_calories';

$_ENV["db_user_hackaton"]     = "root";
$_ENV["db_password_hackaton"] = "sdqxeacwz";
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

<?php

// Database Settings
$config = [
    "DB_HOST" => "localhost",
    "DB_USER" => "",
    "DB_PASS" => "",
    "DB_NAME" => ""
];

// Application Settings
define("SITE_URL", "http://localhost/"); // Example: http://localhost/BlackLogger/app
define("APP_PATH", dirname(__FILE__, 2) . DIRECTORY_SEPARATOR); // ( Don't Change );
define("LOGS_PATH", APP_PATH . "php_logs.log"); // ( Don't Change );

require_once 'environment.php';

// Autoload Composer
require_once APP_PATH . 'vendor/autoload.php';

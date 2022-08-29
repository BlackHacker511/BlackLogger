<?php
session_start();
require_once 'config/config.php';

$database = new Framework\Database($config);
$utils = new Framework\Utils();

$auth = new Framework\Authentication($database, $utils);
$user = new Framework\User($database, $utils);

/** Lock out time used for brute force protection */

$lockout_time = 10;

/** Check if user is already log in */

if (isset($_SESSION['loggedin'])) {
    $utils->redirect(SITE_URL . "/index.php");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $utils->sanitize($_POST['username']);
    $password = $utils->sanitize($_POST['password']);

    $loginstatus = $auth->newLogin($username, $password);

    if ($loginstatus == 200) {
        if (!isset($error)) {
            session_regenerate_id();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;

            $utils->redirect(SITE_URL . "/index.php");
        }
    } elseif ($loginstatus == 401) {
        $error = "Username or Password is incorrect.";
    } elseif ($loginstatus == 403) {
        $error = "This account has been locked because of too many failed logins.
        \nIf this is the case, please try again in $lockout_time minutes.";
    } else {
        $error = "Unexpected error occurred !";
    }
}

$page = "loginPage";

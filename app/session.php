<?php

session_start();

require_once 'config/config.php';

$utils = new Framework\Utils();

$database = new Framework\Database($config);

$user = new Framework\User($database, $utils);

$auth = new Framework\Authentication($database, $utils);

$current_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if (isset($_SESSION)) {
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

    if (!isset($_SESSION['loggedin'])) {
        $utils->redirect(SITE_URL . "/login.php");
    }

    if ($username != null) {
        $data = $user->getUserData($username);

        if (!isset($_SESSION['current_ip'])) {
            $_SESSION['current_ip'] = $utils->sanitize($_SERVER['REMOTE_ADDR']);
        }

        if (!(isset($_SESSION['csrf']))) {
            $auth->generateSessionToken();
        }
    } else {
        $utils->redirect(SITE_URL . "/login.php");
    }
}

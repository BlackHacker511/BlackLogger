<?php

session_start();

require_once 'config/config.php';

$utils = new Framework\Utils();

if (session_destroy()) {
    $utils->redirect(SITE_URL . "/login.php");
}

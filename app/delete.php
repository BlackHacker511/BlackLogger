<?php

include_once 'session.php';

$link = new Framework\Shortener($database);

if ($auth->checkToken($_GET['t'], $_SESSION['csrf'])) {
    $link->deleteLink($_GET['c']);

    $utils->redirect(SITE_URL . '/links.php?message=success');
}

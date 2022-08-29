<?php

$link = new Framework\Shortener($database);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $lg = $utils->sanitize($_POST['long_url']);

    if ($link->updateLink($id, $lg)) {
        $message = "yes";
    }
}

$l = $link->getUrlFromDB($_GET['sc']);
$s = $link->urlToShortCode($l->long_url);

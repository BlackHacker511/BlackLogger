<?php

include_once '../session.php';

$link = new Framework\Shortener($database);

$link->createShortCode($_POST["longUrl"]);

echo json_encode(['response' => true]);

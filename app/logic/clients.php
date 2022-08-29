<?php
require_once 'config/config.php';

$utils = new Framework\Utils();

$database = new Framework\Database($config);

$logger = new Framework\Logger($database, $utils);

$client = new Framework\Client($database, $utils);

$c = $client->getClients();

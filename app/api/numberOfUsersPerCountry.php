<?php

header("Content-Type: application/json");
require_once '../config/config.php';

$utils = new Framework\Utils();

$database = new Framework\Database($config);

$logger = new Framework\Logger($database, $utils);

$client = new Framework\Client($database, $utils);

$countries = $utils->getCountries();
$arrays = [];
foreach ($countries as $data => $value) {
    array_push(
        $arrays,
        [
            "id" => $data,
            "value" => $client->countClientsByCond("country", $data)
        ]
    );
}
echo json_encode(["countries" => $arrays]);

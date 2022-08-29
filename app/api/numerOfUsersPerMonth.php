<?php

header("Content-Type: application/json");
require_once '../config/config.php';

$database = new Framework\Database($config);

$utils = new Framework\Utils();

$clients = new Framework\Client($database, $utils);

$count = [];

$temp = [];

if ($clients->countClients() > 0) {
    foreach ($clients->selectInfoFromClients('created_at') as $dd) {
        if (date("Y", strtotime($dd->created_at)) == date("Y")) {
            $month = date("m", strtotime($dd->created_at));

            if (!key_exists($month, $temp)) {
                $temp[$month] = 0;
            }

            $temp[$month] += 1;
        }
    }

    foreach ($temp as $key => $value) {
        array_push($count, [
            'label' => date('F', mktime(0, 0, 0, $key, 10)),
            'data' => $value
        ]);
    }
} else {
    array_push($count, ["label" => "Nothing", "data" => 0]);
}

echo json_encode($count);

<?php

include_once 'app/config/config.php';

$db = new Framework\Database($config);

$shortener = new Framework\Shortener($db);

$utils = new Framework\Utils();

$browser = new foroco\BrowserDetection();

$client = new Framework\Client($db, $utils);

if (isset($_GET['c']) && strlen($_GET['c']) == 6) {
    $client->newClient([
        'ip_address' => $utils->getIP()->ip,
        'country' => strtolower($utils->getIP()->cc),
        'os' => $browser->getOS($_SERVER['HTTP_USER_AGENT'])['os_name'],
        'browser' => $browser->getBrowser($_SERVER['HTTP_USER_AGENT'])['browser_name'],
        'device' => $browser->getDevice($_SERVER['HTTP_USER_AGENT'])['device_type'],
        'created_at' => date("Y-m-d H:i:s", time()),
    ]);

    $shortCode = rtrim($utils->sanitize($_GET["c"]), "/");

    $utils->redirect($shortener->shortCodeToUrl($shortCode));
}

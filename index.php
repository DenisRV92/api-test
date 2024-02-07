<?php

require_once __DIR__ . '/vendor/autoload.php';

use Src\Service;

$service = new Service();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    if (!array_key_exists('key', $requestData)) {
        http_response_code(400);
        echo "invalid parameter";
        return false;
    }
    $service->handleRequest($requestData);
} else {
    http_response_code(405);
    echo "Method Not Allowed";
}

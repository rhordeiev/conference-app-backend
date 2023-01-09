<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Application\Application;

$app = new Application();
header("Access-Control-Allow-Origin: https://conference-app-frontend.herokuapp.com/");
header('Access-Control-Allow-Headers: Origin, Content-Type');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Content-Type:application/json');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    return 0;
}
$clientData = match ($_SERVER['REQUEST_METHOD']) {
    'GET' => $_GET,
    'POST' => $_POST,
    'DELETE' => [],
    'PUT' => json_decode(file_get_contents("php://input"), true),
};
$response = $app->run(
    $_SERVER['PATH_INFO'],
    $_SERVER['REQUEST_METHOD'],
    $clientData
);
header("HTTP/1.1 {$response['code']} {$response['message']}");
http_response_code($response['code']);
echo json_encode($response);

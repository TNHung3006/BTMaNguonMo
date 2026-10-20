<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../src/ApiClient.php';

use AddressConverter\ApiClient;

try {
    $client = new ApiClient();
    $result = $client->getProvinces();
    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => 'Lỗi máy chủ: ' . $e->getMessage(),
        'data'    => [],
    ], JSON_UNESCAPED_UNICODE);
}


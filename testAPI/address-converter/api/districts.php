<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../src/ApiClient.php';

use AddressConverter\ApiClient;

$province = $_GET['province'] ?? $_POST['province'] ?? '';

if (empty($province)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error'   => 'Thiếu mã Tỉnh/Thành phố (province).',
        'data'    => [],
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $client = new ApiClient();
    $result = $client->getDistricts($province);
    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => 'Lỗi máy chủ: ' . $e->getMessage(),
        'data'    => [],
    ], JSON_UNESCAPED_UNICODE);
}


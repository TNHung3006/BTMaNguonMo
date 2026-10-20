<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../src/ApiClient.php';

use AddressConverter\ApiClient;

$province = $_REQUEST['province'] ?? '';
$district = $_REQUEST['district'] ?? '';
$ward     = $_REQUEST['ward'] ?? '';
$street   = $_REQUEST['street'] ?? '';

if (empty($province) || empty($district) || empty($ward)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error'   => 'Vui lòng cung cấp đầy đủ Tỉnh/Thành phố, Quận/Huyện và Phường/Xã.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $client = new ApiClient();
    $result = $client->convertAddress($province, $district, $ward, $street);
    
    if (!$result['success']) {
        http_response_code(502);
    }
    
    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => 'Lỗi máy chủ: ' . $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}


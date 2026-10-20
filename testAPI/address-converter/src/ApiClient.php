<?php
namespace AddressConverter;

class ApiClient
{
    private const BASE_API_URL = 'https://www.tinhthanhpho.com/api/v1';
    private const BASE_CONVERT_URL = 'https://www.tinhthanhpho.com/convert';
    private string $cacheDir;
    private int $defaultTimeout = 15;
    private int $connectTimeout = 5;

    public function __construct(?string $cacheDir = null)
    {
        $this->cacheDir = $cacheDir ?? dirname(__DIR__) . '/cache';
        if (!is_dir($this->cacheDir)) {
            @mkdir($this->cacheDir, 0777, true);
        }
    }

    /**
     * Thực hiện gửi request cURL
     */
    private function executeCurl(string $url, string $method = 'GET', ?array $headers = [], ?string $postData = null): array
    {
        $ch = curl_init($url);
        
        $defaultHeaders = [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Accept: application/json, text/html, */*',
            'Accept-Language: vi,en;q=0.9',
        ];
        $allHeaders = array_merge($defaultHeaders, $headers ?? []);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 5,
            CURLOPT_TIMEOUT        => $this->defaultTimeout,
            CURLOPT_CONNECTTIMEOUT => $this->connectTimeout,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER     => $allHeaders,
        ]);

        if (strtoupper($method) === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($postData !== null) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            }
        }

        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        $curlErrno = curl_errno($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($curlErrno !== 0) {
            return [
                'success' => false,
                'status'  => 0,
                'error'   => "Lỗi kết nối mạng: {$curlError} (Mã lỗi cURL: {$curlErrno})",
                'data'    => null,
            ];
        }

        if ($httpCode >= 400) {
            return [
                'success' => false,
                'status'  => $httpCode,
                'error'   => "Máy chủ API trả về mã lỗi HTTP {$httpCode}",
                'data'    => $response,
            ];
        }

        return [
            'success' => true,
            'status'  => $httpCode,
            'body'    => $response,
        ];
    }

    /**
     * Đọc cache từ file
     */
    private function getCache(string $key, int $ttl = 86400): ?array
    {
        $file = $this->cacheDir . '/' . md5($key) . '.json';
        if (file_exists($file) && (time() - filemtime($file) < $ttl)) {
            $content = file_get_contents($file);
            $json = json_decode($content, true);
            if (is_array($json)) {
                return $json;
            }
        }
        return null;
    }

    /**
     * Ghi cache ra file
     */
    private function setCache(string $key, array $data): void
    {
        $file = $this->cacheDir . '/' . md5($key) . '.json';
        @file_put_contents($file, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * Lấy danh sách Tỉnh/Thành phố
     */
    public function getProvinces(): array
    {
        $cacheKey = 'provinces_list_v1';
        $cached = $this->getCache($cacheKey, 86400);
        if ($cached !== null) {
            return ['success' => true, 'data' => $cached];
        }

        $url = self::BASE_API_URL . '/provinces?limit=100';
        $res = $this->executeCurl($url);

        if (!$res['success']) {
            return ['success' => false, 'error' => $res['error'], 'data' => []];
        }

        $json = json_decode($res['body'], true);
        if (!isset($json['data']) || !is_array($json['data'])) {
            return ['success' => false, 'error' => 'Dữ liệu tỉnh thành không hợp lệ.', 'data' => []];
        }

        $list = [];
        foreach ($json['data'] as $item) {
            $type = $item['type'] ?? '';
            $name = $item['name'] ?? '';
            $fullName = trim($type . ' ' . $name);
            $list[] = [
                'code'      => (string)($item['code'] ?? ''),
                'name'      => $name,
                'type'      => $type,
                'full_name' => $fullName,
            ];
        }

        // Sắp xếp: Ưu tiên TP trực thuộc TƯ rồi theo chữ cái, hoặc theo chuẩn bảng
        usort($list, function ($a, $b) {
            return strcmp($a['full_name'], $b['full_name']);
        });

        $this->setCache($cacheKey, $list);
        return ['success' => true, 'data' => $list];
    }

    /**
     * Lấy danh sách Quận/Huyện theo Tỉnh
     */
    public function getDistricts(string $provinceCode): array
    {
        $provinceCode = trim($provinceCode);
        if ($provinceCode === '') {
            return ['success' => false, 'error' => 'Mã tỉnh không được để trống.', 'data' => []];
        }

        $cacheKey = 'districts_' . $provinceCode;
        $cached = $this->getCache($cacheKey, 86400);
        if ($cached !== null) {
            return ['success' => true, 'data' => $cached];
        }

        $url = self::BASE_API_URL . '/provinces/' . urlencode($provinceCode) . '/districts?limit=100';
        $res = $this->executeCurl($url);

        if (!$res['success']) {
            return ['success' => false, 'error' => $res['error'], 'data' => []];
        }

        $json = json_decode($res['body'], true);
        if (!isset($json['data']) || !is_array($json['data'])) {
            return ['success' => false, 'error' => 'Dữ liệu quận huyện không hợp lệ.', 'data' => []];
        }

        $list = [];
        foreach ($json['data'] as $item) {
            $type = $item['type'] ?? '';
            $name = $item['name'] ?? '';
            $fullName = trim($type . ' ' . $name);
            $list[] = [
                'code'          => (string)($item['code'] ?? ''),
                'name'          => $name,
                'type'          => $type,
                'full_name'     => $fullName,
                'province_code' => (string)($item['province_code'] ?? $provinceCode),
            ];
        }

        usort($list, function ($a, $b) {
            // Sắp xếp tự nhiên (ví dụ Quận 1, Quận 2, Quận 10...)
            return strnatcasecmp($a['full_name'], $b['full_name']);
        });

        $this->setCache($cacheKey, $list);
        return ['success' => true, 'data' => $list];
    }

    /**
     * Lấy danh sách Xã/Phường theo Quận/Huyện
     */
    public function getWards(string $districtCode): array
    {
        $districtCode = trim($districtCode);
        if ($districtCode === '') {
            return ['success' => false, 'error' => 'Mã quận/huyện không được để trống.', 'data' => []];
        }

        $cacheKey = 'wards_' . $districtCode;
        $cached = $this->getCache($cacheKey, 86400);
        if ($cached !== null) {
            return ['success' => true, 'data' => $cached];
        }

        $url = self::BASE_API_URL . '/districts/' . urlencode($districtCode) . '/wards?limit=100';
        $res = $this->executeCurl($url);

        if (!$res['success']) {
            return ['success' => false, 'error' => $res['error'], 'data' => []];
        }

        $json = json_decode($res['body'], true);
        if (!isset($json['data']) || !is_array($json['data'])) {
            return ['success' => false, 'error' => 'Dữ liệu xã phường không hợp lệ.', 'data' => []];
        }

        $list = [];
        foreach ($json['data'] as $item) {
            $type = $item['type'] ?? '';
            $name = $item['name'] ?? '';
            $fullName = trim($type . ' ' . $name);
            $list[] = [
                'code'          => (string)($item['code'] ?? ''),
                'name'          => $name,
                'type'          => $type,
                'full_name'     => $fullName,
                'district_code' => (string)($item['district_code'] ?? $districtCode),
            ];
        }

        usort($list, function ($a, $b) {
            return strnatcasecmp($a['full_name'], $b['full_name']);
        });

        $this->setCache($cacheKey, $list);
        return ['success' => true, 'data' => $list];
    }

    /**
     * Chuyển đổi địa chỉ cũ sang địa chỉ mới 2 cấp
     */
    public function convertAddress(string $provinceCode, string $districtCode, string $wardCode, string $street = ''): array
    {
        $provinceCode = trim($provinceCode);
        $districtCode = trim($districtCode);
        $wardCode = trim($wardCode);
        $street = trim($street);

        if ($provinceCode === '' || $districtCode === '' || $wardCode === '') {
            return [
                'success' => false,
                'error'   => 'Vui lòng chọn đầy đủ Tỉnh/Thành phố, Quận/Huyện và Phường/Xã.',
            ];
        }

        $cacheKey = "convert_{$provinceCode}_{$districtCode}_{$wardCode}_" . md5($street);
        $cached = $this->getCache($cacheKey, 7200); // cache 2 giờ
        if ($cached !== null) {
            return ['success' => true, 'data' => $cached];
        }

        $query = http_build_query([
            'mode'     => 'select',
            'province' => $provinceCode,
            'district' => $districtCode,
            'ward'     => $wardCode,
            'street'   => $street,
        ]);

        $url = self::BASE_CONVERT_URL . '?' . $query;
        $res = $this->executeCurl($url);

        if (!$res['success']) {
            return ['success' => false, 'error' => $res['error']];
        }

        $html = $res['body'];
        if (preg_match('/<pre id="result-json">(.*?)<\/pre>/s', $html, $matches)) {
            $rawJson = html_entity_decode(trim($matches[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $data = json_decode($rawJson, true);

            if (is_array($data) && isset($data['old']) && isset($data['new'])) {
                // Thêm đường dẫn chi tiết nếu có slug
                if (!empty($data['new']['province']['slug']) && !empty($data['new']['ward']['slug'])) {
                    $data['new']['detail_url'] = "https://www.tinhthanhpho.com/{$data['new']['province']['slug']}/{$data['new']['ward']['slug']}";
                }
                $this->setCache($cacheKey, $data);
                return [
                    'success' => true,
                    'data'    => $data,
                ];
            }
        }

        return [
            'success' => false,
            'error'   => 'Không thể đọc được kết quả chuyển đổi từ hệ thống tinhthanhpho.com.',
            'raw'     => substr(strip_tags($html), 0, 300),
        ];
    }
}


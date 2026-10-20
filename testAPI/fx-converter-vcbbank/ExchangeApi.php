<?php
// Lớp gọi RapidAPI + cache file đơn giản.
class ExchangeApi
{
    public function __construct(private array $cfg) {}

    /** Lấy tỷ giá mid-rate: 1 $from = ? $to */
    public function getRate(string $from, string $to = 'VND'): float
    {
        $from = strtoupper($from);
        $to   = strtoupper($to);

        // Validate: chỉ cho phép 3 chữ cái -> tránh injection vào URL
        if (!preg_match('/^[A-Z]{3}$/', $from) || !preg_match('/^[A-Z]{3}$/', $to)) {
            throw new InvalidArgumentException('Mã tiền tệ không hợp lệ');
        }

        // 1) Đọc cache
        $cacheFile = __DIR__ . "/cache/{$from}_{$to}.json";
        if (is_file($cacheFile) && time() - filemtime($cacheFile) < $this->cfg['cache_ttl']) {
            $cached = json_decode(file_get_contents($cacheFile), true);
            if (isset($cached['rate'])) return (float)$cached['rate'];
        }

        // 2) Gọi API
        // LƯU Ý: kiểm tra lại đường dẫn/tham số trong tab "Code Snippets" (PHP-cURL) trên RapidAPI
        $url = "https://{$this->cfg['api_host']}/convert?" . http_build_query([
            'from' => $from, 'to' => $to, 'amount' => 1,
        ]);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_HTTPHEADER     => [
                'X-RapidAPI-Key: '  . $this->cfg['api_key'],
                'X-RapidAPI-Host: ' . $this->cfg['api_host'],
            ],
        ]);
        $body = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($body === false || $code !== 200) {
            throw new RuntimeException("Gọi API thất bại (HTTP $code)");
        }

        $data = json_decode($body, true);
        // Tuỳ API, giá trị nằm ở các key khác nhau -> thử vài key phổ biến
        $rate = $data['result'] ?? $data['rate'] ?? $data['info']['rate'] ?? null;
        if (!is_numeric($rate) || $rate <= 0) {
            throw new RuntimeException('Dữ liệu API không đúng định dạng: ' . substr($body, 0, 200));
        }

        // Tự tạo thư mục cache nếu chưa có (0755 = chủ sở hữu ghi được, người khác chỉ đọc)
        $dir = dirname($cacheFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        // Ghi cache là "tính năng phụ": nếu ghi lỗi thì bỏ qua, vẫn trả tỷ giá bình thường.
        // Dấu @ chặn warning để không làm hỏng JSON trả về.
        @file_put_contents($cacheFile, json_encode(['rate' => $rate, 'at' => date('c')]));
        return (float)$rate;
    }

    /** Từ mid-rate tính 3 loại giá theo biên độ */
    public function quote(float $mid): array
    {
        $m = $this->cfg['margin'];
        return [
            'cash'     => $mid * (1 + $m['cash']),
            'transfer' => $mid * (1 + $m['transfer']),
            'sell'     => $mid * (1 + $m['sell']),
        ];
    }
}

<?php
// ===== CẤU HÌNH =====
// Lấy key ở RapidAPI > tab "Code Snippets" (header X-RapidAPI-Key).
// KHÔNG commit key lên GitHub (thêm config.php vào .gitignore).
return [
    'api_key'  => 'a06a6c81a5mshc689423e3e49e56p113309jsn70d4450f99eb',
    'api_host' => 'currency-conversion-and-exchange-rates.p.rapidapi.com',

    // Biên độ % so với tỷ giá API (mô phỏng giá ngân hàng)
    // Ngân hàng mua vào thấp hơn mid-rate, bán ra cao hơn.
    'margin' => [
        'cash'     => -0.006, // Mua tiền mặt:     mid * (1 - 0.6%)
        'transfer' => -0.005, // Mua chuyển khoản: mid * (1 - 0.5%)
        'sell'     =>  0.010, // Bán:              mid * (1 + 1.0%)
    ],

    // Danh sách tiền tệ hiển thị trong bảng
    'currencies' => [
        'USD' => 'US DOLLAR',
        'EUR' => 'EURO',
        'GBP' => 'UK POUND STERLING',
        'JPY' => 'JAPANESE YEN',
        'AUD' => 'AUSTRALIAN DOLLAR',
        'SGD' => 'SINGAPORE DOLLAR',
        'THB' => 'THAI BAHT',
        'CAD' => 'CANADIAN DOLLAR',
    ],

    'cache_ttl' => 600, // giây - cache để tiết kiệm quota API
];

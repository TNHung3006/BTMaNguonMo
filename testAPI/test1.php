<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ví dụ đọc API bằng PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        .form-wrapper {
            background-color: #f5f5f5;
            padding: 30px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .row {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            gap: 20px;
        }
        .col-select {
            width: 150px;
        }
        .col-text {
            flex: 1;
        }
        select {
            padding: 5px;
            width: 100%;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        textarea {
            width: 100%;
            height: 120px;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }
        .btn-translate {
            background-color: #00bfa5;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .btn-translate:hover {
            background-color: #009688;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Ví dụ đọc API bằng PHP</h2>
    <p>Sử dụng API: google-translate1 từ trang <a href="https://rapidapi.com/googlecloud/api/google-translate1" target="_blank">https://rapidapi.com/googlecloud/api/google-translate1</a>, Method: POST để tạo ra ứng dụng dịch ngôn ngữ</p>
    
    <?php
    $translatedText = "";
    $q = isset($_POST['q']) ? $_POST['q'] : '';
    $source = isset($_POST['source']) ? $_POST['source'] : 'en';
    $target = isset($_POST['target']) ? $_POST['target'] : 'vi';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($q)) {
        $curl = curl_init();
        
        // Cấu hình payload theo chuẩn x-www-form-urlencoded giống như bài học
        $postfields = "q=" . urlencode($q) . "&target=" . $target . "&source=" . $source;
        
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://google-translate1.p.rapidapi.com/language/translate/v2",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_HTTPHEADER => [
                "Accept-Encoding: application/gzip",
                "X-RapidAPI-Host: google-translate1.p.rapidapi.com",
                "X-RapidAPI-Key: 6c28a307f0mshee1918af97afb34p15d698jsna1309d1d796b",
                "content-type: application/x-www-form-urlencoded"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if (!$err) {
            $array = json_decode($response, true);
            // Lấy kết quả dịch từ mảng JSON theo chuẩn của API google-translate1
            if (isset($array['data']['translations'][0]['translatedText'])) {
                $translatedText = $array['data']['translations'][0]['translatedText'];
            } else {
                $translatedText = "Lỗi hoặc hết hạn quota API: " . $response;
            }
        } else {
            $translatedText = "cURL Error #: " . $err;
        }
    }
    ?>

    <div class="form-wrapper">
        <form method="POST" action="">
            <!-- Vùng Nhập liệu (Source) -->
            <div class="row">
                <div class="col-select">
                    <select name="source">
                        <option value="en" <?= $source == 'en' ? 'selected' : '' ?>>English</option>
                        <option value="vi" <?= $source == 'vi' ? 'selected' : '' ?>>Vietnamese</option>
                    </select>
                </div>
                <div class="col-text">
                    <textarea name="q" placeholder="Nhập văn bản cần dịch..."><?= htmlspecialchars($q) ?></textarea>
                </div>
            </div>
            
            <!-- Nút Dịch -->
            <div class="clearfix">
                <button type="submit" class="btn-translate">Translate</button>
            </div>

            <!-- Vùng Kết quả (Target) -->
            <div class="row">
                <div class="col-select">
                    <select name="target">
                        <option value="vi" <?= $target == 'vi' ? 'selected' : '' ?>>Vietnamese</option>
                        <option value="en" <?= $target == 'en' ? 'selected' : '' ?>>English</option>
                    </select>
                </div>
                <div class="col-text">
                    <textarea readonly placeholder="Bản dịch sẽ hiển thị ở đây..."><?= htmlspecialchars($translatedText) ?></textarea>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<?php
// ===== CẤU HÌNH API =====
const RAPIDAPI_HOST = "google-translator9.p.rapidapi.com";
const RAPIDAPI_KEY  = "a06a6c81a5mshc689423e3e49e56p113309jsn70d4450f99eb";

// Danh sách ngôn ngữ: mã => tên hiển thị
$languages = [
    "en"    => "English",
    "vi"    => "Vietnamese",
    "fr"    => "French",
    "de"    => "German",
    "es"    => "Spanish",
    "ja"    => "Japanese",
    "ko"    => "Korean",
    "zh-CN" => "Chinese (Simplified)",
    "ru"    => "Russian",
    "th"    => "Thai",
];

// Hàm gọi API dịch (POST, JSON)
function translateText(string $text, string $source, string $target): string
{
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL            => "https://" . RAPIDAPI_HOST . "/v2",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => "",
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => "POST",
        CURLOPT_POSTFIELDS     => json_encode([
            "q"      => $text,
            "source" => $source,
            "target" => $target,
            "format" => "text",
        ]),
        CURLOPT_HTTPHEADER     => [
            "Content-Type: application/json",
            "x-rapidapi-host: " . RAPIDAPI_HOST,
            "x-rapidapi-key: " . RAPIDAPI_KEY,
        ],
    ]);

    $response = curl_exec($curl);
    $err      = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return "cURL Error: " . $err;
    }

    $array = json_decode($response, true);

    // Lấy kết quả dịch; nếu không có thì hiển thị lỗi từ API
    if (isset($array["data"]["translations"][0]["translatedText"])) {
        return $array["data"]["translations"][0]["translatedText"];
    }
    return "Lỗi API: " . ($array["message"] ?? $response);
}

// ===== XỬ LÝ FORM =====
$source = $_POST["source"] ?? "en";
$target = $_POST["target"] ?? "vi";
$text   = trim($_POST["text"] ?? "");
$result = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($text === "") {
        $result = "Vui lòng nhập nội dung cần dịch.";
    } elseif (!isset($languages[$source]) || !isset($languages[$target])) {
        $result = "Ngôn ngữ không hợp lệ.";
    } else {
        $result = translateText($text, $source, $target);
    }
}

// Hàm in các <option>, giữ lại lựa chọn sau khi submit
function renderOptions(array $languages, string $selected): void
{
    foreach ($languages as $code => $name) {
        $sel = ($code === $selected) ? "selected" : "";
        echo "<option value=\"$code\" $sel>$name</option>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dịch ngôn ngữ</title>
    <style>
        body   { font-family: Arial, sans-serif; margin: 30px; }
        .box   { background: #f2f2f2; padding: 30px; max-width: 800px; }
        .row   { display: flex; gap: 40px; margin-bottom: 15px; align-items: flex-start; }
        select { width: 140px; padding: 4px; }
        textarea { width: 100%; height: 140px; padding: 10px; font-size: 14px; box-sizing: border-box; }
        .col   { flex: 1; }
        .right { text-align: right; margin-bottom: 15px; }
        button { background: #1aa36f; color: #fff; border: none; padding: 10px 28px;
                 border-radius: 4px; cursor: pointer; font-size: 14px; }
        button:hover { background: #148a5d; }
    </style>
</head>
<body>
    <h2>Ví dụ đọc API bằng PHP</h2>

    <form method="POST" class="box">
        <!-- Ô nhập -->
        <div class="row">
            <select name="source"><?php renderOptions($languages, $source); ?></select>
            <div class="col">
                <textarea name="text" placeholder="Nhập văn bản..."><?= htmlspecialchars($text) ?></textarea>
            </div>
        </div>

        <div class="right"><button type="submit">Translate</button></div>

        <!-- Ô kết quả -->
        <div class="row">
            <select name="target"><?php renderOptions($languages, $target); ?></select>
            <div class="col">
                <textarea readonly><?= htmlspecialchars($result) ?></textarea>
            </div>
        </div>
    </form>
</body>
</html>
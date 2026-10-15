<?php
session_start(); // cache danh sách ngôn ngữ trong session để đỡ tốn lượt gọi API

// ===== CẤU HÌNH API =====
const RAPIDAPI_HOST = "google-translator9.p.rapidapi.com";
const RAPIDAPI_KEY  = "a06a6c81a5mshc689423e3e49e56p113309jsn70d4450f99eb";

// Danh sách dự phòng, dùng khi gọi API Languages bị lỗi
const FALLBACK_LANGUAGES = [
    "en" => "English", "vi" => "Vietnamese", "fr" => "French",
    "de" => "German",  "es" => "Spanish",    "ja" => "Japanese",
    "ko" => "Korean",  "zh-CN" => "Chinese (Simplified)",
    "ru" => "Russian", "th" => "Thai",
];

// Hàm chung gọi API RapidAPI. Trả về mảng đã decode, hoặc ["error" => "..."] nếu lỗi
function callApi(string $method, string $path, ?array $body = null): array
{
    $curl = curl_init();
    $options = [
        CURLOPT_URL            => "https://" . RAPIDAPI_HOST . $path,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => "",
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => $method,
        CURLOPT_HTTPHEADER     => [
            "Content-Type: application/json",
            "x-rapidapi-host: " . RAPIDAPI_HOST,
            "x-rapidapi-key: " . RAPIDAPI_KEY,
        ],
    ];
    if ($body !== null) {
        $options[CURLOPT_POSTFIELDS] = json_encode($body);
    }
    curl_setopt_array($curl, $options);

    $response = curl_exec($curl);
    $err      = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return ["error" => "cURL Error: " . $err];
    }
    $array = json_decode($response, true);
    return is_array($array) ? $array : ["error" => "Phản hồi không hợp lệ: " . $response];
}

// API Languages: lấy danh sách ngôn ngữ (dùng cho dropdown ngôn ngữ đích)
function getLanguages(): array
{
    if (!empty($_SESSION["languages"])) {
        return $_SESSION["languages"];
    }

    $res  = callApi("GET", "/v2/languages?target=en");
    $list = $res["data"]["languages"] ?? null;

    if (!is_array($list) || count($list) === 0) {
        return FALLBACK_LANGUAGES;
    }

    $languages = [];
    foreach ($list as $item) {
        $code = $item["language"] ?? null;
        if ($code) {
            $languages[$code] = $item["name"] ?? (FALLBACK_LANGUAGES[$code] ?? $code);
        }
    }
    asort($languages);
    return $_SESSION["languages"] = $languages;
}

// API Detects: nhận diện ngôn ngữ của văn bản, trả về mã (vd "vi") hoặc null nếu lỗi
function detectLanguage(string $text): ?string
{
    $res = callApi("POST", "/v2/detect", ["q" => $text]);
    return $res["data"]["detections"][0][0]["language"] ?? null;
}

// API Translates: dịch văn bản từ $source sang $target
function translateText(string $text, string $source, string $target): string
{
    $res = callApi("POST", "/v2", [
        "q"      => $text,
        "source" => $source,
        "target" => $target,
        "format" => "text",
    ]);

    if (isset($res["data"]["translations"][0]["translatedText"])) {
        return $res["data"]["translations"][0]["translatedText"];
    }
    return "Lỗi API: " . ($res["error"] ?? $res["message"] ?? json_encode($res));
}

// In các <option>, giữ lại lựa chọn sau khi submit
function renderOptions(array $languages, string $selected): void
{
    foreach ($languages as $code => $name) {
        $sel = ($code === $selected) ? "selected" : "";
        echo "<option value=\"" . htmlspecialchars($code) . "\" $sel>" . htmlspecialchars($name) . "</option>";
    }
}

// ===== XỬ LÝ FORM =====
$languages = getLanguages();
$target    = $_POST["target"] ?? "vi";
$text      = trim($_POST["text"] ?? "");
$result    = "";
$detected  = "Tự động nhận diện ngôn ngữ"; // nhãn hiển thị bên trái ô nhập

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($text === "") {
        $result = "Vui lòng nhập nội dung cần dịch.";
    } elseif (!isset($languages[$target])) {
        $result = "Ngôn ngữ đích không hợp lệ.";
    } else {
        // Bước 1: tự nhận diện ngôn ngữ của văn bản đã nhập
        $source = detectLanguage($text);

        if ($source === null) {
            $result = "Không nhận diện được ngôn ngữ.";
        } else {
            $detected = "Đã nhận diện: " . ($languages[$source] ?? $source);

            // Bước 2: dịch sang ngôn ngữ đích (trùng ngôn ngữ thì giữ nguyên)
            $result = ($source === $target) ? $text : translateText($text, $source, $target);
        }
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
        .label { width: 150px; font-size: 14px; color: #444; padding-top: 6px; }
        select { width: 150px; padding: 4px; }
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
        <!-- Ô nhập: không còn select, chỉ hiện nhãn ngôn ngữ nhận diện được -->
        <div class="row">
            <div class="label"><?= htmlspecialchars($detected) ?></div>
            <div class="col">
                <textarea name="text" placeholder="Nhập văn bản (tự nhận diện ngôn ngữ)..."><?= htmlspecialchars($text) ?></textarea>
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
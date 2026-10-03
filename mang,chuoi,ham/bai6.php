<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sắp xếp mảng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 500px;
            margin: 0 auto;
            margin-top: 50px;
            background-color: #d1ded4; /* Nền xanh xám nhạt giống bài 4 */
            border: 1px solid #339999;
        }
        h2 {
            background-color: #339999; /* Xanh mòng két */
            color: white;
            text-align: center;
            margin: 0;
            padding: 10px;
            font-size: 24px;
            font-style: italic;
            font-family: "Comic Sans MS", cursive, sans-serif; 
            text-transform: uppercase;
        }
        table {
            width: 100%;
            padding: 10px;
            border-collapse: collapse;
        }
        td {
            padding: 6px 10px;
            color: #444; 
            font-size: 15px;
        }
        td:first-child {
            width: 130px; 
        }
        input[type="text"] {
            padding: 4px;
            border: 1px solid #ccc;
        }
        .input-wide {
            width: 250px; 
        }
        input[readonly] {
            background-color: #ccffff; /* Màu xanh lơ nhạt cho ô kết quả */
            color: black; 
            border: 1px solid #88c0d0;
        }
        .btn-submit {
            background-color: #f1f1f1; /* Nút màu xám nhạt */
            border: 1px solid #999;
            padding: 5px 15px;
            font-weight: bold;
            color: #444;
            cursor: pointer;
        }
        .red-text {
            color: red;
            font-weight: bold;
        }
        .note {
            text-align: center;
            font-size: 14px;
            color: #555;
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>

<?php
    // 1. Hàm hoán vị hai số (sử dụng tham chiếu &$a, &$b)
    function hoan_vi(&$a, &$b) {
        $temp = $a;
        $a = $b;
        $b = $temp;
    }

    // 2. Hàm sắp xếp tăng dần
    function sap_tang($mang) {
        $n = count($mang);
        // Thuật toán sắp xếp nổi bọt (Bubble Sort) hoặc tương tự dùng 2 vòng lặp for
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = $i + 1; $j < $n; $j++) {
                if ($mang[$i] > $mang[$j]) {
                    hoan_vi($mang[$i], $mang[$j]);
                }
            }
        }
        return $mang;
    }

    // 3. Hàm sắp xếp giảm dần
    function sap_giam($mang) {
        $n = count($mang);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = $i + 1; $j < $n; $j++) {
                if ($mang[$i] < $mang[$j]) {
                    hoan_vi($mang[$i], $mang[$j]);
                }
            }
        }
        return $mang;
    }

    $mang_nhap = "";
    $mang_tang = "";
    $mang_giam = "";

    // Xử lý khi nhấn nút
    if (isset($_POST["btnSubmit"])) {
        $mang_nhap = $_POST["mang_nhap"];
        
        // Tách chuỗi thành mảng
        $mang = explode(",", $mang_nhap);
        
        // Loại bỏ khoảng trắng dư thừa để thuật toán so sánh chính xác số học
        for ($i = 0; $i < count($mang); $i++) {
            $mang[$i] = trim($mang[$i]);
        }
        
        // Gọi hàm sắp xếp
        $mang_tang_arr = sap_tang($mang);
        $mang_giam_arr = sap_giam($mang);
        
        // Chuyển mảng thành chuỗi để xuất ra TextBox
        $mang_tang = implode(", ", $mang_tang_arr);
        $mang_giam = implode(", ", $mang_giam_arr);
    }
?>

<div class="container">
    <form method="post" action="bai6.php">
        <h2>Sắp xếp mảng</h2>
        <table>
            <tr>
                <td>Nhập mảng:</td>
                <td>
                    <input type="text" name="mang_nhap" value="<?php echo $mang_nhap; ?>" class="input-wide" required>
                    <span class="red-text">(*)</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" name="btnSubmit" class="btn-submit">Sắp xếp tăng/giảm</button>
                </td>
            </tr>
            <!-- Dòng chữ đỏ "Sau khi sắp xếp:" -->
            <tr>
                <td colspan="2" class="red-text">Sau khi sắp xếp:</td>
            </tr>
            <tr>
                <td>Tăng dần:</td>
                <td><input type="text" name="mang_tang" value="<?php echo $mang_tang; ?>" class="input-wide" readonly></td>
            </tr>
            <tr>
                <td>Giảm dần:</td>
                <td><input type="text" name="mang_giam" value="<?php echo $mang_giam; ?>" class="input-wide" readonly></td>
            </tr>
            <tr>
                <td colspan="2" class="note">
                    <span class="red-text">(*)</span> Các số được nhập cách nhau bằng dấu ","
                </td>
            </tr>
        </table>
    </form>
</div>

</body>
</html>

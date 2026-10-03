<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Phát sinh mảng và tính toán</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 550px; /* Tăng độ rộng để chữ GTLN không bị rớt dòng */
            margin: 0 auto;
            margin-top: 50px;
            background-color: white; /* Nền trắng cho phần từ "Mảng" trở xuống */
            border: 1px solid #990066;
        }
        h2 {
            background-color: #a3005c; 
            color: white;
            text-align: center;
            margin: 0;
            padding: 10px;
            font-size: 24px;
            font-style: italic;
            font-family: "Comic Sans MS", cursive, sans-serif; 
        }
        table {
            width: 100%;
            border-collapse: collapse; 
        }
        tr {
            border-bottom: 2px solid white; /* Tạo đường viền trắng giữa các dòng */
        }
        /* 2 dòng đầu có nền hồng nhạt */
        .pink-row {
            background-color: #ffe6f2;
        }
        td {
            padding: 8px 10px;
            color: #444; 
            font-size: 15px;
        }
        td:first-child {
            width: 200px; /* Cột đầu đủ rộng để chữ GTLN (MAX) không bao giờ bị rớt dòng */
        }
        input[type="text"], input[type="number"] {
            padding: 4px;
            border: 1px solid #ccc;
        }
        .input-wide {
            width: 280px; 
        }
        .input-short {
            width: 120px; 
        }
        input[readonly] {
            background-color: #ff9999; 
            color: #660000; 
            font-weight: bold;
            border: 1px solid #ff6666;
        }
        .btn-submit {
            background-color: #ffff99; 
            border: 1px solid #999;
            padding: 5px 15px;
            cursor: pointer;
        }
        .note {
            text-align: center;
            font-size: 14px;
            color: #555;
            padding-top: 10px;
        }
        .ghi-chu {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php
    // 1. Hàm tạo mảng
    function tao_mang($n) {
        $arr = array();
        for ($i = 0; $i < $n; $i++) {
            $arr[] = rand(0, 20); 
        }
        return $arr;
    }

    // 2. Hàm xuất mảng
    function xuat_mang($mang) {
        return implode(" ", $mang);
    }

    // 3. Hàm tính tổng
    function tinh_tong($mang) {
        $tong = 0;
        foreach ($mang as $value) {
            $tong += $value;
        }
        return $tong;
    }

    // 4. Hàm tìm Max
    function tim_max($mang) {
        $max = $mang[0];
        foreach ($mang as $value) {
            if ($value > $max) {
                $max = $value;
            }
        }
        return $max;
    }

    // 5. Hàm tìm Min
    function tim_min($mang) {
        $min = $mang[0];
        foreach ($mang as $value) {
            if ($value < $min) {
                $min = $value;
            }
        }
        return $min;
    }

    $n = "";
    $mang_kq = "";
    $max = "";
    $min = "";
    $tong = "";

    // Xử lý khi nhấn nút
    if (isset($_POST["btnSubmit"])) {
        $n = $_POST["n"];
        
        if (is_numeric($n) && $n > 0) {
            $mang = tao_mang($n);
            $mang_kq = xuat_mang($mang);
            $tong = tinh_tong($mang);
            $max = tim_max($mang);
            $min = tim_min($mang);
        }
    }
?>

<div class="container">
    <form method="post" action="bai3.php">
        <h2>Phát sinh mảng và tính toán</h2>
        <table>
            <!-- Gán class pink-row cho 2 dòng đầu để có nền hồng -->
            <tr class="pink-row">
                <td>Nhập số phần tử:</td>
                <td><input type="number" name="n" value="<?php echo $n; ?>" class="input-wide" required></td>
            </tr>
            <tr class="pink-row">
                <td></td>
                <td>
                    <button type="submit" name="btnSubmit" class="btn-submit">Phát sinh và tính toán</button>
                </td>
            </tr>
            <!-- Các dòng dưới mặc định sẽ lấy nền trắng của container -->
            <tr>
                <td>Mảng:</td>
                <td><input type="text" name="mang_kq" value="<?php echo $mang_kq; ?>" class="input-wide" readonly></td>
            </tr>
            <tr>
                <td>GTLN (MAX) trong mảng:</td>
                <td><input type="text" name="max" value="<?php echo $max; ?>" class="input-short" readonly></td>
            </tr>
            <tr>
                <td>TTNN (MIN) trong mảng:</td>
                <td><input type="text" name="min" value="<?php echo $min; ?>" class="input-short" readonly></td>
            </tr>
            <tr>
                <td>Tổng mảng:</td>
                <td><input type="text" name="tong" value="<?php echo $tong; ?>" class="input-short" readonly></td>
            </tr>
            <tr>
                <td colspan="2" class="note">
                    (<span class="ghi-chu">Ghi chú:</span> Các phần tử trong mảng sẽ có giá trị từ 0 đến 20)
                </td>
            </tr>
        </table>
    </form>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thay thế phần tử mảng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 550px;
            margin: 0 auto;
            margin-top: 50px;
            background-color: white; /* Nền trắng cho phần kết quả */
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
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse; 
        }
        tr {
            border-bottom: 2px solid white; /* Đường viền trắng ngăn cách */
        }
        .pink-row {
            background-color: #ffe6f2; /* Nền hồng nhạt cho phần nhập liệu */
        }
        td {
            padding: 8px 10px;
            color: #444; 
            font-size: 15px;
        }
        td:first-child {
            width: 180px; 
        }
        input[type="text"] {
            padding: 4px;
            border: 1px solid #ccc;
        }
        .input-wide {
            width: 300px; /* Độ rộng lớn cho mảng */
        }
        .input-short {
            width: 150px; /* Độ rộng ngắn cho các giá trị cần thay thế */
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
    // 1. Hàm xuất mảng (Cách nhau bằng khoảng trắng như trong hình mẫu hiển thị)
    function xuat_mang($mang) {
        return implode(" ", $mang); 
    }

    // 2. Hàm thay thế
    function thay_the($mang, $cu, $moi) {
        // Duyệt mảng (dùng for)
        for ($i = 0; $i < count($mang); $i++) {
            // Dùng trim() để tránh lỗi so sánh do người dùng gõ dư dấu cách
            if (trim($mang[$i]) == trim($cu)) {
                $mang[$i] = trim($moi);
            }
        }
        return $mang;
    }

    $mang_nhap = "";
    $gt_cu = "";
    $gt_moi = "";
    $mang_cu_str = "";
    $mang_moi_str = "";

    // Xử lý khi nhấn nút Thay thế
    if (isset($_POST["btnSubmit"])) {
        $mang_nhap = $_POST["mang_nhap"];
        $gt_cu = $_POST["gt_cu"];
        $gt_moi = $_POST["gt_moi"];
        
        // Tạo mảng từ dãy các số (dùng explode)
        $mang = explode(",", $mang_nhap);
        
        // Chuẩn hóa khoảng trắng dư thừa trong mảng (tùy chọn để in ra cho đẹp)
        for ($i = 0; $i < count($mang); $i++) {
            $mang[$i] = trim($mang[$i]);
        }
        
        // Gọi hàm xuất mảng cũ
        $mang_cu_str = xuat_mang($mang);
        
        // Gọi hàm thay thế 
        $mang_moi = thay_the($mang, $gt_cu, $gt_moi);
        
        // Xuất mảng mới sau khi đã thay thế
        $mang_moi_str = xuat_mang($mang_moi);
    }
?>

<div class="container">
    <form method="post" action="bai5.php">
        <h2>THAY THẾ</h2>
        <table>
            <tr class="pink-row">
                <td>Nhập các phần tử:</td>
                <td><input type="text" name="mang_nhap" value="<?php echo $mang_nhap; ?>" class="input-wide" required></td>
            </tr>
            <tr class="pink-row">
                <td>Giá trị cần thay thế:</td>
                <td><input type="text" name="gt_cu" value="<?php echo $gt_cu; ?>" class="input-short" required></td>
            </tr>
            <tr class="pink-row">
                <td>Giá trị thay thế:</td>
                <td><input type="text" name="gt_moi" value="<?php echo $gt_moi; ?>" class="input-short" required></td>
            </tr>
            <tr class="pink-row">
                <td></td>
                <td>
                    <button type="submit" name="btnSubmit" class="btn-submit">Thay thế</button>
                </td>
            </tr>
            
            <!-- Phần bên dưới có nền trắng theo thiết kế của bạn -->
            <tr>
                <td>Mảng cũ:</td>
                <td><input type="text" name="mang_cu" value="<?php echo $mang_cu_str; ?>" class="input-wide" readonly></td>
            </tr>
            <tr>
                <td>Mảng sau khi thay thế:</td>
                <td><input type="text" name="mang_moi" value="<?php echo $mang_moi_str; ?>" class="input-wide" readonly></td>
            </tr>
            <tr>
                <td colspan="2" class="note">
                    (<span class="ghi-chu">Ghi chú:</span> Các phần tử trong mảng sẽ cách nhau bằng dấu ",")
                </td>
            </tr>
        </table>
    </form>
</div>

</body>
</html>

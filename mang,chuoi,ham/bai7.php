<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tính năm âm lịch</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 450px;
            margin: 0 auto;
            margin-top: 50px;
            background-color: #cce6ff; /* Nền màu xanh da trời nhạt */
            border: 1px solid #0066cc;
        }
        h2 {
            background-color: #0066cc; /* Nền tiêu đề màu xanh dương đậm */
            color: white;
            text-align: center;
            margin: 0;
            padding: 10px;
            font-size: 22px;
            font-style: italic;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            padding: 15px;
            text-align: center;
        }
        td {
            padding: 5px;
            color: #003366;
            font-weight: bold;
        }
        .input-year {
            width: 100px;
            padding: 5px;
            text-align: center;
            border: 1px solid #999;
        }
        .input-al {
            width: 120px;
            padding: 5px;
            text-align: center;
            background-color: #ffffcc; /* Nền ô kết quả màu vàng */
            color: red;
            font-weight: bold;
            border: 1px solid #ffcc00;
        }
        .btn-submit {
            background-color: #ffe6cc; /* Nền nút bấm hơi cam nhạt */
            border: 1px solid #ff9933;
            color: red;
            font-weight: bold;
            padding: 5px 15px;
            cursor: pointer;
        }
        .img-container {
            text-align: center;
            padding: 15px;
            min-height: 150px; /* Giữ khoảng trống nếu chưa có ảnh */
        }
    </style>
</head>
<body>

<?php
    $nam = "";
    $nam_al = "";
    $hinh_anh = "";

    // Khi người dùng bấm nút "=>"
    if (isset($_POST["btnSubmit"])) {
        $nam = $_POST["nam"];
        
        if (is_numeric($nam) && $nam > 0) {
            // Khởi tạo 3 mảng theo đúng hướng dẫn của đề
            $mang_can = array("Quý", "Giáp", "Ất", "Bính", "Đinh", "Mậu", "Kỷ", "Canh", "Tân", "Nhâm");
            $mang_chi = array("Hợi", "Tý", "Sửu", "Dần", "Mão", "Thìn", "Tỵ", "Ngọ", "Mùi", "Thân", "Dậu", "Tuất");
            $mang_hinh = array("hoi.jpg", "ty.jpg", "suu.jpg", "dan.jpg", "mao.jpg", "thin.gif", "ran.jpg", "ngo.jpg", "mui.jpg", "than.gif", "dau.jpg", "tuat.jpg");
            
            // Tính toán Can và Chi
            $nam_tinh = $nam - 3;
            $can = $nam_tinh % 10;
            $chi = $nam_tinh % 12;
            
            // Nối Can và Chi lại để thành năm âm lịch (VD: Đinh + Hợi)
            $nam_al = $mang_can[$can] . " " . $mang_chi[$chi];
            
            // Lấy tên hình ảnh tương ứng với con giáp
            $hinh = $mang_hinh[$chi];
            
            // Tạo mã HTML để hiển thị ảnh. Lấy từ thư mục 12con_giap/
            $hinh_anh = "<img src='12con_giap/$hinh' alt='$nam_al' style='max-width: 150px;'>";
        }
    }
?>

<div class="container">
    <form method="post" action="bai7.php">
        <h2>Tính năm âm lịch</h2>
        <table>
            <tr>
                <td>Năm dương lịch</td>
                <td></td>
                <td>Năm âm lịch</td>
            </tr>
            <tr>
                <td>
                    <input type="number" name="nam" value="<?php echo $nam; ?>" class="input-year" required>
                </td>
                <td>
                    <button type="submit" name="btnSubmit" class="btn-submit">=></button>
                </td>
                <td>
                    <input type="text" name="nam_al" value="<?php echo $nam_al; ?>" class="input-al" readonly>
                </td>
            </tr>
            <tr>
                <!-- Nơi xuất hiện hình ảnh con giáp -->
                <td colspan="3" class="img-container">
                    <?php 
                        if ($hinh_anh != "") {
                            echo $hinh_anh; 
                        } else {
                            echo "<span style='color:#999; font-size: 13px;'>(Hình ảnh sẽ hiển thị ở đây)</span>";
                        }
                    ?>
                </td>
            </tr>
        </table>
    </form>
</div>

</body>
</html>

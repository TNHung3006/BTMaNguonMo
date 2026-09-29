<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Diện tích và chu vi hình tròn</title>
    <style>
        .table-bg {
            background-color: #feebca; /* Tạo màu cho form */
            width: 350px;
        }
        .header-text {
            background-color: #fed76e; /* Màu nền tiêu đề */
            color: #d05312; /* Màu chữ tiêu đề */
            text-align: center;
            font-family: "Times New Roman", Times, serif;
            font-style: italic;
            font-size: 22px;
            font-weight: bold;
            padding: 5px;
        }
        input{
            width: 200px;
            padding: 5px;
        }
        button{
            padding: 4px 14px;
        }
        .readonly-input {
            
            background-color: #f7d4d8; /* Đổi màu nền cho textfield không cho phép nhập */
        }
    </style>
</head>
<body>

<?php
    // Ghi chú: PI là hằng số PI=3.14
    define("PI", 3.14); 

    $banKinh = "";
    $dienTich = "";
    $chuVi = "";

    // Khi chọn button Tính, thực hiện tính toán
    if (isset($_POST['btnTinh'])) {
        $banKinh = $_POST['banKinh'];
        
        // Diện tích = PI * (Bán kính)^2
        $dienTich = PI * ($banKinh * $banKinh);
        
        // Chu vi = 2 * PI * (Bán kính)
        $chuVi = 2 * PI * $banKinh;
    }
?>

<!-- Đặt tên cho form, thiết lập phương thức POST, action là tên trang -->
<form name="formHinhTron" method="POST" action="bai2.php">
    <table align="center" class="table-bg">
        <tr>
            <td colspan="2" class="header-text">DIỆN TÍCH và CHU VI<br>HÌNH TRÒN</td>
        </tr>
        <tr>
            <td>Bán kính:</td>
            <td><input type="text" name="banKinh" value="<?php echo $banKinh; ?>"></td>
        </tr>
        <tr>
            <td>Diện tích:</td>
            <!-- Textfield Diện tích và Chu vi không cho phép nhập liệu (readonly) -->
            <td><input type="text" name="dienTich" value="<?php echo $dienTich; ?>" class="readonly-input" readonly></td>
        </tr>
        <tr>
            <td>Chu vi:</td>
            <td><input type="text" name="chuVi" value="<?php echo $chuVi; ?>" class="readonly-input" readonly></td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <!-- Sử dụng điều khiển button -->
                <!-- <input type="submit" name="btnTinh" value="Tính"> -->
                <button type="submit" name="btnTinh">Tinh</button>
            </td>
        </tr>
    </table>
</form>

</body>
</html>
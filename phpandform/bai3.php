<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán tiền điện</title>
    <style>
    form {
        width: 480px; 
        background-color: #fff2b3; 
        margin: 0 auto;
    }

    h2 {
        margin: 0 0 15px 0;
        padding: 8px;
        text-align: center;
        color: #a64b00;
        background-color: #f6d36b;
        font-size: 22px;
        font-family: serif;
        font-style: italic; 
    }

    table {
        width: 100%;
    }

    td {
        padding: 6px;
    }

    td:first-child {
        width: 140px;
    }

    input {
        width: 180px;
        padding: 5px;
    }

    input[readonly] {
        background-color: #f4cccc; 
    }

    button {
        margin-left: 25px;
        padding: 4px 12px;
    }
    
    /* body {
        display: flex;
        justify-content: center; 
        align-items: center; 
        height: 100vh; 
        margin: 0;
    } */
    </style>
</head>

<body>
<?php
    $tenChuHo = "";
    $chiSoCu = "";
    $chiSoMoi = "";

    // Gán giá trị mặc định cho đơn giá
    $donGia = 20000; 
    
    $soTienThanhToan = "";

    // Xử lý khi nhấn nút Tính
    if (isset($_POST["tinh"])) {
        $tenChuHo = $_POST["tenChuHo"];
        $chiSoCu = $_POST["chiSoCu"];
        $chiSoMoi = $_POST["chiSoMoi"];
        $donGia = $_POST["donGia"];
        
        // Tính số tiền
        $soTienThanhToan = ($chiSoMoi - $chiSoCu) * $donGia;
    }
?>

<!-- Form với tên, phương thức POST và action về file hiện tại -->
<form name="formThanhToan" method="post" action="bai3.php">
    <h2>THANH TOÁN TIỀN ĐIỆN</h2>
    <table>
        <tr>
            <td>Tên chủ hộ:</td>
            <td>
                <input type="text" name="tenChuHo" value="<?php echo $tenChuHo; ?>" required>
            </td>
        </tr>

        <tr>
            <td>Chỉ số cũ:</td>
            <td>
                <input type="number" name="chiSoCu" value="<?php echo $chiSoCu; ?>" required> (Kw)
            </td>
        </tr>

        <tr>
            <td>Chỉ số mới:</td>
            <td>
                <input type="number" name="chiSoMoi" value="<?php echo $chiSoMoi; ?>" required> (Kw)
            </td>
        </tr>

        <tr>
            <td>Đơn giá:</td>
            <td>
                <input type="number" name="donGia" value="<?php echo $donGia; ?>" required> (VNĐ)
            </td>
        </tr>

        <tr>
            <td>Số tiền thanh toán:</td>
            <td>
                <!-- Trường số tiền readonly -->
                <input type="text" name="soTienThanhToan" value="<?php echo $soTienThanhToan; ?>" readonly> (VNĐ)
            </td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit" name="tinh">Tính</button>
            </td>
        </tr>
    </table>
</form>
</body>
</html>
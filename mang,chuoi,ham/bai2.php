<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Nhập và tính trên dãy số</title>
    <style>
    form {
        width: 450px; 
        background-color: #ccd9d9; /* Nền form xanh xám nhạt */
        margin: 0 auto;
        margin-top: 50px;
    }

    h2 {
        margin: 0 0 10px 0;
        padding: 10px;
        text-align: center;
        color: white;
        background-color: #339999; /* Nền tiêu đề màu xanh mòng két */
        font-size: 20px;
        font-family: serif;
        font-style: italic; /* Chữ in nghiêng giống ảnh */
    }

    table {
        width: 100%;
        color: black;
    }

    td {
        padding: 6px;
    }

    td:first-child {
        width: 110px;
    }

    input[type="text"] {
        width: 220px;
        padding: 4px;
    }

    /* Đổi màu ô textfield Tổng dãy số */
    input[readonly] {
        background-color: #ccff99; /* Nền xanh lá nhạt */
    }

    button {
        padding: 4px 15px;
        background-color: #ffff99; /* Nút màu vàng */
        border: 1px solid #999;
        cursor: pointer;
    }

    /* Định dạng cho dấu (*) và dòng chú thích */
    .note {
        color: red;
        font-weight: bold;
    }
    
    .footer-note {
        text-align: center;
        color: red;
        font-size: 14px;
        padding-bottom: 15px;
    }
    </style>
</head>
<body>

<?php
    $daySo = "";
    $tong = "";

    // Khi click button Tổng dãy số
    if (isset($_POST["tinhTong"])) {
        $daySo = $_POST["daySo"];
        
        // Tách chuỗi dựa vào dấu phẩy và gán vào mảng
        $mang = explode(",", $daySo);
        
        $hop_le = true;
        // Chuẩn hóa khoảng trắng và kiểm tra xem có chứa chữ cái hay không
        for ($i = 0; $i < count($mang); $i++) {
            $mang[$i] = trim($mang[$i]); // kiểm tra khoảng trắng
            if (!is_numeric($mang[$i]) && $mang[$i] !== "") {
                $hop_le = false;
            }
        }
        
        if ($hop_le == true) {
            // Tính tổng các phần tử của mảng 
            $tong = array_sum($mang);
        } else {
            // Hiện thông báo lỗi
            echo "<script>alert('Lỗi: Bạn đã nhập chữ cái! Vui lòng chỉ nhập các con số và dấu phẩy.');</script>";
        }
    }
?>

<form name="formTinhDaySo" method="post" action="bai2.php">
    <h2>NHẬP VÀ TÍNH TRÊN DÃY SỐ</h2>
    <table>
        <tr>
            <td>Nhập dãy số:</td>
            <td>
                <input type="text" name="daySo" value="<?php echo $daySo; ?>" required> 
                <span class="note">(*)</span>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit" name="tinhTong">Tổng dãy số</button>
            </td>
        </tr>

        <tr>
            <td>Tổng dãy số:</td>
            <td>
                <!-- Không cho phép chỉnh sửa bằng thuộc tính readonly -->
                <input type="text" name="tong" value="<?php echo $tong; ?>" readonly>
            </td>
        </tr>
    </table>
    <!-- Dòng ghi chú cuối form -->
    <div class="footer-note">(*) Các số được nhập cách nhau bằng dấu ","</div>
</form>

</body>
</html>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kết quả phép tính</title>
    <style>
        .container {
            width: 450px;
            margin: 0 auto;
            margin-top: 50px;
        }
        h2 {
            color: #3399cc; 
            text-align: center;
        }
        .red-text {
            color: #cc0000; 
            font-weight: bold;
        }
        .blue-text {
            color: blue; 
            font-weight: bold;
        }
        .text-right {
            text-align: right;
            padding-right: 15px;
            width: 140px;
        }
        input[type="text"] {
            width: 200px;
            padding: 5px;
            /* Canh lề chữ trong textbox theo yêu cầu */
            text-align: left; 
        }
        .back-link {
            color: purple;
            text-decoration: underline;
            font-style: italic;
        }
    </style>
</head>
<body>

<?php
    // Viết các hàm cộng, trừ, nhân, chia cho 2 số theo yêu cầu
    function cong($a, $b) {
        return $a + $b;
    }
    function tru($a, $b) {
        return $a - $b;
    }
    function nhan($a, $b) {
        return $a * $b;
    }
    function chia($a, $b) {
        if ($b == 0) {
            return "Không thể chia cho 0";
        }
        return $a / $b;
    }

    $so1 = "";
    $so2 = "";
    $pheptinh = "";
    $ketqua = "";

    // Xử lý dữ liệu được gửi từ trang bai6.php sang
    if (isset($_POST["tinh"])) {
        $so1 = $_POST["so1"];
        $so2 = $_POST["so2"];
        $pheptinh = $_POST["pheptinh"];

        // Kiểm tra loại phép tính để gọi hàm tương ứng
        switch ($pheptinh) {
            case "Cộng":
                $ketqua = cong($so1, $so2);
                break;
            case "Trừ":
                $ketqua = tru($so1, $so2);
                break;
            case "Nhân":
                $ketqua = nhan($so1, $so2);
                break;
            case "Chia":
                $ketqua = chia($so1, $so2);
                break;
        }
    }
?>

<div class="container">
    <h2>PHÉP TÍNH TRÊN HAI SỐ</h2>
    <table align="center">
        <tr>
            <td class="red-text text-right">Chọn phép tính:</td>
            <td class="red-text"><?php echo $pheptinh; ?></td>
        </tr>
        <tr>
            <td class="blue-text text-right">Số 1:</td>
            <td><input type="text" value="<?php echo $so1; ?>" readonly></td>
        </tr>
        <tr>
            <td class="blue-text text-right">Số 2:</td>
            <td><input type="text" value="<?php echo $so2; ?>" readonly></td>
        </tr>
        <tr>
            <td class="blue-text text-right">Kết quả:</td>
            <td><input type="text" value="<?php echo $ketqua; ?>" readonly></td>
        </tr>
        <tr>
            <td></td>
            <!-- Lệnh javascript để quay lại trang trước -->
            <td>
                <a href="javascript:window.history.back(-1);" class="back-link">Quay lại trang trước</a>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
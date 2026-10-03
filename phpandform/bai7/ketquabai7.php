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
        h2 { color: #3399cc; text-align: center; }
        .red-text { color: #cc0000; font-weight: bold; }
        .blue-text { color: blue; font-weight: bold; }
        .text-right { text-align: right; padding-right: 15px; width: 140px; }
        input[type="text"] { width: 200px; padding: 5px; text-align: left; }
        .back-link { color: purple; text-decoration: underline; font-style: italic; }
    </style>
</head>
<body>

<?php
    // Viết các hàm cộng, trừ, nhân, chia
    function cong($a, $b) { return $a + $b; }
    function tru($a, $b) { return $a - $b; }
    function nhan($a, $b) { return $a * $b; }
    function chia($a, $b) { return $a / $b; }

    // HÀM KIỂM TRA DỮ LIỆU NHẬP VÀO
    function kiemTraHopLe($a, $b, $pt) {
        // Kiểm tra xem dữ liệu có phải là chuỗi ký tự không (không phải số)
        if (!is_numeric($a) || !is_numeric($b)) {
            return false;
        }
        // Kiểm tra phép chia cho 0
        if ($pt == "Chia" && $b == 0) {
            return false;
        }
        return true;
    }

    $so1 = "";
    $so2 = "";
    $pheptinh = "";
    $ketqua = "";

    if (isset($_POST["tinh"])) {
        $so1 = $_POST["so1"];
        $so2 = $_POST["so2"];
        $pheptinh = $_POST["pheptinh"];

        // Gọi hàm kiểm tra
        if (kiemTraHopLe($so1, $so2, $pheptinh)) {
            
            // Xử lý trường hợp là số thực: Ép kiểu dữ liệu về float
            $so1 = (float)$so1;
            $so2 = (float)$so2;
            
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
                    // Điều khiển xuất dữ liệu (ví dụ làm tròn 3 chữ số thập phân nếu lẻ)
                    $ketqua = round($ketqua, 3);
                    break;
            }
        } else {
            // NẾU LỖI: Tự động quay lại trang trước đó bằng lệnh Javascript
            echo "<script>
                    alert('Lỗi: Bạn đã nhập chữ cái hoặc chia cho 0. Hệ thống sẽ quay lại trang trước!');
                    window.history.back();
                  </script>";
            // Dừng ngay lập tức, không load giao diện HTML bên dưới nữa
            exit(); 
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
            <td>
                <a href="javascript:window.history.back(-1);" class="back-link">Quay lại trang trước</a>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
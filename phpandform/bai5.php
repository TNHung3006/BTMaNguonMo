<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tính tiền Karaoke</title>
    <style>
    form {
        width: 480px; 
        background-color: #009999; /* Màu nền xanh cổ vịt */
        margin: 0 auto;
        margin-top: 50px;
    }

    h2 {
        margin: 0 0 15px 0;
        padding: 8px;
        text-align: center;
        color: white; /* Tiêu đề chữ trắng */
        background-color: #006666; /* Nền tiêu đề xanh đậm hơn */
        font-size: 24px;
        font-family: serif;
        font-style: italic; 
    }

    table {
        width: 100%;
        color: black;
    }

    td {
        padding: 6px;
    }

    td:first-child {
        width: 130px;
    }

    input[type="number"], input[type="text"] {
        width: 180px;
        padding: 5px;
    }

    input[readonly] {
        background-color: #ffffcc; /* Nền vàng nhạt cho ô chỉ đọc */
    }

    button {
        margin-right: 35px;
        padding: 4px 15px;
    }
    </style>
</head>

<body>
<?php
    $gioBatDau = "";
    $gioKetThuc = "";
    $tienThanhToan = "";
    $thongBao = "";

    // Xử lý khi người dùng nhấn nút Tính tiền
    if (isset($_POST["tinh"])) {
        $gioBatDau = $_POST["gioBatDau"];
        $gioKetThuc = $_POST["gioKetThuc"];

        // Điều kiện 1: Giờ kết thúc phải lớn hơn giờ bắt đầu
        if ($gioKetThuc > $gioBatDau) {
            
            // Điều kiện 2: Chỉ tính tiền nếu nằm trong giờ hoạt động (10h - 24h)
            if ($gioBatDau >= 10 && $gioKetThuc <= 24) {
                
                // Trường hợp 1: Hát hoàn toàn trong khung giờ 10h - 17h (20.000đ/h)
                if ($gioKetThuc <= 17) {
                    $tienThanhToan = ($gioKetThuc - $gioBatDau) * 20000;
                } 
                // Trường hợp 2: Hát hoàn toàn trong khung giờ 17h - 24h (45.000đ/h)
                elseif ($gioBatDau >= 17) {
                    $tienThanhToan = ($gioKetThuc - $gioBatDau) * 45000;
                } 
                // Trường hợp 3: Hát vắt ngang qua mốc 17h (ví dụ 15h đến 19h)
                else {
                    // Tính tiền phần từ giờ bắt đầu đến 17h + phần từ 17h đến giờ kết thúc
                    $tienThanhToan = (17 - $gioBatDau) * 20000 + ($gioKetThuc - 17) * 45000;
                }
                
            } else {
                // Nằm ngoài giờ hoạt động (Giờ nghỉ)
                $thongBao = "Quán đang trong giờ nghỉ (Chỉ hoạt động từ 10h - 24h)!";
            }
            
        } else {
            // Ngược lại: thông báo theo đúng yêu cầu đề bài
            $thongBao = "Giờ kết thúc phải > Giờ bắt đầu";
        }
    }
?>

<form name="formKaraoke" method="post" action="bai5.php">
    <h2>TÍNH TIỀN KARAOKE</h2>
    <table>
        <tr>
            <td>Giờ bắt đầu:</td>
            <td>
                <input type="number" name="gioBatDau" value="<?php echo $gioBatDau; ?>" required> (h)
            </td>
        </tr>

        <tr>
            <td>Giờ kết thúc:</td>
            <td>
                <input type="number" name="gioKetThuc" value="<?php echo $gioKetThuc; ?>" required> (h)
            </td>
        </tr>

        <tr>
            <td>Tiền thanh toán:</td>
            <td>
                <input type="text" name="tienThanhToan" value="<?php echo $tienThanhToan; ?>" readonly> (VNĐ)
            </td>
        </tr>

        <!-- Hàng hiển thị thông báo lỗi (nếu có) -->
        <tr>
            <td colspan="2" style="text-align: center; color: yellow; font-weight: bold; font-style: italic;">
                <?php echo $thongBao; ?>
            </td>
        </tr>

        <tr>
            <td colspan="2" align="center">
                <button type="submit" name="tinh">Tính tiền</button>
            </td>
        </tr>
    </table>
</form>
</body>
</html>
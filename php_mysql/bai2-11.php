<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sữa mới</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 650px;
            margin: 20px auto;
        }
        /* Bảng form thêm sữa */
        table.form-table {
            width: 100%;
            background-color: #feebe2;
            border-collapse: collapse;
            border: 1px solid #f5cba7;
        }
        table.form-table th.form-header {
            background-color: #ff5252;
            color: #ffffff;
            font-size: 22px;
            padding: 10px;
            text-align: center;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        table.form-table td {
            padding: 6px 12px;
            font-size: 14px;
        }
        table.form-table td.label-col {
            width: 160px;
            font-weight: normal;
            color: #000;
        }
        input[type="text"], textarea, select {
            border: 1px solid #a6a6a6;
            font-family: Arial, sans-serif;
            font-size: 13px;
            padding: 3px 5px;
        }
        textarea {
            width: 95%;
            font-family: monospace, Courier, sans-serif;
            font-size: 13px;
        }
        .submit-btn {
            padding: 4px 15px;
            font-size: 13px;
            background-color: #efefef;
            border: 1px solid #767676;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #e0e0e0;
        }
        .error-msg {
            text-align: center;
            color: #d32f2f;
            font-weight: bold;
            margin: 15px 0 5px 0;
        }
        .success-msg {
            text-align: center;
            font-weight: bold;
            font-size: 15px;
            margin: 20px 0 10px 0;
            color: #000000;
        }

        /* Khung hiển thị chi tiết sữa sau khi thêm */
        .product-card {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #b75317;
            margin-top: 10px;
            margin-bottom: 25px;
            background-color: #ffffff;
        }
        .product-header {
            background-color: #feebe2;
            color: #d35400;
            padding: 8px 12px;
            font-size: 22px;
            font-style: italic;
            font-family: "Brush Script MT", "Comic Sans MS", cursive, sans-serif;
            text-align: center;
            border-bottom: 1px solid #b75317;
        }
        .product-body td {
            padding: 12px;
            vertical-align: top;
        }
        .product-img-col {
            width: 140px;
            text-align: center;
            vertical-align: middle !important;
        }
        .product-img-col img {
            max-width: 120px;
            max-height: 130px;
            display: block;
            margin: 0 auto;
        }
        .product-info {
            font-size: 13px;
            line-height: 1.6;
            color: #333333;
        }
        .product-info b {
            color: #000000;
        }
        .product-price-box {
            text-align: right;
            margin-top: 12px;
            font-size: 13px;
        }
        .price-highlight {
            color: #d32f2f;
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php
// 1. Kết nối vào MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quanly_ban_sua";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");

// Khởi tạo các biến để lưu dữ liệu form
$masua = "";
$tensua = "";
$hangsua = "";
$loaisua = "";
$trongluong = "";
$dongia = "";
$tp_dinhduong = "";
$loiich = "";

$error = "";
$success_sp = null;

// 2. Xử lý khi nhấn nút "Thêm mới"
if (isset($_POST['them_moi'])) {
    $masua = trim($_POST['masua'] ?? '');
    $tensua = trim($_POST['tensua'] ?? '');
    $hangsua = trim($_POST['hangsua'] ?? '');
    $loaisua = trim($_POST['loaisua'] ?? '');
    $trongluong = trim($_POST['trongluong'] ?? '');
    $dongia = trim($_POST['dongia'] ?? '');
    $tp_dinhduong = trim($_POST['tp_dinhduong'] ?? '');
    $loiich = trim($_POST['loiich'] ?? '');

    // Kiểm tra hợp lệ: không để trống các trường cơ bản & trọng lượng, đơn giá phải là số
    if (empty($masua) || empty($tensua) || empty($trongluong) || empty($dongia) || !is_numeric($trongluong) || !is_numeric($dongia) || $trongluong <= 0 || $dongia <= 0) {
        $error = "Kiểm tra lại thông tin nhập vào";
    } else {
        // Xử lý upload file hình ảnh
        $hinh_name = "";
        if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] == 0) {
            $hinh_name = basename($_FILES['hinh_anh']['name']);
            $target_dir = "Hinh_sua/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . $hinh_name;
            move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_file);
        }

        // Thoát các ký tự đặc biệt cho SQL
        $masua_sql = mysqli_real_escape_string($conn, $masua);
        $tensua_sql = mysqli_real_escape_string($conn, $tensua);
        $hangsua_sql = mysqli_real_escape_string($conn, $hangsua);
        $loaisua_sql = mysqli_real_escape_string($conn, $loaisua);
        $trongluong_sql = (int)$trongluong;
        $dongia_sql = (int)$dongia;
        $tp_dinhduong_sql = mysqli_real_escape_string($conn, $tp_dinhduong);
        $loiich_sql = mysqli_real_escape_string($conn, $loiich);
        $hinh_sql = mysqli_real_escape_string($conn, $hinh_name);

        // Kiểm tra xem mã sữa đã tồn tại chưa
        $checkExist = mysqli_query($conn, "SELECT Ma_sua FROM sua WHERE Ma_sua = '{$masua_sql}'");
        if (mysqli_num_rows($checkExist) > 0) {
            $error = "Mã sữa này đã tồn tại, vui lòng nhập mã khác!";
        } else {
            // Thêm sữa mới vào bảng sua
            $insertQuery = "INSERT INTO sua (Ma_sua, Ten_sua, Ma_hang_sua, Ma_loai_sua, Trong_luong, Don_gia, TP_Dinh_Duong, Loi_ich, Hinh)
                            VALUES ('{$masua_sql}', '{$tensua_sql}', '{$hangsua_sql}', '{$loaisua_sql}', {$trongluong_sql}, {$dongia_sql}, '{$tp_dinhduong_sql}', '{$loiich_sql}', '{$hinh_sql}')";

            if (mysqli_query($conn, $insertQuery)) {
                // Truy vấn lại thông tin vừa thêm (kèm tên hãng sữa) để hiển thị
                $queryGet = "SELECT sua.*, hang_sua.Ten_hang_sua 
                             FROM sua 
                             JOIN hang_sua ON sua.Ma_hang_sua = hang_sua.Ma_hang_sua 
                             WHERE sua.Ma_sua = '{$masua_sql}'";
                $resGet = mysqli_query($conn, $queryGet);
                $success_sp = mysqli_fetch_assoc($resGet);
            } else {
                $error = "Lỗi khi thêm sữa vào CSDL: " . mysqli_error($conn);
            }
        }
    }
}

// 3. Đọc danh sách Hãng sữa và Loại sữa để gán vào dropdown List/Menu
$resHang = mysqli_query($conn, "SELECT Ma_hang_sua, Ten_hang_sua FROM hang_sua");
$resLoai = mysqli_query($conn, "SELECT Ma_loai_sua, Ten_loai FROM loai_sua");
?>

<div class="container">
    <!-- FORM THÊM SỮA MỚI -->
    <form name="formThemSua" method="POST" action="bai2-11.php" enctype="multipart/form-data">
        <table class="form-table">
            <tr>
                <th colspan="2" class="form-header">THÊM SỮA MỚI</th>
            </tr>
            <tr>
                <td class="label-col">Mã sữa:</td>
                <td><input type="text" name="masua" value="<?php echo htmlspecialchars($masua); ?>" style="width: 180px;"></td>
            </tr>
            <tr>
                <td class="label-col">Tên sữa:</td>
                <td><input type="text" name="tensua" value="<?php echo htmlspecialchars($tensua); ?>" style="width: 320px;"></td>
            </tr>
            <tr>
                <td class="label-col">Hãng sữa:</td>
                <td>
                    <select name="hangsua" style="min-width: 140px;">
                        <?php
                        while ($h = mysqli_fetch_assoc($resHang)) {
                            $sel = ($hangsua == $h['Ma_hang_sua']) ? 'selected' : '';
                            echo "<option value='{$h['Ma_hang_sua']}' {$sel}>{$h['Ten_hang_sua']}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label-col">Loại sữa:</td>
                <td>
                    <select name="loaisua" style="min-width: 100px;">
                        <?php
                        while ($l = mysqli_fetch_assoc($resLoai)) {
                            $sel = ($loaisua == $l['Ma_loai_sua']) ? 'selected' : '';
                            echo "<option value='{$l['Ma_loai_sua']}' {$sel}>{$l['Ten_loai']}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label-col">Trọng lượng:</td>
                <td>
                    <input type="text" name="trongluong" value="<?php echo htmlspecialchars($trongluong); ?>" style="width: 180px;"> (gr hoặc ml)
                </td>
            </tr>
            <tr>
                <td class="label-col">Đơn giá:</td>
                <td>
                    <input type="text" name="dongia" value="<?php echo htmlspecialchars($dongia); ?>" style="width: 180px;"> (VNĐ)
                </td>
            </tr>
            <tr>
                <td class="label-col" style="vertical-align: top;">Thành phần dinh dưỡng:</td>
                <td>
                    <textarea name="tp_dinhduong" rows="3"><?php echo htmlspecialchars($tp_dinhduong); ?></textarea>
                </td>
            </tr>
            <tr>
                <td class="label-col" style="vertical-align: top;">Lợi ích:</td>
                <td>
                    <textarea name="loiich" rows="3"><?php echo htmlspecialchars($loiich); ?></textarea>
                </td>
            </tr>
            <tr>
                <td class="label-col">Hình ảnh:</td>
                <td>
                    <input type="file" name="hinh_anh" accept="image/*">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center; padding: 12px;">
                    <input type="submit" name="them_moi" value="Thêm mới" class="submit-btn">
                </td>
            </tr>
        </table>
    </form>

    <?php
    // Thông báo lỗi nếu có
    if (!empty($error)) {
        echo "<div class='error-msg'>{$error}</div>";
    }

    // Kết quả sau khi thêm mới thành công
    if ($success_sp != null) {
        $sp_ten = htmlspecialchars($success_sp["Ten_sua"]);
        $sp_hang = htmlspecialchars($success_sp["Ten_hang_sua"]);
        $sp_tp = nl2br(htmlspecialchars($success_sp["TP_Dinh_Duong"]));
        $sp_li = nl2br(htmlspecialchars($success_sp["Loi_ich"]));
        $sp_tl = htmlspecialchars($success_sp["Trong_luong"]);
        $sp_dg = number_format($success_sp["Don_gia"], 0, ',', '.') . " VNĐ";
        $sp_hinh = htmlspecialchars($success_sp["Hinh"]);
        ?>

        <div class="success-msg">Thêm sữa thành công!</div>

        <table class="product-card">
            <tr>
                <th colspan="2" class="product-header">
                    <?php echo "{$sp_ten} - {$sp_hang}"; ?>
                </th>
            </tr>
            <tr class="product-body">
                <td class="product-img-col">
                    <?php if (!empty($sp_hinh) && file_exists("Hinh_sua/{$sp_hinh}")) { ?>
                        <img src="Hinh_sua/<?php echo $sp_hinh; ?>" alt="<?php echo $sp_ten; ?>">
                    <?php } else { ?>
                        <img src="Hinh_sua/<?php echo $sp_hinh; ?>" alt="<?php echo $sp_ten; ?>">
                    <?php } ?>
                </td>
                <td>
                    <div class="product-info">
                        <b>Thành phần dinh dưỡng:</b><br>
                        <?php echo $sp_tp; ?><br>
                        <b>Lợi ích:</b><br>
                        <?php echo $sp_li; ?>
                    </div>
                    <div class="product-price-box">
                        <b>Trọng lượng:</b> <span class="price-highlight"><?php echo $sp_tl; ?> gr</span> - <b>Đơn giá:</b> <span class="price-highlight"><?php echo $sp_dg; ?></span>
                    </div>
                </td>
            </tr>
        </table>

    <?php
    }

    // Đóng kết nối
    mysqli_free_result($resHang);
    mysqli_free_result($resLoai);
    mysqli_close($conn);
    ?>
</div>

</body>
</html>


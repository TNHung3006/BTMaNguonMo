<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin các sản phẩm - List dạng cột có link</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table.main-table {
            border-collapse: collapse;
            width: 900px;
            margin: 20px auto;
            border: 1px solid #d48b54;
        }
        th.header-title {
            background-color: #feebe2;
            color: #e65100;
            padding: 12px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            border: 1px solid #d48b54;
            letter-spacing: 1px;
        }
        td.product-cell {
            border: 1px solid #d48b54;
            width: 20%;
            padding: 10px 5px;
            text-align: center;
            vertical-align: top;
        }
        .product-name {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
            min-height: 35px;
        }
        .product-name a {
            color: #8b1373;
            text-decoration: underline;
        }
        .product-name a:hover {
            color: #d32f2f;
        }
        .product-price {
            font-size: 13px;
            color: #333;
            margin-bottom: 8px;
        }
        .product-img {
            max-width: 100px;
            height: 110px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        /* Style cho phần Chi tiết sản phẩm */
        .detail-card {
            width: 650px;
            margin: 30px auto;
            border: 3px solid #b75317;
            background-color: #fff;
            border-collapse: collapse;
        }
        .detail-header {
            background-color: #feebe2;
            color: #e06000;
            padding: 10px;
            font-size: 24px;
            font-style: italic;
            font-family: "Brush Script MT", "Comic Sans MS", cursive, sans-serif;
            text-align: center;
            border-bottom: 1px solid #b75317;
        }
        .detail-content td {
            padding: 12px;
            vertical-align: top;
        }
        .detail-img-col {
            width: 200px;
            text-align: center;
            vertical-align: middle !important;
        }
        .detail-img-col img {
            max-width: 170px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .detail-info {
            font-size: 13px;
            line-height: 1.6;
            color: #222;
        }
        .detail-info b {
            color: #000;
        }
        .detail-price-box {
            text-align: right;
            margin-top: 15px;
            font-size: 13px;
        }
        .back-link {
            text-align: center;
            margin-top: 8px;
        }
        .back-link a {
            color: #551a8b;
            font-size: 13px;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<?php
// 1. Kết nối vào CSDL MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quanly_ban_sua";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");

// 2. Kiểm tra xem người dùng có đang bấm xem chi tiết sản phẩm nào không (có $_GET['masua'] hay không)
if (isset($_GET['masua']) && !empty($_GET['masua'])) {
    $masua = mysqli_real_escape_string($conn, $_GET['masua']);

    // Truy vấn thông tin chi tiết của loại sữa được chọn
    $detailQuery = "SELECT sua.*, hang_sua.Ten_hang_sua 
                    FROM sua 
                    JOIN hang_sua ON sua.Ma_hang_sua = hang_sua.Ma_hang_sua 
                    WHERE sua.Ma_sua = '{$masua}'";
    $detailResult = mysqli_query($conn, $detailQuery);

    if ($detailResult && mysqli_num_rows($detailResult) > 0) {
        $sp = mysqli_fetch_assoc($detailResult);
        $ten_sua = htmlspecialchars($sp["Ten_sua"]);
        $ten_hang = htmlspecialchars($sp["Ten_hang_sua"]);
        $tp_dinh_duong = nl2br(htmlspecialchars($sp["TP_Dinh_Duong"]));
        $loi_ich = nl2br(htmlspecialchars($sp["Loi_ich"]));
        $trong_luong = htmlspecialchars($sp["Trong_luong"]);
        $don_gia = number_format($sp["Don_gia"], 0, ',', '.') . " VNĐ";
        $hinh = htmlspecialchars($sp["Hinh"]);
        ?>

        <!-- BẢNG HIỂN THỊ CHI TIẾT SẢN PHẨM -->
        <table class="detail-card">
            <tr>
                <th colspan="2" class="detail-header">
                    <?php echo "{$ten_sua} - {$ten_hang}"; ?>
                </th>
            </tr>
            <tr class="detail-content">
                <td class="detail-img-col">
                    <img src="Hinh_sua/<?php echo $hinh; ?>" alt="<?php echo $ten_sua; ?>">
                    <div class="back-link">
                        <a href="bai2-7.php">Quay về</a>
                    </div>
                </td>
                <td>
                    <div class="detail-info">
                        <b>Thành phần dinh dưỡng:</b><br>
                        <?php echo $tp_dinh_duong; ?><br><br>
                        <b>Lợi ích:</b><br>
                        <?php echo $loi_ich; ?>
                    </div>
                    <div class="detail-price-box">
                        <b>Trọng lượng:</b> <?php echo $trong_luong; ?> gr - <b>Đơn giá:</b> <?php echo $don_gia; ?>
                    </div>
                </td>
            </tr>
        </table>

        <?php
        mysqli_free_result($detailResult);
    } else {
        echo "<p style='text-align:center; color:red;'>Không tìm thấy thông tin sản phẩm!</p>";
        echo "<p style='text-align:center;'><a href='bai2-7.php'>Quay về</a></p>";
    }

} else {
    // 3. Nếu chưa chọn sản phẩm nào -> Hiển thị danh sách 5 cột có link
    $query = "SELECT Ma_sua, Ten_sua, Trong_luong, Don_gia, Hinh FROM sua";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    ?>

    <table class="main-table">
        <tr>
            <th colspan="5" class="header-title">THÔNG TIN CÁC SẢN PHẨM</th>
        </tr>

        <?php
        $cols = 5;
        $count = 0;

        while ($row = mysqli_fetch_assoc($result)) {
            if ($count % $cols == 0) {
                echo "<tr>";
            }

            $masua = urlencode($row["Ma_sua"]);
            $ten_sua = htmlspecialchars($row["Ten_sua"]);
            $trong_luong = htmlspecialchars($row["Trong_luong"]);
            $don_gia = number_format($row["Don_gia"], 0, ',', '.') . " VNĐ";
            $hinh = htmlspecialchars($row["Hinh"]);

            echo "<td class='product-cell'>";
            // Link chuyển đến trang chi tiết kèm theo tham số ?masua=...
            echo "<div class='product-name'><a href='bai2-7.php?masua={$masua}'>{$ten_sua}</a></div>";
            echo "<div class='product-price'>{$trong_luong} gr - {$don_gia}</div>";
            echo "<a href='bai2-7.php?masua={$masua}'><img class='product-img' src='Hinh_sua/{$hinh}' alt='{$ten_sua}'></a>";
            echo "</td>";

            $count++;

            if ($count % $cols == 0) {
                echo "</tr>";
            }
        }

        // Bổ sung ô trống nếu dòng cuối không đủ 5 cột
        if ($count % $cols != 0) {
            $remaining = $cols - ($count % $cols);
            for ($i = 0; $i < $remaining; $i++) {
                echo "<td class='product-cell'></td>";
            }
            echo "</tr>";
        }

        mysqli_free_result($result);
        ?>
    </table>

<?php
}

// 4. Đóng kết nối
mysqli_close($conn);
?>

</body>
</html>


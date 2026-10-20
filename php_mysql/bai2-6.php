<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin các sản phẩm - List dạng cột</title>
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
            width: 20%; /* Mỗi dòng 5 cột => mỗi ô chiếm 20% */
            padding: 10px 5px;
            text-align: center;
            vertical-align: top;
        }
        .product-name {
            font-weight: bold;
            font-size: 14px;
            color: #000;
            margin-bottom: 5px;
            min-height: 35px; /* Giữ độ cao đồng đều cho các ô */
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

// 2. Truy vấn đọc bảng sua
$query = "SELECT Ten_sua, Trong_luong, Don_gia, Hinh FROM sua";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<table class="main-table">
    <!-- Tiêu đề gộp 5 cột -->
    <tr>
        <th colspan="5" class="header-title">THÔNG TIN CÁC SẢN PHẨM</th>
    </tr>

    <?php
    $cols = 5;      // Yêu cầu: mỗi dòng có 5 cột
    $count = 0;     // Đếm số sản phẩm đã in ra dòng hiện tại

    while ($row = mysqli_fetch_assoc($result)) {
        // Nếu bắt đầu 1 hàng mới (chia hết cho 5)
        if ($count % $cols == 0) {
            echo "<tr>";
        }

        $ten_sua = htmlspecialchars($row["Ten_sua"]);
        $trong_luong = htmlspecialchars($row["Trong_luong"]);
        $don_gia = number_format($row["Don_gia"], 0, ',', '.') . " VNĐ";
        $hinh = htmlspecialchars($row["Hinh"]);

        // In từng ô sản phẩm
        echo "<td class='product-cell'>";
        echo "<div class='product-name'>{$ten_sua}</div>";
        echo "<div class='product-price'>{$trong_luong} gr - {$don_gia}</div>";
        echo "<img class='product-img' src='Hinh_sua/{$hinh}' alt='{$ten_sua}'>";
        echo "</td>";

        $count++;

        // Khi đã đủ 5 cột thì đóng hàng
        if ($count % $cols == 0) {
            echo "</tr>";
        }
    }

    // Nếu dòng cuối cùng chưa đủ 5 sản phẩm thì bổ sung các ô <td> trống
    if ($count % $cols != 0) {
        $remaining = $cols - ($count % $cols);
        for ($i = 0; $i < $remaining; $i++) {
            echo "<td class='product-cell'></td>";
        }
        echo "</tr>";
    }

    // Giải phóng bộ nhớ và đóng kết nối
    mysqli_free_result($result);
    mysqli_close($conn);
    ?>
</table>

</body>
</html>
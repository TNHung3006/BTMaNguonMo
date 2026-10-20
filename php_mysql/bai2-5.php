<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin các sản phẩm - List đơn giản</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 600px;
            margin: 20px auto;
            border: 1px solid #dcdcdc;
            box-shadow: 0px 0px 5px rgba(0,0,0,0.1);
        }
        th {
            background-color: #feebe2;
            color: #d35400;
            padding: 12px;
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 1px;
            border-bottom: 2px solid #f5cba7;
        }
        td {
            border-bottom: 1px solid #e0e0e0;
            padding: 10px 15px;
            vertical-align: middle;
        }
        .col-img {
            width: 140px;
            text-align: center;
        }
        .col-img img {
            max-width: 90px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .product-name {
            font-weight: bold;
            font-size: 16px;
            color: #000000;
            margin-bottom: 8px;
        }
        .product-info {
            font-size: 13px;
            color: #333333;
            line-height: 1.6;
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

// 2. Truy vấn dữ liệu từ bảng sua, hang_sua, loai_sua
$query = "SELECT sua.Ten_sua, sua.Hinh, sua.Trong_luong, sua.Don_gia, 
                 hang_sua.Ten_hang_sua, loai_sua.Ten_loai
          FROM sua 
          JOIN hang_sua ON sua.Ma_hang_sua = hang_sua.Ma_hang_sua
          JOIN loai_sua ON sua.Ma_loai_sua = loai_sua.Ma_loai_sua";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<table>
    <!-- Hàng tiêu đề chính của bảng -->
    <tr>
        <th colspan="2">THÔNG TIN CÁC SẢN PHẨM</th>
    </tr>

    <?php
    // 3. Lặp qua từng sản phẩm sữa
    while ($row = mysqli_fetch_assoc($result)) {
        // Tên file ảnh từ CSDL (nằm trong thư mục Hinh_sua/)
        $hinh = htmlspecialchars($row["Hinh"]);
        $ten_sua = htmlspecialchars($row["Ten_sua"]);
        $ten_hang = htmlspecialchars($row["Ten_hang_sua"]);
        $ten_loai = htmlspecialchars($row["Ten_loai"]);
        $trong_luong = htmlspecialchars($row["Trong_luong"]);
        // Định dạng tiền đơn giá (không dấu chấm thập phân, ví dụ: 145000 VNĐ)
        $don_gia = number_format($row["Don_gia"], 0, '', '') . " VNĐ";

        echo "<tr>";
        // Cột 1: Cột hình ảnh sản phẩm
        echo "<td class='col-img'>";
        echo "<img src='Hinh_sua/{$hinh}' alt='{$ten_sua}'>";
        echo "</td>";

        // Cột 2: Cột nội dung chi tiết
        echo "<td>";
        echo "<div class='product-name'>{$ten_sua}</div>";
        echo "<div class='product-info'>";
        echo "Nhà sản xuất: {$ten_hang}<br>";
        echo "{$ten_loai} - {$trong_luong} gr - {$don_gia}";
        echo "</div>";
        echo "</td>";

        echo "</tr>";
    }

    // 4. Giải phóng bộ nhớ và đóng kết nối
    mysqli_free_result($result);
    mysqli_close($conn);
    ?>
</table>

</body>
</html>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin chi tiết các loại sữa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h2.main-title {
            text-align: center;
            color: #d84315;
            font-style: italic;
            font-family: "Times New Roman", Times, serif;
            letter-spacing: 2px;
            margin-top: 20px;
            margin-bottom: 25px;
        }
        .container {
            width: 650px;
            margin: 0 auto;
        }
        .product-card {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #b75317;
            margin-bottom: 20px;
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
            max-width: 110px;
            max-height: 120px;
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
            margin-top: 10px;
            font-size: 13px;
        }
        .product-price-box b {
            color: #000000;
        }
        .price-highlight {
            color: #d32f2f;
        }
        /* Thanh phân trang */
        .pagination {
            text-align: center;
            margin: 25px auto;
            font-size: 14px;
            white-space: nowrap;
        }
        .pagination a {
            color: #551a8b;
            text-decoration: underline;
            padding: 1px 2px;
        }
        .pagination a:hover {
            color: #d84315;
        }
        .pagination .current {
            font-weight: bold;
            color: #000000;
            padding: 1px 2px;
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

// 2. Thiết lập thông số phân trang (Mỗi trang gồm có hai sản phẩm như yêu cầu chức năng)
$rowsPerPage = 2;

// Lấy trang hiện tại từ URL (GET), nếu không có thì mặc định là trang 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Tính vị trí bắt đầu lấy dữ liệu (OFFSET)
$offset = ($page - 1) * $rowsPerPage;

// 3. Đếm tổng số sản phẩm sữa để tính tổng số trang
$countQuery = "SELECT COUNT(*) as total FROM sua";
$countResult = mysqli_query($conn, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$totalRows = $countRow['total'];
$maxPage = ceil($totalRows / $rowsPerPage);

// Điều chỉnh nếu vượt quá maxPage
if ($page > $maxPage && $maxPage > 0) {
    $page = $maxPage;
    $offset = ($page - 1) * $rowsPerPage;
}

// 4. Truy vấn 2 sản phẩm cho trang hiện tại kết hợp tên hãng sữa
$query = "SELECT sua.*, hang_sua.Ten_hang_sua 
          FROM sua 
          JOIN hang_sua ON sua.Ma_hang_sua = hang_sua.Ma_hang_sua 
          LIMIT $offset, $rowsPerPage";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<h2 class="main-title">THÔNG TIN CHI TIẾT CÁC LOẠI SỮA</h2>

<div class="container">
    <?php
    // 5. Hiển thị thông tin chi tiết từng sản phẩm
    while ($sp = mysqli_fetch_assoc($result)) {
        $ten_sua = htmlspecialchars($sp["Ten_sua"]);
        $ten_hang = htmlspecialchars($sp["Ten_hang_sua"]);
        $tp_dinh_duong = nl2br(htmlspecialchars($sp["TP_Dinh_Duong"]));
        $loi_ich = nl2br(htmlspecialchars($sp["Loi_ich"]));
        $trong_luong = htmlspecialchars($sp["Trong_luong"]);
        $don_gia = number_format($sp["Don_gia"], 0, ',', '.') . " VNĐ";
        $hinh = htmlspecialchars($sp["Hinh"]);
        ?>
        
        <table class="product-card">
            <tr>
                <th colspan="2" class="product-header">
                    <?php echo "{$ten_sua} - {$ten_hang}"; ?>
                </th>
            </tr>
            <tr class="product-body">
                <td class="product-img-col">
                    <img src="Hinh_sua/<?php echo $hinh; ?>" alt="<?php echo $ten_sua; ?>">
                </td>
                <td>
                    <div class="product-info">
                        <b>Thành phần dinh dưỡng:</b><br>
                        <?php echo $tp_dinh_duong; ?><br>
                        <b>Lợi ích:</b><br>
                        <?php echo $loi_ich; ?>
                    </div>
                    <div class="product-price-box">
                        <b>Trọng lượng:</b> <span class="price-highlight"><?php echo $trong_luong; ?> gr</span> - <b>Đơn giá:</b> <span class="price-highlight"><?php echo $don_gia; ?></span>
                    </div>
                </td>
            </tr>
        </table>

    <?php } ?>

    <!-- 6. Thanh phân trang số: << < 1 2 3 ... 14 ... 22 > >> -->
    <div class="pagination">
        <?php
        // Nút trang đầu (<<) và trang trước (<)
        if ($page > 1) {
            echo "<a href='?page=1'>&lt;&lt;</a> ";
            echo "<a href='?page=" . ($page - 1) . "'>&lt;</a> ";
        }

        // Danh sách các số trang
        for ($i = 1; $i <= $maxPage; $i++) {
            if ($i == $page) {
                echo "<span class='current'>$i</span> ";
            } else {
                echo "<a href='?page=$i'>$i</a> ";
            }
        }

        // Nút trang kế (>) và trang cuối (>>)
        if ($page < $maxPage) {
            echo "<a href='?page=" . ($page + 1) . "'>&gt;</a> ";
            echo "<a href='?page=$maxPage'>&gt;&gt;</a>";
        }
        ?>
    </div>
</div>

<?php
// 7. Giải phóng bộ nhớ và đóng kết nối
mysqli_free_result($result);
mysqli_free_result($countResult);
mysqli_close($conn);
?>

</body>
</html>


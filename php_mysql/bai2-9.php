<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm đơn giản - Thông tin sữa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 650px;
            margin: 20px auto;
        }
        /* Khung Form Tìm Kiếm */
        .search-box {
            background-color: #fde8e8;
            border: 1px solid #f8b4b4;
            padding: 15px;
            text-align: center;
            margin-bottom: 15px;
        }
        .search-title {
            color: #e02424;
            font-size: 22px;
            font-style: italic;
            font-family: "Times New Roman", Times, serif;
            letter-spacing: 1px;
            margin: 0 0 12px 0;
            text-transform: uppercase;
        }
        .search-form {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: bold;
            color: #9b1c1c;
        }
        .search-input {
            width: 250px;
            padding: 4px 8px;
            font-size: 14px;
            border: 1px solid #ccc;
        }
        .search-btn {
            padding: 4px 12px;
            font-size: 13px;
            background-color: #efefef;
            border: 1px solid #767676;
            cursor: pointer;
        }
        .search-btn:hover {
            background-color: #e0e0e0;
        }

        /* Dòng thông báo kết quả */
        .result-notify {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin: 15px 0;
        }
        .not-found {
            color: #d32f2f;
        }

        /* Khung hiển thị chi tiết sản phẩm sữa */
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

// 2. Lấy từ khóa tìm kiếm (nếu có submit form)
$ten_sua_search = isset($_GET['ten_sua']) ? trim($_GET['ten_sua']) : '';
$isSearched = isset($_GET['timkiem']);
?>

<div class="container">
    <!-- KHUNG FORM TÌM KIẾM -->
    <div class="search-box">
        <h2 class="search-title">TÌM KIẾM THÔNG TIN SỮA</h2>
        <form action="" method="GET" class="search-form">
            <label for="ten_sua">Tên sữa:</label>
            <input type="text" id="ten_sua" name="ten_sua" class="search-input" value="<?php echo htmlspecialchars($ten_sua_search); ?>">
            <input type="submit" name="timkiem" value="Tìm kiếm" class="search-btn">
        </form>
    </div>

    <?php
    // 3. Xử lý tìm kiếm khi người dùng nhấn nút Tìm kiếm
    if ($isSearched) {
        $ten_sua_safe = mysqli_real_escape_string($conn, $ten_sua_search);

        // Truy vấn tìm kiếm tương đối (LIKE %...%) kết hợp tên hãng sữa
        $query = "SELECT sua.*, hang_sua.Ten_hang_sua 
                  FROM sua 
                  JOIN hang_sua ON sua.Ma_hang_sua = hang_sua.Ma_hang_sua 
                  WHERE sua.Ten_sua LIKE '%{$ten_sua_safe}%'";

        $result = mysqli_query($conn, $query);
        $num_rows = $result ? mysqli_num_rows($result) : 0;

        // Thông báo kết quả tìm kiếm
        if ($num_rows > 0) {
            echo "<div class='result-notify'>Có {$num_rows} sản phẩm được tìm thấy</div>";

            // In danh sách các sản phẩm tìm được
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

            <?php
            }
            mysqli_free_result($result);
        } else {
            // Không tìm thấy sản phẩm nào
            echo "<div class='result-notify not-found'>Không tìm thấy sản phẩm này</div>";
        }
    }

    // Đóng kết nối
    mysqli_close($conn);
    ?>
</div>

</body>
</html>


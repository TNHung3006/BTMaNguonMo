<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm nâng cao - Thông tin sữa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 650px;
            margin: 20px auto;
        }
        /* Khung Form Tìm Kiếm Nâng Cao */
        .search-box {
            background-color: #feebe2;
            border: 1px solid #f5cba7;
            padding: 15px;
            margin-bottom: 15px;
        }
        .search-title {
            color: #d35400;
            font-size: 22px;
            font-style: italic;
            font-family: "Times New Roman", Times, serif;
            letter-spacing: 1px;
            text-align: center;
            margin: 0 0 15px 0;
            text-transform: uppercase;
        }
        .form-row {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
            font-size: 14px;
            color: #b94a00;
            font-weight: bold;
        }
        .form-group {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        select, input[type="text"] {
            padding: 3px 6px;
            font-size: 13px;
            border: 1px solid #ccc;
        }
        select {
            min-width: 100px;
        }
        input[type="text"] {
            width: 220px;
        }
        .search-btn {
            padding: 3px 12px;
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

// 2. Lấy dữ liệu cho dropdown Loại sữa và Hãng sữa
$queryLoai = "SELECT Ma_loai_sua, Ten_loai FROM loai_sua";
$resultLoai = mysqli_query($conn, $queryLoai);

$queryHang = "SELECT Ma_hang_sua, Ten_hang_sua FROM hang_sua";
$resultHang = mysqli_query($conn, $queryHang);

// 3. Lấy các giá trị người dùng đã chọn / nhập (để giữ trạng thái form)
$selected_loai = isset($_GET['loai_sua']) ? $_GET['loai_sua'] : '';
$selected_hang = isset($_GET['hang_sua']) ? $_GET['hang_sua'] : '';
$ten_sua_search = isset($_GET['ten_sua']) ? trim($_GET['ten_sua']) : '';
$isSearched = isset($_GET['timkiem']);
?>

<div class="container">
    <!-- FORM TÌM KIẾM NÂNG CAO -->
    <div class="search-box">
        <h2 class="search-title">TÌM KIẾM THÔNG TIN SỮA</h2>
        <form action="" method="GET">
            <!-- Dòng 1: Chọn Loại sữa và Hãng sữa -->
            <div class="form-row">
                <div class="form-group">
                    <label for="loai_sua">Loại sữa:</label>
                    <select name="loai_sua" id="loai_sua">
                        <?php
                        while ($loai = mysqli_fetch_assoc($resultLoai)) {
                            $sel = ($selected_loai == $loai['Ma_loai_sua']) ? 'selected' : '';
                            echo "<option value='{$loai['Ma_loai_sua']}' {$sel}>{$loai['Ten_loai']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="hang_sua">Hãng sữa:</label>
                    <select name="hang_sua" id="hang_sua">
                        <?php
                        while ($hang = mysqli_fetch_assoc($resultHang)) {
                            $sel = ($selected_hang == $hang['Ma_hang_sua']) ? 'selected' : '';
                            echo "<option value='{$hang['Ma_hang_sua']}' {$sel}>{$hang['Ten_hang_sua']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Dòng 2: Nhập Tên sữa và Nút Tìm kiếm -->
            <div class="form-row">
                <div class="form-group">
                    <label for="ten_sua">Tên sữa:</label>
                    <input type="text" id="ten_sua" name="ten_sua" value="<?php echo htmlspecialchars($ten_sua_search); ?>">
                </div>
                <input type="submit" name="timkiem" value="Tìm kiếm" class="search-btn">
            </div>
        </form>
    </div>

    <?php
    // 4. Xử lý tìm kiếm nâng cao khi submit
    if ($isSearched) {
        $ten_sua_safe = mysqli_real_escape_string($conn, $ten_sua_search);
        $loai_safe = mysqli_real_escape_string($conn, $selected_loai);
        $hang_safe = mysqli_real_escape_string($conn, $selected_hang);

        // Xây dựng câu truy vấn kết hợp: Loại sữa + Hãng sữa + Tên sữa (tìm kiếm tương đối)
        $query = "SELECT sua.*, hang_sua.Ten_hang_sua 
                  FROM sua 
                  JOIN hang_sua ON sua.Ma_hang_sua = hang_sua.Ma_hang_sua 
                  WHERE sua.Ma_loai_sua = '{$loai_safe}'
                    AND sua.Ma_hang_sua = '{$hang_safe}'
                    AND sua.Ten_sua LIKE '%{$ten_sua_safe}%'";

        $result = mysqli_query($conn, $query);
        $num_rows = $result ? mysqli_num_rows($result) : 0;

        // Thông báo kết quả tìm kiếm
        if ($num_rows > 0) {
            echo "<div class='result-notify'>Có {$num_rows} sản phẩm được tìm thấy</div>";

            // In danh sách chi tiết các sản phẩm tìm được
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
            echo "<div class='result-notify not-found'>Không tìm thấy sản phẩm này</div>";
        }
    }

    // 5. Giải phóng tài nguyên và đóng kết nối
    mysqli_free_result($resultLoai);
    mysqli_free_result($resultHang);
    mysqli_close($conn);
    ?>
</div>

</body>
</html>


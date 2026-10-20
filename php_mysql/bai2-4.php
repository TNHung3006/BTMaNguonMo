<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin sữa - Phân trang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 850px;
            margin: 15px auto;
            border: 2px solid #e08b5c;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #e08b5c;
            padding: 6px 10px;
        }
        th {
            background-color: #fed9bf;
            color: #b94a00;
            font-weight: bold;
            text-align: center;
        }
        h2 {
            text-align: center;
            color: #b94a00;
            font-style: italic;
            font-family: "Times New Roman", Times, serif;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }
        /* Dòng lẻ: nền trắng, chữ đen */
        tr:nth-child(even) td {
            background-color: #ffffff;
            color: #000000;
        }
        /* Dòng chẵn: nền cam nhạt, chữ nâu đậm */
        tr:nth-child(odd):not(:first-child) td {
            background-color: #fee9db;
            color: #a04000;
        }
        .center {
            text-align: center;
        }
        .right {
            text-align: right;
        }
        /* Thanh phân trang */
        .pagination {
            text-align: center;
            margin: 15px auto;
            font-size: 16px;
        }
        .pagination a {
            color: #8b3294;
            text-decoration: none;
            padding: 2px 5px;
            font-weight: bold;
        }
        .pagination a:hover {
            text-decoration: underline;
        }
        .pagination .current {
            font-weight: bold;
            color: #000000;
            padding: 2px 5px;
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

// 2. Thiết lập thông số phân trang
// Đề bài yêu cầu: mỗi trang gồm có 2 dòng dữ liệu (hoặc 5 dòng như trong ảnh minh họa)
$rowsPerPage = 5; // Bạn có thể sửa thành 2 theo yêu cầu chức năng hoặc 5 theo hình ảnh

// Lấy trang hiện tại từ URL (GET), nếu không có thì mặc định là trang 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Tính vị trí bắt đầu lấy dữ liệu (OFFSET)
$offset = ($page - 1) * $rowsPerPage;

// 3. Đếm tổng số dòng sữa để tính tổng số trang
$countQuery = "SELECT COUNT(*) as total FROM sua";
$countResult = mysqli_query($conn, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$totalRows = $countRow['total'];
$maxPage = ceil($totalRows / $rowsPerPage);

// 4. Truy vấn dữ liệu có LIMIT/OFFSET kết hợp JOIN bảng sua, hang_sua, loai_sua
$query = "SELECT sua.Ten_sua, hang_sua.Ten_hang_sua, loai_sua.Ten_loai, sua.Trong_luong, sua.Don_gia 
          FROM sua 
          JOIN hang_sua ON sua.Ma_hang_sua = hang_sua.Ma_hang_sua
          JOIN loai_sua ON sua.Ma_loai_sua = loai_sua.Ma_loai_sua
          LIMIT $offset, $rowsPerPage";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<h2>THÔNG TIN SỮA</h2>

<table>
    <tr>
        <th>Số TT</th>
        <th>Tên sữa</th>
        <th>Hãng sữa</th>
        <th>Loại sữa</th>
        <th>Trọng lượng</th>
        <th>Đơn giá</th>
    </tr>

    <?php
    // Số thứ tự tăng dần theo từng trang
    $stt = $offset + 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td class='center'>{$stt}</td>";
        echo "<td>" . htmlspecialchars($row["Ten_sua"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Ten_hang_sua"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Ten_loai"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Trong_luong"]) . " gram</td>";
        // Định dạng tiền tệ kiểu Việt Nam (ví dụ: 90.000 VNĐ)
        echo "<td class='right'>" . number_format($row["Don_gia"], 0, ',', '.') . " VNĐ</td>";
        echo "</tr>";
        $stt++;
    }
    ?>
</table>

<!-- 5. Thanh điều hướng phân trang: << < 1 2 3 ... > >> -->
<div class="pagination">
    <?php
    // Nút về trang đầu (<<) và trang trước (<)
    if ($page > 1) {
        echo "<a href='?page=1'>&lt;&lt;</a> ";
        echo "<a href='?page=" . ($page - 1) . "'>&lt;</a> ";
    }

    // Các con số trang: 1 2 3 4...
    for ($i = 1; $i <= $maxPage; $i++) {
        if ($i == $page) {
            echo "<span class='current'>$i</span> ";
        } else {
            echo "<a href='?page=$i'>$i</a> ";
        }
    }

    // Nút sang trang kế (>) và trang cuối (>>)
    if ($page < $maxPage) {
        echo "<a href='?page=" . ($page + 1) . "'>&gt;</a> ";
        echo "<a href='?page=$maxPage'>&gt;&gt;</a>";
    }
    ?>
</div>

<?php
// Giải phóng vùng nhớ và đóng kết nối
mysqli_free_result($result);
mysqli_free_result($countResult);
mysqli_close($conn);
?>

</body>
</html>
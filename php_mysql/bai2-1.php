<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin hãng sữa</title>
    <style>
        table {
            border-collapse: collapse;
            width: 800px;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 6px 10px;
        }
        th {
            font-weight: bold;
            text-align: center;
        }
        h2 {
            text-align: center;
            color: #2b78a9;
            font-style: italic;
            font-family: "Times New Roman", Times, serif;
            letter-spacing: 2px;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>

<?php
// 1. Kết nối vào MySQL (sử dụng thông tin từ file Bai1-3.php)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quanly_ban_sua";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Thiết lập mã UTF-8 để hiển thị tiếng Việt không bị lỗi font
mysqli_set_charset($conn, "utf8");

// 2. Chuẩn bị & thực thi câu truy vấn đọc bảng hang_sua
$query = "SELECT Ma_hang_sua, Ten_hang_sua, Dia_chi, Dien_thoai, Email FROM hang_sua";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<h2>THÔNG TIN HÃNG SỮA</h2>

<table border="2">
    <tr>
        <th>Mã HS</th>
        <th>Tên hãng sữa</th>
        <th>Địa chỉ</th>
        <th>Điện thoại</th>
        <th>Email</th>
    </tr>

    <?php
    // 3. Duyệt và in từng dòng dữ liệu lên lưới table
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td class='center'>" . htmlspecialchars($row["Ma_hang_sua"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Ten_hang_sua"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Dia_chi"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Dien_thoai"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Email"]) . "</td>";
        echo "</tr>";
    }

    // 4. Giải phóng vùng nhớ và đóng kết nối
    mysqli_free_result($result);
    mysqli_close($conn);
    ?>
</table>

</body>
</html>
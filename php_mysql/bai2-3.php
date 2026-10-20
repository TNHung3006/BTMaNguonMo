<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lưới tùy biến - Thông tin khách hàng</title>
    <style>
        table {
            border-collapse: collapse;
            width: 850px;
            margin: 20px auto;
            border: 2px solid #d48b54;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #d48b54;
            padding: 6px 10px;
        }
        th {
            font-weight: bold;
            text-align: center;
            color: #b33900;
            background-color: #ffffff;
        }
        h2 {
            text-align: center;
            text-transform: uppercase;
            font-family: Arial, sans-serif;
            letter-spacing: 1px;
        }
        /* Tô màu xen kẽ các dòng (dòng lẻ nền cam nhạt, dòng chẵn nền trắng) */
        tr:nth-child(odd) td {
            background-color: #feefe3;
        }
        tr:nth-child(even) td {
            background-color: #ffffff;
        }
        .center {
            text-align: center;
        }
        /* Chỉnh kích thước icon giới tính */
        .gender-icon {
            width: 32px;
            height: 32px;
            vertical-align: middle;
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

// Thiết lập mã UTF-8 để hiển thị tiếng Việt không bị lỗi font
mysqli_set_charset($conn, "utf8");

// 2. Chuẩn bị & thực thi câu truy vấn đọc bảng khach_hang
$query = "SELECT Ma_khach_hang, Ten_khach_hang, Phai, Dia_chi, Dien_thoai FROM khach_hang";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<h2>THÔNG TIN KHÁCH HÀNG</h2>

<table>
    <tr>
        <th>Mã KH</th>
        <th>Tên khách hàng</th>
        <th>Giới tính</th>
        <th>Địa chỉ</th>
        <th>Số điện thoại</th>
    </tr>

    <?php
    // 3. Duyệt và in dữ liệu
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td class='center'>" . htmlspecialchars($row["Ma_khach_hang"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Ten_khach_hang"]) . "</td>";
        
        // Tùy biến cột giới tính: Phai = 1 (hoặc khác 0) là Nữ, Phai = 0 là Nam
        // (Kiểm tra và đổi lại đường dẫn ảnh cho đúng với thư mục chứa ảnh trên máy của bạn)
        $hinh_gioi_tinh = ($row["Phai"] == 1 || $row["Phai"] == "1") ? "nu.png" : "nam.png";
        
        echo "<td class='center'><img class='gender-icon' src='Hinh_sua/{$hinh_gioi_tinh}' alt='Giới tính'></td>";
        echo "<td>" . htmlspecialchars($row["Dia_chi"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Dien_thoai"]) . "</td>";
        echo "</tr>";
    }
    // 4. Giải phóng bộ nhớ và đóng kết nối
    mysqli_free_result($result);
    mysqli_close($conn);
    ?>
</table>

</body>
</html>
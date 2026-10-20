<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách khách hàng</title>
</head>
<body>
    <?php 
        // 1. Kết nối CSDL
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "quanly_ban_sua";
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");

        // 2. Câu truy vấn
        $query = "SELECT *
                  FROM khach_hang
                  WHERE Ten_khach_hang LIKE 'N%' AND Phai = 0";
        $result = mysqli_query($conn, $query);
        if (!$result) die("Lỗi: " . mysqli_error($conn));
    ?>

    <table border="1" cellpadding="5" style="border-collapse: collapse;">
        <tr>
            <th>Mã khách hàng</th>
            <th>Tên khách hàng</th>
            <th>Phái</th>
            <th>Địa chỉ</th>
            <th>Điện thoại</th>
            <th>Email</th>
        </tr>

        <?php 
        // 3. In dữ liệu theo Cách 2: Dùng mysqli_fetch_assoc và gọi theo tên cột
        while ($row = mysqli_fetch_assoc($result)) { 
        ?>
            <tr>
                <td><?php echo htmlspecialchars($row["Ma_khach_hang"]); ?></td>
                <td><?php echo htmlspecialchars($row["Ten_khach_hang"]); ?></td>
                <td><?php echo ($row["Phai"] == 0) ? "Nam" : "Nữ"; ?></td>
                <td><?php echo htmlspecialchars($row["Dia_chi"]); ?></td>
                <td><?php echo htmlspecialchars($row["Dien_thoai"]); ?></td>
                <td><?php echo htmlspecialchars($row["Email"]); ?></td>
            </tr>
        <?php 
        } 
        
        // 4. Giải phóng vùng nhớ và đóng kết nối
        mysqli_free_result($result);
        mysqli_close($conn);
        ?> 
    </table>
</body>
</html>


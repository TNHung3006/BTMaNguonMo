<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sữa có đơn giá cao nhất của mỗi hãng</title>
</head>
<body>
    <?php 
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "quanly_ban_sua";
        $conn = mysqli_connect($servername, $username, $password, $database);

        if(!$conn) die("khong ket noi duoc db" . mysqli_connect_error());
        mysqli_set_charset($conn, "utf8");

        // Với mỗi dòng sữa s, subquery tìm mã sữa đắt nhất cùng hãng (LIMIT 1)
        // Chỉ giữ dòng nào có Ma_sua trùng -> mỗi hãng còn đúng 1 sữa
        $query = "SELECT *
                FROM sua s
                WHERE s.Ma_sua = (SELECT s2.Ma_sua
                                  FROM sua s2
                                  WHERE s2.Ma_hang_sua = s.Ma_hang_sua
                                  ORDER BY s2.Don_gia DESC
                                  LIMIT 1)
                ORDER BY s.Ma_hang_sua";
        $resault = mysqli_query($conn, $query);
        if(!$resault) die("Loi!!". mysqli_error($conn));
    ?>
    <table border="1">
        <tr>
            <th>Mã sữa</th>
            <th>Tên sữa</th>
            <th>Mã hãng sữa</th>
            <th>Mã loại sữa</th>
            <th>Trọng lượng</th>
            <th>Đơn giá</th>
            <th>Thành phần dinh dưỡng</th>
            <th>Lợi ích</th>
            <th>Hình</th>
        </tr>
        <?php 
            while($row=mysqli_fetch_assoc($resault)){
        ?>
            <tr>
                <td><?php echo htmlspecialchars($row["Ma_sua"]); ?></td>
                <td><?php echo htmlspecialchars($row["Ten_sua"]); ?></td>
                <td><?php echo htmlspecialchars($row["Ma_hang_sua"]); ?></td>
                <td><?php echo htmlspecialchars($row["Ma_loai_sua"]); ?></td>
                <td><?php echo htmlspecialchars($row["Trong_luong"]); ?></td>
                <td><?php echo htmlspecialchars($row["Don_gia"]); ?></td>
                <td><?php echo htmlspecialchars($row["TP_Dinh_Duong"]); ?></td>
                <td><?php echo htmlspecialchars($row["Loi_ich"]); ?></td>
                <td><img src="Hinh_sua\<?php echo htmlspecialchars($row["Hinh"]); ?>" alt="<?php echo htmlspecialchars($row["Hinh"]); ?>" width="100"></td>
            </tr>
        <?php
            }
            mysqli_free_result($resault);
            mysqli_close($conn);
        ?>

    </table>
    
</body>
</html>
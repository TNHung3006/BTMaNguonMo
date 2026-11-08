<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin hãng sữa</title>
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

        // LEFT JOIN để hãng nào chưa có sữa vẫn hiện ra (số lượng = 0)
        // COUNT(s.Ma_sua) đếm số sữa của từng hãng
        $query = "SELECT h.*, COUNT(s.Ma_sua) AS So_luong
                FROM hang_sua h
                LEFT JOIN sua s ON h.Ma_hang_sua = s.Ma_hang_sua
                GROUP BY h.Ma_hang_sua";
        $resault = mysqli_query($conn, $query);
        if(!$resault) die("Loi!!". mysqli_error($conn));
    ?>
    <table border="1">
        <tr>
            <th>Mã hãng sữa</th>
            <th>Tên hãng sữa</th>
            <th>Địa chỉ</th>
            <th>Điện thoại</th>
            <th>Email</th>
            <th>Số lượng sữa</th>
            <th>Đánh giá</th>
        </tr>
        <?php 
            while($row=mysqli_fetch_assoc($resault)){
                // Lấy số lượng sữa của hãng và phân loại
                $so_luong = $row["So_luong"];
                if($so_luong < 5){
                    $danh_gia = "Số lượng sp ít";
                } elseif($so_luong <= 10){   // từ 5 đến 10
                    $danh_gia = "Số lượng sp vừa";
                } else {                     // > 10
                    $danh_gia = "Số lượng sp nhiều";
                }
        ?>
            <tr>
                <td><?php echo htmlspecialchars($row["Ma_hang_sua"]); ?></td>
                <td><?php echo htmlspecialchars($row["Ten_hang_sua"]); ?></td>
                <td><?php echo htmlspecialchars($row["Dia_chi"]); ?></td>
                <td><?php echo htmlspecialchars($row["Dien_thoai"]); ?></td>
                <td><?php echo htmlspecialchars($row["Email"]); ?></td>
                <td><?php echo $so_luong; ?></td>
                <td><?php echo $danh_gia; ?></td>
            </tr>
        <?php
            }
            mysqli_free_result($resault);
            mysqli_close($conn);
        ?>

    </table>
    
</body>
</html>
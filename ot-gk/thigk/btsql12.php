<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "quanly_ban_sua";
        $conn = mysqli_connect($servername, $username, $password, $database);

        if(!$conn) die("khong ket noi duoc db!!!" . mysqli_connect_error());
        mysqli_set_charset($conn, "utf8");

        $query = "SELECT h.*, COUNT(S.Ma_sua) AS So_luong
                FROM hang_sua h
                JOIN sua s on s.Ma_hang_sua = h.Ma_hang_sua
                GROUP BY h.Ma_hang_sua";
        $resault = mysqli_query($conn, $query);
        if(!$resault) die("Lỗi!!" . mysqli_error($conn));
    ?>

    <table border="1">
        <tr>
            <th>Ma_hang_sua</th>
            <th>Ten_hang_sua</th>
            <th>Dia_chi</th>
            <th>Dien_thoai</th>
            <th>Email</th>
            <th>số lượng</th>
            <th>đánh giá</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($resault)){ 
                $soluong = $row["So_luong"];
                if($soluong < 5) {
                    $danhgia = "so luong sp it";
                }elseif($soluong < 10){
                    $danhgia = "so luong sp vua";
                }else{
                    $danhgia = "so luong sp nhieu";
                }
        ?>
            <tr>
                <td><?php echo htmlspecialchars($row["Ma_hang_sua"]) ?></td>
                <td><?php echo htmlspecialchars($row["Ten_hang_sua"]) ?></td>
                <td><?php echo htmlspecialchars($row["Dia_chi"]) ?></td>
                <td><?php echo htmlspecialchars($row["Dien_thoai"]) ?></td>
                <td><?php echo htmlspecialchars($row["Email"]) ?></td>
                <td><?php echo $soluong; ?> </td>
                <td><?php echo $danhgia ?></td>
            </tr>
        <?php } 
            mysqli_free_result($resault);
            mysqli_close($conn);
        ?>
    </table>
    
</body>
</html>
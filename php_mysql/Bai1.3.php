<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lay Du Lieu tu mysql</title>
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quanly_ban_sua";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");
//2. chuẩn bị câu truy vấn
$queryCau1 = "SELECT Ten_hang_sua, Dia_chi, Dien_thoai
              FROM hang_sua";
$resultCau1 = mysqli_query($conn, $queryCau1);
if (!$resultCau1) die("Lỗi câu 1: " . mysqli_error($conn));

$queryCau2 = "SELECT Ten_khach_hang, Dia_chi, Dien_thoai
              FROM khach_hang
              ORDER BY Ten_khach_hang ASC";
$resultCau2 = mysqli_query($conn, $queryCau2);
if (!$resultCau2) die("Lỗi câu 2: " . mysqli_error($conn));

$queryCau3 = "SELECT Ten_khach_hang, Phai, Dia_chi, Dien_thoai
              FROM Khach_hang
              ORDER BY Phai ASC";
$resultCau3 = mysqli_query($conn, $queryCau3);
if(!$resultCau3) die("Lỗi câu 3: " . mysqli_errno($conn));

$queryCau4 = "SELECT Ten_sua, Trong_luong, Don_gia
              FROM Sua
              ORDER BY Ten_sua ASC, Don_gia DESC";
$resultCau4 = mysqli_query($conn, $queryCau4);
if(!$resultCau4) die("Lỗi câu 4: " . mysqli_errno($conn));

$queryCau5 = "SELECT Ten_sua, Trong_luong, Don_gia, TP_Dinh_Duong
              FROM Sua
              WHERE Ten_sua LIKE 'S%'";
$resultCau5 = mysqli_query($conn, $queryCau5);
if(!$resultCau5) die("Lỗi câu 5: " . mysqli_errno($conn));

$queryCau6 = "SELECT Ma_hang_sua, Ten_hang_sua, Dia_chi, Dien_thoai
              FROM hang_sua
              WHERE Ma_hang_sua LIKE '%M'"; 
$resultCau6 = mysqli_query($conn, $queryCau6);
if (!$resultCau6) die("Lỗi câu 6: " . mysqli_error($conn));

$queryCau7 = "SELECT *
              FROM Sua
              WHERE Ten_sua LIKE '%grow%'";
$resultCau7 = mysqli_query($conn, $queryCau7);
if(!$resultCau7) die("Lỗi câu 7: " . mysqli_errno($conn));

$queryCau8 = "SELECT Ten_sua, Trong_luong, Don_gia
              FROM Sua
              WHERE Don_gia > 100000
              ORDER BY Ten_sua DESC";
$resultCau8 = mysqli_query($conn, $queryCau8);
if(!$resultCau8) die("Lỗi câu 8: " . mysqli_errno($conn));

$queryCau9 = "SELECT Ten_sua, TP_Dinh_Duong, Loi_ich
              FROM Sua
              WHERE Ma_hang_sua = 'VNM' AND Ma_loai_sua = 'SC'";
$resultCau9 = mysqli_query($conn, $queryCau9);
if(!$resultCau9) die("Lỗi câu 9: " . mysqli_errno($conn));

$queryCau10 = "SELECT *
              FROM Sua
              WHERE Trong_luong >= 900 OR Ma_hang_sua = 'DS'";
$resultCau10 = mysqli_query($conn, $queryCau10);
if(!$resultCau10) die("Lỗi câu 10: " . mysqli_errno($conn));

$queryCau11 = "SELECT *
              FROM Sua
              WHERE Don_gia BETWEEN 100000 AND 150000 ";
$resultCau11 = mysqli_query($conn, $queryCau11);
if(!$resultCau11) die("Lỗi câu 11: " . mysqli_errno($conn));

$queryCau12 = "SELECT *
              FROM Sua
              WHERE Ma_hang_sua = 'DM' OR Ma_hang_sua = 'DL' OR Ma_hang_sua = 'DS' AND Trong_luong >= 800
              ORDER BY Trong_luong ASC ";
$resultCau12 = mysqli_query($conn, $queryCau12);
if(!$resultCau12) die("Lỗi câu 12: " . mysqli_errno($conn));

$queryCau13 = "SELECT *
              FROM Sua
              WHERE Ma_loai_sua = 'SD' OR Don_gia <= 12000
              ORDER BY Trong_luong ASC ";
$resultCau13 = mysqli_query($conn, $queryCau13);
if(!$resultCau13) die("Lỗi câu 13: " . mysqli_errno($conn));

$queryCau14 = "SELECT *
              FROM Khach_hang
              WHERE Phai = 0 AND Ten_khach_hang LIKE 'N%'";
$resultCau14 = mysqli_query($conn, $queryCau14);
if(!$resultCau14) die("Lỗi câu 14: " . mysqli_errno($conn));
$numfileds14 = mysqli_num_fields($resultCau14);
$numrows14 = mysqli_num_rows($resultCau14);

$queryCau15 = "SELECT Ten_hang_sua
              FROM hang_sua
              WHERE Ma_hang_sua NOT LIKE '%M%' ";
$resultCau15 = mysqli_query($conn, $queryCau15);
if (!$resultCau15) die("Lỗi câu 15: " . mysqli_error($conn));

$queryCau16 = "SELECT Ten_sua, TP_Dinh_Duong
              FROM Sua
              WHERE TP_Dinh_Duong LIKE '%canxi%' AND TP_Dinh_Duong LIKE '%vitamin%'   
              ORDER BY Trong_luong ASC ";
$resultCau16 = mysqli_query($conn, $queryCau16);
if(!$resultCau16) die("Lỗi câu 16: " . mysqli_errno($conn));

$queryCau17 = "SELECT *
              FROM Sua
              WHERE Trong_luong = 180 OR Trong_luong = 200 OR Trong_luong = 900";
$resultCau17 = mysqli_query($conn, $queryCau17);
if(!$resultCau17) die("Lỗi câu 17: " . mysqli_errno($conn));

$queryCau18 = "SELECT *
              FROM Sua
              WHERE Trong_luong NOT IN (400, 800, 900)";
$resultCau18 = mysqli_query($conn, $queryCau18);
if(!$resultCau18) die("Lỗi câu 18: " . mysqli_errno($conn));
?>

<h3>Câu 1.1</h3>
<table border="1" style="border-collapse: collapse;" cellpadding="5">
    <tr>
        <th>Tên hãng sữa</th>
        <th>Địa chỉ</th>
        <th>Điện thoại</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($resultCau1)) { ?>
        <tr>
            <td><?php echo $row["Ten_hang_sua"]; ?></td>
            <td><?php echo $row["Dia_chi"]; ?></td>
            <td><?php echo $row["Dien_thoai"]; ?></td>
        </tr>
    <?php } ?>
</table>

<h3>Câu 1.2</h3>
<table border="1" style="border-collapse: collapse;" cellpadding="5">
    <tr>
        <th>Tên khách hàng</th>
        <th>Địa chỉ</th>
        <th>Điện thoại</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($resultCau2)) { ?>
        <tr>
            <td><?php echo $row["Ten_khach_hang"]; ?></td>
            <td><?php echo $row["Dia_chi"]; ?></td>
            <td><?php echo $row["Dien_thoai"]; ?></td>
        </tr>
    <?php } ?>
</table>
<h3>Câu 1.3</h3>
<table border="1" style="border-collapse: collapse;" cellpadding ="5">
    <tr>
        <th>Tên khách hàng</th>
        <th>Phái</th>
        <th>Địa chỉ</th>
        <th>Điện thoại</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($resultCau3)) { ?>
        <tr>
            <td><?php echo $row["Ten_khach_hang"] ?></td>
            <td><?php echo $row["Phai"] ?></td>
            <td><?php echo $row["Dia_chi"] ?></td>
            <td><?php echo $row["Dien_thoai"] ?></td>
        </tr>
    <?php } ?>    
</table>
<h3>Câu 1.4</h3>
<table border="1" style="border-collapse: collapse;" cellpadding ="5">
    <tr>
        <th>Tên sữa</th>
        <th>Trọng lượng</th>
        <th>Đơn giá</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($resultCau4)) { ?>
        <tr>
            <td><?php echo $row["Ten_sua"] ?></td>
            <td><?php echo $row["Trong_luong"] ?></td>
            <td><?php echo $row["Don_gia"] ?></td>
        </tr>
    <?php } ?>    
</table>

<h3>Câu 1.5</h3>
<table border="1" style="border-collapse: collapse;" cellpadding ="5">
    <tr>
        <th>Tên sữa</th>
        <th>Trọng lượng</th>
        <th>Đơn giá</th>
        <TH>Thành phần dinh dưỡng</TH>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($resultCau5)) { ?>
        <tr>
            <td><?php echo $row["Ten_sua"] ?></td>
            <td><?php echo $row["Trong_luong"] ?></td>
            <td><?php echo $row["Don_gia"] ?></td>
            <td><?php echo $row["TP_Dinh_Duong"] ?></td>
        </tr>
    <?php } ?>    
</table>
<h3>Câu 1.6</h3>
<table border="1" style="border-collapse: collapse;" cellpadding="5">
    <tr>
        <th>Mã hãng sữa</th>
        <th>Tên hãng sữa</th>
        <th>Địa chỉ</th>
        <th>Điện thoại</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($resultCau6)) { ?>
        <tr>
            <td><?php echo $row["Ma_hang_sua"] ?></td>
            <td><?php echo $row["Ten_hang_sua"]; ?></td>
            <td><?php echo $row["Dia_chi"]; ?></td>
            <td><?php echo $row["Dien_thoai"]; ?></td>
        </tr>
    <?php } ?>
</table>

<h3>Câu 1.7</h3>
<table border="1" style="border-collapse: collapse;" cellpadding = "5">
    <tr>
        <th>Mã sữa</th>
        <th>Tên sữa</th>
        <th>Mã hãng sữa</th>
        <th>Mã loại sữa</th>
        <th>Trọng luọng</th>
        <th>Đơn giá</th>
        <th>Thành phần dinh dưỡng</th>
        <th>Lợi ích</th>
        <th>Hình</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($resultCau7)) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row["Ma_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ten_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ma_hang_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ma_loai_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Trong_luong"]); ?></td>
        <td><?php echo htmlspecialchars($row["Don_gia"]); ?></td>
        <td><?php echo htmlspecialchars($row["TP_Dinh_Duong"]); ?></td>
        <td><?php echo htmlspecialchars($row["Loi_ich"]); ?></td>
        <td>
            <img src="Hinh_sua/<?php echo htmlspecialchars($row["Hinh"]); ?>"
                 alt="<?php echo htmlspecialchars($row["Ten_sua"]); ?>"
                 width="100">
        </td>
    </tr>
<?php } ?>
</table>

<h3>Câu 1.8</h3>
<table border="1" style="border-collapse: collapse;" cellpadding ="5">
    <tr>
        <th>Tên sữa</th>
        <th>Trọng lượng</th>
        <th>Đơn giá</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($resultCau8)) { ?>
        <tr>
            <td><?php echo $row["Ten_sua"] ?></td>
            <td><?php echo $row["Trong_luong"] ?></td>
            <td><?php echo $row["Don_gia"] ?></td>
        </tr>
    <?php } ?>    
</table>

<h3>Câu 1.9</h3>
<table border="1" style="border-collapse: collapse;" cellpadding = "5">
    <tr>
        <th>Tên sữa</th>
        <th>Thành phần dinh dưỡng</th>
        <th>Lợi ích</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($resultCau9)) { ?>
        <tr>
            <td><?php echo $row["Ten_sua"] ?></td>
            <td><?php echo $row["TP_Dinh_Duong"] ?></td>
            <td><?php echo $row["Loi_ich"] ?></td>
        </tr>
    <?php } ?>
</table>

<h3>Câu 1.10</h3>
<table border="1" style="border-collapse: collapse;" cellpadding = "5">
    <tr>
        <th>Mã sữa</th>
        <th>Tên sữa</th>
        <th>Mã hãng sữa</th>
        <th>Mã loại sữa</th>
        <th>Trọng luọng</th>
        <th>Đơn giá</th>
        <th>Thành phần dinh dưỡng</th>
        <th>Lợi ích</th>
        <th>Hình</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($resultCau10)) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row["Ma_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ten_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ma_hang_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ma_loai_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Trong_luong"]); ?></td>
        <td><?php echo htmlspecialchars($row["Don_gia"]); ?></td>
        <td><?php echo htmlspecialchars($row["TP_Dinh_Duong"]); ?></td>
        <td><?php echo htmlspecialchars($row["Loi_ich"]); ?></td>
        <td>
            <img src="Hinh_sua/<?php echo htmlspecialchars($row["Hinh"]); ?>"
                 alt="<?php echo htmlspecialchars($row["Ten_sua"]); ?>"
                 width="100">
        </td>
    </tr>
<?php } ?>
</table>

<h3>Câu 1.11</h3>
<table border="1" style="border-collapse: collapse;" cellpadding = "5">
    <tr>
        <th>Mã sữa</th>
        <th>Tên sữa</th>
        <th>Mã hãng sữa</th>
        <th>Mã loại sữa</th>
        <th>Trọng luọng</th>
        <th>Đơn giá</th>
        <th>Thành phần dinh dưỡng</th>
        <th>Lợi ích</th>
        <th>Hình</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($resultCau11)) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row["Ma_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ten_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ma_hang_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ma_loai_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Trong_luong"]); ?></td>
        <td><?php echo htmlspecialchars($row["Don_gia"]); ?></td>
        <td><?php echo htmlspecialchars($row["TP_Dinh_Duong"]); ?></td>
        <td><?php echo htmlspecialchars($row["Loi_ich"]); ?></td>
        <td>
            <img src="Hinh_sua/<?php echo htmlspecialchars($row["Hinh"]); ?>"
                 alt="<?php echo htmlspecialchars($row["Ten_sua"]); ?>"
                 width="100">
        </td>
    </tr>
<?php } ?>
</table>

<h3>Câu 1.12</h3>
<table border="1" style="border-collapse: collapse;" cellpadding = "5">
    <tr>
        <th>Mã sữa</th>
        <th>Tên sữa</th>
        <th>Mã hãng sữa</th>
        <th>Mã loại sữa</th>
        <th>Trọng luọng</th>
        <th>Đơn giá</th>
        <th>Thành phần dinh dưỡng</th>
        <th>Lợi ích</th>
        <th>Hình</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($resultCau12)) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row["Ma_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ten_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ma_hang_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ma_loai_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Trong_luong"]); ?></td>
        <td><?php echo htmlspecialchars($row["Don_gia"]); ?></td>
        <td><?php echo htmlspecialchars($row["TP_Dinh_Duong"]); ?></td>
        <td><?php echo htmlspecialchars($row["Loi_ich"]); ?></td>
        <td>
            <img src="Hinh_sua/<?php echo htmlspecialchars($row["Hinh"]); ?>"
                 alt="<?php echo htmlspecialchars($row["Ten_sua"]); ?>"
                 width="100">
        </td>
    </tr>
<?php } ?>
</table>

<h3>Câu 1.13</h3>
<table border="1" style="border-collapse: collapse;" cellpadding = "5">
    <tr>
        <th>Mã sữa</th>
        <th>Tên sữa</th>
        <th>Mã hãng sữa</th>
        <th>Mã loại sữa</th>
        <th>Trọng luọng</th>
        <th>Đơn giá</th>
        <th>Thành phần dinh dưỡng</th>
        <th>Lợi ích</th>
        <th>Hình</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($resultCau13)) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row["Ma_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ten_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ma_hang_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ma_loai_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Trong_luong"]); ?></td>
        <td><?php echo htmlspecialchars($row["Don_gia"]); ?></td>
        <td><?php echo htmlspecialchars($row["TP_Dinh_Duong"]); ?></td>
        <td><?php echo htmlspecialchars($row["Loi_ich"]); ?></td>
        <td>
            <img src="Hinh_sua/<?php echo htmlspecialchars($row["Hinh"]); ?>"
                 alt="<?php echo htmlspecialchars($row["Ten_sua"]); ?>"
                 width="100">
        </td>
    </tr>
<?php } ?>
</table>

<h3>Câu 1.14</h3>
<table border="1" style="border-collapse: collapse;" cellpadding = "5">
    <tr>
        <th>Mã khách hàng</th>
        <th>Tên khách hàng</th>
        <th>Phái</th>
        <th>Địa chỉ</th>
        <th>Điện thoại</th>
        <th>Email</th>
    </tr>
    <?php
        if($numrows14 != 0){
            while($row = mysqli_fetch_array($resultCau14)){
                echo "<tr>";
                for($i=0; $i < $numfileds14; $i++){
                    if($i == 2){ // cột thứ 3
                        if($row[$i]==0) echo "<td>Nam</td>";
                        else echo "<td>Nữ</td>";
                    }
                    else echo "<td>".$row[$i]."</td>";
                }
                echo "</tr>";
            }
        }
    ?>
</table>

<h3>Câu 1.15</h3>
<table border="1" style="border-collapse: collapse;" cellpadding="5">
    <tr>
        <th>Tên hãng sữa</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($resultCau15)) { ?>
        <tr>
            <td><?php echo $row["Ten_hang_sua"]; ?></td>
        </tr>
    <?php } ?>
</table>

<h3>Câu 1.16</h3>
<table border="1" style="border-collapse: collapse;" cellpadding = "5">
    <tr>
        <th>Tên sữa</th>
        <th>Thành phần dinh dưỡng</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($resultCau16)) { ?>
    <tr>
        
        <td><?php echo htmlspecialchars($row["Ten_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["TP_Dinh_Duong"]); ?></td>
    </tr>
<?php } ?>
</table>

<h3>Câu 1.17</h3>
<table border="1" style="border-collapse: collapse;" cellpadding = "5">
    <tr>
        <th>Mã sữa</th>
        <th>Tên sữa</th>
        <th>Mã hãng sữa</th>
        <th>Mã loại sữa</th>
        <th>Trọng luọng</th>
        <th>Đơn giá</th>
        <th>Thành phần dinh dưỡng</th>
        <th>Lợi ích</th>
        <th>Hình</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($resultCau17)) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row["Ma_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ten_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ma_hang_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ma_loai_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Trong_luong"]); ?></td>
        <td><?php echo htmlspecialchars($row["Don_gia"]); ?></td>
        <td><?php echo htmlspecialchars($row["TP_Dinh_Duong"]); ?></td>
        <td><?php echo htmlspecialchars($row["Loi_ich"]); ?></td>
        <td>
            <img src="Hinh_sua/<?php echo htmlspecialchars($row["Hinh"]); ?>"
                 alt="<?php echo htmlspecialchars($row["Ten_sua"]); ?>"
                 width="100">
        </td>
    </tr>
<?php } ?>
</table>

<h3>Câu 1.18</h3>
<table border="1" style="border-collapse: collapse;" cellpadding = "5">
    <tr>
        <th>Mã sữa</th>
        <th>Tên sữa</th>
        <th>Mã hãng sữa</th>
        <th>Mã loại sữa</th>
        <th>Trọng luọng</th>
        <th>Đơn giá</th>
        <th>Thành phần dinh dưỡng</th>
        <th>Lợi ích</th>
        <th>Hình</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($resultCau18)) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row["Ma_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ten_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ma_hang_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Ma_loai_sua"]); ?></td>
        <td><?php echo htmlspecialchars($row["Trong_luong"]); ?></td>
        <td><?php echo htmlspecialchars($row["Don_gia"]); ?></td>
        <td><?php echo htmlspecialchars($row["TP_Dinh_Duong"]); ?></td>
        <td><?php echo htmlspecialchars($row["Loi_ich"]); ?></td>
        <td>
            <img src="Hinh_sua/<?php echo htmlspecialchars($row["Hinh"]); ?>"
                 alt="<?php echo htmlspecialchars($row["Ten_sua"]); ?>"
                 width="100">
        </td>
    </tr>
<?php } ?>
</table>



<?php
mysqli_free_result($resultCau1);
mysqli_free_result($resultCau2);
mysqli_free_result($resultCau3);
mysqli_free_result($resultCau4);
mysqli_free_result($resultCau5);
mysqli_free_result($resultCau6);
mysqli_free_result($resultCau7);
mysqli_free_result($resultCau8);
mysqli_free_result($resultCau9);
mysqli_free_result($resultCau10);
mysqli_free_result($resultCau11);
mysqli_free_result($resultCau12);
mysqli_free_result($resultCau13);
mysqli_free_result($resultCau14);
mysqli_free_result($resultCau15);
mysqli_free_result($resultCau16);
mysqli_free_result($resultCau17);
mysqli_free_result($resultCau18);
mysqli_close($conn);
?>
</body>
</html>
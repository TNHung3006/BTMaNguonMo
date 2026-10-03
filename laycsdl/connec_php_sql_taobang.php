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
$dbname = "quanly_ban_sua";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");
// if($conn){
//     echo "<br> <b>Ket noi thanh cong</b><br>";
// }

//2. chuẩn bị câu truy vấn
//$query = 'SELECT * FROM khach_hang';
$query = "SELECT DISTINCT khach_hang.* 
          FROM khach_hang 
          JOIN hoa_don ON khach_hang.Ma_khach_hang = hoa_don.Ma_khach_hang
          JOIN ct_hoadon ON hoa_don.So_hoa_don = ct_hoadon.So_hoa_don
          WHERE ct_hoadon.Ma_sua = 'AB0001'";
//3. thực thi câu truy vấn
$result = mysqli_query($conn, $query);
if(!$result) die('<br> <b>Query failed</b>');
$numfileds = mysqli_num_fields($result);
$numrows = mysqli_num_rows($result);
?>
<table border="1" style="border-collapse: collapse;" cellpadding="5">
    <tr>
        <th>Mã khách hàng</th>
        <th>Tên khách hàng</th>
        <th>Phái</th>
        <th>Địa chỉ</th>
        <th>Điện thoại</th>
        <th>Email</th>
    </tr>
    <?php
        //4. Xử lý dữ liệu trả về
        if($numrows != 0){
            while($row = mysqli_fetch_array($result)){
                echo "<tr>";
                for($i=0; $i < $numfileds; $i++){
                    if($i == 2){
                        if($row[$i]==0) echo "<td>Nam</td>";
                        else echo "<td>Nữ</td>";
                    }
                    else echo "<td>".$row[$i]."</td>";
                }
                echo "</tr>";
            }
        }
        //5. xoá kết quả khoi vùng nhớ và đóng kết nối
        mysqli_free_result($result);
        mysqli_close($conn);
    ?>
</table>

</body>
</html>
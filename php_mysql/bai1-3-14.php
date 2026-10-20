<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>danh sách khách hàng</title>
</head>
<body>
    <?php 
        //kết nối db
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "quanly_ban_Sua";
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if(!$conn){
            die("connection failed: " . mysqli_connect_errno());
        }
        mysqli_set_charset($conn, "utf8");

        // câu truy vấn
        $query = "SELECT *
                FROM khach_hang
                WHERE Ten_khach_hang LIKE 'N%' AND Phai = 0";
        $resault = mysqli_query($conn, $query);
        if(!$resault) die("Lỗi !!!" . mysqli_errno($conn));
        $numfileds = mysqli_num_fields($resault);
        $numrows = mysqli_num_rows($resault); 
    ?>
    <table border="1">
        <tr>
            <th>Mã khách hàng</th>
            <th>Tên khách hàng</th>
            <th>Phái</th>
            <th>Địa chỉ</th>
            <th>Điện thoại</th>
            <th>Email</th>
        </tr>
        <?php 
            if($numrows != 0){
                while($row = mysqli_fetch_array($resault)){
                    echo "<tr>";
                    for($i = 0; $i < $numfileds; $i++){
                        if($i == 2){
                            if($row[$i]==0) echo "<td>Nam</td>";
                            else echo "<td>Nu</td>";
                        }
                        else echo "<td>".$row[$i]."</td>";
                    }
                    echo "</tr>";
                }
            }
            mysqli_free_result($resault);
        ?> 
    </table>
</body>
</html>
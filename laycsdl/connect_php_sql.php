<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quanly_ban_sua";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
if($conn){
    echo "<br> <b>Ket noi thanh cong</b><br>";
}

//2. chuẩn bị câu truy vấn
$query = 'SELECT * FROM khach_hang';
//3. thực thi câu truy vấn
$result = mysqli_query($conn, $query);
if(!$result) die('<br> <b>Query failed</b>');
// //4. Xử lý dữ liệu trả về.
// if(mysqli_num_rows($result) !=0){
//     while($row = mysqli_fetch_array($result)){
//         for($i=0; $i < mysqli_num_fields($result); $i++){
//             echo $row[$i] . " ";
//         }
//         echo "<br>";
//     }
// }

//4. Xử lý dữ liệu trả về
if(mysqli_num_rows($result) != 0){
    // Bắt đầu in thẻ table với viền (border)
    echo "<table border='1' style='border-collapse: collapse; text-align: left;'>";
    
    // (Tùy chọn) In dòng tiêu đề - Lấy tên của các cột trong Database làm tiêu đề bảng
    echo "<tr style='background-color: #f2f2f2;'>";
    while($field = mysqli_fetch_field($result)){
        echo "<th style='padding: 5px;'>" . $field->name . "</th>";
    }
    echo "</tr>";
    
    // In nội dung dữ liệu
    while($row = mysqli_fetch_array($result)){
        echo "<tr>"; // Bắt đầu một dòng mới
        
        // Lặp qua từng cột dữ liệu của dòng đó
        for($i=0; $i < mysqli_num_fields($result); $i++){
            echo "<td style='padding: 5px;'>" . $row[$i] . "</td>"; // In từng ô
        }
        
        echo "</tr>"; // Kết thúc dòng
    }
    
    echo "</table>"; // Đóng thẻ table
}

//5. xoá kết quả khoi vùng nhớ và đóng kết nối
mysqli_free_result($result);
mysqli_close($conn);
?>
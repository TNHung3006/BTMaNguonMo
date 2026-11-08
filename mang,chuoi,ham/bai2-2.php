<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tính tổng dãy số</title>
</head>
<body>
<?php
    $dayso = "";
    $tong = "";
    $thongbao = "";
    if(isset($_POST["tongdayso"])){
        $dayso = $_POST["dayso"];
        $mang = explode(",", $dayso);

        $hople = true;
        for($i = 0; $i < count($mang); $i++){
            $mang[$i] = trim($mang[$i]);
            if(!is_numeric($mang[$i]) || $mang[$i] ===""){
                $hople = false;
            }
        }
        if($hople == true){
            $tong = array_sum($mang);
        }else $thongbao = "vui lòng nhập dãy số cách nhau bởi dấu ,";

    }
?>
<form action="bai2-2.php" method="POST" name="Tinh tong day so">
    <h2>Nhập Và Tính Trên dẫy số</h2>
    <table>
        <tr>
            <td>Nhập dãy số: </td>
            <td><input type="text" name="dayso" value="<?php echo $dayso ?>" required></td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit" name="tongdayso">Tổng dãy số</button></td>
        </tr>
        <tr>
            <td>Tổng dãy số: </td>
            <td><input type="number" name="tong" value="<?php echo $tong ?>" readonly></td>
        </tr>
        <p style="color: red;"><?php echo $thongbao; ?></p>
    </table>

</form>
</body>
</html>
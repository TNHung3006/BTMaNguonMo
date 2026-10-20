<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test bai 3</title>
    <style>
        form{
            width: 600px;
            margin: auto;
            background-color: #f2dff7;
        }
        h2{
            background-color: #ab045d;
            text-align: center;
            margin: 0;
            padding: 7px 0 7px 0;
            color: #dfecf7;
        }
        table{
            width: 100%;
        }
        tr{
            width: 100%;
        }
        td:first-child{
            width: 200px;
            
        }
        button{
            padding: 5px 20px 5px 20px;
            background-color: #fffd6d;
        }
        input{
            padding: 5px;
        }
        input[name="n"]{
            width: 250px;
        }
        input[readonly]{
            background-color: #e67878;
            width: 150px;
        }
        input[name="mangkq"]{
            width: 320px;
        }
        .pink{
            background-color: #e498cc;
        }
        
    </style>
</head>
<body>
<?php 
    function taomang($n){
        $arr = [];
        for($i = 0; $i < $n; $i++){
            $arr[$i] = rand(0, 20);
        }
        return $arr;
    }
    function xuatmang($mang){
        return implode(" ", $mang);
    }
    function tong($mang){
        $tong = 0;
        foreach($mang as $value){
            $tong += $value;
        }
        return $tong;
    }
    function timmin($mang){
        $min = $mang[0];
        foreach($mang as $value){
            if($value < $min){
                $min = $value;
            }
        }
        return $min;
    }
    function timmax($mang){
        $max = $mang[0];
        foreach($mang as $value){
            if($value > $max){
                $max = $value;
            }
        }
        return $max;
    }

    $n = "";
    $mangkq = "";
    $min = "";
    $max = "";
    $tongmang = "";
    if(isset($_POST["phatsinhvatinhtoan"])){
        $n = $_POST["n"];
        if(is_numeric($n) && $n > 0){
            $mang = taomang($n);
            $mangkq = xuatmang($mang);
            $max = timmax($mang);
            $min = timmin($mang);
            $tongmang = tong($mang);
        }
    }
?>

<form name="Phat sinh mang" method="POST" action="bai3-test.php">
    <h2>PHÁT SINH MẢNG VÀ TÍNH TOÁN</h2>
    <table>
        <tr class="pink">
            <td>Nhập số phần tử: </td>
            <td><input type="number" name="n" value="<?php echo $n ?>" required></td>
        </tr>
        <tr class="pink">
            <td></td>
            <td><button type="submit" name="phatsinhvatinhtoan">Phát sinh và tính toán</button></td>
        </tr>
        <tr >
            <td>Mảng:</td>
            <td><input type="text" name="mangkq" value="<?php echo $mangkq ?>" readonly></td>
        </tr>
        <tr>
            <td>GTLN (MAX) trong mảng: </td>
            <td><input type="text" name="max" value="<?php echo $max ?>" readonly></td>
        </tr>
        <tr>
            <td>GTNN (MIN) trong mảng: </td>
            <td><input type="text" name="min" value="<?php echo $min ?>" readonly></td>
        </tr>
        <tr>
            <td>Tổng mảng: </td>
            <td><input type="text" name="tongmang" value="<?php echo $tongmang ?>" readonly></td>
        </tr>
    </table>
    <h3 align="center">(Ghi chú: Các phần tử trong mảng sẽ có giá trị từ 0 đến 20)</h3>
</form>
</body>
</html>
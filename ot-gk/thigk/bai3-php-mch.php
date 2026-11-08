<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phát SINH MẢNG VÀ TÍNH TOÁN</title>
</head>
<body>
    <?php
        function taomang($n){
            $arr = [];
            for($i = 0; $i < $n; $i++){
                $arr[$i] = rand(0,20);
            }
            return $arr;
        }
        function xuatmang($mang){
            return implode(" ", $mang);
        }
        function timmax($mang){
            $max = $mang[0];
            foreach($mang as $value){
                if($value > $max) $max = $value;
            }
            return $max;
        }
        function timmin($mang){
            $min = $mang[0];
            foreach($mang as $value){
                if($value < $min) $min = $value; 
            }
            return $min;
        }
        function tong($mang){
            $tong = 0;
            foreach($mang as $value){
                $tong += $value;
            }
            return $tong;
        }

        $soluongphantu = "";
        $mang = "";
        $mangxuat = "";
        $GTLN = "";
        $GTNN = "";
        $tong = "";

        if(isset($_POST["phatsinh"])){
            $soluongphantu = $_POST["n"];
            $mang = taomang($soluongphantu);
            $mangxuat = xuatmang($mang);
            $GTLN = timmax($mang);
            $GTNN = timmin($mang);
            $tong = tong($mang);
        }
    ?>
    <form action="bai3-php-mch.php" method="POST" name="Mang">
        <h2>PHÁT SINH MẢNG VÀ TÍNH TOÁN</h2>
        <table>
            <tr>
                <td>Nhập số phần tử: </td>
                <td><input type="number" name="n" value="<?php echo $soluongphantu ?>"></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit" name="phatsinh">Phát sinh và tính toán</button></td>
            </tr>
            <tr>
                <td>Mảng: </td>
                <td><input type="text" name="mangxuat" value="<?php echo $mangxuat ?>" readonly></td>
            </tr>
            <tr>
                <td>GTLN (MAX) trong mảng: </td>
                <td><input type="text" name="GTLN" value="<?php echo $GTLN ?>" readonly></td>
            </tr>
            <tr>
                <td>GTNN (MIN) trong mảng: </td>
                <td><input type="text" name="GTNN" value="<?php echo $GTNN ?>" readonly></td>
            </tr>
            <tr>
                <td>Tổng mảng: </td>
                <td><input type="text" name="tong" value="<?php echo $tong ?>" readonly></td>
            </tr>
        </table>
    </form>
</body>
</html>
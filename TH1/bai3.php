<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Nhập số N</h2>

    <form method="post">
        <input type="number" name="n" value="<?php echo isset($_POST['n']) ? $_POST['n'] : ''; ?>" required>
        <button type="submit">Kiểm tra</button>
    </form>

    <?php
    function LaSNT($x){
        if($x < 2) return false;
        for($i = 2; $i <= sqrt($x); $i++){
            if($x % $i == 0) return false;
        }
        return true;
    }

    function laSoChinhPhuong($x) {
        if($x < 0) return false;
        $can = (int)sqrt($x);
        return ($can*$can == $x);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $n = $_POST['n'];

        echo "<div class='ket-qua'>";

        if($n < - 100|| $n > 100){
            echo "N khong thuoc khoang [-100; 100].";
        }else{
            echo "N = $n <br>";
            if($n > 0){
                echo "N la so duong. <br>";
                //1. in ra cac uoc so cua N;
                echo "Cac uoc so cua N: ";
                $dsUoc = [];
                for($i = 1; $i <= $n; $i++){
                    if($n % $i == 0){
                        $dsUoc[] = $i;
                    }
                }
                echo empty($dsUoc) ? "Khong co" : implode(", ", $dsUoc);
                echo "<br>";
                //2. kiem tra N co phai la so nguyen to hay khong
                echo "N co phai la so nguyen to khong? ";
                echo LaSNT($n) ? "Co":"Khong";
                echo "<br>";

                //3. Tim tong cac so nguyen to
                $tong = 0;
                $soNguyenTo = [];
                for($i = 2; $i < $n; $i++){
                    if(LaSNT($i)){
                        $tong += $i;
                        $soNguyenTo[] = $i;
                    }
                }
                echo "Cac so nguyen to nho hon N: ";
                echo empty($soNguyenTo) ? "Khong co" : implode(", ", $soNguyenTo);
                echo "<br>";
                echo "Tong cac so nguyen to nho hon N: $tong <br>";

                //4. Kiem tra N co la so chinh phuong khong
                echo "N co phai la so chinh phuong khong: ";
                echo laSoChinhPhuong($n) ? "Co" : "Khong";
                echo "<br>";
            }else {
                echo "N khong la so duong.";
            }

        }

        echo "</div>";
    }
    ?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 
    $n = "";
    $ketqua = "";

    if(isset($_POST["Thuchien"])){
        $n = $_POST["sotunhien"];
        if($n > 0 && floor($n) == $n){
            $arr = array();
            for($i = 0; $i < $n; $i++){
                $arr[] = rand(-100, 100);
            }
            $strA = "<b>b. Mảng ngẫu nhiên là: </b>" . implode(", ", $arr);

            $dem = 0;
            foreach($arr as $value){
                if($value % 2 == 0) $dem++;
            }
            $strB = "<b>c. Số phần tử chẳn trong mảng là: </b>" . $dem;

            
            $ketqua = $strA . "<br>" . $strB;
        }
    }
?>

<form action="bai1-1.php" method="POST" name="mang-chuoi-ham">
    <h2>Thao tác mảng chuỗi hàm</h2>
    <table>
        <tr>
            <td>Nhập vào số nguyên dương: </td>
            <td><input type="number" name="sotunhien" value="<?php echo $n ?>" required></td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit" name="Thuchien">Thực hiện</button></td>
        </tr>
    </table>
    
    <?php 
        if($ketqua != ""){
            echo $ketqua;
        }
    ?>

</form>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hình tròn</title>
    <style>
        form{
            width: 400px;
            background-color: #e6e3a5;
            margin: auto;
        }
        h2{
            margin: 0;
            background-color: #f0cb5e;
            text-align: center;
        }
        td:first-child{
            width: 120px;
        }
        table{
            padding: 5px;
        }
        input[readonly]{
            background-color: #e6b0dd;
        }
        button{
            margin-left: 20px;
            padding: 4px;
        }
    </style>
</head>
<body>
    <?php 
        define("PI", 3.14);
        $bankinh = "";
        $dientich = "";
        $chuvi = "";

        if(isset($_POST["Tinh"])){
            $bankinh = $_POST["bankinh"];
            $dientich = PI * ($bankinh * $bankinh);
            $chuvi = 2 * PI * $bankinh;
        }
    ?>
    <form name="hình tròn" method="POST" action="bai2-1.php">
        <h2>DIỆN TÍCH VÀ CHU VI<br>HÌNH TRÒN</h2>
        <table>
            <tr>
                <td>Bán kính: </td>
                <td><input type="number" name="bankinh" value="<?php echo $bankinh ?>" required></td>
            </tr>
            <tr>
                <td>Diện tích: </td>
                <td><input type="number" name="dientich" value="<?php echo $dientich ?>" readonly></td>
            </tr>
            <tr>
                <td>Chu vi: </td>
                <td><input type="number" name="chuvi" value="<?php echo $chuvi ?>" readonly></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit" name="Tinh">Tính</button></td>
            </tr>
        </table>
    </form>
    
</body>
</html>
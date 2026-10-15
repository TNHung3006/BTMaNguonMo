<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán Tiền Điện</title>
    <style>
        form{
            width: 450px;
            background-color: #f0dfa9;
            margin: 0 auto;
        }
        h3{
            width: 100%;
            background-color: #f4c118;
            padding: 3px 0 3px 0; 
            text-align: center;
            font-size: 22px;
            color: #692e03;
        }
        input{
            width: 70%;
            padding: 3px;
            margin: 0 5px 0 5px;
        }
        input[readonly]{
            background-color: #ffd5fe;
        }
        table{
            width: 100%;
        }
        td{
            padding: 5px;
        }
        button{
            margin-left: 20px;
        }
    </style>
</head>
<body>
<?php 
    $tenchuho = "";
    $chisocu = "";
    $chisomoi = "";
    $dongia = 2000;
    $sotienthanhtoan = "";
    if(isset($_POST["tinh"])){
        $tenchuho = $_POST["tenchuho"];
        $chisocu = $_POST["chisocu"];
        $chisomoi = $_POST["chisomoi"];
        $dongia = $_POST["dongia"];
        $sotienthanhtoan = ($chisomoi-$chisocu) * $dongia;   
    }
?>
<form name="ThanhToanTienDien" method="post" action="bai3-1.php">
    <h3>Thanh Toán Tiền Điện</h3>
    <table>
        <tr>
            <td>Tên chủ hộ:</td>
            <td><input type="text" name="tenchuho" value="<?php echo $tenchuho; ?>" required></td>
        </tr>
        <tr>
            <td>Chỉ số cũ:</td>
            <td><input type="number" name="chisocu" value="<?php echo $chisocu ?>" required>(Kw)</td>
        </tr>
        <tr>
            <td>Chỉ số mới:</td>
            <td><input type="number" name="chisomoi" value="<?php echo $chisomoi ?>" >(Kw)</td>
        </tr>
        <tr>
            <td>Đơn giá:</td>
            <td><input type="number" name="dongia" value="<?php echo $dongia ?>" >(VNĐ)</td>
        </tr>
        <tr>
            <td>Số tiền thanh toán: </td>
            <td><input type="number" name="sotiencanthanhtoan" value="<?php echo $sotienthanhtoan ?>" readonly>(VNĐ)</td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit" name="tinh">Tinh</button></td>
        </tr>
    </table>
</form>    
</body>
</html>
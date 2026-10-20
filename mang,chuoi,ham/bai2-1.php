<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tính tích dãy số</title>
    <style>
        form{
            width: 430px;
            background-color: #79b095;
            margin: auto;
        }
        h2{
            text-align: center;
            width: 100%;
            background-color: #35949f;
            padding: 5px 0 5px 0;
            font-style: italic;
        }
        table{
            padding: 5px;
        }
        tr{
            margin-left: 5px;
        }
        input{
            padding: 5px;
            width: 225px;
            margin: 5px 0px 5px 20px;
        }
        input[readonly]{
            width: 110px;
            background-color: #59e227;
        }
        button{
            background-color: #ffff14;
            padding: 5px 15px 5px 15px;
            margin-left: 20px;
        }

    </style>
</head>
<body>
<?php 
    $dayso = "";
    $tichdayso = "";

    if(isset($_POST["Tinhtich"])){
        $dayso = $_POST["dayso"];
        $mang = explode(",", $dayso);

        $hople = true;
        for($i = 0; $i < count($mang); $i++){
            $mang[$i] = trim($mang[$i]);
            if(!is_numeric($mang[$i]) || $mang[$i] === ""){
                $hople = false;
            }
        }

        if($hople == true){
            $tichdayso = array_product($mang);
        }else{
            echo "<script>alert('Lỗi: vui lòng nhập số không nhập chữ');</script>";
        }
    }
?>

<form name="form tính tích" method="POST" action="bai2-1.php">
    <h2>Nhập và tính trên dãy số</h2>
    <table>
        <tr>
            <td>Nhập dãy số: </td>
            <td><input type="text" name="dayso" value="<?php echo $dayso ?>" required>(*)</td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit" name="Tinhtich">Tích dẫy số</button></td>
        </tr>
        <tr>
            <td>Tích dãy số: </td>
            <td><input type="number" name="tichdayso" value="<?php echo $tichdayso ?>" readonly></td>
        </tr>
    </table>
    <h4 align = "center">Các dãy số được nhập cách nhau bằng dấu ","</h4>

</form>
    
</body>
</html>
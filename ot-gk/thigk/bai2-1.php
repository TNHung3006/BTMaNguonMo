<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php 
        $chuoi = "";
        $cumcu = "";
        $cummoi = "";
        $ketqua = "";
        $loi = "";

        if(isset($_POST["thaythe"])){
            $chuoi = $_POST["chuoi"];
            $cumcu = trim($_POST["cumcu"]);
            $cummoi = trim($_POST["cummoi"]);

            if(trim($chuoi) == ""){
                $loi = "vui long nhap chuoi can thay the!!";
            }elseif($cummoi == ""){
                $loi = "vui long nhap cum moi thay the!!";
            }elseif($cumcu == ""){
                $loi = "vui long nhap cum cu can thay the!!";
            }elseif($cumcu == $cummoi){
                $loi = "cum cu va cum moi phai khac nhau!!";
            }else{
                $ketqua = str_replace($cumcu, $cummoi, $chuoi);
            }
        }

    ?>

    <form  align="center" method="post" action="bai2-1.php">
        <h2 align="center">Công cụ thay thế hàng loạt ký tự trong chuỗi</h2>
        <textarea name="chuoi" rows="3" cols="40" placeholder="nhập vào chuỗi cần thay thế"><?php echo htmlspecialchars($chuoi) ?></textarea><br>
        <label>Cụm ký tự cần thay thế: </label><br>
        <input type="text" name="cumcu" value="<?php echo $cumcu ?>"><br>
        <label>Cụm ký tự thay thế</label></tr><br>
        <input type="text" name="cummoi" value="<?php echo $cummoi ?>"><br>
        <button type="submit" name="thaythe">Thay the</button><br>
        <h2 align="center" style="color: #00f541;">Kết quả</h2>
        <textarea name="ketqua"><?php echo $ketqua ?></textarea><br>
    </form>
    
</body>
</html>
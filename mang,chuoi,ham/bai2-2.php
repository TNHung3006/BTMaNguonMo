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
        $tongdayso = "";
        $thongbao = "";

        if(isset($_POST["Tongdayso"])){
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
                $tongdayso = array_sum($mang);
            }else{
                $thongbao = "vui lòng nhập số!!";
            }
        }
    ?>

    
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tich day so</title>
</head>
<body>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f7d7dc, #f5c2d1);
        }

        .box {
            width: 560px;
            background: #f4c7d0;
            border-radius: 18px;
            padding: 30px 28px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
            border: 2px solid #e7a9b8;
        }

        h2 {
            margin: 0 0 25px;
            text-align: center;
            font-size: 38px;
            color: #2d2d2d;
            font-weight: 700;
        }

        .row {
            display: flex;
            align-items: center;
            margin-bottom: 18px;
        }

        .label {
            width: 150px;
            font-size: 24px;
            color: #2a2a2a;
            font-weight: 600;
        }

        .input {
            flex: 1;
            padding: 10px 12px;
            font-size: 18px;
            border: 2px solid #e7a7b3;
            border-radius: 8px;
            outline: none;
            background: #fff;
        }

        .btn {
            display: block;
            margin: 20px auto 0;
            padding: 12px 28px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #ff8db1, #ff5c8d);
            color: white;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 6px 15px rgba(255, 94, 141, 0.35);
        }

        .btn:hover {
            opacity: 0.95;
        }
    </style>

    <form method="get" name="tichdayso" class="box">
        <h2>Form tinh tich day so</h2>

        <div class="row">
            <div class="label">Nhap day so</div>
            <input class="input" type="text" name="dayso" value="<?php if(isset($_GET['btnsubmit'])){ echo $_GET['dayso']; } ?>">
        </div>

        <div class="row">
            <div class="label">Ket qua</div>
            <input class="input" type="text" readonly value="<?php
                if(isset($_GET['btnsubmit'])){
                    $ds = $_GET['dayso'];
                    $kt = 1;
                    $flag = 0;
                    $ds = str_replace(' ', '', $ds);
                    $arr = explode(",", $ds);

                    foreach($arr as $v){
                        if(!is_numeric($v)){
                            $flag = 1;
                            break;
                        }
                    }
                    if($flag){
                        echo "Day chua kt, nhap lai!";
                    }else{ 
                        $arr = array_map('intval', $arr);  
                        $kq = array_product($arr);
                        echo $kq;
                    } 
                }
            ?>">
        </div>

        <input class="btn" type="submit" name="btnsubmit" value="Tich day so">
    </form>
</body>
</html>
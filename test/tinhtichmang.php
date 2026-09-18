<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tich day so</title>
</head>
<body>
    <form method="get" name="tichdayso">
        <table align="center" bgcolor="pink">
            <tr>
                <td colspan="2" align="center"><h2>Form tinh tich day so</h2></td>
            </tr>
            <tr>
                <td>Nhap day so</td>
                <td>
                    <input type="text" name="dayso" 
                    value="<?php
                        if(isset($_GET['btnsubmit'])){
                            echo $_GET['dayso'];
                        }
                    ?>"
                    >
                </td>
            </tr>
            <tr>
                <td>Ket qua</td>
                <td><input type="text" readonly 
                    value="<?php
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
                    ?>"
                >
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" name="btnsubmit" value="Tich day so">
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
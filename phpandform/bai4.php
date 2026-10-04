<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ket qua thi dai hoc</title>
    <style>
        form{
            width: 400px;
            background-color: #e5c1e1;
            margin: 0 auto; /*căn giữa */
        }
        h2{
            text-align: center;
            padding: 3px;
            background-color: #b52f67;
            font-size: 24px;
            color: white;
            font-style: italic;  /* chữ nghiên */
        }
        table{
            width: 100%;
        }
        td{
            padding: 0px 3px 3px 5px;
        }
        input{
            margin-left: 20px;
            padding: 5px;
            width: 180px;
        }
        button{
            margin-left: 10px;
            padding: 4px 15px;
        }
    </style>
</head>
<body>
<?php 
    $toan = "";
    $ly = "";
    $hoa = "";
    $diemChuan = "";
    $tongDiem = "";
    $ketQuaThi = "";

    if(isset($_POST["xemketqua"])){
        $toan = $_POST["toan"];
        $ly = $_POST["ly"];
        $hoa = $_POST["hoa"];
        $diemChuan = $_POST["diemChuan"];
        $tongDiem = $toan + $ly + $hoa;
        if($tongDiem >= $diemChuan){
            $ketQuaThi = "Đậu";
        }else $ketQuaThi = "Rớt";
    }
?>

<form method="post" action="bai4.php">
    <h2>KẾT QUẢ THI ĐẠI HỌC</h2>
    <table>
        <tr>
            <td>Toán: </td>
            <td><input type="Number" name="toan" step="0.1" value="<?php echo $toan ?>" required></td>
        </tr>
        <tr>
            <td>Lý: </td>
            <td>
                <input type="number" name="ly" step="0.1" value="<?php echo $ly ?>" required>
            </td>
        </tr>
        <tr>
            <td>Hoá: </td>
            <td>
                <input type="number" name="hoa" step="0.1" value="<?php echo $hoa ?>" required>
            </td>
        </tr>
        <tr>
            <td>Điểm Chuẩn: </td>
            <td>
                <input type="number" name="diemChuan" step="0.1" value="<?php echo $diemChuan ?>" required>
            </td>
        </tr>
        <tr>
            <td>Tổng điểm: </td>
            <td>
                <input type="number" name="tongDiem" step="0.1" value="<?php echo $tongDiem ?>" readonly>
            </td>
        </tr>
        <tr>
            <td>Kết quả thi: </td>
            <td>
                <input type="text" name="ketQuaThi" value="<?php echo $ketQuaThi ?>" readonly>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" name="xemketqua">Xem kết quả</button>
            </td>
        </tr>
    </table>
</form>
</body>
</html>
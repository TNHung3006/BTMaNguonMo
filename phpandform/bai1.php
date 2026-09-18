<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Diện tích hình chữ nhật</title>
    <style>
    form {
        width: 430px;
        background-color: #fff2b3;
    }

    h2 {
        margin: 0 0 15px 0;
        padding: 8px;
        text-align: center;
        color: #a64b00;
        background-color: #f6d36b;
        font-size: 22px;
    }

    table {
        width: 100%;
    }

    td {
        padding: 6px;
    }

    td:first-child {
        width: 120px;
    }

    input {
        width: 200px;
        padding: 5px;
    }

    input[readonly] {
        background-color: #f4cccc;
    }

    button {
        margin-left: 25px;
        padding: 4px 12px;
    }
</style>
</head>

<body>
<?php
    $chieuDai = "";
    $chieuRong = "";
    $dienTich = "";

    if (isset($_POST["tinh"])) {
        $chieuDai = $_POST["chieuDai"];
        $chieuRong = $_POST["chieuRong"];
        $dienTich = $chieuDai * $chieuRong;
    }
?>

<form method="post" action="bai1.php">
    <h2>DIỆN TÍCH HÌNH CHỮ NHẬT</h2>

    <table>
        <tr>
            <td>Chiều dài:</td>
            <td>
                <input type="number" name="chieuDai"
                       value="<?php echo $chieuDai; ?>" required>
            </td>
        </tr>

        <tr>
            <td>Chiều rộng:</td>
            <td>
                <input type="number" name="chieuRong"
                       value="<?php echo $chieuRong; ?>" required>
            </td>
        </tr>

        <tr>
            <td>Diện tích:</td>
            <td>
                <input type="text"
                       value="<?php echo $dienTich; ?>" readonly>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit" name="tinh">Tính</button>
            </td>
        </tr>
    </table>
</form>
</body>
</html>
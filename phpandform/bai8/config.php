<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Config</title>
</head>
<body>

    Bạn đã nhập thành công, dưới đây là những thông tin bạn đã nhập:<br>
    Họ tên: <?php echo isset($_POST["fullname"]) ? $_POST["fullname"] : ""; ?><br>
    Address: <?php echo isset($_POST["address"]) ? $_POST["address"] : ""; ?><br>
    Phone: <?php echo isset($_POST["phone"]) ? $_POST["phone"] : ""; ?><br>
    Gender: <?php echo isset($_POST["gender"]) ? $_POST["gender"] : ""; ?><br>
    Country: <?php echo isset($_POST["country"]) ? $_POST["country"] : ""; ?><br>
    
    <!-- Cố tình không dùng hàm nl2br() để nó dồn hết chữ thành 1 hàng ngang giống ảnh mẫu -->
    Note: <?php echo isset($_POST["note"]) ? $_POST["note"] : ""; ?><br>

    <br>
    <!-- Nút quay về -->
    <a href="javascript:history.back()">Quay về</a>

</body>
</html> 
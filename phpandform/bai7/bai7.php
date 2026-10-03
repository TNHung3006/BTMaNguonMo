<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Phép tính</title>
    <style>
        .container {
            width: 450px;
            margin: 0 auto;
            margin-top: 50px;
        }
        h2 {
            color: #3399cc; 
            text-align: center;
        }
        .red-text {
            color: #cc0000; 
            font-weight: bold;
        }
        .blue-text {
            color: blue; 
            font-weight: bold;
        }
        .text-right {
            text-align: right;
            padding-right: 15px;
            width: 140px;
        }
        /* Cố tình dùng type="text" để bạn có thể gõ chữ vào test lỗi */
        input[type="text"] {
            width: 200px;
            padding: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>PHÉP TÍNH TRÊN HAI SỐ</h2>
    
    <form method="post" action="ketquabai7.php">
        <table align="center">
            <tr>
                <td class="red-text text-right">Chọn phép tính:</td>
                <td class="red-text">
                    <input type="radio" name="pheptinh" value="Cộng" checked> Cộng
                    <input type="radio" name="pheptinh" value="Trừ"> Trừ
                    <input type="radio" name="pheptinh" value="Nhân"> Nhân
                    <input type="radio" name="pheptinh" value="Chia"> Chia
                </td>
            </tr>
            <tr>
                <td class="blue-text text-right">Số thứ nhất:</td>
                <td><input type="text" name="so1" required></td>
            </tr>
            <tr>
                <td class="blue-text text-right">Số thứ nhì:</td>
                <td><input type="text" name="so2" required></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" name="tinh">Tính</button>
                </td>
            </tr>
        </table>
    </form>
</div>

</body>
</html>
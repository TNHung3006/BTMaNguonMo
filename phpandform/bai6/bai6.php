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
            color: #3399cc; /* Màu xanh nước biển */
            text-align: center;
        }
        .red-text {
            color: #cc0000; /* Chữ màu đỏ */
            font-weight: bold;
        }
        .blue-text {
            color: blue; /* Chữ màu xanh */
            font-weight: bold;
        }
        .text-right {
            text-align: right;
            padding-right: 15px;
            width: 140px;
        }
        input[type="number"] {
            width: 200px;
            padding: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>PHÉP TÍNH TRÊN HAI SỐ</h2>
    
    <!-- action chuyển hướng dữ liệu sang file ketquabai6.php -->
    <form method="post" action="ketquabai6.php">
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
                <td><input type="number" step="any" name="so1" required></td>
            </tr>
            <tr>
                <td class="blue-text text-right">Số thứ nhì:</td>
                <td><input type="number" step="any" name="so2" required></td>
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
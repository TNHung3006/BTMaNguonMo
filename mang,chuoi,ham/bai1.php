<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài tập Mảng - Chuỗi - Hàm</title>
    <style>
    form {
        width: 550px; 
        background-color: #f4f9f9; 
        margin: 0 auto;
        margin-top: 50px;
        padding-bottom: 15px;
        border: 1px solid #c9e4e4;
        box-shadow: 0 0 10px rgba(0,0,0,0.1); /* Thêm chút bóng mờ cho đẹp */
    }

    h2 {
        margin: 0 0 15px 0;
        padding: 12px;
        text-align: center;
        color: white;
        background-color: #008080; /* Màu xanh cổ vịt */
        font-size: 22px;
    }

    table {
        width: 100%;
    }

    td {
        padding: 8px;
    }

    td:first-child {
        width: 100px;
        font-weight: bold;
        text-align: right;
    }

    input[type="number"] {
        width: 200px;
        padding: 6px;
    }

    button {
        padding: 6px 20px;
        background-color: #008080;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 16px;
    }

    /* Khung hiển thị kết quả bên dưới nút bấm */
    .result-box {
        background-color: #fff;
        border: 1px dashed #008080;
        padding: 15px;
        margin: 15px;
        line-height: 2.0; /* Giãn dòng cho dễ đọc */
    }
    </style>
</head>
<body>

<?php
    $n = "";
    $ketQua = "";

    // Khi người dùng bấm nút "Thực hiện"
    if (isset($_POST["thucHien"])) {
        $n = $_POST["n"];

        // a- Kiểm tra n có phải là số nguyên dương
        if ($n > 0 && floor($n) == $n) {
            $arr = [];
            
            // b- Phát sinh mảng ngẫu nhiên (chọn từ -100 đến 100 để có số âm và số 0)
            for ($i = 0; $i < $n; $i++) {
                $arr[] = rand(-100, 100); 
            }
            $strB = "<b>b- Mảng ngẫu nhiên:</b> " . implode(", ", $arr);
            
            // c- Đếm số phần tử trong mảng có giá trị chẵn
            $demChan = 0;
            foreach ($arr as $val) {
                if ($val % 2 == 0) {
                    $demChan++;
                }
            }
            $strC = "<b>c- Số phần tử chẵn:</b> " . $demChan;
            
            // d- Đếm số phần tử nhỏ hơn 100
            $demNhoHon100 = 0;
            foreach ($arr as $val) {
                if ($val < 100) {
                    $demNhoHon100++;
                }
            }
            $strD = "<b>d- Số phần tử nhỏ hơn 100:</b> " . $demNhoHon100;
            
            // e- Tính tổng các phần tử âm
            $tongAm = 0;
            foreach ($arr as $val) {
                if ($val < 0) {
                    $tongAm += $val;
                }
            }
            $strE = "<b>e- Tổng các phần tử âm:</b> " . $tongAm;
            
            // f- In ra vị trí của các phần tử bằng 0 (vị trí đếm từ 0)
            $viTriKhong = [];
            foreach ($arr as $key => $val) {
                if ($val == 0) {
                    $viTriKhong[] = $key;
                }
            }
            // Nếu mảng rỗng thì báo Không có, nếu có thì nối các vị trí lại bằng dấu phẩy
            $strF = "<b>f- Vị trí phần tử bằng 0:</b> " . (empty($viTriKhong) ? "Không có" : implode(", ", $viTriKhong));
            
            // g- Sắp xếp các phần tử tăng dần
            sort($arr);
            $strG = "<b>g- Mảng tăng dần:</b> " . implode(", ", $arr);
            
            // Gom tất cả kết quả thành một chuỗi lớn, cách nhau bởi thẻ xuống dòng <br>
            $ketQua = $strB . "<br>" . $strC . "<br>" . $strD . "<br>" . $strE . "<br>" . $strF . "<br>" . $strG;
            
        } else {
            // Thông báo lỗi nếu n không phải số nguyên dương
            $ketQua = "<span style='color:red;'>Vui lòng nhập n là một số nguyên dương!</span>";
        }
    }
?>

<form method="post" action="">
    <h2>THAO TÁC TRÊN MẢNG</h2>
    <table>
        <tr>
            <td>Nhập n:</td>
            <td>
                <input type="number" name="n" value="<?php echo $n; ?>" required>
            </td>
        </tr>

        <tr>
            <td colspan="2" align="center">
                <button type="submit" name="thucHien">Thực hiện</button>
            </td>
        </tr>
    </table>
    
    <!-- Vùng hiển thị kết quả (chỉ hiện ra khi biến $ketQua có dữ liệu) -->
    <?php if ($ketQua != ""): ?>
        <div class="result-box">
            <?php echo $ketQua; ?>
        </div>
    <?php endif; ?>
</form>

</body>
</html>
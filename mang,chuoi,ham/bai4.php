<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tìm kiếm trên mảng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 500px;
            margin: 0 auto;
            margin-top: 50px;
            background-color: #d1ded4; /* Nền xanh xám nhạt */
            border: 1px solid #339999;
        }
        h2 {
            background-color: #339999; /* Xanh mòng két */
            color: white;
            text-align: center;
            margin: 0;
            padding: 10px;
            font-size: 22px;
            font-style: italic;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            padding: 10px;
        }
        td {
            padding: 6px;
        }
        td:first-child {
            width: 140px;
        }
        input[type="text"] {
            width: 280px;
            padding: 4px;
        }
        /* Style riêng cho ô Kết quả */
        input[readonly].result {
            background-color: #ccffff; /* Xanh lơ nhạt */
            color: red;
            font-weight: bold;
        }
        .btn-submit {
            background-color: #99ccff; /* Xanh biển nhạt */
            border: 1px solid #6699cc;
            padding: 4px 15px;
            cursor: pointer;
        }
        .note {
            text-align: center;
            color: white;
            background-color: #339999;
            padding: 10px;
            font-size: 14px;
            margin: 0;
        }
    </style>
</head>
<body>

<?php
    // Xây dựng hàm tìm kiếm
    function tim_kiem($mang, $gia_tri) {
        for ($i = 0; $i < count($mang); $i++) {
            // Dùng hàm trim() để cắt bỏ khoảng trắng thừa 
            // (tránh trường hợp " 9" không bằng "9")
            if (trim($mang[$i]) == trim($gia_tri)) {
                return $i; // Trả về vị trí index trong mảng (bắt đầu từ 0)
            }
        }
        return -1; // Không tìm thấy
    }

    $mang_nhap = "";
    $so_can_tim = "";
    $mang_xuat = "";
    $ket_qua = "";

    // Xử lý khi nhấn nút Tìm kiếm
    if (isset($_POST["btnSubmit"])) {
        $mang_nhap = $_POST["mang_nhap"];
        $so_can_tim = $_POST["so_can_tim"];
        
        // 1. Tách chuỗi và gán vào mảng bằng hàm explode()
        $mang = explode(",", $mang_nhap);
        
        // 2. Gọi hàm tìm kiếm đã viết
        $vi_tri = tim_kiem($mang, $so_can_tim);
        
        // 3. In mảng (Dùng hàm implode theo hướng dẫn)
        $mang_xuat = implode(", ", $mang);
        
        // 4. Kiểm tra kết quả và xuất câu thông báo
        if ($vi_tri != -1) {
            // Cộng thêm 1 vì mảng bắt đầu từ 0, nhưng đếm vị trí thực tế thì đếm từ 1
            $vitri_thu = $vi_tri + 1;
            $ket_qua = "Tìm thấy $so_can_tim tại vị trí thứ $vitri_thu của mảng";
        } else {
            $ket_qua = "Không tìm thấy $so_can_tim trong mảng";
        }
    }
?>

<div class="container">
    <form method="post" action="bai4.php">
        <h2>TÌM KIẾM</h2>
        <table>
            <tr>
                <td>Nhập mảng:</td>
                <td><input type="text" name="mang_nhap" value="<?php echo $mang_nhap; ?>" required></td>
            </tr>
            <tr>
                <td>Nhập số cần tìm:</td>
                <td><input type="text" name="so_can_tim" value="<?php echo $so_can_tim; ?>" style="width: 100px;" required></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" name="btnSubmit" class="btn-submit">Tìm kiếm</button>
                </td>
            </tr>
            <tr>
                <td>Mảng:</td>
                <td><input type="text" name="mang_xuat" value="<?php echo $mang_xuat; ?>" readonly></td>
            </tr>
            <tr>
                <td>Kết quả tìm kiếm:</td>
                <td><input type="text" name="ket_qua" value="<?php echo $ket_qua; ?>" class="result" readonly></td>
            </tr>
        </table>
        <!-- Sửa lỗi chính tả từ "cánh nhau" (trong ảnh) thành "cách nhau" -->
        <div class="note">
            (Các phần tử trong mảng sẽ cách nhau bằng dấu ",")
        </div>
    </form>
</div>

</body>
</html>

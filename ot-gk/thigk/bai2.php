<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Công cụ thay thế hàng loạt ký tự trong chuỗi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            width: 700px;
            margin: 40px auto;
            background-color: white;
            padding: 20px 30px;
            border: 1px solid #ddd;
        }
        h2 {
            text-align: center;
            color: #222;
            margin-top: 0;
        }
        label {
            display: block;
            text-align: center;
            font-size: 14px;
            color: #444;
            margin: 15px 0 5px;
        }
        textarea, input[type="text"] {
            width: 100%;
            box-sizing: border-box; /* để width 100% không bị tràn khung */
            padding: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
            font-family: Arial, sans-serif;
        }
        textarea {
            height: 200px;
        }
        .center {
            text-align: center;
            margin: 15px 0;
        }
        .btn-submit {
            padding: 6px 20px;
            background-color: #eee;
            border: 1px solid #ccc;
            cursor: pointer;
            font-size: 15px;
        }
        .label-kq {
            text-align: center;
            color: #2e7d32; /* màu xanh lá cho chữ "Kết quả:" */
            font-weight: bold;
            margin: 15px 0 5px;
        }
        .error {
            color: red;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
        }
        .info {
            color: #2e7d32;
            text-align: center;
            margin: 10px 0;
        }
    </style>
</head>
<body>

<?php
    // 1. Hàm thay thế hàng loạt: trả về chuỗi mới, đếm số lần thay qua tham chiếu $dem
    function thay_the($chuoi, $cum_cu, $cum_moi, &$dem) {
        return str_replace($cum_cu, $cum_moi, $chuoi, $dem);
    }

    // Khởi tạo biến mặc định
    $chuoi   = "";
    $cum_cu  = "";
    $cum_moi = "";
    $ket_qua = "";
    $loi     = "";
    $thong_bao = "";

    // 2. Xử lý khi nhấn nút
    if (isset($_POST["btnSubmit"])) {
        // trim() để bỏ khoảng trắng thừa 2 đầu cụm cần thay
        $chuoi   = $_POST["chuoi"];
        $cum_cu  = trim($_POST["cum_cu"]);
        $cum_moi = trim($_POST["cum_moi"]);

        // 3. Ràng buộc các điều kiện ngoại lệ
        if (trim($chuoi) == "") {
            $loi = "Vui lòng nhập chuỗi cần xử lý!";
        } elseif ($cum_cu == "") {
            $loi = "Vui lòng nhập cụm ký tự cần thay thế!";
        } elseif ($cum_moi == "") {
            $loi = "Vui lòng nhập cụm ký tự thay thế!";
        } elseif ($cum_cu == $cum_moi) {
            $loi = "Cụm ký tự cần thay thế và cụm thay thế đang giống nhau!";
        } elseif (strpos($chuoi, $cum_cu) === false) {
            // Không tìm thấy cụm cần thay trong chuỗi
            $loi = "Không tìm thấy cụm \"" . htmlspecialchars($cum_cu) . "\" trong chuỗi!";
        } else {
            // Hợp lệ -> thực hiện thay thế
            $dem = 0;
            $ket_qua = thay_the($chuoi, $cum_cu, $cum_moi, $dem);
            $thong_bao = "Đã thay thế $dem vị trí.";
        }
    }
?>

<div class="container">
    <form method="post" action="bai2.php">
        <h2>Công cụ thay thế hàng loạt ký tự trong chuỗi</h2>

        <!-- htmlspecialchars: chống lỗi hiển thị/XSS khi in lại dữ liệu người dùng nhập -->
        <textarea name="chuoi"><?php echo htmlspecialchars($chuoi); ?></textarea>

        <label>Cụm ký tự cần thay thế:</label>
        <input type="text" name="cum_cu" value="<?php echo htmlspecialchars($cum_cu); ?>">

        <label>Cụm ký tự thay thế:</label>
        <input type="text" name="cum_moi" value="<?php echo htmlspecialchars($cum_moi); ?>">

        <div class="center">
            <button type="submit" name="btnSubmit" class="btn-submit">Thay thế</button>
        </div>

        <?php if ($loi != "") { ?>
            <div class="error"><?php echo $loi; ?></div>
        <?php } ?>
        <?php if ($thong_bao != "") { ?>
            <div class="info"><?php echo $thong_bao; ?></div>
        <?php } ?>

        <div class="label-kq">Kết quả:</div>
        <textarea name="ket_qua" readonly><?php echo htmlspecialchars($ket_qua); ?></textarea>
    </form>
</div>

</body>
</html>
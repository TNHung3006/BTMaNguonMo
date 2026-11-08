<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tính Body Fat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .container {
            width: 450px;
            margin: 40px auto;
            background-color: white;
            padding: 20px 25px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
        label.title {
            display: block;
            font-weight: bold;
            font-size: 14px;
            margin: 15px 0 5px;
        }
        input[type="number"] {
            width: 100%;
            box-sizing: border-box; /* tránh tràn khung */
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .gender label {
            margin-right: 15px;
            font-size: 14px;
        }
        .note {
            font-size: 12px;
            font-style: italic;
            color: #555;
            margin: 10px 0;
        }
        .btn {
            padding: 8px 18px;
            border: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-calc  { background-color: #2f6fb5; }
        .btn-reset { background-color: #e0584d; }
        .result {
            text-align: center;
            margin-top: 20px;
        }
        .result h3 {
            margin: 5px 0;
            text-transform: uppercase;
        }
        .bf-value {
            font-size: 36px;
            font-weight: bold;
            color: #e0584d;
        }
        .error {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-top: 15px;
        }
        .reference {
            width: 700px;
            max-width: calc(100% - 40px);
            margin: 20px auto;
        }
        .reference table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }
        .reference th,
        .reference td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .reference th {
            background-color: #eee;
        }
        .formula {
            margin: 12px 0;
        }
    </style>
</head>
<body>

<?php
    // 1. Hàm tính Body Fat (log ở đây là log10 -> dùng hàm log10() của PHP)
    function tinh_body_fat($gioi_tinh, $cao, $eo, $co) {
        if ($gioi_tinh == "nam") {
            return 495 / (1.0324 - 0.19077 * log10($eo - $co) + 0.15456 * log10($cao)) - 450;
        }
        return 495 / (1.29579 - 0.35004 * log10($eo - $co) + 0.22100 * log10($cao)) - 450;
    }

    // 2. Hàm đánh giá theo bảng phân loại (dùng cận trên để không bị hở khoảng giữa các nhóm)
    function danh_gia($gioi_tinh, $bf) {
        if ($gioi_tinh == "nam") {
            if ($bf < 6)  return "Mỡ thiết yếu";
            if ($bf < 14) return "Vận động viên";
            if ($bf < 18) return "Fitness";
            if ($bf < 25) return "Trung bình";
            return "Béo phì";
        }
        if ($bf < 14) return "Mỡ thiết yếu";
        if ($bf < 21) return "Vận động viên";
        if ($bf < 25) return "Fitness";
        if ($bf < 32) return "Trung bình";
        return "Béo phì";
    }

    // Khởi tạo biến mặc định
    $gioi_tinh = "nam";
    $cao = "";
    $eo = "";
    $co = "";
    $loi = "";
    $bf = "";
    $nhan_xet = "";

    // 3. Xử lý khi nhấn nút "Tính Body Fat"
    if (isset($_POST["btnTinh"])) {
        $gioi_tinh = isset($_POST["gioi_tinh"]) ? $_POST["gioi_tinh"] : "";
        $cao = trim($_POST["cao"]);
        $eo  = trim($_POST["eo"]);
        $co  = trim($_POST["co"]);

        // 4. Ràng buộc các điều kiện ngoại lệ
        if ($gioi_tinh != "nam" && $gioi_tinh != "nu") {
            $loi = "Vui lòng chọn giới tính!";
        } elseif ($cao == "" || $eo == "" || $co == "") {
            $loi = "Vui lòng nhập đầy đủ chiều cao, vòng eo và vòng cổ!";
        } elseif (!is_numeric($cao) || !is_numeric($eo) || !is_numeric($co)) {
            $loi = "Chiều cao, vòng eo, vòng cổ phải là số!";
        } elseif ($cao <= 0 || $eo <= 0 || $co <= 0) {
            $loi = "Các số đo phải lớn hơn 0!";
        } elseif ($eo <= $co) {
            // eo - cổ <= 0 thì log() không xác định
            $loi = "Vòng eo phải lớn hơn vòng cổ!";
        } elseif ($cao < 100 || $cao > 250) {
            $loi = "Chiều cao phải trong khoảng 100 - 250 cm!";
        } else {
            $bf = round(tinh_body_fat($gioi_tinh, $cao, $eo, $co), 2);
            if ($bf <= 0) {
                $loi = "Số đo không hợp lệ (kết quả Body Fat <= 0), vui lòng kiểm tra lại!";
                $bf = "";
            } else {
                $nhan_xet = danh_gia($gioi_tinh, $bf);
            }
        }
    }

    // Nút "Làm mới": quay về trạng thái ban đầu (các biến giữ giá trị mặc định ở trên)
?>

<div class="container">
    <form method="post" action="bai1.php">
        <label class="title">Giới tính</label>
        <div class="gender">
            <label><input type="radio" name="gioi_tinh" value="nam" <?php if ($gioi_tinh == "nam") echo "checked"; ?>> Nam</label>
            <label><input type="radio" name="gioi_tinh" value="nu" <?php if ($gioi_tinh == "nu") echo "checked"; ?>> Nữ</label>
        </div>

        <label class="title">Chiều cao (cm)</label>
        <input type="number" name="cao" step="any" value="<?php echo htmlspecialchars($cao); ?>">

        <label class="title">Vòng eo (cm)</label>
        <input type="number" name="eo" step="any" value="<?php echo htmlspecialchars($eo); ?>">

        <label class="title">Vòng cổ (cm)</label>
        <input type="number" name="co" step="any" value="<?php echo htmlspecialchars($co); ?>">

        <div class="note">Lưu ý: Không hóp bụng khi đo. Số đo tính bằng cm.</div>

        <button type="submit" name="btnTinh" class="btn btn-calc">Tính Body Fat</button>
        <button type="submit" name="btnReset" class="btn btn-reset" formnovalidate>Làm mới</button>

        <?php if ($loi != "") { ?>
            <div class="error"><?php echo $loi; ?></div>
        <?php } ?>

        <?php if ($bf !== "") { ?>
            <div class="result">
                <h3>Kết quả</h3>
                <div class="bf-value"><?php echo $bf; ?></div>
                <div>Đánh giá: <b><?php echo $nhan_xet; ?></b></div>
            </div>
        <?php } ?>
    </form>
</div>

<div class="reference">
    <h3>Công thức tính Body Fat cho nam:</h3>
    <p class="formula">495 / (1.0324 - 0.19077 x log10(vòng eo - vòng cổ) + 0.15456 x log10(chiều cao)) - 450</p>

    <h3>Công thức tính Body Fat cho nữ:</h3>
    <p class="formula">495 / (1.29579 - 0.35004 x log10(vòng eo - vòng cổ) + 0.22100 x log10(chiều cao)) - 450</p>

    <h3>2. Phân loại tỷ lệ mỡ cơ thể</h3>
    <table>
        <thead>
            <tr>
                <th>Nhóm</th>
                <th>Phụ nữ</th>
                <th>Nam giới</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Mỡ thiết yếu</td>
                <td>10-13%</td>
                <td>2-5%</td>
            </tr>
            <tr>
                <td>Vận động viên</td>
                <td>14-20%</td>
                <td>6-13%</td>
            </tr>
            <tr>
                <td>Fitness</td>
                <td>21-24%</td>
                <td>14-17%</td>
            </tr>
            <tr>
                <td>Trung bình</td>
                <td>25-31%</td>
                <td>18-24%</td>
            </tr>
            <tr>
                <td>Béo phì</td>
                <td>&ge;32%</td>
                <td>&ge;25%</td>
            </tr>
        </tbody>
    </table>
</div>

</body>
</html>
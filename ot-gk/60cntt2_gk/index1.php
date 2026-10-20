<?php
// ===== 1. Kết nối MySQL (XAMPP mặc định: user root, mật khẩu rỗng) =====
$conn = new mysqli("localhost", "root", "", "chuyenbay");
$conn->set_charset("utf8mb4");              // tránh lỗi font tiếng Việt
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$thongbao = "";

// ===== 2. Xử lý khi bấm nút "Thêm dữ liệu" =====
if (isset($_POST['them'])) {
    $ma   = trim($_POST['ma_tp']);
    $ten  = trim($_POST['ten_tp']);
    $bang = trim($_POST['ten_bang']);
    $qg   = $_POST['ma_quoc_gia'];

    // Validation: mã và tên không được trống
    if ($ma == "" || $ten == "") {
        $thongbao = "❌ Mã và tên thành phố không được để trống!";
    } else {
        // Prepared statement: dùng ? thay vì nối chuỗi => chống SQL injection
        $stmt = $conn->prepare(
            "INSERT INTO thanhpho (ma_tp, ten_tp, ten_bang, ma_quoc_gia) VALUES (?,?,?,?)"
        );
        $stmt->bind_param("ssss", $ma, $ten, $bang, $qg);

        try {
            $stmt->execute();
            $thongbao = "✅ Thêm thành công!";
        } catch (mysqli_sql_exception $e) {
            // Lỗi thường gặp: trùng mã (duplicate) hoặc sai khóa ngoại
            $thongbao = "❌ Lỗi: không thêm được (có thể trùng mã thành phố).";
        }
    }
}

// Lấy danh sách quốc gia cho thẻ <select>
$dsqg = $conn->query("SELECT ma_quoc_gia, ten_quoc_gia FROM quocgia");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Nhập thành phố</title>
</head>
<body>
    <h2>Nhập dữ liệu THÀNH PHỐ</h2>
    <p><?= $thongbao ?></p>

    <form method="post" action="">
        Mã thành phố: <input type="text" name="ma_tp" maxlength="10" required><br><br>
        Tên thành phố: <input type="text" name="ten_tp" maxlength="100" required><br><br>
        Tên bang/tỉnh: <input type="text" name="ten_bang" maxlength="100"><br><br>
        Quốc gia:
        <select name="ma_quoc_gia">
            <?php while ($r = $dsqg->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($r['ma_quoc_gia']) ?>">
                    <?= htmlspecialchars($r['ten_quoc_gia']) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit" name="them">Thêm dữ liệu</button>
        <!-- type="reset": tự xóa sạch các ô nhập, không cần PHP -->
        <button type="reset">Reset dữ liệu</button>
        <!-- Chuyển sang trang kết quả -->
        <button type="button" onclick="location.href='index2.php'">Xem kết quả</button>
    </form>
</body>
</html>
<?php
// ===== 1. Kết nối MySQL =====
$conn = new mysqli("localhost", "root", "", "chuyenbay");
$conn->set_charset("utf8mb4");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// ===== 2. Truy vấn: chuyến bay đi HOẶC đến Nha Trang =====
// JOIN bảng thanhpho 2 lần (đặt bí danh di / den) để lấy tên TP khởi hành và TP đến
$sql = "SELECT cb.ma_chuyen_bay, cb.so_hieu,
               cb.ma_tp_khoi_hanh, di.ten_tp  AS ten_di, cb.ngay_khoi_hanh,
               cb.ma_tp_den,       den.ten_tp AS ten_den, cb.ngay_den,
               cb.gia_ve
        FROM chuyenbay cb
        JOIN thanhpho di  ON cb.ma_tp_khoi_hanh = di.ma_tp
        JOIN thanhpho den ON cb.ma_tp_den       = den.ma_tp
        WHERE di.ten_tp = ? OR den.ten_tp = ?
        ORDER BY cb.ngay_khoi_hanh";

$tp = "Nha Trang";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $tp, $tp);
$stmt->execute();
$kq = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chuyến bay liên quan Nha Trang</title>
    <style>
        body  { font-family: Arial, sans-serif; text-align: center; }
        table { margin: 0 auto; border-collapse: collapse; }   /* canh giữa bảng */
        th, td { border: 1px solid #333; padding: 8px 12px; text-align: center; } /* canh giữa chữ */
        th    { background-color: #1e88e5; color: white; }     /* màu tiêu đề */
        tr:nth-child(even) td { background-color: #e3f2fd; }   /* màu xen kẽ dòng */
        tr:nth-child(odd)  td { background-color: #ffffff; }
    </style>
</head>
<body>
    <h2>Các chuyến bay liên quan đến thành phố Nha Trang</h2>

    <?php if ($kq->num_rows > 0): ?>
    <table>
        <tr>
            <th>Mã chuyến bay</th>
            <th>Số hiệu</th>
            <th>Mã TP khởi hành</th>
            <th>TP khởi hành</th>
            <th>Ngày khởi hành</th>
            <th>Mã TP đến</th>
            <th>TP đến</th>
            <th>Ngày đến</th>
            <th>Giá vé (VNĐ)</th>
        </tr>
        <?php while ($r = $kq->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($r['ma_chuyen_bay']) ?></td>
            <td><?= htmlspecialchars($r['so_hieu']) ?></td>
            <td><?= htmlspecialchars($r['ma_tp_khoi_hanh']) ?></td>
            <td><?= htmlspecialchars($r['ten_di']) ?></td>
            <td><?= htmlspecialchars($r['ngay_khoi_hanh']) ?></td>
            <td><?= htmlspecialchars($r['ma_tp_den']) ?></td>
            <td><?= htmlspecialchars($r['ten_den']) ?></td>
            <td><?= htmlspecialchars($r['ngay_den']) ?></td>
            <td><?= number_format($r['gia_ve'], 0, ',', '.') ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p>Không có chuyến bay nào liên quan đến Nha Trang.</p>
    <?php endif; ?>

    <br><a href="index1.php">← Quay lại form nhập</a>
</body>
</html>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Các dạng mảng cơ bản trong PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 30px auto;
            line-height: 1.6;
        }

        h1 {
            color: #1d4ed8;
        }

        h2 {
            color: #166534;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        pre {
            background: #f4f4f4;
            padding: 12px;
            border-left: 4px solid #2563eb;
            overflow-x: auto;
        }

        .result {
            background: #ecfdf5;
            padding: 10px 15px;
            border: 1px solid #86efac;
        }
    </style>
</head>
<body>
    <h1>Các dạng mảng cơ bản trong PHP</h1>

    <?php
        // 1. Mảng chỉ số: phần tử được đánh số tự động từ 0.
        $monHoc = ["PHP", "HTML", "CSS"];
    ?>
    <h2>1. Mảng chỉ số</h2>
    <pre>$monHoc = ["PHP", "HTML", "CSS"];</pre>
    <div class="result">
        Phần tử đầu tiên: <?php echo $monHoc[0]; ?><br>
        Phần tử thứ hai: <?php echo $monHoc[1]; ?><br>
        Số phần tử: <?php echo count($monHoc); ?>
    </div>

    <?php
        // 2. Mảng kết hợp: mỗi giá trị có một khóa do người lập trình đặt tên.
        $sinhVien = [
            "hoTen" => "Nguyen Van An",
            "tuoi" => 20,
            "lop" => "PHP01"
        ];
    ?>
    <h2>2. Mảng kết hợp</h2>
    <pre>$sinhVien = [
    "hoTen" => "Nguyen Van An",
    "tuoi" => 20,
    "lop" => "PHP01"
];</pre>
    <div class="result">
        Họ tên: <?php echo $sinhVien["hoTen"]; ?><br>
        Tuổi: <?php echo $sinhVien["tuoi"]; ?><br>
        Lớp: <?php echo $sinhVien["lop"]; ?>
    </div>

    <?php
        // 3. Mảng nhiều chiều: một mảng chứa các mảng con.
        $danhSachSinhVien = [
            ["hoTen" => "Nguyen Van An", "tuoi" => 20],
            ["hoTen" => "Tran Thi Binh", "tuoi" => 21],
            ["hoTen" => "Le Van Cuong", "tuoi" => 19]
        ];
    ?>
    <h2>3. Mảng nhiều chiều</h2>
    <pre>$danhSachSinhVien = [
    ["hoTen" => "Nguyen Van An", "tuoi" => 20],
    ["hoTen" => "Tran Thi Binh", "tuoi" => 21]
];</pre>
    <div class="result">
        <?php
            foreach ($danhSachSinhVien as $sinhVien) {
                echo "Ho ten: " . $sinhVien["hoTen"] . ", Tuoi: " . $sinhVien["tuoi"] . "<br>";
            }
        ?>
    </div>

    <h2>4. Duyệt mảng bằng foreach</h2>
    <pre>foreach ($monHoc as $mon) {
    echo $mon;
}</pre>
    <div class="result">
        <?php
            foreach ($monHoc as $mon) {
                echo $mon . "<br>";
            }
        ?>
    </div>

    <h2>5. Thêm, sửa và xóa phần tử</h2>
    <pre>$monHoc[] = "JavaScript";       // Thêm
$monHoc[0] = "PHP nâng cao";    // Sửa
unset($monHoc[2]);              // Xóa</pre>
    <div class="result">
        <?php
            $monHocDemo = $monHoc;
            $monHocDemo[] = "JavaScript";
            $monHocDemo[0] = "PHP nang cao";
            unset($monHocDemo[2]);
            print_r($monHocDemo);
        ?>
    </div>

    <h2>6. Một số hàm xử lý mảng</h2>
    <pre>$so = [5, 2, 8, 1];
sort($so);                    // Sắp xếp tăng dần
rsort($so);                   // Sắp xếp giảm dần
count($so);                   // Đếm phần tử
in_array(8, $so);             // Kiểm tra phần tử</pre>
    <div class="result">
        <?php
            $so = [5, 2, 8, 1];
            sort($so);
            echo "Sau khi sort tăng dần: ";
            print_r($so);
            echo "<br>";
            echo "Mảng có chứa số 8 không? ";
            echo in_array(8, $so) ? "Có" : "Không";
        ?>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài tập 9 - Trang chủ</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0; 
            background-color: #f4f4f4;
        }
        .container { 
            width: 800px; 
            margin: 20px auto; 
            border: 1px solid #ccc; 
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header { 
            background-color: #0066cc; 
            color: white;
            padding: 20px; 
            text-align: center; 
        }
        .header h1 {
            margin: 0;
        }
        .menu { 
            background-color: #333; 
            overflow: hidden; 
        }
        .menu a { 
            float: left; 
            display: block; 
            color: white; 
            text-align: center; 
            padding: 14px 16px; 
            text-decoration: none; 
        }
        .menu a:hover { 
            background-color: #0066cc; 
            color: white; 
        }
        .content { 
            padding: 20px; 
            min-height: 250px; 
            font-size: 18px;
            line-height: 1.6;
        }
        .footer { 
            background-color: #f1f1f1; 
            padding: 10px; 
            text-align: center; 
            border-top: 1px solid #ccc;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>WEBSITE BÀI TẬP 9</h1>
    </div>

    <!-- Thanh Menu -->
    <div class="menu">
        <a href="index.php?page=trangchu">Trang chủ</a>
        <a href="index.php?page=gioithieu">Giới thiệu</a>
        <a href="index.php?page=tintuc">Tin tức</a>
        <a href="index.php?page=lienhe">Liên hệ</a>
        <a href="index.php?page=diendan">Diễn đàn</a>
    </div>

    <!-- Phần nội dung chính (load các trang con) -->
    <div class="content">
        <?php
            // Lấy tham số 'page' từ URL. Nếu mới vào trang web (chưa có tham số), mặc định là 'trangchu'
            $page = isset($_GET['page']) ? $_GET['page'] : 'trangchu';
            
            // Yêu cầu g: load nội dung của các trang con vào trang index.php
            // Dùng hàm include() để nhúng file
            
            // Danh sách các trang được phép nhúng (bảo mật)
            $allowed_pages = ['trangchu', 'gioithieu', 'tintuc', 'lienhe', 'diendan'];
            
            if (in_array($page, $allowed_pages)) {
                $file_to_include = $page . '.php'; // Nối thêm đuôi .php
                if (file_exists($file_to_include)) {
                    include($file_to_include); // Gọi file con vào đây
                } else {
                    echo "<p style='color:red;'>Lỗi: Không tìm thấy file <b>$file_to_include</b>!</p>";
                }
            } else {
                echo "<p style='color:red;'>Lỗi: Trang bạn yêu cầu không tồn tại!</p>";
            }
        ?>
    </div>

    <div class="footer">
        <p>&copy; Bài tập PHP & Form - Thực hành Include/Require</p>
    </div>
</div>

</body>
</html>

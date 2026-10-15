<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;   // bật log để debug, xong thì tắt đi
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'tranngochung730@gmail.com';
    $mail->Password   = 'mriy lqai ddpx bzmn';  // App Password 16 ký tự, viết liền không dấu cách
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // cổng 465 đi với SMTPS
    $mail->Port       = 465;
    $mail->CharSet    = 'UTF-8';             // để gửi tiếng Việt không lỗi font

    $mail->setFrom('tranngochung730@gmail.com', 'Tên hệ thống');
    $mail->addAddress('tranngochung730@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = 'Test gửi mail';
    $mail->Body    = 'Xin chào, đây là mail <b>thử nghiệm</b>!';
    $mail->AltBody = 'Xin chào, đây là mail thử nghiệm!';

    $mail->send();
    echo 'Gửi thành công';
} catch (Exception $e) {
    echo "Gửi thất bại: {$mail->ErrorInfo}";
}
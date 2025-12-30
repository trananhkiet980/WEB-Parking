<?php
// Include file DAO
require_once '../dao/user-accounts.php';

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Đảm bảo đường dẫn đến autoload.php là chính xác

// Hàm tạo token xác thực ngẫu nhiên
function generateVerificationToken($length = 32) {
    return bin2hex(random_bytes($length));
}

// Xử lý dữ liệu từ form đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $email = trim($_POST['emailInput']);
    $signup_password = trim($_POST['passwordInput']);
    $confirm_password = trim($_POST['confirmPasswordInput']);


    // Kiểm tra dữ liệu
    if (empty($email) || empty($signup_password) || empty($confirm_password)) {
        echo "Vui lòng điền đầy đủ thông tin.";
        exit;
    }

    if ($signup_password !== $confirm_password) {
        echo "Mật khẩu xác nhận không khớp.";
        exit;
    }

    // Tách username từ email (phần trước @)
    $username = explode('@', $email)[0];

    // Mã hóa mật khẩu
    $hashed_password = password_hash($signup_password, PASSWORD_DEFAULT);

    // Đường dẫn mặc định cho profile_pic
    $profile_pic = "default_profile.jpg"; // Thay đổi nếu cần

    try {
        // Kiểm tra xem email đã tồn tại chưa
        $existing_user = user_account_select_by_email($email);
        if ($existing_user) {
            echo "Email này đã được sử dụng.";
            exit;
        }

        // Tạo token xác thực ngẫu nhiên
        $email_verification_token = generateVerificationToken();

        // Thêm người dùng vào bảng user_accounts cùng với token xác thực
        $user_id = user_account_insert($username, $email, $hashed_password, $profile_pic, $email_verification_token);


        // Gửi email xác thực bằng PHPMailer
        $mail = new PHPMailer(true);

        try {
            echo "Đã thử gửi mail.";
            // Cấu hình SMTP cho Gmail
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Địa chỉ SMTP server Gmail
            $mail->SMTPAuth   = true;
            $mail->Username   = 'trananhkiet980@gmail.com'; // Tài khoản Gmail gửi
            $mail->Password   = 'vvimjtaipecjbbyn'; // Mật khẩu ứng dụng Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Sử dụng TLS
            $mail->Port       = 587; // Cổng SMTP cho TLS

            // Thông tin người gửi và người nhận
            $mail->setFrom('trananhkiet980@gmail.com', 'Website [SKTParking]'); // Đặt địa chỉ người gửi là Gmail của bạn
            $mail->addAddress($email, $username); // Địa chỉ email và username của người nhận

            // Nội dung email
            $mail->isHTML(true);
            $mail->Subject = 'Vui lòng xác nhận địa chỉ email của bạn';
            $verificationLink = 'localhost/SKTParking/dao/verify-email.php?token=' . $email_verification_token;
            $mail->Body    = 'Chào ' . $username . ',<br><br>' .
                             'Vui lòng nhấp vào liên kết sau để xác nhận địa chỉ email của bạn:<br>' .
                             '<a href="' . $verificationLink . '">' . $verificationLink . '</a><br><br>' .
                             'Nếu bạn không thực hiện đăng ký, vui lòng bỏ qua email này.<br><br>' .
                             'Trân trọng,<br>' .
                             'Đội ngũ [SKTParking]';
            $mail->AltBody = 'Chào ' . $username . ',\n\nVui lòng truy cập liên kết sau để xác nhận địa chỉ email của bạn: ' . $verificationLink . '\n\nNếu bạn không thực hiện đăng ký, vui lòng bỏ qua email này.\n\nTrân trọng,\nĐội ngũ [Tên trang web]';

            $mail->send();
            echo "Đăng ký thành công. Vui lòng kiểm tra hộp thư đến của bạn để xác nhận email.";
            // Chuyển hướng sau khi đăng ký thành công (tùy chọn - bạn sẽ cần trang thông báo kiểm tra email)
            // header("Location: index.php");
            exit;

        } catch (Exception $e) {
            echo "Đăng ký thành công, nhưng có lỗi khi gửi email xác thực. Vui lòng thử lại sau. Mailer Error: {$mail->ErrorInfo}";
            // Ghi log lỗi để điều tra
            error_log("Lỗi gửi email xác thực cho " . $email . ": " . $mail->ErrorInfo);
            // Chuyển hướng người dùng đến trang thông báo lỗi (tùy chọn)
            // header("Location: register-error.php?error=" . urlencode($mail->ErrorInfo));
            exit;
        }
    } catch (PDOException $e) {
        echo "Lỗi khi đăng ký: " . $e->getMessage();
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}
?>
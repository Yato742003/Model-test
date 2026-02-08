<?php
require_once __DIR__ . '/validator.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

$required = ['fullname', 'email', 'phone', 'password', 'confirm_password'];
if (!require_fields($required, $_POST) || !is_valid_email($_POST['email'])) {
    http_response_code(400);
    echo 'Vui lòng nhập đầy đủ thông tin.';
    exit;
}

if ($_POST['password'] !== $_POST['confirm_password']) {
    http_response_code(400);
    echo 'Mật khẩu xác nhận không trùng khớp.';
    exit;
}

$fullname = sanitize_input($_POST['fullname']);

echo "Đăng ký thành công cho $fullname (demo).";
?>

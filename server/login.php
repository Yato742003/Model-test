<?php
require_once __DIR__ . '/validator.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

$required = ['email', 'password'];
if (!require_fields($required, $_POST) || !is_valid_email($_POST['email'])) {
    http_response_code(400);
    echo 'Email hoặc mật khẩu không hợp lệ.';
    exit;
}

echo 'Đăng nhập thành công (demo).';
?>

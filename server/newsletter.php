<?php
require_once __DIR__ . '/validator.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

if (!isset($_POST['email']) || !is_valid_email($_POST['email'])) {
    http_response_code(400);
    echo 'Email không hợp lệ.';
    exit;
}

$email = sanitize_input($_POST['email']);

echo "Đăng ký nhận tin thành công cho $email.";
?>

<?php
require_once __DIR__ . '/validator.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

$required = ['fullname', 'email', 'phone', 'need', 'message'];
if (!require_fields($required, $_POST) || !is_valid_email($_POST['email'])) {
    http_response_code(400);
    echo 'Vui lòng cung cấp đầy đủ thông tin hợp lệ.';
    exit;
}

$fullname = sanitize_input($_POST['fullname']);
$email = sanitize_input($_POST['email']);
$phone = sanitize_input($_POST['phone']);
$need = sanitize_input($_POST['need']);
$message = sanitize_input($_POST['message']);

echo "Yêu cầu của $fullname đã được ghi nhận. Chúng tôi sẽ liên hệ qua $email.";
?>

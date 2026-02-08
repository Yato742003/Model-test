<?php
require_once __DIR__ . '/validator.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

$required = ['fullname', 'email', 'phone', 'address', 'payment'];
if (!require_fields($required, $_POST) || !is_valid_email($_POST['email'])) {
    http_response_code(400);
    echo 'Thông tin thanh toán chưa đầy đủ.';
    exit;
}

$fullname = sanitize_input($_POST['fullname']);

echo "Cảm ơn $fullname! Đơn hàng của bạn đã được ghi nhận (demo).";
?>

<?php
require_once __DIR__ . '/validator.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

$required = ['fullname', 'email', 'question'];
if (!require_fields($required, $_POST) || !is_valid_email($_POST['email'])) {
    http_response_code(400);
    echo 'Vui lòng nhập đầy đủ thông tin.';
    exit;
}

$fullname = sanitize_input($_POST['fullname']);
$question = sanitize_input($_POST['question']);

echo "Cảm ơn $fullname! Câu hỏi của bạn đã được ghi nhận: $question";
?>

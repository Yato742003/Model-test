<?php
require_once __DIR__ . '/validator.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

$required = ['comment'];
if (!require_fields($required, $_POST)) {
    http_response_code(400);
    echo 'Vui lòng nhập đầy đủ thông tin.';
    exit;
}

$comment = sanitize_input($_POST['comment']);
$fullname = isset($_POST['fullname']) ? sanitize_input($_POST['fullname']) : 'Khách hàng';

echo "Cảm ơn $fullname! Bình luận đã được gửi: $comment";
?>

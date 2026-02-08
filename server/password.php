<?php
require_once __DIR__ . '/validator.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

$required = ['current_password', 'new_password', 'confirm_password'];
if (!require_fields($required, $_POST)) {
    http_response_code(400);
    echo 'Vui lòng nhập đầy đủ thông tin.';
    exit;
}

if ($_POST['new_password'] !== $_POST['confirm_password']) {
    http_response_code(400);
    echo 'Mật khẩu xác nhận không trùng khớp.';
    exit;
}

echo 'Đổi mật khẩu thành công (demo).';
?>

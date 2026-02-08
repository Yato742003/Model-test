<?php
require_once __DIR__ . '/validator.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

$required = ['fullname', 'email', 'phone'];
if (!require_fields($required, $_POST) || !is_valid_email($_POST['email'])) {
    http_response_code(400);
    echo 'Thông tin hồ sơ không hợp lệ.';
    exit;
}

$fullname = sanitize_input($_POST['fullname']);
$avatarPath = '';

if (!empty($_FILES['avatar']['name'])) {
    $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'];
    if (!in_array($_FILES['avatar']['type'], $allowed, true)) {
        http_response_code(400);
        echo 'Định dạng ảnh không hợp lệ.';
        exit;
    }
    if ($_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo 'Tải ảnh thất bại.';
        exit;
    }
    $filename = uniqid('avatar_', true) . '-' . basename($_FILES['avatar']['name']);
    $destination = __DIR__ . '/../uploads/avatars/' . $filename;
    if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $destination)) {
        http_response_code(500);
        echo 'Không thể lưu ảnh.';
        exit;
    }
    $avatarPath = 'uploads/avatars/' . $filename;
}

echo "Cập nhật hồ sơ thành công cho $fullname (demo).";
if ($avatarPath) {
    echo " Ảnh đại diện: $avatarPath";
}
?>

<?php
require_once __DIR__ . '/validator.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

if (!isset($_FILES['image']) || empty($_FILES['image']['name'])) {
    http_response_code(400);
    echo 'Vui lòng chọn tệp để tải lên.';
    exit;
}

$allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'];
if (!in_array($_FILES['image']['type'], $allowed, true)) {
    http_response_code(400);
    echo 'Định dạng hình ảnh không hợp lệ.';
    exit;
}

if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo 'Tải ảnh thất bại.';
    exit;
}

if (!isset($_POST['note']) || trim($_POST['note']) === '') {
    http_response_code(400);
    echo 'Vui lòng nhập ghi chú.';
    exit;
}

$filename = uniqid('media_', true) . '-' . basename($_FILES['image']['name']);
$destination = __DIR__ . '/../uploads/media/' . $filename;
if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
    http_response_code(500);
    echo 'Không thể lưu tệp.';
    exit;
}

$note = sanitize_input($_POST['note']);
$path = 'uploads/media/' . $filename;

echo "Tải lên thành công: $path. Ghi chú: $note";
?>

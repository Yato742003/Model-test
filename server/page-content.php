<?php
require_once __DIR__ . '/validator.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

$required = ['home_title', 'hotline', 'address', 'intro', 'about_summary'];
if (!require_fields($required, $_POST)) {
    http_response_code(400);
    echo 'Vui lòng nhập đầy đủ nội dung.';
    exit;
}

if (empty($_FILES['logo']['name']) || empty($_FILES['about_image']['name'])) {
    http_response_code(400);
    echo 'Vui lòng tải lên logo và ảnh giới thiệu.';
    exit;
}

$allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'];
if (!in_array($_FILES['logo']['type'], $allowed, true) || !in_array($_FILES['about_image']['type'], $allowed, true)) {
    http_response_code(400);
    echo 'Định dạng hình ảnh không hợp lệ.';
    exit;
}

if ($_FILES['logo']['error'] !== UPLOAD_ERR_OK || $_FILES['about_image']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo 'Tải hình ảnh thất bại.';
    exit;
}

$filename = uniqid('logo_', true) . '-' . basename($_FILES['logo']['name']);
$destination = __DIR__ . '/../uploads/logos/' . $filename;
if (!move_uploaded_file($_FILES['logo']['tmp_name'], $destination)) {
    http_response_code(500);
    echo 'Không thể lưu logo.';
    exit;
}

$aboutFilename = uniqid('about_', true) . '-' . basename($_FILES['about_image']['name']);
$aboutDestination = __DIR__ . '/../uploads/media/' . $aboutFilename;
if (!move_uploaded_file($_FILES['about_image']['tmp_name'], $aboutDestination)) {
    http_response_code(500);
    echo 'Không thể lưu ảnh giới thiệu.';
    exit;
}

$title = sanitize_input($_POST['home_title']);
$hotline = sanitize_input($_POST['hotline']);
$address = sanitize_input($_POST['address']);
$intro = sanitize_input($_POST['intro']);
$aboutSummary = sanitize_input($_POST['about_summary']);

$logoPath = 'uploads/logos/' . $filename;
$aboutImagePath = 'uploads/media/' . $aboutFilename;

echo "Đã cập nhật nội dung trang chủ: $title. Giới thiệu: $aboutSummary. Logo: $logoPath. Ảnh giới thiệu: $aboutImagePath";
?>

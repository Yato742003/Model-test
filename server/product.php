<?php
require_once __DIR__ . '/validator.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

$required = ['name', 'category', 'price', 'stock', 'description'];
if (!require_fields($required, $_POST)) {
    http_response_code(400);
    echo 'Thông tin sản phẩm chưa đầy đủ.';
    exit;
}

if (empty($_FILES['image']['name'])) {
    http_response_code(400);
    echo 'Vui lòng tải lên hình ảnh sản phẩm.';
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
    echo 'Tải hình ảnh thất bại.';
    exit;
}

$filename = uniqid('product_', true) . '-' . basename($_FILES['image']['name']);
$destination = __DIR__ . '/../uploads/products/' . $filename;
if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
    http_response_code(500);
    echo 'Không thể lưu hình ảnh.';
    exit;
}

$name = sanitize_input($_POST['name']);
$category = sanitize_input($_POST['category']);
$price = sanitize_input($_POST['price']);
$stock = sanitize_input($_POST['stock']);
$description = sanitize_input($_POST['description']);

$imagePath = 'uploads/products/' . $filename;

echo "Đã thêm sản phẩm $name ($category). Hình ảnh: $imagePath";
?>

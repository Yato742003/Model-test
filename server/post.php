<?php
require_once __DIR__ . '/validator.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

$required = ['title', 'keywords', 'description', 'content'];
if (!require_fields($required, $_POST)) {
    http_response_code(400);
    echo 'Thông tin bài viết chưa đầy đủ.';
    exit;
}

$title = sanitize_input($_POST['title']);

echo "Bài viết '$title' đã được lưu (demo).";
?>

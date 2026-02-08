<?php
require_once __DIR__ . '/validator.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

$required = ['question', 'answer'];
if (!require_fields($required, $_POST)) {
    http_response_code(400);
    echo 'Vui lòng nhập đầy đủ câu hỏi và câu trả lời.';
    exit;
}

$question = sanitize_input($_POST['question']);
$answer = sanitize_input($_POST['answer']);

echo "Đã lưu FAQ: $question - $answer";
?>

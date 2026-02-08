<?php
function sanitize_input($value) {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

function require_fields($fields, $data) {
    foreach ($fields as $field) {
        if (!isset($data[$field]) || trim($data[$field]) === '') {
            return false;
        }
    }
    return true;
}

function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
?>

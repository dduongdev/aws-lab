<?php
require_once __DIR__ . '/config/session.php';

// Xoá toàn bộ session
$_SESSION = [];

// Xoá session cookie
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
    );
}

session_destroy();

// Chuyển về trang chủ
header('Location: index.php');
exit;

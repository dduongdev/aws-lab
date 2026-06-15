<?php
/**
 * Khởi tạo session với cấu hình bảo mật
 *
 * - HttpOnly  : JavaScript không thể đọc session cookie
 * - SameSite  : chống CSRF (chỉ gửi cookie khi cùng site)
 * - Secure    : chỉ gửi qua HTTPS (khi có certificate)
 */
session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    'secure'   => isset($_SERVER['HTTPS']),
]);
session_start();

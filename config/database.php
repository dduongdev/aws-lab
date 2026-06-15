<?php
/**
 * Cấu hình kết nối MySQL
 * Hỗ trợ .env — copy .env.example thành .env và sửa thông số
 */

// Load .env (nếu có) — ưu tiên env vars hệ thống hơn .env
require_once __DIR__ . '/loadenv.php';

define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'user_auth');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');

/**
 * Kết nối PDO
 * @return PDO
 */
function getDB(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            DB_HOST,
            DB_PORT,
            DB_NAME
        );

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,

            // SSL — dùng cho AWS RDS hoặc MySQL có SSL
            // Tuỳ chỉnh qua .env: DB_SSL_CA=true, DB_SSL_CERT=false
            PDO::MYSQL_ATTR_SSL_CA   => filter_var(getenv('DB_SSL_CA') ?: 'true', FILTER_VALIDATE_BOOLEAN),
            PDO::MYSQL_ATTR_SSL_CERT => filter_var(getenv('DB_SSL_CERT') ?: 'false', FILTER_VALIDATE_BOOLEAN),
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            die('Kết nối database thất bại: ' . $e->getMessage());
        }
    }

    return $pdo;
}

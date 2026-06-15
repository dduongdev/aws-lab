<?php
/**
 * Load .env file vào $_SERVER / getenv()
 * 
 * Cách dùng: require_once __DIR__ . '/loadenv.php';
 * Hàm tự động tìm file .env trong thư mục gốc của project.
 */

$envPath = __DIR__ . '/../.env';

if (!file_exists($envPath)) {
    return; // Không có .env — dùng fallback / env vars hệ thống
}

$lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if ($lines === false) {
    return;
}

foreach ($lines as $line) {
    // Bỏ qua comment (dòng bắt đầu bằng #)
    $line = trim($line);
    if ($line === '' || $line[0] === '#') {
        continue;
    }

    // Tách key=value (hỗ trợ value có dấu = bên trong)
    $pos = strpos($line, '=');
    if ($pos === false) {
        continue;
    }

    $key   = trim(substr($line, 0, $pos));
    $value = trim(substr($line, $pos + 1));

    // Bỏ quote nếu có
    if (strlen($value) >= 2) {
        if (($value[0] === '"' && $value[-1] === '"') ||
            ($value[0] === "'" && $value[-1] === "'")) {
            $value = substr($value, 1, -1);
        }
    }

    // Chỉ set nếu chưa có trong môi trường thực
    if (!array_key_exists($key, $_SERVER) && !array_key_exists($key, getenv())) {
        putenv("$key=$value");
        $_SERVER[$key] = $value;
        $_ENV[$key]    = $value;
    }
}

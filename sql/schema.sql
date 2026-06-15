-- ============================================
-- Database: user_auth
-- Table: users
-- Dùng cho ứng dụng PHP Đăng ký / Đăng nhập
-- ============================================

CREATE DATABASE IF NOT EXISTS user_auth
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE user_auth;

CREATE TABLE IF NOT EXISTS users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(50)  NOT NULL UNIQUE,
    email       VARCHAR(100) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,  -- Lưu hash, không lưu plain-text
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

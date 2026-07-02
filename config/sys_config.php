<?php
// Bật session cho toàn hệ thống - Bắt buộc phải có để làm chức năng Đăng nhập/Đăng xuất
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Định nghĩa đường dẫn gốc của dự án (giúp làm link không bị lỗi điều hướng)
define('BASE_URL', '/web_ban_do_/');
?>
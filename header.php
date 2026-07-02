<?php
// Giữ lại cấu hình hệ thống của nhóm trưởng
require_once 'config/sys_config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ - Hệ Thống Bán Đồ Ăn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning" href="index.php">🍔 CaMau Food</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Thực đơn</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a></li>
                </ul>
                
                <div class="d-flex align-items-center">
                    <form class="d-flex me-3" action="search.php" method="GET">
                        <input class="form-control form-control-sm me-2" type="search" name="keyword" placeholder="Tìm món ăn..." aria-label="Search">
                        <button class="btn btn-outline-warning btn-sm" type="submit">Tìm</button>
                    </form>
                    
                    <?php if (isset($_SESSION['user'])): ?>
                        <span class="text-light me-3">Xin chào, <b class="text-warning"><?= htmlspecialchars($_SESSION['user']['fullname']) ?></b>!</span>
                        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                            <a href="admin/index.php" class="btn btn-danger btn-sm me-2">Quản trị 👑</a>
                        <?php endif; ?>
                        <a href="logout.php" class="btn btn-secondary btn-sm">Đăng xuất</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-warning text-white fw-bold btn-sm">Đăng Nhập</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
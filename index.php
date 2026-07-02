<?php
require_once 'config/sys_config.php';
require_once 'config/database.php'; // Khai báo kết nối CSDL để lấy món ăn

// Truy vấn lấy danh sách món ăn từ database
try {
    $stmt = $conn->query("SELECT * FROM products ORDER BY id DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $products = [];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Chủ - Hệ Thống Bán Đồ Ăn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 text-center">
        <h1 class="text-warning fw-bold">🍔 HỆ THỐNG BÁN ĐỒ ĂN 🍕</h1>
        <p class="lead">Đây là giao diện trang chủ hiển thị món ăn dành cho Khách hàng.</p>
        <hr>

        <?php if (isset($_SESSION['user'])): ?>
            <div class="alert alert-info d-inline-block">
                Xin chào, <b><?= htmlspecialchars($_SESSION['user']['fullname']) ?></b>! 
                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <a href="admin/index.php" class="btn btn-danger btn-sm ms-2">Vào trang Quản trị 👑</a>
                <?php endif; ?>
                <a href="logout.php" class="btn btn-secondary btn-sm ms-2">Đăng xuất</a>
            </div>
        <?php else: ?>
            <p>Bạn muốn đặt hàng hoặc quản trị hệ thống?</p>
            <a href="login.php" class="btn btn-warning text-white fw-bold">Đăng Nhập Ngay</a>
        <?php endif; ?>
        
        <div class="mt-4 text-start">
            <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-danger m-0">🍕 Thực Đơn Nổi Bật</h4>
    <a href="cart.php" class="btn btn-success fw-bold shadow-sm text-white">
        🛒 Xem Giỏ Hàng
        <?php 
        $cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
        if ($cart_count > 0) {
            echo "<span class='badge bg-danger ms-1'>$cart_count</span>";
        }
        ?>
    </a>
</div>
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
                <?php if (count($products) > 0): ?>
                    <?php foreach ($products as $pro): ?>
                        <div class="col">
                            <div class="card h-100 shadow-sm border-0">
                                <?php if (!empty($pro['image'])): ?>
                                    <img src="uploads/<?= htmlspecialchars($pro['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($pro['name']) ?>" style="height: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/200?text=No+Image" class="card-img-top" style="height: 200px; object-fit: cover;">
                                <?php endif; ?>
                                
                                <div class="card-body text-center d-flex flex-column">
                                    <h6 class="card-title fw-bold text-dark"><?= htmlspecialchars($pro['name']) ?></h6>
                                    <p class="card-text text-danger fw-bold fs-5 mt-auto mb-3"><?= number_format($pro['price'], 0, ',', '.') ?> đ</p>
                                    <a href="add_to_cart.php?id=<?= $pro['id'] ?>" class="btn btn-warning w-100 fw-bold rounded-pill text-dark shadow-sm">🛒 Thêm vào giỏ</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="p-5 bg-white rounded shadow-sm text-center text-muted">
                            <i>Hiện chưa có món ăn nào trong thực đơn. Hãy vào trang quản trị để thêm món!</i>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
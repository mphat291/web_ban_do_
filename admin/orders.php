<?php
require_once '../config/sys_config.php';
require_once '../config/database.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}

// Lấy danh sách đơn hàng kèm chi tiết món ăn (Sử dụng subquery cực xịn)
try {
    $sql = "SELECT o.*, 
            (SELECT GROUP_CONCAT(CONCAT(p.name, ' (x', od.quantity, ')') SEPARATOR '<br>') 
             FROM order_details od 
             JOIN products p ON od.product_id = p.id 
             WHERE od.order_id = o.id) as order_items
            FROM orders o 
            ORDER BY o.order_date DESC";
    $stmt = $conn->query($sql);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $orders = [];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Đơn Hàng - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 shadow-sm border-0">
            <h1 class="text-danger fw-bold text-center mb-4">🛵 QUẢN LÝ ĐƠN HÀNG</h1>
            
            <div class="d-flex justify-content-between mb-3">
                <a href="index.php" class="btn btn-secondary fw-bold">⬅ Quay lại Menu món ăn</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle small">
                    <thead class="table-success text-center">
                        <tr>
                            <th>Mã Đơn</th>
                            <th>Khách Hàng</th>
                            <th>Liên Hệ</th>
                            <th>Địa Chỉ Giao</th>
                            <th>Chi Tiết Món Đặt</th>
                            <th>Tổng Tiền</th>
                            <th>Thời Gian Đặt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($orders) > 0): ?>
                            <?php foreach ($orders as $ord): ?>
                                <tr>
                                    <td class="text-center fw-bold">#<?= $ord['id'] ?></td>
                                    <td class="fw-bold text-primary"><?= htmlspecialchars($ord['customer_name']) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($ord['phone']) ?></td>
                                    <td><?= htmlspecialchars($ord['address']) ?></td>
                                    <td class="text-danger fw-bold"><?= $ord['order_items'] ?></td>
                                    <td class="text-center text-danger fw-bold fs-6"><?= number_format($ord['total_price'], 0, ',', '.') ?> đ</td>
                                    <td class="text-center text-muted"><?= date('d/m/Y H:i', strtotime($ord['order_date'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center text-muted py-4">Hiện chưa có đơn hàng nào!</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
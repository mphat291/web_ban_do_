<?php
require_once 'config/sys_config.php';
require_once 'config/database.php';

// Lấy giỏ hàng từ Session, nếu chưa có thì để mảng rỗng
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$products_in_cart = [];
$total_price = 0;

if (!empty($cart)) {
    // Lấy danh sách ID các món ăn đã thêm vào giỏ
    $ids = implode(',', array_keys($cart));
    try {
        $stmt = $conn->query("SELECT * FROM products WHERE id IN ($ids)");
        $products_in_cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ Hàng - Hệ Thống Bán Đồ Ăn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-danger fw-bold mb-4">🛒 Giỏ Hàng Của Bạn</h2>
        <a href="index.php" class="btn btn-secondary mb-3">⬅ Tiếp tục mua hàng</a>

        <?php if (isset($_SESSION['success_cart'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                ✨ <?= $_SESSION['success_cart']; unset($_SESSION['success_cart']); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($products_in_cart)): ?>
            <div class="alert alert-warning text-center p-5 shadow-sm">
                <h5>Giỏ hàng của bạn đang trống!</h5>
                <p>Hãy ra trang chủ và chọn cho mình một món ăn thật ngon nhé.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive bg-white p-4 rounded shadow-sm">
                <table class="table align-middle">
                    <thead class="table-warning text-center">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products_in_cart as $pro): 
                            $quantity = $cart[$pro['id']]['quantity'];
                            $subtotal = $pro['price'] * $quantity;
                            $total_price += $subtotal;
                        ?>
                        <tr class="text-center">
                            <td class="text-start">
                                <?php if (!empty($pro['image'])): ?>
                                    <img src="uploads/<?= htmlspecialchars($pro['image']) ?>" style="width: 60px; height: 60px; object-fit: cover;" class="me-3 rounded shadow-sm">
                                <?php endif; ?>
                                <span class="fw-bold text-dark"><?= htmlspecialchars($pro['name']) ?></span>
                            </td>
                            <td class="text-danger"><?= number_format($pro['price'], 0, ',', '.') ?> đ</td>
                            <td class="fw-bold"><?= $quantity ?></td>
                            <td class="text-danger fw-bold"><?= number_format($subtotal, 0, ',', '.') ?> đ</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <hr>
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <h4 class="text-dark fw-bold m-0">Tổng thanh toán: <span class="text-danger fs-3"><?= number_format($total_price, 0, ',', '.') ?> đ</span></h4>
                    <a href="checkout.php" class="btn btn-success btn-lg fw-bold px-5 shadow">Tiến Hành Đặt Hàng</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
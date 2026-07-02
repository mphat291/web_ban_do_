<?php
require_once 'config/sys_config.php';
require_once 'config/database.php';

if (empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit();
}

// Lấy danh sách sản phẩm và tính tổng tiền
$total_price = 0;
$ids = implode(',', array_keys($_SESSION['cart']));
try {
    $stmt = $conn->query("SELECT id, price FROM products WHERE id IN ($ids)");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($products as $pro) {
        $total_price += $pro['price'] * $_SESSION['cart'][$pro['id']]['quantity'];
    }
} catch (PDOException $e) {
    die("Lỗi kết nối: " . $e->getMessage());
}

// XỬ LÝ LƯU ĐƠN HÀNG VÀ CHI TIẾT ĐƠN HÀNG
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = trim($_POST['customer_name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    try {
        // 1. Lưu thông tin tổng quan vào bảng orders
        $stmt = $conn->prepare("INSERT INTO orders (customer_name, phone, address, total_price) VALUES (:name, :phone, :address, :total)");
        $stmt->execute([
            'name' => $customer_name,
            'phone' => $phone,
            'address' => $address,
            'total' => $total_price
        ]);

        // Lấy ID của đơn hàng vừa mới tạo xong
        $order_id = $conn->lastInsertId();

        // 2. Lưu từng món ăn vào bảng order_details
        $stmt_detail = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
        
        foreach ($products as $pro) {
            $quantity = $_SESSION['cart'][$pro['id']]['quantity'];
            $stmt_detail->execute([
                'order_id' => $order_id,
                'product_id' => $pro['id'],
                'quantity' => $quantity,
                'price' => $pro['price']
            ]);
        }

        // Đặt hàng thành công thì dọn sạch giỏ hàng
        unset($_SESSION['cart']);

        // Chuyển hướng về trang chủ
        echo "<script>
            alert('🎉 Đặt hàng thành công! Đơn của bạn đã được chuyển tới nhà bếp.');
            window.location.href = 'index.php';
        </script>";
        exit();
    } catch (PDOException $e) {
        $error = "Lỗi khi lưu đơn hàng: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh Toán - Hệ Thống Bán Đồ Ăn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow-sm border-0 p-4">
            <h3 class="text-danger fw-bold text-center mb-4">🛵 XÁC NHẬN ĐẶT HÀNG</h3>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <div class="alert alert-warning text-center">
                Tổng số tiền cần thanh toán: <br>
                <strong class="fs-2 text-danger"><?= number_format($total_price, 0, ',', '.') ?> đ</strong>
            </div>

            <form method="POST" action="checkout.php">
                <div class="mb-3">
                    <label class="form-label fw-bold">Tên người nhận:</label>
                    <input type="text" name="customer_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Số điện thoại liên hệ:</label>
                    <input type="tel" name="phone" class="form-control" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Địa chỉ giao hàng:</label>
                    <textarea name="address" class="form-control" rows="2" required></textarea>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success btn-lg fw-bold shadow-sm">Xác Nhận & Đặt Món</button>
                    <a href="cart.php" class="btn btn-secondary">⬅ Quay lại giỏ hàng</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
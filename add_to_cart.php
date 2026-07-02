<?php
require_once 'config/sys_config.php';

// Kiểm tra xem khách hàng có bấm chọn món nào không (dựa vào id truyền lên URL)
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Nếu giỏ hàng (lưu bằng Session) chưa tồn tại, thì tạo một giỏ hàng trống
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Nếu món ăn này đã có trong giỏ, thì cộng thêm 1 vào số lượng
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += 1;
    } else {
        // Nếu món này chưa có trong giỏ, thêm mới vào với số lượng là 1
        $_SESSION['cart'][$id] = [
            'quantity' => 1
        ];
    }

    // Tạo một thông báo thành công để hiển thị ra màn hình
    $_SESSION['success_cart'] = "Đã thêm món ăn vào giỏ hàng thành công!";
}

// Xử lý xong thì tự động quay ngược trở lại trang chủ
header('Location: index.php');
exit();
?>
<?php
require_once '../config/sys_config.php';
require_once '../config/database.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $price = isset($_POST['price']) ? (float)$_POST['price'] : 0;
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $image_name = '';

    if (empty($name) || $price <= 0) {
        $error = 'Vui lòng nhập tên món và giá hợp lệ!';
    } else {
        // Xử lý Upload ảnh
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                $image_name = time() . '_' . uniqid() . '.' . $ext;
                $upload_dir = '../uploads/';
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name);
            } else {
                $error = 'Định dạng ảnh không hợp lệ!';
            }
        }

        if (empty($error)) {
            try {
                $stmt = $conn->prepare("INSERT INTO products (name, price, description, image) VALUES (:name, :price, :description, :image)");
                $stmt->execute(['name' => $name, 'price' => $price, 'description' => $description, 'image' => $image_name]);
                $_SESSION['success_msg'] = "Thêm món ăn thành công!";
                header('Location: index.php');
                exit();
            } catch (PDOException $e) { $error = 'Lỗi: ' . $e->getMessage(); }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Món Ăn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="card p-4 shadow-sm">
            <h4 class="text-success fw-bold mb-3">➕ THÊM MÓN ĂN MỚI</h4>
            <?php if (!empty($error)): ?><div class="alert alert-danger py-1 small"><?= $error ?></div><?php endif; ?>
            <form action="add_product.php" method="POST" enctype="multipart/form-data">
                <div class="mb-2"><label class="form-label small fw-bold">Tên món</label><input type="text" class="form-control form-control-sm" name="name" required></div>
                <div class="mb-2"><label class="form-label small fw-bold">Giá bán</label><input type="number" class="form-control form-control-sm" name="price" required></div>
                <div class="mb-2"><label class="form-label small fw-bold">Hình ảnh</label><input type="file" class="form-control form-control-sm" name="image" accept="image/*"></div>
                <div class="mb-3"><label class="form-label small fw-bold">Mô tả</label><textarea class="form-control form-control-sm" name="description" rows="3"></textarea></div>
                <button type="submit" class="btn btn-success btn-sm w-100 fw-bold">Lưu Món Ăn</button>
                <a href="index.php" class="btn btn-secondary btn-sm w-100 mt-1">Hủy bỏ</a>
            </form>
        </div>
    </div>
</body>
</html>
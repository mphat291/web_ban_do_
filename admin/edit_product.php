<?php
require_once '../config/sys_config.php';
require_once '../config/database.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}

$error = ''; $product = null;
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) { header('Location: index.php'); exit(); }
} else { header('Location: index.php'); exit(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $price = isset($_POST['price']) ? (float)$_POST['price'] : 0;
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $image_name = $product['image'];

    if (empty($name) || $price <= 0) { $error = 'Dữ liệu không hợp lệ!'; } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                if (!empty($product['image']) && file_exists('../uploads/' . $product['image'])) {
                    unlink('../uploads/' . $product['image']);
                }
                $image_name = time() . '_' . uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $image_name);
            } else { $error = 'Định dạng ảnh không hợp lệ!'; }
        }

        if (empty($error)) {
            try {
                $stmt = $conn->prepare("UPDATE products SET name = :name, price = :price, description = :description, image = :image WHERE id = :id");
                $stmt->execute(['name' => $name, 'price' => $price, 'description' => $description, 'image' => $image_name, 'id' => $id]);
                $_SESSION['success_msg'] = "Cập nhật món ăn thành công!";
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
    <title>Sửa Món Ăn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="card p-4 shadow-sm">
            <h4 class="text-warning fw-bold mb-3">📝 CẬP NHẬT MÓN ĂN</h4>
            <?php if (!empty($error)): ?><div class="alert alert-danger py-1 small"><?= $error ?></div><?php endif; ?>
            <form action="edit_product.php?id=<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-2"><label class="form-label small fw-bold">Tên món</label><input type="text" class="form-control form-control-sm" name="name" value="<?= htmlspecialchars($product['name']) ?>" required></div>
                <div class="mb-2"><label class="form-label small fw-bold">Giá bán</label><input type="number" class="form-control form-control-sm" name="price" value="<?= $product['price'] ?>" required></div>
                <div class="mb-2">
                    <label class="form-label small fw-bold">Hình ảnh hiện tại</label>
                    <?php if(!empty($product['image'])): ?><img src="../uploads/<?= $product['image'] ?>" style="width:60px;display:block;" class="mb-1 rounded border"><?php endif; ?>
                    <input type="file" class="form-control form-control-sm" name="image" accept="image/*">
                </div>
                <div class="mb-3"><label class="form-label small fw-bold">Mô tả</label><textarea class="form-control form-control-sm" name="description" rows="3"><?= htmlspecialchars($product['description']) ?></textarea></div>
                <button type="submit" class="btn btn-warning text-white btn-sm w-100 fw-bold">Cập Nhật</button>
                <a href="index.php" class="btn btn-secondary btn-sm w-100 mt-1">Hủy bỏ</a>
            </form>
        </div>
    </div>
</body>
</html>
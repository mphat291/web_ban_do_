<?php
require_once '../config/sys_config.php';

// Bảo mật: Nếu chưa đăng nhập hoặc không phải admin thì đá bay ra trang login
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}
?>
<?php
require_once '../config/sys_config.php';

// Bảo mật: Nếu chưa đăng nhập hoặc không phải admin thì đá bay ra trang login
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}

// --- ĐOẠN THÊM MỚI 1: Xử lý xóa món ăn và nạp file kết nối DB ---
require_once '../config/database.php'; 

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id_delete = (int)$_GET['id'];
    try {
        // Lấy tên ảnh cũ để xóa file trên server cho đỡ rác
        $stmt_img = $conn->prepare("SELECT image FROM products WHERE id = :id");
        $stmt_img->execute(['id' => $id_delete]);
        $product = $stmt_img->fetch(PDO::FETCH_ASSOC);
        if ($product && !empty($product['image']) && file_exists('../uploads/' . $product['image'])) {
            unlink('../uploads/' . $product['image']);
        }

        // Xóa món ăn trong Database
        $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute(['id' => $id_delete]);
        $_SESSION['success_msg'] = "Xóa món ăn thành công rồi ní ơi!";
    } catch (PDOException $e) {
        $_SESSION['error_msg'] = "Lỗi xóa món ăn: " . $e->getMessage();
    }
    header('Location: index.php');
    exit();
}

// Lấy danh sách món ăn từ database
try {
    $stmt = $conn->query("SELECT * FROM products ORDER BY id DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $products = [];
}
// --- HẾT ĐOẠN THÊM MỚI 1 ---
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Quản Trị - Hệ Thống Bán Đồ Ăn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 shadow-sm">
            <h1 class="text-danger fw-bold">👑 TRANG QUẢN TRỊ ADMIN 👑</h1>
            <p class="lead">Chào mừng, <b><?= htmlspecialchars($_SESSION['user']['fullname']) ?></b> đã đăng nhập thành công!</p>
            <hr>
            <hr>
            <?php if (isset($_SESSION['success_msg'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ✨ <?= $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error_msg'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ❌ <?= $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
                <h4 class="text-secondary fw-bold m-0">Danh Sách Món Ăn</h4>
                <a href="add_product.php" class="btn btn-success btn-sm fw-bold">+ Thêm Món Mới</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center small">
                    <thead class="table-warning">
                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Tên Món</th>
                            <th>Giá</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($products) > 0): ?>
                            <?php foreach ($products as $pro): ?>
                                <tr>
                                    <td><?= $pro['id'] ?></td>
                                    <td>
                                        <?php if (!empty($pro['image'])): ?>
                                            <img src="../uploads/<?= htmlspecialchars($pro['image']) ?>" style="width: 50px; height: 40px; object-fit: cover;" class="rounded border">
                                        <?php else: ?>
                                            <span class="text-muted">Không ảnh</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-start fw-bold"><?= htmlspecialchars($pro['name']) ?></td>
                                    <td class="text-danger fw-bold"><?= number_format($pro['price'], 0, ',', '.') ?> đ</td>
                                    <td>
                                        <a href="edit_product.php?id=<?= $pro['id'] ?>" class="btn btn-warning btn-sm py-0">Sửa</a>
                                        <a href="index.php?action=delete&id=<?= $pro['id'] ?>" class="btn btn-danger btn-sm py-0" onclick="return confirm('Ní chắc chắn muốn xóa không?')">Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-muted">Chưa có món ăn nào!</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <p>Hệ thống phân quyền Auth đã chạy chuẩn đét. Giờ ní có thể bàn giao folder...</p>
            <p>Hệ thống phân quyền Auth đã chạy chuẩn đét. Giờ ní có thể bàn giao folder <code>admin</code> này cho bạn làm chức năng CRUD món ăn rồi đó!</p>
            <a href="../logout.php" class="btn btn-dark mt-3">Đăng xuất hệ thống</a>
        </div>
    </div>
</body>
</html>
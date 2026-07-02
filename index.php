<?php
// 1. Nhúng file Header dùng chung (đã bao gồm cấu hình hệ thống, session, navbar và ô tìm kiếm)
include 'header.php';
?>

<div id="foodSlider" class="carousel slide shadow-sm mb-5" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#foodSlider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#foodSlider" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#foodSlider" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    
    <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="4000">
            <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=1200&h=400&fit=crop" class="d-block w-100" alt="Banner Món Ngon" style="max-height: 400px; object-fit: cover;">
            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                <h3 class="fw-bold text-warning">🍔 TINH HOA ẨM THỰC CÀ MAU 🍕</h3>
                <p class="mb-0">Đặt món nhanh chóng - Giao hàng tận nơi - Thưởng thức trọn vị.</p>
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="4000">
            <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?q=80&w=1200&h=400&fit=crop" class="d-block w-100" alt="Banner Khuyến Mãi" style="max-height: 400px; object-fit: cover;">
            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                <h3 class="fw-bold text-warning">🎉 SIÊU ƯU ĐÃI THÁNG NÀY 🥤</h3>
                <p class="mb-0">Giảm ngay 50% cho khách hàng đầu tiên đăng ký tài khoản và đặt món.</p>
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="4000">
            <img src="https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?q=80&w=1200&h=400&fit=crop" class="d-block w-100" alt="Banner Đa Dạng" style="max-height: 400px; object-fit: cover;">
            <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
                <h3 class="fw-bold text-warning">🍗 THỰC ĐƠN ĐA DẠNG & PHONG PHÚ 🥞</h3>
                <p class="mb-0">Đầy đủ các món ăn vặt, cơm trưa văn phòng và nước uống giải khát cực đã.</p>
            </div>
        </div>
    </div>
    
    <button class="carousel-control-prev" type="button" data-bs-target="#foodSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#foodSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="text-warning fw-bold text-uppercase">🔥 MÓN ĂN BÁN CHẠY NHẤT 🔥</h2>
        <p class="text-muted">Những món ăn siêu ngon được cộng đồng CaMau Food săn đón nhiều nhất</p>
        <hr class="w-25 mx-auto text-warning" style="height: 3px; opacity: 1;">
    </div>

    <div class="row g-4">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm border-0 position-relative">
                <span class="position-absolute top-0 start-0 badge bg-danger m-3 px-3 py-2 fs-6 shadow">HOT</span>
                <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=500&h=350&fit=crop" class="card-img-top" alt="Hamburger đặc biệt" style="height: 220px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold text-dark">Hamburger Bò Phô Mai</h5>
                    <p class="card-text text-muted flex-grow-1">Bánh mì kẹp thịt bò nướng lò thơm phức, kết hợp lớp phô mai béo ngậy, xà lách tươi và nước sốt BBQ hảo hạng.</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="text-danger fw-bold fs-5">55.000 đ</span>
                        <a href="detail.php?id=1" class="btn btn-warning text-white btn-sm fw-bold px-3">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm border-0 position-relative">
                <span class="position-absolute top-0 start-0 badge bg-danger m-3 px-3 py-2 fs-6 shadow">HOT</span>
                <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=500&h=350&fit=crop" class="card-img-top" alt="Pizza Thập Cẩm" style="height: 220px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold text-dark">Pizza Thập Cẩm Phô Mai</h5>
                    <p class="card-text text-muted flex-grow-1">Đế bánh dày giòn rụm phủ đầy ắp tôm, mực, xúc xích và lớp phô mai Mozzarella kéo sợi béo ngậy ngập tràn.</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="text-danger fw-bold fs-5">139.000 đ</span>
                        <a href="detail.php?id=2" class="btn btn-warning text-white btn-sm fw-bold px-3">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm border-0 position-relative">
                <span class="position-absolute top-0 start-0 badge bg-danger m-3 px-3 py-2 fs-6 shadow">HOT</span>
                <img src="https://images.unsplash.com/photo-1540420773420-3366772f4999?q=80&w=500&h=350&fit=crop" class="card-img-top" alt="Salad Ức Gà" style="height: 220px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold text-dark">Salad Ức Gà Sốt Mè Rang</h5>
                    <p class="card-text text-muted flex-grow-1">Lựa chọn tuyệt vời cho chế độ ăn lành mạnh với ức gà áp chảo xé nhỏ, các loại rau mầm hữu cơ tươi xanh sạch sẽ.</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="text-danger fw-bold fs-5">45.000 đ</span>
                        <a href="detail.php?id=3" class="btn btn-warning text-white btn-sm fw-bold px-3">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 p-4 bg-white rounded shadow-sm text-center text-muted border border-dashed">
        <p class="mb-0">💡 <i>[Phần danh sách thực đơn toàn bộ, bộ lọc danh mục món ăn (Đồ ăn, Thức uống) và chức năng thêm vào giỏ hàng sẽ do bạn Nam và các thành viên khác kết nối Backend đổ dữ liệu dynamic từ Database tại đây]</i></p>
    </div>
</div>

<?php
// 4. Nhúng file Footer dùng chung (Đóng body, chứa thông tin bản quyền và thư viện Bootstrap JS)
include 'footer.php';
?>
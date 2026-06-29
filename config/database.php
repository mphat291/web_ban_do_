<?php
$host = "localhost";
$db_name = "web_ban_do_an";
$username = "root"; // Mặc định của XAMPP
$password = "";     // Mặc định của XAMPP để trống

try {
    // Kết nối database qua PDO chuẩn theo yêu cầu đồ án
    $conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name . ";charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $exception) {
    echo "Lỗi kết nối Cơ sở dữ liệu: " . $exception->getMessage();
    exit();
}
?>

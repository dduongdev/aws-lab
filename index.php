<?php
require_once __DIR__ . '/config/session.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/header.php';
?>

<div class="card">
    <h1>Chào mừng đến với AWS Auth Lab</h1>
    <p>
        Ứng dụng PHP đơn giản minh hoạ tính năng
        <strong>Đăng ký</strong>, <strong>Đăng nhập</strong> và <strong>Đăng xuất</strong>.
    </p>
    <p>Dùng source này để luyện tập triển khai lên AWS.</p>

    <?php if (isset($_SESSION['user_id'])): ?>
        <p style="margin-top:1.5rem;">
            <a href="dashboard.php" class="btn btn-primary">Vào Dashboard</a>
        </p>
    <?php else: ?>
        <div class="btn-group" style="margin-top:1.5rem;">
            <a href="register.php" class="btn btn-primary">Đăng ký</a>
            <a href="login.php" class="btn btn-secondary">Đăng nhập</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

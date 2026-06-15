<?php
require_once __DIR__ . '/config/session.php';

// Yêu cầu đăng nhập — nếu chưa đăng nhập thì đá về login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/header.php';

$pdo  = getDB();
$stmt = $pdo->prepare('SELECT id, username, email, created_at FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<div class="card">
    <h1>Dashboard</h1>
    <p>Xin chào, <strong><?= htmlspecialchars($_SESSION['user_username']) ?></strong>!</p>

    <div class="info-table">
        <div class="info-row">
            <span class="info-label">ID</span>
            <span><?= $user['id'] ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Tên đăng nhập</span>
            <span><?= htmlspecialchars($user['username']) ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Email</span>
            <span><?= htmlspecialchars($user['email']) ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Ngày tạo</span>
            <span><?= htmlspecialchars($user['created_at']) ?></span>
        </div>
    </div>

    <div class="btn-group" style="margin-top: 1.5rem;">
        <a href="logout.php" class="btn btn-secondary">Đăng xuất</a>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

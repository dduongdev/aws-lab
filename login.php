<?php
require_once __DIR__ . '/config/session.php';

// Nếu đã đăng nhập thì chuyển sang dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

require_once __DIR__ . '/config/database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password']      ?? '';

    if ($username === '' || $password === '') {
        $error = 'Vui lòng nhập tên đăng nhập và mật khẩu.';
    } else {
        $pdo  = getDB();
        $stmt = $pdo->prepare('SELECT id, username, password FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Đăng nhập thành công → lưu session
            // Chống session fixation
            session_regenerate_id(true);

            $_SESSION['user_id']       = $user['id'];
            $_SESSION['user_username'] = $user['username'];

            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Sai tên đăng nhập hoặc mật khẩu.';
        }
    }
}

require_once __DIR__ . '/header.php';
?>

<div class="card">
    <h1>Đăng nhập</h1>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" class="auth-form">
        <div class="form-group">
            <label for="username">Tên đăng nhập</label>
            <input type="text" name="username" id="username" required
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" name="password" id="password" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
    </form>

    <p style="margin-top:1rem; text-align:center;">
        Chưa có tài khoản? <a href="register.php">Đăng ký</a>
    </p>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

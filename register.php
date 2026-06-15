<?php
require_once __DIR__ . '/config/session.php';

// Nếu đã đăng nhập thì chuyển sang dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

require_once __DIR__ . '/config/database.php';

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email']    ?? '');
    $password = $_POST['password']      ?? '';
    $confirm  = $_POST['confirm']       ?? '';

    // --- Validation ---
    if ($username === '' || $email === '' || $password === '' || $confirm === '') {
        $error = 'Vui lòng điền đầy đủ các trường.';
    } elseif (!preg_match('/^[a-zA-Z0-9_]{3,50}$/', $username)) {
        $error = 'Tên đăng nhập chỉ gồm chữ cái, số, gạch dưới, độ dài 3-50 ký tự.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email không hợp lệ.';
    } elseif (strlen($password) < 6) {
        $error = 'Mật khẩu phải có ít nhất 6 ký tự.';
    } elseif ($password !== $confirm) {
        $error = 'Mật khẩu xác nhận không khớp.';
    } else {
        $pdo = getDB();

        // Kiểm tra username / email đã tồn tại chưa
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
        $stmt->execute([$username, $email]);

        if ($stmt->fetch()) {
            $error = 'Tên đăng nhập hoặc email đã được sử dụng.';
        } else {
            // Lưu user mới
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
            $stmt->execute([$username, $email, $hash]);

            $success = 'Đăng ký thành công! <a href="login.php">Đăng nhập ngay</a>.';
        }
    }
}

require_once __DIR__ . '/header.php';
?>

<div class="card">
    <h1>Đăng ký tài khoản</h1>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php else: ?>
        <form method="post" class="auth-form">
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" name="username" id="username" required
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" name="password" id="password" required minlength="6">
            </div>

            <div class="form-group">
                <label for="confirm">Xác nhận mật khẩu</label>
                <input type="password" name="confirm" id="confirm" required minlength="6">
            </div>

            <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
        </form>

        <p style="margin-top:1rem; text-align:center;">
            Đã có tài khoản? <a href="login.php">Đăng nhập</a>
        </p>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

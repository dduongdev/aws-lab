<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Auth - AWS Lab</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="container nav-container">
        <a href="index.php" class="nav-brand">AWS Auth Lab</a>
        <ul class="nav-links">
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Đăng xuất</a></li>
            <?php else: ?>
                <li><a href="register.php">Đăng ký</a></li>
                <li><a href="login.php">Đăng nhập</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<main class="container">

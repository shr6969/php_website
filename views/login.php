<?php
session_start();

// Виведення помилок / повідомлень із сесії
$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);

$logout_success = isset($_GET['logout']) && $_GET['logout'] === '1'
    ? 'Ви успішно вийшли з акаунту.'
    : '';
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Вхід — Viajero</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="login-container">
    <h2>Вхід у Viajero</h2>

    <?php if ($error): ?>
        <div class="error-box"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($logout_success): ?>
        <div class="success-box"><?= htmlspecialchars($logout_success) ?></div>
    <?php endif; ?>

    <form action="index.php?action=submit_login" method="POST">
        <div class="form-group">
            <label for="username">Логін:</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <button type="submit">Увійти</button>
        </div>
    </form>
</div>

</body>
</html>

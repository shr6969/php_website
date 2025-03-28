<?php
session_start();
$errors = $_SESSION['registration_errors'] ?? [];
$old = $_SESSION['registration_old'] ?? [];
unset($_SESSION['registration_errors'], $_SESSION['registration_old']);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Реєстрація - Viajero</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="registration-container">
    <h2>Форма реєстрації</h2>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="index.php?action=submit_registration" method="POST">
        <div class="form-group">
            <label for="username">Логін:</label>
            <input type="text" id="username" name="username" required
                   value="<?= htmlspecialchars($old['username'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="confirm_password">Повторіть пароль:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>

        <div class="form-group">
            <label for="email">Електронна пошта:</label>
            <input type="email" id="email" name="email" required
                   value="<?= htmlspecialchars($old['email'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="first_name">Ім'я:</label>
            <input type="text" id="first_name" name="first_name"
                   value="<?= htmlspecialchars($old['first_name'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="country">Країна:</label>
            <select name="country" id="country" required>
                <option value="">Оберіть країну</option>
                <?php
                $lines = file('countries.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $countries = [];

                foreach ($lines as $line) {
                    [$code, $name] = explode('|', $line);
                    $code = strtoupper(trim($code));
                    $name = trim($name);
                    if (preg_match('/^[A-Z]{2}$/', $code)) {
                        $countries[] = ['code' => $code, 'name' => $name];
                    }
                }

                usort($countries, function($a, $b) {
                    return strcmp($a['name'], $b['name']);
                });

                foreach ($countries as $country) {
                    $selected = ($old['country'] ?? '') === $country['code'] ? 'selected' : '';
                    echo "<option value=\"{$country['code']}\" $selected>{$country['name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="register-button">Зареєструватися</button>
        </div>
    </form>
</div>

</body>
</html>

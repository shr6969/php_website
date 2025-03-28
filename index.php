<?php
session_start();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Viajero</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'layout/header.php'; ?>

<div class="container">
    <?php include 'layout/left_menu.php'; ?>

    <main>
    <?php
        $action = isset($_GET['action']) ? $_GET['action'] : 'main';

        switch ($action) {
            case 'login':
                include 'views/login.php';
                break;
            
                case 'submit_login':
                    require_once 'db.php';
                
                    $username = $_POST['username'] ?? '';
                    $password = $_POST['password'] ?? '';
                
                    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
                    $stmt->execute([':username' => $username]);
                    $user = $stmt->fetch();
                
                    if ($user && password_verify($password, $user['password'])) {
                        //Зберігаємо в сесію
                        $_SESSION['user'] = $user['username'];
                        $_SESSION['user_id'] = $user['id'];       
                        $_SESSION['admin'] = $user['admin'];       
                
                        //Виведення повідомлення
                        echo "<h2>Успішний вхід!</h2>";
                        echo "<p>Вітаємо, {$_SESSION['user']}!</p>";
                        echo "<p><a href='index.php?action=main'>На головну</a></p>";
                        exit;
                    } else {
                        $_SESSION['login_error'] = "Невірний логін або пароль.";
                        header("Location: index.php?action=login");
                        exit;
                    }
                    break;
                                

            case 'about':
                include 'views/about.php';
                break;

            case 'registration':
                include 'views/registration.php';
                break;

            case 'registration_successful':
                echo "<h2>Реєстрація пройшла успішно 🎉</h2>";
                echo "<p>Дякуємо за реєстрацію!</p>";
                echo "<p><a href='index.php?action=main'>На головну</a></p>";
                break;

            case 'submit_registration':
                $errors = [];
                $old = $_POST;

                // 1. Логін
                if (!preg_match('/^[a-zA-Zа-яА-ЯіІїЇєЄ0-9_-]{4,}$/u', $_POST['username'] ?? '')) {
                    $errors[] = "Логін має містити щонайменше 4 символи та лише літери, цифри, _ або -.";
                }

                // 2. Пароль
                $password = $_POST['password'] ?? '';
                if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{7,}$/', $password)) {
                    $errors[] = "Пароль має містити щонайменше 7 символів, великі і малі літери та цифри.";
                }

                // 3. Повтор пароля
                if ($_POST['confirm_password'] !== $password) {
                    $errors[] = "Паролі не співпадають.";
                }

                // 4. Email
                if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Некоректна електронна адреса.";
                }

                // 5. Країна
                if (!preg_match('/^[A-Z]{2}$/', $_POST['country'] ?? '')) {
                    $errors[] = "Оберіть коректну країну.";
                }

                if ($errors) {
                    $_SESSION['registration_errors'] = $errors;
                    $_SESSION['registration_old'] = $old;
                    header("Location: index.php?action=registration");
                    exit;
                } else {
                    require_once 'db.php';

                    $username = $_POST['username'];
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $email = $_POST['email'];
                    $firstName = $_POST['first_name'] ?? null;
                    $country = $_POST['country'];

                    $sql = "INSERT INTO users (username, password, email, first_name, country)
                            VALUES (:username, :password, :email, :first_name, :country)";
                    $stmt = $pdo->prepare($sql);

                    try {
                        $stmt->execute([
                            ':username' => $username,
                            ':password' => $passwordHash,
                            ':email' => $email,
                            ':first_name' => $firstName,
                            ':country' => $country
                        ]);
                        header("Location: index.php?action=registration_successful");
                        exit;
                    } catch (PDOException $e) {
                        $_SESSION['registration_errors'] = ['Помилка при збереженні в базу даних: ' . $e->getMessage()];
                        $_SESSION['registration_old'] = $_POST;
                        header("Location: index.php?action=registration");
                        exit;
                    }
                }

                break;

            case 'logout':
                session_unset();
                session_destroy();
                header("Location: index.php?action=login&logout=1");
                exit;


            default:
                include 'views/main.php';
                break;
        }
    ?>
    </main>
</div>

<?php include 'layout/footer.php'; ?>

</body>
</html>



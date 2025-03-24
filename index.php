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
            $page = isset($_GET['page']) ? $_GET['page'] : 'main';

            if ($page === 'about') {
                include 'views/about.php';
            } else {
                include 'views/main.php';
            }
        ?>
    </main>

    <!-- <?php include 'layout/right_menu.php'; ?> (якщо є) -->
</div>

<?php include 'layout/footer.php'; ?>

</body>
</html>

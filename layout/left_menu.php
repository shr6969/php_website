<nav class="sidebar">
    <ul>
        <li><a href="index.php?action=main">Головна</a></li>
        <li><a href="index.php?action=about">Про сайт</a></li>
        <li><a href="index.php?action=registration">Реєстрація</a></li>

        <?php if (!empty($_SESSION['user'])): ?>
            <li><a href="index.php?action=logout">Вийти</a></li>
        <?php else: ?>
            <li><a href="index.php?action=login">Увійти</a></li>
        <?php endif; ?>

    </ul>
</nav>

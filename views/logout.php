<?php
session_start();
session_unset();
session_destroy();

// Повернення до login з повідомленням
header("Location: login.php?logout=1");
exit;

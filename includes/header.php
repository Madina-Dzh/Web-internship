<?php
session_start();
require_once dirname(__DIR__) . '/includes/config.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ПрактДог — Система договорных практик</title>
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>header.css">
</head>
<body>
    <header class="main-header">
        <div class="logo">
            <span class="logo-text">ПрактиДог</span>
        </div>
        <nav class="main-nav">
            <a href="<?php echo CONTRACTS_URL; ?>active-contracts.php" class="nav-link">Договоры</a>
            <a href="<?php echo PRACTICES_URL; ?>active-practices.php" class="nav-link">Практики</a>
            <a href="<?php echo REFERENCES_URL; ?>organizations.php" class="nav-link">Справочники</a>
        </nav>
        <div class="account">
            <!--<button class="login-btn">Войти</button>-->
        </div>
    </header>
</body>
</html>
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ПрактДог — Система договорных практик</title>
    <link rel="stylesheet" href="./css/header.css">
</head>
<body>
    <header class="main-header">
        <div class="logo">
            <span class="logo-text">ПрактДог</span>
        </div>
        <nav class="main-nav">
            <a href="./active-practices.php" class="nav-link">Практики</a>
            <a href="./active-contracts.php" class="nav-link">Договоры</a>
            <a href="./organizations.php" class="nav-link">Справочники</a>
        </nav>
        <div class="account">
            <button class="login-btn">Войти</button>
        </div>
    </header>
</body>
</html>
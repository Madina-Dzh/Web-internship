<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Шапка</title>
    <link  rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="header">
        <a class="element-head" href="./index.php">&#183; Главная</a>
        <a class="element-head" href="#">&#183; О нас</a>
        <a class="element-head" href="#">&#183; Новости / Объявления</a>
        <a class="element-head" href="#">&#183; Faq / Помощь</a>
        <a class="element-head" href="#">&#183; Контакты</a>
        <a class="element-head" href="./cabinet.php">&#183; Личный кабинет</a>
        <?php
            if (empty($_SESSION)) {
                echo '<a class="element-head" href="./authentication.php">&#183; Вход / Регистрация</a>';
            } else {
                echo '<a class="element-head" href="logout.php" onclick="return confirm(`Вы уверены, что хотите выполнить это действие?`);">&#183; Выход</a>';
                echo "<br><a class='element-head'>{$_SESSION['login']}</a>";
            }
        ?>
        
    </div>
</body>
</html>
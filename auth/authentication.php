<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в систему</title>
    <link rel="stylesheet" href="./authentication.css">
</head>
<body class="site">
    <?php 
        include 'header.php';
    ?>
    <div class="wrapper-auth">
        <form id="auth" action="login.php" method="POST"> 
            <label for="ligin">Логин пользователя</label><br>
            <input class="input-text" type="text" name="login" id="login" placeholder="Введите логин пользователя"/><br><br>
            <label>Пароль пользователя</label><br>
            <input class="input-text" type="password" name="password" id="password" placeholder="Введите пароль пользователя"/>
            <?php if(!empty($_SESSION['error'])) echo '<div class="error">' . $_SESSION['error'] . '</div><br>'; else echo '<br><br>' ?>
            <input type="submit" value="Войти" name="btn-submit" id="btn-submit"/>
        </form>
    </div>
    
</body>
</html>
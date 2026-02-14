<?php 
session_start();
$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");
if (!empty($_POST['password']) and !empty($_POST['login'])) {  
    $login = $_POST['login'];  
    $password = md5($_POST['password']);
    $query = "SELECT * FROM users WHERE login='$login' AND password='$password'";  
    $res = $mysql->query($query);
    $user = mysqli_fetch_assoc($res);  
    if (!empty($user)) {  
        // пользователь авторизован 
        echo "Вход успешен!";  
        session_set_cookie_params (240);
        $_SESSION['login'] = $login;
        print_r($_SESSION);
        header("Location: http://localhost/test/");
    } else {  
        // неверный логин или пароль  
        echo "Вход провален!<br>";
        echo  $query;
    }  
}  
$mysql->close();
?>  


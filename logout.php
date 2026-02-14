<?php  
// продолжить текущую сессию  
session_start();  
// проверить, установлена ли переменная сессии  
if (!empty($_SESSION['login'])) {  
    session_destroy();  
}  
// перенаправить пользователя на домашнюю страницу  
header("Location: http://localhost/test/");  
?>  
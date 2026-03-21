<?php
$mysql = new mysqli("localhost", "root", "", "internship");
if ($mysql->connect_error) {
    die("Ошибка подключения: " . $mysql->connect_error);
}
$mysql->query("SET NAMES 'utf8'");

$groupId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$contractId = isset($_GET['contract_id']) ? intval($_GET['contract_id']) : 0;

$message = "Некорректный ID группы";
$messageType = "error";

if ($groupId > 0) {
    $query = "DELETE FROM contract_details WHERE id = $groupId";
    if ($mysql->query($query) === TRUE) {
        $message = "Группа успешно удалена!";
        $messageType = "success";
    } else {
        $message = "Ошибка при удалении: " . $mysql->error;
    }
}

$mysql->close();

$redirectUrl = 'collective-details.php?id=' . $contractId . '&message=' . urlencode($message) . '&type=' . $messageType;
header("Location: $redirectUrl");
exit();
?>
<?php
$mysql = new mysqli("localhost", "root", "", "internship");
if ($mysql->connect_error) {
    die("Ошибка подключения: " . $mysql->connect_error);
}
$mysql->query("SET NAMES 'utf8'");

$studId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$contractId = isset($_GET['contract_id']) ? intval($_GET['contract_id']) : 0;

$message = "Некорректный ID группы";
$messageType = "error";


print_r($result);


if ($studId > 0) {
    $query = "DELETE FROM contract_details WHERE id = $studId";
    if ($mysql->query($query) === TRUE) {
        $message = "Группа успешно удалена!";
        $messageType = "success";
    } else {
        $message = "Ошибка при удалении: " . $mysql->error;
    }
}

// Проверяем, есть ли записи с данным contract_code в таблице contract
$checkQuery = "SELECT 1 FROM `contract`
              WHERE contract_code = '$contractId'
              LIMIT 1";
$result = $mysql->query($checkQuery);

if ($result->num_rows > 0) {
    echo("Записей нет - в черновики");
    $updateQuery = "UPDATE `contract`
                  SET `status` = 'draft'
                  WHERE contract_code = '$contractId'";
    $mysql->query($updateQuery);
}

print_r($result);
$number = str_pad($contractId, 3, '0', STR_PAD_LEFT);
$mysql->query("INSERT INTO `user_actions`(`action_text`) VALUES ('Удалён студент из индивидуального договора № $number')");
$mysql->close();

$redirectUrl = 'individual-details.php?id=' . $contractId . '&message=' . urlencode($message) . '&type=' . $messageType;
header("Location: $redirectUrl");
exit();
?>
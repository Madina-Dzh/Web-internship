<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");

$errors = [];

// Проверка обязательных полей
if (empty($_POST['contract_code'])) {
    $errors[] = "Номер практики обязателен";
}
if (empty($_POST['organization_code'])) {
    $errors[] = "Организация обязательна";
}
if (empty($_POST['type'])) {
    $errors[] = "Тип договора обязателен";
}
if (empty($_POST['start_date'])) {
    $errors[] = "Дата начала обязательна";
}
if (empty($_POST['end_date'])) {
    $errors[] = "Дата окончания обязательна";
}

// Проверка, что дата окончания позже даты начала
if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
    $start_date_obj = DateTime::createFromFormat('Y-m-d', $_POST['start_date']);
    $end_date_obj = DateTime::createFromFormat('Y-m-d', $_POST['end_date']);

    if ($start_date_obj && $end_date_obj) {
        if ($end_date_obj <= $start_date_obj) {
            $errors[] = "Дата окончания должна быть позже даты начала";
        }
    } else {
        $errors[] = "Неверный формат дат. Используйте ГГГГ-ММ-ДД";
    }
}

if (!empty($errors)) {
    http_response_code(400);
    echo "errors:" . implode(", ", $errors);
    exit;
}

// Безопасное получение данных
$contract_code = $mysql->real_escape_string($_POST['contract_code']);
$organization_code = intval($_POST['organization_code']);
$type = $mysql->real_escape_string($_POST['type']);
$start_date = $mysql->real_escape_string($_POST['start_date']);
$end_date = $mysql->real_escape_string($_POST['end_date']);

// ПРОВЕРКА НА СУЩЕСТВОВАНИЕ ЗАПИСИ С ТАКИМ contract_code
$checkQuery = "SELECT COUNT(*) as count FROM `contract` WHERE `contract_code` = '$contract_code'";
$checkResult = $mysql->query($checkQuery);
$row = $checkResult->fetch_assoc();

if ($row['count'] > 0) {
    http_response_code(400);
    echo "errors:Запись с таким номером договора уже существует";
    exit;
}

// Формируем SQL‑запрос с правильным порядком полей и кавычками
$query = "INSERT INTO `contract`
                (`contract_code`, `organization_code`, `start_date`, `end_date`, `status`, `type`)
          VALUES ('$contract_code', '$organization_code', '$start_date', '$end_date', 'draft', '$type')";

$result = $mysql->query($query);

if ($result) {
    $number = str_pad($contract_code, 3, '0', STR_PAD_LEFT);
    $mysql->query("INSERT INTO `user_actions`(`action_text`) VALUES ('добавлен контракт № $number')");
    // Мгновенный редирект без вывода каких‑либо сообщений
    header("Location: draft-contract.php");
    exit;
} else {
    http_response_code(500);
    echo "Ошибка при добавлении в базу данных";
    exit;
}

$mysql->close();
?>

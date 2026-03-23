<?php
// Устанавливаем кодировку
header('Content-Type: text/html; charset=utf-8');

$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");

// Получаем данные из формы
$contractId = isset($_POST['contract_id']) ? trim($_POST['contract_id']) : '';
$practice_code = isset($_POST['practice_code']) ? $_POST['practice_code'] : null;
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;
$group = isset($_POST['group']) ? $_POST['group'] : null;
$groupId = isset($_POST['edit_id']) ? $_POST['edit_id'] : null; // Используем edit_id, а не groupId

// ВАЖНАЯ ПРОВЕРКА: ID договора не должен быть пустым
if (empty($contractId)) {
    die("Ошибка: ID договора не передан. Невозможно выполнить операцию.");
}

// Формируем запрос с экранированными данными (используем подготовленные запросы для безопасности)
$query = "UPDATE `contract_details`
            SET `practice_code` = ?, `shifr_gr` = ?, `quantity` = ?
            WHERE `id` = ?";
$stmt = $mysql->prepare($query);
$stmt->bind_param("ssii", $practice_code, $group, $quantity, $groupId);

// Выполняем запрос и проверяем результат
if ($stmt->execute()) {
    echo "Запись успешно обновлена в базе данных!";
    echo "Договор № $contractId";
    // Редирект на страницу договора с корректным ID
    header("Refresh: 0; url=collective-details.php?id=$contractId");
} else {
    echo "Ошибка при обновлении записи: " . $mysql->error;
}

$stmt->close();
$mysql->close();
?>

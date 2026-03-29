<?php
// Устанавливаем кодировку для корректного отображения кириллицы
header('Content-Type: text/html; charset=utf-8');

$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");

// Получаем и записываем каждую переменную из POST‑запроса в отдельную переменную
$id = isset($_POST['id']) ? $_POST['id'] : null;
$practice_code = isset($_POST['practice_code']) ? $_POST['practice_code'] : null;
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;
$group = isset($_POST['group']) ? $_POST['group'] : null;

// Выводим значения переменных (просто текст, без оформления)
echo "id: " . $id . "\n";
echo "practice_code: " . $practice_code . "\n";
echo "quantity: " . $quantity . "\n";
echo "group: " . $group . "\n";

// Экранируем данные для защиты от SQL‑инъекций
$id_safe = $mysql->real_escape_string($id);
$practice_code_safe = $mysql->real_escape_string($practice_code);
$quantity_safe = $mysql->real_escape_string($quantity);
$group_safe = $mysql->real_escape_string($group);

// Сначала получаем Shifr_spec для указанной группы
$getSpecQuery = "SELECT G.Shifr_gr, G.Shifr_spec
                  FROM `group` G
                  INNER JOIN speciality S ON S.Shifr_spec = G.Shifr_spec
                  WHERE G.Shifr_gr = '$group_safe'";
$specResult = $mysql->query($getSpecQuery);

if (!$specResult) {
    echo "\nОшибка при получении специальности для группы: " . $mysql->error;
    exit;
}

if ($specResult->num_rows == 0) {
    echo "\nОшибка: группа '$group' не найдена в базе данных";
    exit;
}

$specRow = $specResult->fetch_assoc();
$shifr_spec_safe = $mysql->real_escape_string($specRow['Shifr_spec']);

echo "\nНайденная специальность для группы: " . $specRow['Shifr_spec'] . "\n";

// Формируем запрос с экранированными данными, включая Shifr_spec
$query = "INSERT INTO `contract_details`
        (`contract_code`, `practice_code`, `shifr_gr`, `quantity`, `Shifr_spec`)
        VALUES ('$id_safe', '$practice_code_safe', '$group_safe', '$quantity_safe', '$shifr_spec_safe')";

echo "\n\nВыполняемый запрос:\n$query";

// Выполняем запрос и проверяем результат
if ($mysql->query($query)) {
    echo "\nЗапись успешно добавлена в базу данных!";
    header("Refresh: 0; url=collective-details.php?id=$id");
    exit; // Обязательно добавляем exit после header, чтобы скрипт остановился
} else {
    echo "\nОшибка при добавлении записи: " . $mysql->error;
}
?>

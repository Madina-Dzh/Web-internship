<?php
// Устанавливаем кодировку для корректного отображения кириллицы
header('Content-Type: text/html; charset=utf-8');

$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");

// Получаем и записываем каждую переменную из POST‑запроса в отдельную переменную
$id = isset($_POST['id']) ? $_POST['id'] : null;
$practice_code = isset($_POST['practice_code']) ? $_POST['practice_code'] : null;
$student = isset($_POST['student']) ? $_POST['student'] : null;
$Shifr_spec = isset($_POST['Shifr_spec']) ? $_POST['Shifr_spec'] : null;

// Выводим значения переменных (просто текст, без оформления)
echo "id: " . $id . "\n";
echo "practice_code: " . $practice_code . "\n";
echo "student: " . $student . "\n";
echo "Shifr_spec: " . $Shifr_spec . "\n";

// Экранируем данные для защиты от SQL‑инъекций
$id_safe = $mysql->real_escape_string($id);
$practice_code_safe = $mysql->real_escape_string($practice_code);
$student_safe = $mysql->real_escape_string($student);
$Shifr_spec_safe = $mysql->real_escape_string($Shifr_spec);

// Формируем и выполняем INSERT
$query = "INSERT INTO `contract_details`
        (`contract_code`, `practice_code`, `Shifr_spec`, `fio`)
VALUES ('$id_safe', '$practice_code_safe', '$Shifr_spec_safe', '$student_safe')";

if (!$mysql->query($query)) {
    die("Ошибка INSERT: " . $mysql->error);
}

// Проверяем статус контракта через JOIN с корректным условием
$checkQuery = "SELECT C.contract_code
              FROM contract_details C INNER JOIN practice P ON P.practice_code = C.practice_code
              WHERE P.end_date > CURRENT_DATE()
              AND C.contract_code = $id_safe
              LIMIT 1";

$result = $mysql->query($checkQuery);
if (!$result) {
    die("Ошибка SELECT: " . $mysql->error);
}

if ($result->num_rows > 0) {
    echo "Дата поздняя — активно\n";
    $updateQuery = "UPDATE `contract`
                  SET `status` = 'active'
                  WHERE contract_code = '$id_safe'";
    if (!$mysql->query($updateQuery)) {
        die("Ошибка UPDATE (active): " . $mysql->error);
    }
} else {
    echo "Дата неудачна — истекший\n";
    $updateQuery = "UPDATE `contract`
                  SET `status` = 'expired'
                  WHERE contract_code = '$id_safe'";
    if (!$mysql->query($updateQuery)) {
        die("Ошибка UPDATE (expired): " . $mysql->error);
    }
}

// Отладка: выводим запросы и результат
echo "\nВыполняемые запросы:\n";
echo "INSERT: $query\n";
echo "SELECT: $checkQuery\n";
echo "Найдено записей: " . $result->num_rows . "\n";

echo "\nЗапись успешно добавлена в базу данных!";
header("Refresh: 0; url=individual-details.php?id=$id");
?>

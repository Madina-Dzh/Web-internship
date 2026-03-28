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

// Формируем запрос с экранированными данными
$query = "INSERT INTO `contract_details`
        (`contract_code`, `practice_code`, `Shifr_spec`, `fio`)
VALUES ('$id_safe', '$practice_code_safe', '$Shifr_spec_safe', '$student_safe')";

echo "\n\nВыполняемый запрос:\n$query";


// Выполняем запрос и проверяем результат
if ($mysql->query($query)) {
    echo "\nЗапись успешно добавлена в базу данных!";
    header("Refresh: 0; url=individual-details.php?id=$id");
} else {
    echo "\nОшибка при добавлении записи: " . $mysql->error;
}
?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");

$errors = [];

// Проверка обязательных полей
if (empty($_POST['Shifr_spec'])) {
    $errors[] = "Специальность обязательна";
}
if (empty($_POST['subject_code'])) {
    $errors[] = "Предмет обязателен";
}
if (empty($_POST['teacher'])) {
    $errors[] = "Преподаватель обязателен";
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
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

// Безопасное получение данных
$Shifr_spec = $mysql->real_escape_string($_POST['Shifr_spec']);
$subject_code = intval($_POST['subject_code']);
$teacher = $mysql->real_escape_string($_POST['teacher']);
$start_date = $mysql->real_escape_string($_POST['start_date']);
$end_date = $mysql->real_escape_string($_POST['end_date']);

// Формируем SQL‑запрос с правильным порядком полей и кавычками
$query = "INSERT INTO `practice`
          (`Shifr_spec`, `subject_code`, `teacher`, `start_date`, `end_date`)
          VALUES ('$Shifr_spec', '$subject_code', '$teacher', '$start_date', '$end_date')";

// Отладочный вывод — раскомментируйте для проверки

echo "Debug - SQL query:\n";
echo $query;
//exit;


if ($mysql->query($query)) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'errors' => ['Ошибка при добавлении практики: ' . $mysql->error]
    ]);
}

$mysql->query("INSERT INTO `user_actions`(`action_text`) VALUES ('Добавлена практика $subject_code')");
$mysql->close();
?>

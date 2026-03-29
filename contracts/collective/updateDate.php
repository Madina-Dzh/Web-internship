<?php
// Устанавливаем кодировку для корректного отображения кириллицы
header('Content-Type: text/html; charset=utf-8');

$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");




// Получаем ID договора из POST
$id = isset($_GET['id']) ? $_GET['id'] : '';
$id_safe = $mysql->real_escape_string($id);

// Загружаем текущую дату начала из БД (для отображения в интерфейсе)
$currentDate = null;
if ($id) {
    $loadQuery = "SELECT start_date FROM contract WHERE contract_code = '$id_safe'";
    $result = $mysql->query($loadQuery);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentDate = $row['start_date'];
    }
}

// Обрабатываем отправку формы — работаем с ПЕРЕДАВАЕМОЙ датой
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sdate'])) {
    $newDateStr = trim($_POST['sdate']);

    // Валидация формата YYYY-mm-dd
    if (!isValidDateString($newDateStr)) {
        // Перенаправляем с сообщением об ошибке
        header("Location: collective-details.php?id=$id&message=Ошибка:%20неверный%20формат%20даты&type=error");
        exit;
    } else {
        // Экранируем для SQL
        $newDateSafe = $mysql->real_escape_string($newDateStr);

        // Обновляем дату в БД
        $updateQuery = "UPDATE contract SET start_date = '$newDateSafe' WHERE contract_code = '$id_safe'";

        if ($mysql->query($updateQuery)) {
            // Успешное обновление — перенаправляем с сообщением успеха
            header("Location: collective-details.php?id=$id&message=Дата%20успешно%20обновлена&type=success");
            exit;
        } else {
            // Ошибка обновления — перенаправляем с сообщением ошибки
            header("Location: collective-details.php?id=$id&message=Ошибка%20при%20обновлении:%20" . urlencode($mysql->error) . "&type=error");
            exit;
        }
    }
}

/**
 * Проверяет, что строка соответствует формату YYYY-mm-dd и является валидной датой
 * @param string $dateStr Строка даты
 * @return bool true, если дата валидна
 */
function isValidDateString($dateStr) {
    // Проверяем формат через регулярное выражение
    if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $dateStr, $matches)) {
        return false;
    }

    // Извлекаем компоненты даты
    $year = (int)$matches[1];
    $month = (int)$matches[2];
    $day = (int)$matches[3];

    // Проверяем, что дата существует (например, не 2026-02-30)
    return checkdate($month, $day, $year);
}

require_once dirname(__DIR__, 2) . '/includes/config.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Планирование коллективного договора</title>
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>form.css">
    <style>
        .success-message { color: green; background: #d4edda; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .error-message { color: red; background: #f8d7da; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body class="site">
    <?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>

    <div class="container">
        <?php include dirname(__DIR__, 2) . '/includes/aside.php'; ?>

        <main class="main-wrapper">
            <div class="form-container">
                <?php echo $message; // Выводим сообщение об успехе/ошибке ?>
                <form class="practice-form" id="practiceForm" action="" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <h2>Изменение даты начала для договора <?php echo htmlspecialchars($id); ?></h2>

            <div class="form-group">
                <label for="sdate">Новая дата (ГГГГ-ММ-ДД):</label>
                <!-- В поле ввода — текущая дата как подсказка, но пользователь может ввести любую -->
                <input type="date" id="sdate" name="sdate"
                       value="<?php print($currentDate) ?>" 
                       pattern="\d{4}-\d{2}-\d{2}"
                       title="Формат: ГГГГ-ММ-ДД"
                       required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Изменить</button>
                <button type="reset" class="btn btn-secondary">Очистить форму</button>
            </div>
        </form>
            </div>
        </main>
    </div>

    <?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
</body>
</html>

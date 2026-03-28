<?php
$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");

// Получаем параметры из URL
$id = isset($_GET['id']) ? $_GET['id'] : '';
$selectedSpec = isset($_GET['Shifr_spec']) ? $_GET['Shifr_spec'] : ''; // Получаем выбранную группу из URL


$query = "SELECT Shifr_spec, Sokrashenie
FROM `speciality`
WHERE 1";
$speciality = $mysql->query($query);

require_once dirname(__DIR__, 2) . '/includes/config.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Планирование коллективного договора</title>
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>form.css">
</head>
<body class="site">
    <?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>

    <div class="container">
        <?php include dirname(__DIR__, 2) . '/includes/aside.php'; ?>

        <main class="main-wrapper">
            <div class="form-container">
                <form class="practice-form" id="practiceForm" action="planning-indDet2.php" method="POST">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
    <!-- ДОБАВЛЕНО: скрытое поле для передачи Shifr_spec -->
    <input type="hidden" name="Shifr_spec" value="<?php echo htmlspecialchars($selectedSpec); ?>">

    <h2>Добавление студента в договор для <?php print($id) ?></h2>

    <div class="form-group">
        <label for="Shifr_spec">Специальность:</label>
        <select id="Shifr_spec" name="Shifr_spec" required>
            <option value="">Выберите специальность</option>
            <?php
                while ($row = mysqli_fetch_array($speciality)) {
                    $isSelected = ($row['Shifr_spec'] === $selectedSpec) ? ' selected' : '';
            // ИСПРАВЛЕНО: исправлено имя поля — было shift_spec, стало Shifr_spec
            echo '<option value="' . htmlspecialchars($row['Shifr_spec']) . '"' . $isSelected . '>'
                 . htmlspecialchars($row['Shifr_spec'] . ' - ' . $row['Sokrashenie']) . '</option>';
                }
            ?>
        </select>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Следующий этап</button>
        <button type="reset" class="btn btn-secondary">Очистить форму</button>
    </div>
</form>
    </div>
</main>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
</body>
</html>

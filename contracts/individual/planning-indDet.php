<?php
$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");

// Получаем параметры из URL
$id = isset($_GET['id']) ? $_GET['id'] : '';
$selectedGroup = isset($_GET['group']) ? $_GET['group'] : ''; // Получаем выбранную группу из URL


$query = "SELECT P.Shifr_gr
FROM `practice` P INNER JOIN `group` G ON G.Shifr_gr = P.Shifr_gr
WHERE 1";
$groups = $mysql->query($query);

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


            <h2>Добавление студента в договор для <?php print($id) ?></h2>

            <div class="form-group">
                <label for="group">Группа:</label>
                <select id="group" name="group" required>
                    <option value="">Выберите группу</option>
            <?php
                while ($row = mysqli_fetch_array($groups)) {
                $isSelected = ($row['Shifr_gr'] === $selectedGroup) ? ' selected' : '';
                echo '<option value="' . htmlspecialchars($row['Shifr_gr']) . '"' . $isSelected . '>'
             . htmlspecialchars($row['Shifr_gr']) . '</option>';
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

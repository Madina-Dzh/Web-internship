<?php
// Получаем параметры из URL (передаются при редактировании)
$groupId = isset($_GET['groupId']) ? intval($_GET['groupId']) : 0;
$practiceCode = isset($_GET['practice_code']) ? htmlspecialchars($_GET['practice_code']) : '';
$group = isset($_GET['group']) ? htmlspecialchars($_GET['group']) : '';
$quantity = isset($_GET['quantity']) ? htmlspecialchars($_GET['quantity']) : '';


// Подключение к БД и запросы остаются без изменений
$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");

$contract_id = isset($_GET['contract_id']) ? $_GET['contract_id'] : '';

// Запросы к БД
$query = "SELECT `practice_code`, `subject_code`, `start_date`, `end_date`, `teacher` FROM `practice`
WHERE DATE(end_date) > CURDATE()";
$practices = $mysql->query($query);

$query = "SELECT `Shifr_gr` FROM `group` WHERE 1";
$groups = $mysql->query($query);

require_once dirname(__DIR__, 2) . '/includes/config.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Планирование коллективного договра</title>
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>form.css">
</head>
<body class="site">
    <?php include dirname(__DIR__, 2) . '/includes/header.php';?>

    <div class="container">
        <?php include dirname(__DIR__, 2) . '/includes/aside.php'; ?>

        <main class="main-wrapper">

            <div class="form-container">

                <form class="practice-form" id="practiceForm" action="update_collDet.php" method="POST">
    <input type="hidden" name="contract_id" value="<?php echo htmlspecialchars($contract_id); ?>">
    <input type="hidden" name="groupId"value="<?php print($groupId) ?>">

    <h2>
        <?php
                echo "Редактирование группы в договоре";
        ?>
    </h2>

    <div class="form-group">
        <label for="group">Группа:</label>
        <select id="group" name="group" required>
            <option value="">Выберите группу</option>
            <?php
                while ($row = mysqli_fetch_array($groups)) {
                    $selected = ($row['Shifr_gr'] === $group) ? ' selected' : '';
            print("<option value='" . htmlspecialchars($row['Shifr_gr']) . "'$selected>" . htmlspecialchars($row['Shifr_gr']) . "</option>");
                }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="practice_code">Практика:</label>
        <select id="practice_code" name="practice_code" required>
            <option value="">Выберите практику</option>
            <?php
                while ($row = mysqli_fetch_array($practices)) {
            $selected = ($row['practice_code'] === $practiceCode) ? ' selected' : '';
            print("<option value='" . htmlspecialchars($row['practice_code']) . "'$selected>" . htmlspecialchars($row['practice_code']) . "</option>");
                }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="quantity">Количество студентов:</label>
        <input type="text" id="quantity" name="quantity"
               value="<?php echo $quantity; ?>" required>
    </div>

    <div class="form-actions">
            <input type="hidden" name="edit_id" value="<?php echo $groupId; ?>">
            <button type="submit" class="btn btn-primary">Обновить запись</button>
        <button type="reset" class="btn btn-secondary">Очистить форму</button>
    </div>
</form>

            </div>
        </main>
    </div>

    <?php
        include dirname(__DIR__, 2) . '/includes/footer.php';
    ?>
</body>

<script>
</script>



</html>
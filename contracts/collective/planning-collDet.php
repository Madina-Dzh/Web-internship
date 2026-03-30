<?php 
$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");

// Получаем параметр 'id' из URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// практики
$query = "SELECT `practice_code`, `subject_code`, `start_date`, `end_date`, `teacher` FROM `practice` 
WHERE DATE(end_date) > CURDATE()";
$practices = $mysql->query($query);

$query = "SELECT `Shifr_gr`
FROM `group` WHERE 1";
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

                <form class="practice-form"  id="practiceForm" action="add_collDet.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                    <h2>Добавление группы в договор № <?php print(str_pad($id, 3, '0', STR_PAD_LEFT)) ?></h2>

                    <div class="form-group">
                        <label for="group">Группа:</label>
                        <select id="group" name="group" required>
                            <option value="">Выберите группу</option> 
                            <?php 
                                while ($row = mysqli_fetch_array($groups)) {
                                    print("<option value='" . $row['Shifr_gr'] . "'>" . $row['Shifr_gr'] . "</option>");
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
                                    print("<option value='" . $row['practice_code'] . "'>" . $row['practice_code'] . "</option>");
                                }
                            ?> 
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Количество студентов:</label>
                        <input type="text" id="quantity" name="quantity" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Добавить договор</button>
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
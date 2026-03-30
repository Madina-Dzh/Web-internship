<?php
header('Content-Type: text/html; charset=utf-8');
$mysql = new mysqli("localhost", "root", "", "internship");

// Проверка подключения к БД
if ($mysql->connect_error) {
    die("Ошибка подключения к БД: " . $mysql->connect_error);
}

$mysql->query("SET NAMES 'utf8'");

$id = isset($_POST['id']) ? $_POST['id'] : null;
$Shifr_spec = isset($_POST['Shifr_spec']) ? $_POST['Shifr_spec'] : null;

// Практики
$query = "SELECT P.practice_code, S.code, P.Shifr_spec AS шифр_специальности, C.Sokrashenie
          FROM practice P
          INNER JOIN subjects_in_cycle S ON S.id = P.subject_code
          INNER JOIN speciality C ON C.Shifr_spec = P.Shifr_spec
WHERE P.Shifr_spec = '$Shifr_spec'";
$practices = $mysql->query($query);

// Студенты
$query = "SELECT S.Nom_stud, S.FIO, S.Shifr_gr
          FROM student S INNER JOIN `group` g ON g.Shifr_gr = s.Shifr_gr
          WHERE G.Shifr_spec = '$Shifr_spec'
          ORDER BY Shifr_gr, S.FIO";
$students = $mysql->query($query);

require_once dirname(__DIR__, 2) . '/includes/config.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Планирование коллективного договора (этап 2)</title>
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>form.css">
</head>
<body class="site">
    <?php include dirname(__DIR__, 2) . '/includes/header.php'; ?>

    <div class="container">
        <?php include dirname(__DIR__, 2) . '/includes/aside.php'; ?>

        <main class="main-wrapper">
            <div class="form-container">
                <form class="practice-form" id="practiceForm" action="add_indDet.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id ?? ''); ?>">
            <input type="hidden" name="Shifr_spec" value="<?php echo $Shifr_spec; ?>">

            <h2>Добавление студента в договор № <?php print(str_pad($id, 3, '0', STR_PAD_LEFT)) ?></h2>

            <!-- Кнопка «Назад» -->
            <div class="form-actions">
                <a href="planning-indDet.php?id=<?php echo urlencode($id ?? ''); ?>&Shifr_spec=<?php echo urlencode($Shifr_spec ?? ''); ?>"
                   >
                    ← Назад к выбору группы
                </a>
            </div>

            <!-- Практика -->
            <div class="form-group">
                <label for="practice_code">Практика:</label>
                <select id="practice_code" name="practice_code" required>
                    <option value="">Выберите практику</option>
            <?php
                if ($practices->num_rows > 0) {
                    while ($row = $practices->fetch_assoc()) {
                echo '<option value="' . htmlspecialchars($row['practice_code'] ?? '') . '">'
             . htmlspecialchars($row['code'] ?? '') . '</option>';
            }
        } else {
            echo '<option value="" disabled>Для группы нет доступных практик</option>';
        }
            ?>
                </select>
            </div>

            <!-- Студент -->
            <div class="form-group">
                <label for="student">Студент:</label>
                <select id="student" name="student" required>
            <option value="">Выберите студента группы <?php echo htmlspecialchars($group ?? ''); ?></option>
            <?php
                if ($students->num_rows > 0) {
            while ($row = $students->fetch_assoc()) {
                echo '<option value="' . htmlspecialchars($row['FIO'] ?? '') . '">'
             . htmlspecialchars($row['Shifr_gr'] ?? '') . " - " . htmlspecialchars($row['FIO'] ?? '') . '</option>';
            }
        } else {
            echo '<option value="" disabled>В группе нет студентов</option>';
        }
            ?>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Добавить договор</button>
                <button type="reset" class="btn btn-secondary">Очистить форму</button>
            </div>
        </form>
    </div>
</main>
</div>

<?php include dirname(__DIR__, 2) . '/includes/footer.php'; ?>
</body>
</html>

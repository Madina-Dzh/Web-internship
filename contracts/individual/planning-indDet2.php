<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

header('Content-Type: text/html; charset=utf-8');
$mysql = new mysqli("localhost", "root", "", "internship");

// Проверка подключения к БД
if ($mysql->connect_error) {
    die("Ошибка подключения к БД: " . $mysql->connect_error);
}

$mysql->query("SET NAMES 'utf8'");

$id = isset($_POST['id']) ? $_POST['id'] : null;
$group = isset($_POST['group']) ? $_POST['group'] : null;

// Практики
$query = "SELECT P.practice_code, S.code, P.Shifr_gr
          FROM practice P
          INNER JOIN subjects_in_cycle S ON S.id = P.subject_code
          WHERE P.Shifr_gr = ?";
$stmt = $mysql->prepare($query);
$stmt->bind_param("s", $group);
$stmt->execute();
$practices = $stmt->get_result();

// Студенты
$query = "SELECT Nom_stud, FIO, Shifr_gr
          FROM student
          WHERE Shifr_gr = ?";
$stmt = $mysql->prepare($query);
$stmt->bind_param("s", $group);
$stmt->execute();
$students = $stmt->get_result();

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
                <form class="practice-form" id="practiceForm" action="add-indDet.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id ?? ''); ?>">
            <input type="hidden" name="group" value="<?php echo htmlspecialchars($group ?? ''); ?>">

            <h2>Добавление студента в договор для <?php echo htmlspecialchars($id ?? ''); ?></h2>

            <!-- Кнопка «Назад» -->
            <div class="form-actions">
                <a href="planning-indDet.php?id=<?php echo urlencode($id ?? ''); ?>&group=<?php echo urlencode($group ?? ''); ?>"
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
                echo '<option value="' . htmlspecialchars($row['Nom_stud'] ?? '') . '">'
             . htmlspecialchars($row['FIO'] ?? '') . '</option>';
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

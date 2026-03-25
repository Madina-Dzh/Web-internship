<?php 
$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");

// Предметы
$query = "SELECT `id`, `code`
FROM `subjects_in_cycle` 
WHERE title LIKE '%практика%' OR title LIKE '%ПРАКТИКА%'";
$subjects = $mysql->query($query);

// Преподаватели
$query = "SELECT `Tab_nom`, `FIO`
FROM `teacher` 
WHERE 1
ORDER BY FIO";
$teachers = $mysql->query($query);

$query = "SELECT `Shifr_spec`, Sokrashenie FROM `speciality` WHERE 1";
$speciality = $mysql->query($query);

require_once '../includes/config.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Планирование практик</title>
    <link rel="stylesheet" href="<?php echo CSS_URL;?>form.css">
</head>
<body class="site">
    <?php
        include '../includes/header.php';
    ?>

    <div class="container">
        <?php include '../includes/aside.php'; ?>

        <main class="main-wrapper">
            <!-- Вкладки -->
            <div class="tabs">
                <a href="./active-practices.php" class="tab">Активные</a>
                <a href="./expired-practices.php" class="tab">Архив</a>
                <a href="./planning-practices.php" class="tab active">Планирование</a>
            </div>

            <!-- Форма добавления практики -->
            <div class="form-container">
                <!-- Сообщения об успехе/ошибке (заглушки) 
                <div class="alert alert-success">Практика успешно добавлена!</div>
                <div class="alert alert-error">Ошибка при добавлении практики</div>-->

                <form class="practice-form"  id="practiceForm" action="add_practice.php" method="POST">
                    <h2>Добавление новой практики</h2>

            <!-- Форма добавления практики -->
            <div class="form-group">
                <label for="Shifr_spec">Специальность:</label>
                <select id="Shifr_spec" name="Shifr_spec" required>
                    <option value="">Выберите Специальность</option> 
                    <?php 
                        while ($row = mysqli_fetch_array($speciality)) {
                            print("<option value='" . $row['Shifr_spec'] . "'>" . $row['Sokrashenie'] . "</option>");
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="subject_code">Предмет:</label>
                <select id="subject_code" name="subject_code" required>
                    <option value="">Выберите предмет</option> 
                    <?php 
                        while ($row = mysqli_fetch_array($subjects)) {
                            print("<option value='" . $row['id'] . "'>" . $row['code'] . "</option>");
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="teacher">Преподаватель:</label>
                <select id="teacher" name="teacher" required>
                    <option value="">Выберите преподавателя</option>
                    <?php 
                        while ($row = mysqli_fetch_array($teachers)) {
                            print("<option value='" . $row['Tab_nom'] . "'>" . $row['FIO'] . "</option>");
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="start_date">Дата начала:</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>

            <div class="form-group">
                <label for="end_date">Дата окончания:</label>
                <input type="date" id="end_date" name="end_date" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Добавить практику</button>
                <button type="reset" class="btn btn-secondary">Очистить форму</button>
            </div>
        </form>
    </div>
</main>
    </div>

    <?php
        include '../includes/footer.php';
    ?>
</body>

<script>
document.getElementById('practiceForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Отменяем стандартную отправку формы

    const formData = new FormData(this);

    fetch('add_practice.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const alertContainer = document.querySelector('.form-container');

        // Удаляем предыдущие сообщения
        const existingAlerts = alertContainer.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());

        if (data.success) {
            // Показываем сообщение об успехе
            const successAlert = document.createElement('div');
            successAlert.className = 'alert alert-success';
            successAlert.textContent = 'Практика успешно добавлена!';
            alertContainer.insertBefore(successAlert, this); // ОШИБКА: такого метода нет

            // Правильный вариант:
            alertContainer.prepend(successAlert); // Вставляем в начало контейнера

            // Очищаем форму
            this.reset();
        } else {
            // Показываем ошибки
            data.errors.forEach(error => {
                const errorAlert = document.createElement('div');
                errorAlert.className = 'alert alert-error';
                errorAlert.textContent = error;
                alertContainer.prepend(errorAlert); // Вставляем перед формой
            });
        }
    })
    .catch(error => {
        console.error('Ошибка:', error);
        const alertContainer = document.querySelector('.form-container');
        const errorAlert = document.createElement('div');
        errorAlert.className = 'alert alert-error';
        errorAlert.textContent = 'Произошла непредвиденная ошибка';
        alertContainer.prepend(errorAlert);
    });
});
</script>



</html>
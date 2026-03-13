<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Планирование практик</title>
    <link rel="stylesheet" href="./css/form.css">
</head>
<body class="site">
    <?php
        include 'includes/header.php';
    ?>

    <div class="container">
        <?php include 'includes/aside.php'; ?>

        <main class="main-wrapper">
            <!-- Вкладки -->
            <div class="tabs">
                <a href="./active-practices.php" class="tab">Активные</a>
                <a href="./expired-practices.php" class="tab">Архив</a>
                <a href="./planning.php" class="tab active">Планирование</a>
            </div>

            <!-- Форма добавления практики -->
            <div class="form-container">
                <!-- Сообщения об успехе/ошибке (заглушки) 
                <div class="alert alert-success">Практика успешно добавлена!</div>
                <div class="alert alert-error">Ошибка при добавлении практики</div>-->

                <form class="practice-form">
                    <h2>Добавление новой практики</h2>

                    <div class="form-group">
                <label for="practice_code">Номер практики:</label>
                <input type="text" id="practice_code" name="practice_code" required>
            </div>

            <div class="form-group">
                <label for="subject_code">Предмет:</label>
                <select id="subject_code" name="subject_code" required>
                    <option value="">Выберите предмет</option>
                    <option value="1">МАТ-001 - Математика</option>
            <option value="2">ФИЗ-002 - Физика</option>
            <option value="3">ИНФ-003 - Информатика</option>
                </select>
            </div>

            <div class="form-group">
                <label for="teacher">Преподаватель:</label>
                <select id="teacher" name="teacher" required>
                    <option value="">Выберите преподавателя</option>
            <option value="101">Иванов И.И.</option>
            <option value="102">Петров П.П.</option>
            <option value="103">Сидоров С.С.</option>
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
        include 'includes/footer.php';
    ?>
</body>
</html>
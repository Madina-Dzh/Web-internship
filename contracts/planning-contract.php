<?php 
$mysql = new mysqli("localhost", "root", "", "internship");
$mysql->query("SET NAMES 'utf8'");
$query = "SELECT organization_code, title
FROM organization";
$organizations = $mysql->query($query);

require_once dirname(__DIR__) . '/includes/config.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Планирование практик</title>
    <link rel="stylesheet" href="<?php echo CSS_URL ?>form.css">
</head>
<body class="site">
    <?php
        include '../includes/header.php';
    ?>

    <div class="container">
        <?php include '../includes/aside.php'; ?>

        <main class="main-wrapper">

            <!-- Форма добавления практики -->
            <div class="form-container">
                <!-- Сообщения об успехе/ошибке (заглушки) 
                <div class="alert alert-success">Практика успешно добавлена!</div>
                <div class="alert alert-error">Ошибка при добавлении практики</div>-->

                <form class="practice-form"  id="practiceForm" action="add_contract.php" method="POST">
                    <h2>Добавление нового договора</h2>

                    <div class="form-group">
                        <label for="contract_code">Номер договора:</label>
                        <input type="text" id="contract_code" name="contract_code" required>
                    </div>

                    <div class="form-group">
                        <label for="organization_code">Организация:</label>
                        <select id="organization_code" name="organization_code" required>
                            <option value="">Выберите организацию</option> 
                            <?php 
                                while ($row = mysqli_fetch_array($organizations)) {
                                    print("<option value='" . $row['organization_code'] . "'>" . $row['title'] . "</option>");
                                }
                            ?> 
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="type">Тип организации:</label>
                        <select id="type" name="type" required>
                            <option value="индивидуальный">индивидуальный</option> 
                            <option value="коллективный">коллективный</option>
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
                        <button type="submit" class="btn btn-primary">Добавить договор</button>
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

</html>
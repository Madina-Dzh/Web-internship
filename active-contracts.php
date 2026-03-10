<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <link rel="stylesheet" href="./css/contracts.css">
</head>
<body class="site">
    <?php
        include 'includes/header.php';
    ?>
    <div class="container">
        <?php include 'includes/aside.php'; ?>
        <div class="main-wrapper">
            <!-- Вкладки -->
            <div class="tabs">
                <a href="./active-contracts.php" class="tab active">Активные</a>
                <a href="#expired.html" class="tab">Истекшие</a>
                <a href="#drafts.html" class="tab">Черновики</a>
            </div>

            <!-- Таблица договоров -->
            <div class="table-wrapper">
                <table class="contracts-table">
                    <thead>
                        <tr>
                            <th>Номер</th>
                            <th>Организация</th>
                            <th>Дата начала</th>
                            <th>Дата конца</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>001</td>
                            <td>ООО «ТехноСервис»</td>
                            <td>15.03.2024</td>
                            <td>15.03.2025</td>
                            <td class="status active">Действует</td>
                            <td><button class="details-btn" onclick="goToDetails('001')">Детали</button></td>
                        </tr>
                        <tr>
                            <td>002</td>
                            <td>АО «ПромСтрой»</td>
                            <td>20.01.2024</td>
                            <td>20.01.2026</td>
                            <td class="status active">Действует</td>
                            <td><button class="details-btn" onclick="goToDetails('002')">Детали</button></td>
                        </tr>
                        <tr>
                            <td>003</td>
                            <td>ИП Иванов А.С.</td>
                            <td>10.02.2023</td>
                            <td>10.02.2024</td>
                            <td class="status expired">Не действует</td>
                            <td><button class="details-btn" onclick="goToDetails('003')">Детали</button></td>
                        </tr>
                        <tr>
                            <td>004</td>
                            <td>ЗАО «МегаПроект»</td>
                            <td>05.05.2024</td>
                            <td>05.05.2027</td>
                            <td class="status active">Действует</td>
                            <td><button class="details-btn" onclick="goToDetails('004')">Детали</button></td>
                        </tr>
                        <tr>
                            <td>005</td>
                            <td>ООО «СтройГарант»</td>
                            <td>12.04.2023</td>
                            <td>12.04.2024</td>
                            <td class="status expired">Не действует</td>
                            <td><button class="details-btn" onclick="goToDetails('005')">Детали</button></td>
                        </tr>
                        <tr>
                            <td>006</td>
                            <td>ПАО «ЭнергоРесурс»</td>
                            <td>30.06.2024</td>
                            <td>30.06.2025</td>
                            <td class="status active">Действует</td>
                            <td><button class="details-btn" onclick="goToDetails('006')">Детали</button></td>
                        </tr>
                        <tr>
                            <td>007</td>
                            <td>ООО «Новые Технологии»</td>
                            <td>18.07.2024</td>
                            <td>18.07.2026</td>
                            <td class="status active">Действует</td>
                            <td><button class="details-btn" onclick="goToDetails('007')">Детали</button></td>
                        </tr>
                        <tr>
                            <td>008</td>
                            <td>ИП Сидоров В.П.</td>
                            <td>25.08.2023</td>
                            <td>25.08.2024</td>
                            <td class="status expired">Не действует</td>
                            <td><button class="details-btn" onclick="goToDetails('008')">Детали</button></td>
                        </tr>
                        <tr>
                            <td>009</td>
                            <td>АО «Финансовый Центр»</td>
                            <td>01.09.2024</td>
                            <td>01.09.2025</td>
                            <td class="status active">Действует</td>
                            <td><button class="details-btn" onclick="goToDetails('009')">Детали</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Футер таблицы с кнопками и счётчиком -->
            <div class="table-footer">
                <div class="actions">
                    <button class="action-btn delete">Удалить договор</button>
                    <button class="action-btn add">Добавить договор с организацией</button>
                    <button class="action-btn edit">Изменить договор</button>
                </div>
                <div class="record-count">Записей: 9</div>
            </div>
        </div>
    </div>
    <?php
        include 'includes/footer.php';
    ?>
</body>
</html>

<?php

use function PHPSTORM_META\type;

    $mysql = new mysqli("localhost", "root", "", "internship");
    $mysql->query("SET NAMES 'utf8'");

    $query = "SELECT C.contract_code AS Номер, O.title AS Организация, C.start_date AS Дата_начала, C.end_date AS Дата_конца, C.type AS Тип
    FROM Organization O INNER JOIN Contract C ON C.organization_code = O.organization_code
    WHERE c.status = 'draft'
    ORDER BY Номер";

    $dreaftContract = $mysql->query($query);
    $row_cnt = $dreaftContract->num_rows;

    require_once dirname(__DIR__) . '/includes/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Черновики договоров</title>
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>contracts.css">
</head>
<body class="site">
    <?php
        include '../includes/header.php';
    ?>
    <div class="container">
        <?php include '../includes/aside.php'; ?>
        <div class="main-wrapper">
            <!-- Вкладки -->
            <div class="tabs">
                <a href="./active-contracts.php" class="tab">Активные</a>
                <a href="./expired-contracts.php" class="tab">Истекшие</a>
                <a href="./draft-contract.php" class="tab active">Черновики</a>
            </div>

            <!-- Таблица договоров -->
            <div class="table-wrapper">
                <?php
echo "<table class='contracts-table'>
    <thead>
        <tr>
            <th class='radio'></th>
            <th>Номер</th>
            <th>Организация</th>
            <th>Дата начала</th>
            <th>Дата конца</th>
            <th>Тип</th>
            <th>Действия</th>
        </tr>
    </thead>";
while ($row = mysqli_fetch_array($dreaftContract)) {
    $type = $row['Тип'];
    if ($type == "коллективный") {
        print("<tr data-id='" . htmlspecialchars($row['Номер']) . "'>
              <td class='radio'><input type='radio' name='groupContract'></td>
              <td>" . str_pad($row['Номер'], 3, '0', STR_PAD_LEFT) . "</td>
              <td>" . htmlspecialchars($row['Организация']) . "</td>
              <td>" . date('d.m.Y', strtotime($row['Дата_начала'])) . "</td>
              <td>" . date('d.m.Y', strtotime($row['Дата_конца'])) . "</td>
              <td>" . $type ."</td>
              <td>
                  <button class='details-btn' onclick=".'"' . "window.location.href = '" . CONTRACTS_URL . "collective/collective-details.php?id=" . rawurlencode($row['Номер']) . "'" .'"'  .">Детали</button>
              </td>
          </tr>");
    }
    else {
        print("<tr data-id='" . htmlspecialchars($row['Номер']) . "'>
              <td class='radio'><input type='radio' name='groupContract'></td>
              <td>" . str_pad($row['Номер'], 3, '0', STR_PAD_LEFT) . "</td>
              <td>" . htmlspecialchars($row['Организация']) . "</td>
              <td>" . date('d.m.Y', strtotime($row['Дата_начала'])) . "</td>
              <td>" . date('d.m.Y', strtotime($row['Дата_конца'])) . "</td>
              <td>" . $type ."</td>
              <td>
                <button class='details-btn' onclick=".'"' . "window.location.href = '" . CONTRACTS_URL . "individual/individual-details.php?id=" . rawurlencode($row['Номер']) . "'" .'"'  .">Детали</button>              </td>
          </tr>");
    }
    
}
echo "</table>";
?>
                
            </div>

            <!-- Футер таблицы с кнопками и счётчиком -->
            <div class="table-footer">
                <div class="actions">
                    <a href="./planning-contract.php"><button class="action-btn add">Добавить договор с организацией</button></a>
                </div>
                <div class="record-count">Записей: <?php print($row_cnt) ?></div>
            </div>
        </div>
    </div>
    <?php
        include '../includes/footer.php';
    ?>
</body>
</html>

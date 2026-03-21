<?php 
require_once dirname(__DIR__) . '/includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aside</title>
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>aside.css">
</head>
<body>
    <aside class="sidebar">
  <nav class="sidebar-nav">
    <ul class="nav-list">
      <li>
        <a href="http://localhost/test/index.php" class="nav-link">Дашборд</a>
      </li>

      <li>
        <details open>
          <summary class="nav-link nav-link--parent">Практики</summary>
          <ul class="submenu">
            <li><a href="<?php echo PRACTICES_URL; ?>active-practices.php" class="submenu-link">Активные</a></li>
            <li><a href="<?php echo PRACTICES_URL; ?>expired-practices.php" class="submenu-link">Архив</a></li>
            <li><a href="<?php echo PRACTICES_URL; ?>planning-practices.php" class="submenu-link">Планирование</a></li>
          </ul>
        </details>
      </li>

      <li>
        <details open>
          <summary class="nav-link nav-link--parent">Договоры</summary>
          <ul class="submenu">
            <li><a href="<?php echo CONTRACTS_URL; ?>active-contracts.php" class="submenu-link">Активные</a></li>
            <li><a href="<?php echo CONTRACTS_URL; ?>expired-contracts.php" class="submenu-link">Истекшие</a></li>
            <li><a href="<?php echo CONTRACTS_URL; ?>draft-contract.php" class="submenu-link">Черновики</a></li>
          </ul>
        </details>
      </li>

      <li>
        <details open>
          <summary class="nav-link nav-link--parent">Справочники</summary>
          <ul class="submenu">
            <li><a href="<?php echo REFERENCES_URL; ?>organizations.php" class="submenu-link">Организации</a></li>
            <li><a href="<?php echo REFERENCES_URL; ?>groups.php" class="submenu-link">Группы</a></li>
            <li><a href="<?php echo REFERENCES_URL; ?>specialities.php" class="submenu-link">Специальности</a></li>
          </ul>
        </details>
      </li>
    </ul>
  </nav>

  <button class="add-btn">Добавить</button>
</aside>
</body>
</html>
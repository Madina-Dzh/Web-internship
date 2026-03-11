<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aside</title>
    <link rel="stylesheet" href="./css/aside.css">
</head>
<body>
    <aside class="sidebar">
  <nav class="sidebar-nav">
    <ul class="nav-list">
      <li>
        <a href="./index.php" class="nav-link">Дашборд</a>
      </li>

      <li>
        <details open>
          <summary class="nav-link nav-link--parent">Практики</summary>
          <ul class="submenu">
            <li><a href="./active-practices.php" class="submenu-link">Активные</a></li>
            <li><a href="./expired-practices.php" class="submenu-link">Архив</a></li>
            <li><a href="#draft-practices" class="submenu-link">Планирование</a></li>
          </ul>
        </details>
      </li>

      <li>
        <details open>
          <summary class="nav-link nav-link--parent">Договоры</summary>
          <ul class="submenu">
            <li><a href="./active-contracts.php" class="submenu-link">Активные</a></li>
            <li><a href="./expired-contracts.php" class="submenu-link">Истекшие</a></li>
            <li><a href="#draft-contracts" class="submenu-link">Черновики</a></li>
          </ul>
        </details>
      </li>

      <li>
        <details open>
          <summary class="nav-link nav-link--parent">Справочники</summary>
          <ul class="submenu">
            <li><a href="./organizations.php" class="submenu-link">Организации</a></li>
            <li><a href="#groups" class="submenu-link">Группы</a></li>
            <li><a href="#programs" class="submenu-link">Программы</a></li>
            <li><a href="#practices-ref" class="submenu-link">Практики</a></li>
            <li><a href="#specialties" class="submenu-link">Специальности</a></li>
          </ul>
        </details>
      </li>
    </ul>
  </nav>

  <button class="add-btn">Добавить</button>
</aside>
</body>
</html>
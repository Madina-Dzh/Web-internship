<?php 
require_once dirname(__DIR__) . '/includes/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>footer.css">
</head>
<body>
    <footer class="main-footer">
    <div class="footer-container">
        <div class="footer-section">
            <h3 class="footer-title">О разработчике</h3>
            <p class="footer-text">Студент факультета среднего профессионального образования</p>
            <p class="footer-text">Орский гуманитарно‑технологический институт</p>
        </div>

        <div class="footer-section">
            <h3 class="footer-title">Контакты</h3>
            <div class="contact-item">
                <span class="contact-icon">📞</span>
                <a href="tel:+79225522682" class="contact-link">+7 (922) 552-26-82</a>
            </div>
            <div class="contact-item">
                <span class="contact-icon">✉️</span>
                <a href="mailto:developer@example.com" class="contact-link">madinadzhanaeva670@gmail.com</a>
            </div>
        </div>

        <div class="footer-section">
            <h3 class="footer-title">Профиль разработчика</h3>
            <div class="contact-item">
                <span class="contact-icon">💻</span>
                <a href="https://github.com/Madina-Dzh" class="contact-link github-link" target="_blank">GitHub: Madina-Dzh</a>
            </div>
        </div>

        <div class="footer-section footer-copyright">
            <p class="footer-text">&copy; 2026 ПрактиДог. Все права защищены.</p>
            <p class="footer-text">Онлайн платформа управления договорами производственной практики студентов факультета среднего профессионального образования</p>
        </div>
    </div>
</footer>
</body>
</html>
<?php
// Укажите ваш email, куда должны приходить заявки
$to = "mnd12518@gmail.com"; 
$subject = "Новая заявка с сайта (Заказ услуг)";

// Настройка кодировки и заголовков
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "From: Заявки с сайта <https://yung6ix6ix6ix.github.io/CopyPastPro.github.io/>\r\n";

// Проверка защиты Honeypot (если скрытое поле заполнено ботом — блокируем)
if (!empty($_POST['honeypot'])) {
    die("Spam detected");
}

// Проверяем, что форма была отправлена методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Получаем и очищаем данные из формы
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : '';
    $service = isset($_POST['service']) ? htmlspecialchars(trim($_POST['service'])) : '';
    $comment = isset($_POST['comment']) ? htmlspecialchars(trim($_POST['comment'])) : '';

    // Проверяем обязательные поля
    if (!empty($name) && !empty($phone) && !empty($service)) {
        
        // Формируем красивое HTML-письмо
        $message = "
        <h2>Новая заявка на услугу</h2>
        <p><strong>Имя:</strong> {$name}</p>
        <p><strong>Телефон:</strong> {$phone}</p>
        <p><strong>Выбранная услуга:</strong> {$service}</p>
        <p><strong>Комментарий к заказу:</strong><br>" . nl2br($comment) . "</p>
        ";

        // Отправка письма
        if (mail($to, $subject, $message, $headers)) {
            // Перенаправление на страницу «Спасибо» или вывод сообщения
            echo "<h3>Спасибо! Ваша заявка успешно отправлена.</h3>";
            echo "<script>setTimeout(function(){ window.location.href = '/'; }, 3000);</script>";
        } else {
            echo "<h3>Ошибка отправки. Пожалуйста, попробуйте позже.</h3>";
        }
    } else {
        echo "<h3>Пожалуйста, заполните все обязательные поля.</h3>";
    }
} else {
    echo "<h3>Доступ запрещен.</h3>";
}
?>

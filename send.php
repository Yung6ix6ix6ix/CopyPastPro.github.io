<?php
// ====== НАСТРОЙКИ ======
$to = 'mnd12518@gmail.com'; // СЮДА впишите вашу почту
$from_email = 'https://yung6ix6ix6ix.github.io/CopyPastPro.github.io/'; // Почта/домен вашего сайта
$from_name = 'Заявка с сайта';
$subject = 'Новая заявка с сайта';

// ====== ЗАЩИТА И ДАННЫЕ ======
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /');
    exit;
}

// Антиспам: скрытое поле должно остаться пустым
if (!empty($_POST['honeypot'])) {
    header('Location: /?status=spam');
    exit;
}

function clean($value) {
    return trim(strip_tags($value ?? ''));
}

$name = clean($_POST['name'] ?? '');
$phone = clean($_POST['phone'] ?? '');
$service = clean($_POST['service'] ?? '');
$comment = clean($_POST['comment'] ?? '');

if ($name === '' || $phone === '' || $service === '') {
    header('Location: /?status=error');
    exit;
}

// ====== ПИСЬМО ======
$message = "Новая заявка с сайта\n\n";
$message .= "Имя: {$name}\n";
$message .= "Телефон: {$phone}\n";
$message .= "Услуга: {$service}\n";
$message .= "Комментарий: " . ($comment !== '' ? $comment : '—') . "\n";
$message .= "Дата: " . date('d.m.Y H:i') . "\n";

$encoded_subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

$headers = "From: =?UTF-8?B?" . base64_encode($from_name) . "?= <{$from_email}>\r\n";
$headers .= "Reply-To: {$from_email}\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "Content-Transfer-Encoding: 8bit\r\n";

$sent = mail($to, $encoded_subject, $message, $headers);

// ====== ПЕРЕНАПРАВЛЕНИЕ ======
if ($sent) {
    header('Location: /?status=success#zayavka');
} else {
    header('Location: /?status=error#zayavka');
}
exit;
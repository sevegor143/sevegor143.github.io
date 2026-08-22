<?php
$to = "koleso.effectivnosti@gmail.com";

// Собираем данные
$name      = $_POST['Name']      ?? '';
$position  = $_POST['Position']  ?? '';
$phone     = $_POST['Phone']     ?? '';
$email     = $_POST['Email']     ?? '';
$company   = $_POST['Company']   ?? '';
$industry  = $_POST['Industry']  ?? '';
$employees = $_POST['Employees'] ?? '';
$package   = $_POST['Package']   ?? '';
$problems  = $_POST['Problems']  ?? '';
$services  = isset($_POST['Services']) ? implode(", ", $_POST['Services']) : '';
$time      = $_POST['ContactTime'] ?? '';
$source    = $_POST['source']     ?? 'brief';

// ВАЛИДАЦИЯ: телефон ИЛИ email
if (empty($phone) && empty($email)) {
    echo "<script>alert('Пожалуйста, укажите телефон или email, чтобы мы могли с вами связаться.'); history.back();</script>";
    exit;
}

// Формируем письмо
$subject = "Новая заявка с сайта — " . ($source === 'checklist' ? 'Чек-лист' : 'Бриф');
$message = "Источник: $source\n\n";
$message .= "Имя: $name\n";
$message .= "Должность: $position\n";
$message .= "Телефон: $phone\n";
$message .= "Email: $email\n";
$message .= "Компания: $company\n";
$message .= "Отрасль: $industry\n";
$message .= "Сотрудников: $employees\n";
$message .= "Пакет: $package\n";
$message .= "Проблемы: $problems\n";
$message .= "Услуги: $services\n";
$message .= "Удобное время: $time\n";

// Отправляем
$headers = "From: noreply@koleso-effect.ru\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

mail($to, $subject, $message, $headers);

// Возвращаем пользователя на сайт
if ($source === 'checklist') {
    header("Location: https://ВАШ_НИК.github.io/Checklist.html?sent=1");
} elseif ($source === 'contacts') {
    header("Location: https://ВАШ_НИК.github.io/contacts.html?sent=1");
} else {
    header("Location: https://ВАШ_НИК.github.io/index.html?sent=1#brief");
}
exit;
?>
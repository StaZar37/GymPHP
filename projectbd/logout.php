<?php

require_once 'includes/auth.php'; // Підключення потрібних файлів з певними налаштуваннями 

if (is_login()) { // Якщо користувач увійшов у систему
    unset($_SESSION['user']); // Видаляється з сесії
}
header('Location: ./index.php'); // Перенаправлення на головну
exit(); 

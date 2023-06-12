<?php
// Файл підключення до бж
// У цьому рядку значення змінної $_SERVER['REQUEST_URI'], яке містить поточний шлях до сторінки, присвоюється змінній 
$_SESSION['last_uri'] = $_SERVER['REQUEST_URI'];
// В цьому рядку значення $_SESSION['last_uri'] копіюється в $_SESSION['last_uri2']. Це зберігає копію останнього відвіданого URI в іншій змінній сеансу
$_SESSION['last_uri2'] = $_SESSION['last_uri'];
// Константи бази даних
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "lab4");


// Ці рядки встановлюють параметри обробки помилок. В даному випадку, display_errors встановлюється на 0, що означає, що помилки не будуть відображатись на екрані. error_reporting також встановлюється на 0, що вимикає звіт про помилки.
ini_set("display_errors", 0);
error_reporting(0);

<?php

// Отримання даних для автоматичного виведення повної ціни
session_start(); // Початок сесії, щоб можна було звернутися до глобального масиву $_SESSION
require_once("includes/connection.php"); // Підключення файлу з налаштуваннями
if (isset($_POST['value1']) && isset($_POST['value2']) && isset($_POST['value3']) && isset($_POST['value4'])) { // Якщо перше значення встановлене у файлі create
    $value1 = $_POST['value1']; // Отримання значення, що встановлюється в у файлі create (ПІБ тренера)
    $value2 = $_POST['value2']; // Отримання значення, що встановлюється в у файлі create (Вид тренувань)
    $value3 = $_POST['value3']; // Отримання значення, що встановлюється в у файлі create (Строк страховки в місяцях)
    $value4 = $_POST['value4']; // Отримання значення, що встановлюється в у файлі create (Кількість занять)

    $sql1 = mysqli_query($con, "SELECT trainer_price FROM trainer WHERE trainer_fio = '$value1'"); // Запит до бд, отримання ціни тренера в залежності від його ПІБ
    $row1 = mysqli_fetch_assoc($sql1); // Перетворення запиту $sql1 у асоціативний масив
    $sql2 = mysqli_query($con, "SELECT service_price FROM service WHERE service_type = '$value2'"); // Запит до бд, отримання ціни послуги в залежності від його виду
    $row2 = mysqli_fetch_assoc($sql2); // Перетворення запиту $sql2 у асоціативний масив
    $trainer_price = $row1['trainer_price']; // Створення змінної з ціною тренування з тренером
    $service_price = $row2['service_price']; // Створення змінної з ціною послуги



    $val = ($trainer_price + $service_price) * $value4 + $value3 * 200; // Остаточна ціна, порахована за формулою
    $_SESSION['val'] = $val; // Додавання змінної до сесії, щоб можна було звернутися до неї з інших файлів
    echo $val; // Виведення змінної з ціною
}

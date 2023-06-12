<?php require_once 'includes/auth.php' ?>

<?php
// Якщо не адмін - вихід
if (!$is_admin) {
    exit();
}
require_once("includes/connection.php");

// Перевіряє, чи передані значення table і id в запиті GE
if ($_GET['table'] != "" && $_GET['id'] != "") {
    $table = htmlspecialchars($_GET['table']);
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT); // фільтрується та перетворюється в ціле число за допомогою функції filter_var() з фільтром FILTER_SANITIZE_NUMBER_INT.

    extract(_switch($table));

    // Перевіряється, чи значення id є дійсним цілим числом за допомогою функції filter_var() з фільтром FILTER_VALIDATE_INT.
    if (filter_var($id, FILTER_VALIDATE_INT)) {
    } else {
        exit('Помилка з айді! Не грайтеся з вогнем :)');
    }

    // Виконується цикл foreach, в якому отримується перший елемент з масиву $n_cols (який містить назви стовпців таблиці) і його значення присвоюється змінній $col_name
    foreach ($n_cols as $col => $a) {
        $col_name = $col;
        break;
    }

    // Запит до бд, видаляє запис
    mysqli_query($con, "DELETE FROM `$table` WHERE `$table`.`$col_name` = $id");
    msg('Запис успішно видалено!', false);
    // Редірект до сторінки таблиці
    header('Location: ./index.php?table=' . $table);
} else {
    header('Location: ./index.php');
}

<?php require_once 'includes/auth.php' ?>

<style>
    #particles-js {
        z-index: 0;
    }

    .particles-js-canvas-el {
        z-index: 0;
    }
</style>

<?php
require_once("includes/connection.php");
require 'includes/header.php';

$table = htmlspecialchars($_GET['table']); // Створення змінної з URL-запиту і застосовує функцію htmlspecialchars() для безпечного відображення значення у вихідному HTML

if ($table == "") { // Якщо у URL-запиті змінна $table пуста, то переходить на сторінку з таблицею client
    if ($is_admin) {
        $table = 'client';
    } else {
        $table = 'trainer';
    }
}

extract(_switch($table)); // Викликає функцію _switch() зі значенням $table і розпаковує її повернутий результат у змінні, функція _switch написана у файлі connection.php


$data = mysqli_query($con, "SELECT * FROM `$table`"); // Запит до бд для вибору усіх записів  з таблиці, яка визначена значенням $table

if ($data) {  // Перевіряє, чи $data не має значення false або null
?>
    <div class="container-fluid text-center text-white">
        <!-- $name - назва таблиці, змінну об'явлено у файлі connection.php -->
        <h1 class="pt-5"><?= $name ?></h1>
    </div>
    <!-- Перевірка на адмін або таблицю client для того, щоб вивести кнопку реєстрації -->
    <?php if ($is_admin ||  $table == 'client') : ?>
        <div class="container" style="z-index:9999;position:relative;">
            <a href="create.php?table=<?= $table ?>" class="btn btn-order d-block">Зареєструвати</a>
        </div>
        <!-- Закінчення умови -->
    <?php endif; ?>
    <?php if (!(!$is_admin && $table == 'client')) : ?>
        <table class="mt-4 table table-dark table-bordered table-striped">

            <tr>
                <!-- Цикл foreach, який проходиться по кожному елементу масиву $cols. Кожен елемент $col використовується як назва заголовку стовпця <th> в таблиці.
                Дві крапки означають початок циклу foreach (використовуються не тільки для циклу). Це означає, що наступний блок коду буде виконуватись для кожного елемента масиву $cols. -->
                <?php foreach ($cols as $col) : ?>
                    <!-- Безпечне відображення значення у вихідному HTML -->
                    <th><?= htmlspecialchars($col) ?></th>
                <?php endforeach; ?>
                <!-- Якщо адмін, то додаються додаткові два символи (олівця редакції та хрестика видалення) -->
                <?php if ($is_admin) : ?>
                    <th>&#9998;</th>
                    <th>&#10006;</th>
                <?php endif; ?>
            </tr>
            <!-- Цей рядок запускає цикл foreach, який проходиться по кожному рядку $data -->
            <?php foreach ($data as $row) : ?>
                <tr>
                    <!-- Створення змінної -->
                    <?php $i = 0; ?>
                    <!-- Цей цикл foreach виконується для кожного елемента масиву $row. Кожен елемент масиву буде доступний у змінній $field, а ключ елемента - у змінній $key -->
                    <?php foreach ($row as $key => $field) : ?>
                        <?php
                        // Цей рядок перевіряє, чи поточний стовпець є першим у рядку. Якщо так, значення поля $field зберігається у змінній $temp_id.
                        if ($i == 0) {
                            $temp_id = $field;
                        }
                        ?>
                        <td>
                            <?= htmlspecialchars($field) ?>
                        </td>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                    <!-- Якщо адмін -->
                    <?php if ($is_admin) : ?>
                        <td>
                            <!-- Цей рядок виводить посилання для редагування рядка. Значення $table і $temp_id використовуються у URL-параметрах. -->
                            <a href="edit.php?table=<?= htmlspecialchars($table) ?>&id=<?= htmlspecialchars($temp_id) ?>">&#9998;</a>
                        </td>
                        <td>
                            <!-- Цей рядок виводить посилання для видалення рядка. Значення $table і $temp_id використовуються у URL-параметрах. -->
                            <a href="delete.php?table=<?= htmlspecialchars($table) ?>&id=<?= htmlspecialchars($temp_id) ?>">&#10006;</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
<?php
} else {
    echo ('<h1 style="color: #fff;">This table is empty!</h1>');
}

require 'includes/footer.php'; // Підключення нижньої частини сторінки
?>
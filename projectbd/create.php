<?php require_once 'includes/auth.php'; ?>


<?php

// if (!$is_admin) {
//     exit();
// }

require_once("includes/connection.php");


if (!empty($_POST)) {
    $table = htmlspecialchars($_POST['table']);
    extract(_switch($table));
    $sql = "INSERT INTO `$table` ("; // формує початок SQL-запиту на вставку даних в таблицю з назвою, яка зберігається у змінній $table.
    $i = 0;
    // Проходиться по масиву $n_cols, який містить назви стовпців таблиці і їх значення. У циклі формується рядок з назвами стовпців, які будуть включені до SQL-запиту INSERT.
    foreach ($n_cols as $col => $a) {
        // Перевіряє, чи індекс $i дорівнює нулю. Якщо так, то значення $col (назва стовпця) присвоюється змінній $col_id_name. Це виконується лише для першого елемента масиву $n_cols, оскільки перший стовпець вважається стовпцем ID (ідентифікатором) таблиці.
        if ($i == 0) {
            $col_id_name = $col;
        }
        // Перевіряє, чи індекс $i більший за 1. Якщо так, то до рядка $sql додається кома (,) для розділення назв стовпців у SQL-запиті
        if ($i > 1) {
            $sql .= ", ";
        }
        // Якщо так, то до рядка $sql додається назва стовпця, оточена символом зворотнього апострофу (`). Це виконується для всіх стовпців, крім першого (ID стовпця)
        if ($i > 0) {
            $sql .= '`' . $col . '`';
        }
        $i++;
    }
    $sql .= ") VALUES (";
    $i = 0;
    // Виконує SQL-запит для отримання значення останнього ID в таблиці. Отримане значення зберігається у змінній $last_id.
    $last_id = mysqli_query($con, "SELECT $col_id_name FROM `$table` ORDER BY $col_id_name DESC LIMIT 1");

    $last_id = mysqli_fetch_row($last_id); // Виконує запит до бази даних за допомогою об'єкту $last_id (результат попереднього запиту) і повертає рядок результатів у вигляді числового масив
    $last_id = $last_id[0] + 1;

    foreach ($_POST as $key => $data) { // Цикл, який проходить через всі елементи масиву $_POST. Кожен елемент масиву містить дані, надіслані методом POST з HTML-форми
        if ($i == 0) {
            // $sql .= $last_id;
        } else {
            // $sql .= ", ";
        }
        if ($i > 1) {
            $sql .= ", ";
        }
        if ($i != 0) {
            $sql .= "'$data'";
        }
        $i++;
    }
    $sql .= ")";
    mysqli_query($con, $sql);
    msg('Запис успішно додано!', false);
    header('Location: ./index.php?table=' . $table);
    exit();
}

require 'includes/header.php';

$table = htmlspecialchars($_GET['table']);


extract(_switch($table));

$cols = mysqli_query($con, "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='" . DB_NAME . "' AND `TABLE_NAME`='$table'");


?>

<div class="container mregister">
    <div id="login" class="text-white text-center">
        <h2 class="pt-4">Додавання запису</h2>
        <h3 class="pb-4 pt-2"><?= $name ?></h3>
        <form action="create.php" id="loginform" method="post" name="loginform">
            <input type="hidden" name="table" value="<?= $table ?>">
            <!-- Создаём $i для пропуска поля айди, ведь оно создаться в бд само -->
            <?php $i = 0; ?>
            <?php foreach ($n_cols as $name => $col) : ?>
                <?php if ($i != 0) : ?>
                    <?php

                    // Запит до бд, який отримує trainer_fio
                    $train = "SELECT trainer_fio FROM trainer";
                    $result = mysqli_query($con, $train);
                    // Запит до бд, який отримує service_type
                    $services = "SELECT service_type FROM service";
                    $serv = mysqli_query($con, $services);


                    $type = 'text';

                    // Чи є в імені слово date, якщо є, то $type = 'date';
                    if (stripos($name, 'date') !== false) {
                        $type = 'date';
                    }
                    $menu = "";
                    // Якщо відповідає умові, то створюється дропдаун (випадаюче меню), яке заповнене значенням з таблиці в бд
                    if ($name == 'trainer_fio') {
                        $menu = '<select class="menu" id="dropdown" style="appearance: none;" onchange="updateInputValue()">
                                    <option value="">&#128203;</option>';
                        while ($row = mysqli_fetch_assoc($result)) {
                            $menu .= '<option value="' . $row['trainer_fio'] . '">' . '&#128203; '  . $row['trainer_fio'] . '</option>';
                        }
                        $menu .= '</select>';
                        echo '<script>
                                function updateInputValue() {
                                    let selectElement = document.getElementById("dropdown");
                                    let selectedValue = selectElement.value;
                                    let inputElement = document.getElementById("' . $name . '");
                                    inputElement.value = selectedValue;

                                    let inputEvent = new Event("input", {
                                        bubbles: true
                                    });
                                    inputElement.dispatchEvent(inputEvent);
                                }
                                </script>';
                    }
                    // Якщо відповідає умові, то створюється дропдаун (випадаюче меню), яке заповнене значенням з таблиці в бд
                    if ($name == 'service_type') {
                        $menu = '<select class="menu" id="dropdown1" style="appearance: none;" onchange="updateInputValue1()">
                            <option value="">&#128203;</option>';
                        while ($row1 = mysqli_fetch_assoc($serv)) {
                            $menu .= '<option value="' . $row1['service_type'] . '">' . '&#128203; ' . $row1['service_type'] . '</option>';
                        }
                        $menu .= '</select>';
                        echo '<script>
                                function updateInputValue1() {
                                    let selectElement = document.getElementById("dropdown1");
                                    let selectedValue = selectElement.value;
                                    let inputElement = document.getElementById("' . $name . '");
                                    inputElement.value = selectedValue;

                                    let inputEvent = new Event("input", {
                                        bubbles: true
                                    });
                                    inputElement.dispatchEvent(inputEvent);
                                }
                            </script>';
                    }  ?>
                    <!-- Динамічний цикл виведення полів для форми реєстрації, кожний параметр за щось відповідає, кожен прописаний в цьому або connection.php файлі -->
                    <p><label for="<?= ($name); ?>"><?= ($col); ?><br>
                            <?= $menu ?><input class="input" id="<?= ($name); ?>" name="<?= ($name); ?>" size="20" type="<?= $type ?>" value="<?= ($type == 'date') ? date('Y-m-d') : '' ?> ">

                        </label>
                    </p>
                <?php endif; ?>
                <?php $i++; ?>
            <?php endforeach; ?>
            <p class="submit"><input class="button" type="submit" value="Зареєструвати"></p>
        </form>

    </div>
</div>
<script>
    // Створення глобальних змінних
    let value1 = '';
    let value2 = '';
    let value3 = '';
    let value4 = '';
    let allFieldsFilled = false; // змінна для відстежування заповненості всіх полів

    // Функція для перевірки заповненості всіх полів
    function checkFieldsFilled() {
        if (value1 !== '' && value2 !== '' && value3 !== '' && value4 !== '') {
            allFieldsFilled = true;
        } else {
            allFieldsFilled = false;
        }
    }
    // Функції що беруть значення з полів, а потім за допомою Аяксу відсилають її у файл totalpricechecker.php, який в сво. чергу повертає значення загнальної суми
    $('#trainer_fio').on('input change', function() { // Створення змінної в залежності від айді, а також функції яка реагує на введення в поле даних
        value1 = $(this).val(); // Присвоєння змінної значення, що введено в поле
        checkFieldsFilled(); // Перевірка чи заповнені всі поля
        sendValuesToPHP(); // Відправка даних за допомогою Аяксу
    });

    $('#service_type').on('input change', function() { // Створення змінної в залежності від айді, а також функції яка реагує на введення в поле даних
        value2 = $(this).val(); // Присвоєння змінної значення, що введено в поле
        checkFieldsFilled(); // Перевірка чи заповнені всі поля
        sendValuesToPHP(); // Відправка даних за допомогою Аяксу
    });

    $('#insurance_termin').on('input', function() { // Створення змінної в залежності від айді, а також функції яка реагує на введення в поле даних
        value3 = $(this).val(); // Присвоєння змінної значення, що введено в поле
        checkFieldsFilled(); // Перевірка чи заповнені всі поля
        sendValuesToPHP(); // Відправка даних за допомогою Аяксу
    });

    $('#num_trains').on('input', function() { // Створення змінної в залежності від айді, а також функції яка реагує на введення в поле даних
        value4 = $(this).val(); // Присвоєння змінної значення, що введено в поле
        checkFieldsFilled(); // Перевірка чи заповнені всі поля
        sendValuesToPHP(); // Відправка даних за допомогою Аяксу
    });


    // Функція для відправки значень до PHP
    function sendValuesToPHP() {

        if (allFieldsFilled) {

            // Виклик Ajax-запиту для передачі значень до PHP
            $.ajax({
                url: './totalpricechecker.php',
                type: 'POST',
                data: {
                    value1: value1,
                    value2: value2,
                    value3: value3,
                    value4: value4
                },
                success: function(response) {
                    $('#total_price').val(response); // Оновлення значення на сторiнцi
                },
                error: function(xhr, status, error) {
                    console.log(error); // Обробка помилки
                }
            });
        }
    }
</script>

<?php
require 'includes/footer.php';
?>
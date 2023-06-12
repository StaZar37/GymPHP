<?php require_once 'includes/auth.php' ?>

<?php
// Якщо не адмін - вихід
if (!$is_admin) {
    exit();
}

require_once("includes/connection.php");

// Перевіряє, чи не порожній масив $_POST
if (!empty($_POST)) {
    $table = htmlspecialchars($_POST['table']);
    // Фільтрація, як у файлі delete.php
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    // Перевірка, як у файлі delete.php
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        exit('Помилка з айді! Не грайтеся з вогнем :)');
    }
    extract(_switch($table));

    // Виконується цикл foreach, в якому отримується перший елемент з масиву $n_cols (який містить назви стовпців таблиці) і його значення присвоюється змінній $col_name
    foreach ($n_cols as $col => $a) {
        $col_name = $col;
        break;
    }

    $i = 0;
    $_data = []; // Створюється пустий масив $_data.
    // Виконується цикл foreach по $_POST, в якому значенням змінної $data заповнюється масив $_data (починаючи з індексу 0, припускаючи, що значення з індексами 0 і 1 не враховуються).
    foreach ($_POST as $key => $data) {
        if ($i > 1) {
            $_data[$i - 2] = $data;
        }
        $i++;
    }

    // Генеруємо sql запрос пропускаючи перший параметр айді
    $sql = "UPDATE `$table` SET ";
    $i = 0;
    foreach ($n_cols as $col => $a) {
        if ($i != 0) {
            if ($i > 1) {
                $sql .= ", ";
            }
            $sql .= "`" . $col . "` = '" . $_data[$i - 1] . "'";
        }
        $i++;
    }
    $sql .= " WHERE `$col_name` = '$id'";
    mysqli_query($con, $sql);
    msg('Запис успішно змінено!', false);
    header('Location: ./index.php?table=' . $table);
} else if ($_GET["table"] != "" && $_GET["id"] != "") {

    $table = htmlspecialchars($_GET['table']);
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        exit('Помилка з айді! Не грайтеся з вогнем :)');
    }
    extract(_switch($table));

    require 'includes/header.php';

    // Виконується цикл foreach, в якому отримується перший елемент з масиву $n_cols (який містить назви стовпців таблиці) і його значення присвоюється змінній $col_name
    foreach ($n_cols as $col => $a) {
        $col_name = $col;
        break;
    }

    $data = mysqli_query($con, "SELECT * FROM `$table` WHERE `$table`.`$col_name` = '$id'");

    $data = mysqli_fetch_row($data);

    if (!$data) {
        header('Location: ./index.php?table=' . $table);
    }

    $_data = []; // Створюється пустий масив $_data.
    $i = 0;
    foreach ($n_cols as $col => $name) { // Виконується цикл foreach по масиву $n_cols, де кожний елемент масиву має ключ $col і значення $name.
        $_data[$col] = $data[$i];
        $i++;
    }
    // Після виконання циклу, масив $_data міститиме значення змінної $data, розташовані за відповідними ключами $col з масиву $n_cols.

?>

    <style>

    </style>

    <div class="container mregister">
        <div id="login" class="text-white text-center">
            <h2 class="pt-4">Редагування запису</h2>
            <h3 class="py-2"><?= $name ?></h3>
            <form action="edit.php" id="loginform" method="post" name="loginform">
                <input type="hidden" name="table" value="<?= htmlspecialchars($table) ?>">
                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                <!-- Создаём $i для пропуска поля айди -->
                <?php $i = 0; ?>
                <?php foreach ($_data as $key => $data) : ?>
                    <!-- Генерация полей на основе названий в нашей таблице -->
                    <?php if ($i != 0) : ?>
                        <?php
                        $type = 'text';
                        if (stripos($key, 'date') !== false) {
                            $type = 'date';
                        }

                        ?>
                        <p><label for="<?= $key ?>"><?= $n_cols[$key] ?><br>
                                <input class="input" id="<?= $key ?>" name="<?= $key ?>" size="20" type="<?= $type ?>" value="<?= htmlspecialchars($data) ?>"></label></p>
                    <?php endif; ?>
                    <?php $i++; ?>
                <?php endforeach; ?>
                <p class="submit"><input class="button" type="submit" value="Редагувати"></p>
            </form>
        </div>
    </div>

<?php

    require 'includes/footer.php';
} else {
    header('Location: ./index.php');
}

<?php

require("constants.php");
// Цей код встановлює з'єднання з базою даних MySQL, використовуючи параметри, визначені у константах DB_SERVER, DB_USER, DB_PASS і DB_NAME
// Функція mysqli_connect() приймає параметри: адресу сервера бази даних (DB_SERVER), ім'я користувача бази даних (DB_USER) і пароль (DB_PASS). Якщо підключення не вдається, код виконує функцію die(), яка виводить повідомлення про помилку, отримане за допомогою функції mysqli_error(), і припиняє виконання скрипту.
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysqli_error($con));
// У цьому рядку вибирається база даних для використання. Функція mysqli_select_db() приймає з'єднання до сервера бази даних ($con) і назву бази даних (DB_NAME). Якщо вибір бази даних не вдається, код виконує функцію die(), яка виводить повідомлення про помилку "Cannot select DB" і припиняє виконання скрипту.
mysqli_select_db($con, DB_NAME) or die("Cannot select DB");

// Оголошує функцію з ім'ям _switch і приймає аргумент $table
function _switch($table)
{
    // озпочинається оператор switch, який оцінює значення змінної $table та визначає, який варіант case буде виконуватися.
    switch ($table) {
            // Перший варіант case, який перевіряє, чи змінна $table має значення 'client'
        case 'client':
            // && $_SESSION['user'][1] == 'admin'
            // Перевіряє, чи існує змінна сесії з ім'ям 'user'
            if (isset($_SESSION['user'])) {
                // Встановлює значення змінної $name
                $name = 'Таблиця клієнтів';
                // Встановлює значення змінної $cols як масив, що містить рядки з назвами стовпців таблиці для клієнтів
                $cols = ['ID', 'ПIБ клієнта', 'ПІБ тренера', 'Вид тренувань',  'Строк страховки (мiс.)', 'Кiлькiсть занять', 'Загальна цiна', 'Дата оплати послуги'];
                // Встановлює значення змінної $n_cols як асоціативний масив, де ключі відповідають назвам полів таблиці для клієнтів, а значення - відповідним назвам стовпців
                $n_cols = [
                    'client_id' => $cols[0],
                    'client_fio' => $cols[1],
                    'trainer_fio' => $cols[2],
                    'service_type' => $cols[3],
                    'insurance_termin' => $cols[4],
                    'num_trains' => $cols[5],
                    'total_price' => $cols[6],
                    'date_pay_service' => $cols[7]
                ];
            } else {
                exit('Такої таблиці  не існує!');
            }
            break;
        case 'trainer':
            $name = 'Таблиця тренерів';
            $cols = ['ID', 'ПIБ тренера', 'Ціна тренувань', 'Чи працює тренер?'];
            $n_cols = [
                'trainer_id' => $cols[0],
                'trainer_fio' => $cols[1],
                'trainer_price' => $cols[2],
                'is_work' => $cols[3]
            ];
            break;
        case 'service':
            $name = 'Таблиця послуг';
            $cols = ['ID', 'Тип послуги', 'Ціна послуги'];
            $n_cols = [
                'service_id' => $cols[0],
                'service_type' => $cols[1],
                'service_price' => $cols[2]
            ];
            break;
            // case 'insurance':
            //     $name = 'Таблиця страхових полiсiв';
            //     $cols = ['ID', 'ID клієнта', 'Ціна страхового полiсу', 'Термін страхового полiсу'];
            //     $n_cols = [
            //         'insurance_id' => $cols[0],
            //         'client_id' => $cols[1],
            //         'insurance_price' => $cols[2],
            //         'insurance_termin' => $cols[3]
            //     ];
            //     break;
        default:
            exit('Такої таблиці  не існує!');
            break;
    }


    // Повертає масив зі значеннями змінних $name, $cols і $n_cols відповідно як результат виконання функції _switch.
    return [
        'name'   => $name,
        'cols'   => $cols,
        'n_cols' => $n_cols
    ];
}

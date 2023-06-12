<?php
session_start();

if (isset($_SESSION['msg']) && $_SESSION['msg']) { // Перевірка чи існує ключ 'msg' в глобальному масиві $_SESSION, а також перевіряє, чи не є значення 'msg' пустим
    echo ("<script>setTimeout(() => alert('" . $_SESSION['msg'] .  "'), 500)</script>"); // Вивід повідомлення на екран
    unset($_SESSION['msg']); // Очищення повідомлення
}

function msg($msg, $redir = true)
{
    $_SESSION['msg'] = $msg; // Повідомлення, що передається як параметр функції, яке виводить умова вище 
    if ($redir) { // Якщо виконується умова виконується перехід та вихід
        header("location: " . $_SERVER["REQUEST_URI"]);
        exit();
    }
}

$is_login = false;
$is_admin = false;


if (isset($_SESSION['user'])) { //  Перевірка на користувача (юзера)
    $is_login = true;
}
if ($is_login && $_SESSION['user'][1] == 'admin') { //  Перевірка на користувача (адміна)
    $is_admin = true;
}


function is_login()
{
    if (isset($_SESSION['user'])) { // Чи залогінений юзер
        return true;
    }
    return false;
}

function debug($var)
{
    echo ('<pre style="color: #fff !important">');
    var_dump($var);
    echo ('</pre>');
}

function check_POST_()
{
    return (!empty($_POST) && isset($_POST['login']) && isset($_POST['pass'])); // Повертає true/false в залежності чи виконується умова (массив $_POST - не є порожнім, чи встановлені ключи login та pass)
}

// Перевіряє, чи існує GET-параметр 'a' і чи його значення дорівнює рядку 'reg'
if (isset($_GET['a']) && $_GET['a'] == 'reg') {
    // Перевіряє, чи виконується функція 
    if (check_POST_()) {
        $login = $_POST['login']; // Отримує значення змінної $_POST['login']
        $pass  = $_POST['pass']; // Отримує значення змінної $_POST['pass']
        $pass  = password_hash($pass, PASSWORD_DEFAULT); // Хешування пароля

        require 'includes/connection.php';
        $sql = "SELECT * FROM users WHERE login = '$login'"; // Формування запиту до бд, обирання всіх полів з таблитці юзер де login = '$login'

        $check = mysqli_query($con, $sql); // Запит до бд
        $check = mysqli_fetch_assoc($check); // Перетворення змінної на асоціативний масив

        if ($check) { // Чи не порожній результат запиту
            msg("Такий логін вже існує! Введіть інший");
        } else {
            $sql = "INSERT INTO users (login, password, roles) VALUES ('$login', '$pass', 'user')"; // Формує SQL-запит для вставки нового рядка в таблицю users

            mysqli_query($con, $sql); // Виконує SQL-запит для вставки нового рядка в базу даних.

            $_SESSION['user'] = [$login, 'user'];
            header('Location: ./index.php'); // Зберігає інформацію про користувача у змінній сесії $_SESSION['user'], встановлюючи логін і роль користувача
        }

        exit();
    } else {
        require 'includes/header.php';
?>


        <div class="container mregister">
            <div id="login" class="text-white text-center">
                <h2 class="pt-4">Реєстрація</h2>
                <div class="py-4"></div>
                <form action="" id="loginform" method="post" name="loginform">
                    <p><label for="">Логін<br>
                            <input class="input" id="" name="login" size="20" type="text" value="" required></label></p>
                    <p><label for="">Пароль<br>
                            <input class="input" id="" name="pass" size="20" type="password" value="" required></label></p>
                    <p class="submit"><input class="button" type="submit" value="Зареєструватися"></p>
                    <p><a class="fs-5 text-start log-add-link" href="?">Зайти в акаунт</span></a>
                </form>
            </div>
        </div>



        <?php
        require 'includes/footer.php';
        exit();
    }
} else {
    // Перевіряє, чи користувач вже авторизований. 
    if (is_login()) {
        // nothing
    } else {
        //  Перевіряє, чи HTTP-запит був виконаний методом POST
        if (check_POST_()) {
            $login = $_POST['login'];
            $pass  = $_POST['pass'];

            require 'includes/connection.php';

            $sql = "SELECT * FROM users WHERE login = '$login'";
            $check = mysqli_query($con, $sql);
            $check = mysqli_fetch_assoc($check);
            // Перевіряє, чи існує результат запиту
            if ($check) {
                //  Перевіряє, чи введений пароль відповідає хешованому паролю, збереженому у базі даних. Використовує функцію password_verify() для порівняння паролів
                if (password_verify($pass, $check['password'])) {
                    //  Зберігає інформацію про користувача у змінній сесії $_SESSION['user']
                    $_SESSION['user'] = [$login, $check['roles']];
                    header('Location: ./index.php');

                    exit();
                } else {
                    msg("Пароль не вірний! Спробуйте ще раз");
                }
            } else {
                msg("Такого облікового запису не існує! Спробуйте ще раз");
            }

            exit();
        } else {

            require 'includes/header.php';
        ?>


            <div class="container mregister">
                <div id="login" class="text-white text-center">
                    <h2 class="pt-4">Авторизація</h2>
                    <div class="py-4"></div>
                    <form action="" id="loginform" method="post" name="loginform">
                        <p><label for="">Логін<br>
                                <input class="input" id="" name="login" size="20" type="text" value="" required></label></p>
                        <p><label for="">Пароль<br>
                                <input class="input" id="" name="pass" size="20" type="password" value="" required></label></p>
                        <p class="submit"><input class="button" type="submit" value="Авторизація"></p>
                        <p><a class="fs-5 text-start log-add-link" href="?a=reg">Зареєструватися</span></a>
                    </form>
                </div>
            </div>

<?php
            require 'includes/footer.php';
            exit();
        }
    }
}

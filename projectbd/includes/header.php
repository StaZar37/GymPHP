<?php require_once("includes/connection.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Gym</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link href="./css/style.css" media="screen" rel="stylesheet">
  <link href="./css/style-table.css" media="screen" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>


</head>

<body>
  <!-- Якщо не встановлено в URL значення qwerty, додається фон з частинками -->
  <?php if (!isset($_GET['qwerty'])) : ?>
    <div id="particles-js"></div>
  <?php endif; ?>
  <!-- Якщо залогінений -->
  <?php if (is_login()) : ?>

    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
      <div class="container-fluid px-5">
        <a class="navbar-brand" href="./map.php"><span class='pricolation'>Спортзал</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php /*if ($is_admin):*/ ?>
            <li class="nav-item">
              <a class="nav-link" href="index.php?table=client"><span class="header-underline">Клієнти</span></a>
            </li>
            <?php /*endif; */ ?>
            <li class="nav-item">
              <a class="nav-link" href="index.php?table=trainer"><span class="header-underline">Тренера</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?table=service"><span class="header-underline">Послуги</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="index.php?table=insurance"><span class="header-underline">Страховi полiси</span></a>
            </li> -->
          </ul>
          <div class="ms-auto text-white d-flex align-items-center">
            <!-- $_SESSION['user'][0] - ім'я юзера поточної сесії   -->
            Привіт, <?= $_SESSION['user'][0] ?><a href="logout.php" class="text-white ps-3" title="Вийти">
              <svg xmlns="http://www.w3.org/2000/svg" style="fill: #8c00ff;" height="24" width="24">
                <path d="M12 21v-2h7V5h-7V3h7q.825 0 1.413.587Q21 4.175 21 5v14q0 .825-.587 1.413Q19.825 21 19 21Zm-2-4-1.375-1.45 2.55-2.55H3v-2h8.175l-2.55-2.55L10 7l5 5Z" />
              </svg>
            </a>
          </div>
        </div>
      </div>
    </nav>

  <?php endif; ?>
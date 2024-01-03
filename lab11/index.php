<?php
session_start();
$_SESSION['active'] = true;
$_FORMULARZ['version'] = 'przypomnij';
?>

<!DOCTYPE html>
<html lang="PL-pl">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
  <meta http-equiv="Content-Language" content="pl" />
  <meta name="Author" content="Filip Gorczyca v1.9" />
  <title>Komputer moją pasją</title>
  <link rel="stylesheet" href="css/Style.css">
</head>

<body>
  <div class="menu">
    <a href="index.php?page=glowna&id=1">Strona główna</a>
    <a href="index.php?page=historia&id=2">Historia</a>
    <a href="index.php?page=csgo&id=3">CS:GO</a>
    <a href="index.php?page=cs2&id=4">CS2</a>
    <a href="index.php?page=kontakt&id=5">Kontakt</a>
    <a href="index.php?page=skrypty&id=6">Skrypty</a>
    <a href="index.php?page=filmy&id=7">Filmy</a>
    <a href="html/shop.html">Sklep</a>
    <a class="cta" href="./php/admin_page.php">Logowanie</a>
  </div>

  <?php
  include("cfg.php");

  error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

  function PokazPodstrone($id)
  {
    global $link;
    $id_clear = mysqli_real_escape_string($link, $id);

    $query = "SELECT * FROM page_list WHERE page_title = '$id_clear' LIMIT 1";
    $result = mysqli_query($link, $query);

    if (!$result) {
      die('Query failed: ' . mysqli_error($link));
    }

    if (mysqli_num_rows($result) == 0) {
      $web = '[nie_znaleziono_strony]';
    } else {
      $row = mysqli_fetch_assoc($result);
      $web = $row['page_content'];
    }
    return $web;
  }

  $strona = PokazPodstrone($_GET['page']);

  echo $strona;
  ?>

  <footer>
    <p>
    <?php
    $nr_indeksu = '164370';
    $nrGrupy = '2';
    echo 'Autor: Filip Gorczyca ' . $nr_indeksu . ' grupa ' . $nrGrupy;
    ?>
    </p>
  </footer>

</body>

</html>
<?php
require_once('contact.php');
require_once('../cfg.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="pl" />
    <title>Komputer moją pasją</title>
    <meta name="Author" content="Filip Gorczyca" />
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="#">
    <title>CMS</title>
</head>

<body>
    <?php

    // if($_FORMULARZ['version'] == 'przypomnij'){
    //     echo PrzyPomnijHaslo();
    // }else{
    //     echo PokazKontakt();
    // }

    echo PokazKontakt();

    // Po wcisnieciu inputu send wysyla uzupelniony formularz kontaktowy na podanego maila
    if (isset($_POST['send'])) {
        WyslijMainKontankt("picore6014@ksyhtc.com");
    }

    // Po wcisnieciu inputu back wraca do glownej strony cms
    if (isset($_POST['back'])) {
        header('Location: cms.php');
    }
    ?>

</body>

</html>
<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'moja_strona';

    $link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
    $login = "admin";
    $pass = "admin";

    if (!$link) {
        echo '<b>przerwano połączenie</b>';
        die(mysqli_connect_error()); // Dodano die() aby przerwać wykonywanie skryptu w razie nieudanego połączenia
    }
?>

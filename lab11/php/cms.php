<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_page.php');
    exit();
}
require_once('../admin/admin.php');
require_once('../cfg.php');

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS</title>
</head>

<body>
    <table>
        <tr>
            <td><button class="b"><a href="create_page.php">Dodaj Podstronę</a></button></td> <!-- tworzenie nowych stron -->
            <td><button class="b"><a href="show_page.php">Pokaż Podstrony</a></button></td> <!-- wyswietlanie stron -->
            <td><button class="b"><a href="edit_page.php">Edytuj Podstronę</a></button></td> <!-- edytowanie stron -->
            <td><button class="b"><a href="delete_page.php">Usuń Podstronę</a></button></td> <!-- usuwanie stron -->
            <td><button class="b"><a href="log_out.php">Wyloguj się</a></button></td>   <!-- wylogowywanie się -->
        </tr>
        <tr class="osobna">
            <td><button><a href="show_category.php">Zarządzaj Kategoriami</a></button></td> <!-- zarządzanie kategoriami obiektowe -->
        </tr>
        <tr>
            <td><button><a href="create_product.php">Dodaj Produkt</button></td> <!-- tworzenie produktów -->
            <td><button><a href="show_product.php">Pokaż Produkty</button></td> <!-- wyświetlanie produktów -->
            <td><button><a href="edit_product.php">Edytuj Produkty</button></td> <!-- edycja produktów -->
            <td><button><a href="delete_product.php">Usuń Produkt</button></td> <!-- usuwanie produktów -->
        </tr>
    </table>
</body>

</html>
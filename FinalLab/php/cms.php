<link rel="stylesheet" href="../css/cms.css">

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
            <td colspan="4"><p>Panel sterowania</p></td>
        </tr>
        <tr>
            <td colspan="4"><button class="b"><a href="log_out.php">Wyloguj się</a></button></td>
        </tr>
        <tr>
            <td colspan="4"><p>Kontrola podstron</p></td>
        </tr>
        <tr>
            <td><button class="b"><a href="create_page.php">Dodaj Podstronę</a></button></td>
            <td><button class="b"><a href="edit_page.php">Edytuj Podstronę</a></button></td>
            <td><button class="b"><a href="delete_page.php">Usuń Podstronę</a></button></td>
        </tr>
        <tr>
            <td colspan="4"><p>Kontrola kategori</p></td>
        </tr>
        <tr class="osobna">
            <td colspan="4"><button><a href="show_category.php">Zarządzaj Kategoriami</a></button></td>
        </tr>
        <tr>
            <td colspan="4"><p>Kontrola produktów</p></td>
        </tr>
        <tr>
            <td><button><a href="create_product.php">Dodaj Produkt</a></button></td>
            <td><button><a href="edit_product.php">Edytuj Produkty</a></button></td>
            <td><button><a href="delete_product.php">Usuń Produkt</a></button></td>
        </tr>
    </table>
</body>


</html>
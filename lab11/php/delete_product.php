<?php 
    ob_start();
    require_once('../admin/admin.php'); # import pliku z funkcjami administracyjnimi
    require_once('../cfg.php'); # import pliku konfiguracyjnego
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
    <?php 
        echo UsunProdukt(); # wywołanie funkcji usuwającej produkt z bazy danych
        echo ListaProdukt(); # wywołanie funkcji wyświetlania produktów z danymi potrzebnymi do połączenia z bazą danych

        if(isset($_POST['btn-delete-p'])){ # gdy został wciśnięty przycisk o wartości name=btn-delete-p
            $category_id = $_POST['id']; # pobierane jest id podane w inpucie
            $query = "DELETE FROM products WHERE id = '".$category_id."'"; # zapytanie MYSQL usuwa produkt o danym id z bazy
            mysqli_query($link, $query); # wynik poprzedniego polecenia
            header("Location: delete_product.php"); # przekierowanie na stronę delete_product
            echo ListaProdukt(); # ponowne wywołanie funkcji w celu odświeżenia wyników
        }
?>

<?php ob_end_flush(); ?>
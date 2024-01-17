<link rel="stylesheet" href="../css/products_cms.css">

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
    echo StworzProdukt(); # wywołanie funkcji StworzProdukt()
    echo ListaProdukt(); # wywołanie funkcji wyświetlania produktów z danymi potrzebnymi do połączenia z bazą danych

    if (isset($_POST['btn-create-p'])) { # gdy został wciśnięty przycisk o wartości name=btn-create-p
        $title = $_POST['title']; # pobierany jest tytuł podany w inpucie i przypisywany do zmiennej $title
        $description = $_POST['description']; # pobierany jest opis podany w inpucie i przypisywany do zmiennej $description
        $creation_date = date("Y-m-d H:i:s"); # pobierana jest data podana w inpucie i przypisywana do zmiennej $creation_date
        $modify_date = date("Y-m-d H:i:s"); # pobierana jest data podana w inpucie i przypisywana do zmiennej $modify_date
        $expiration_date = date('Y-m-d H:i:s', strtotime($creation_date . ' + 30 days')); # pobierana jest data podana w inpucie i przypisywana do zmiennej $expiration_date + 30 dni
        $netto_value = $_POST['netto_value']; # pobierana jest cena netto podana w inpucie i przypisywana do zmiennej $netto_value
        $vat = $_POST['vat']; # pobierany jest vat podany w inpucie i przypisywany do zmiennej $vat
        $amount = $_POST['amount']; # pobierana jest ilość podana w inpucie i przypisywana do zmiennej $amount
        $availability_status = $_POST['availability_status']; # pobierany jest status dostępności produktu podany w inpucie i przypisywany do zmiennej $availability_status
        $category = $_POST['category']; # pobierana jest kategoria produktu podana w inpucie i przypisywana do zmiennej $category
        $weight = $_POST['weight']; # pobierana jest waga podana w inpucie i przypisywana do zmiennej $weight
        $image = $_FILES['image'];

        if ($image['error'] === UPLOAD_ERR_OK) {
            $info = getimagesize($image['tmp_name']);
            if (!$info) {
                die("File is not an image");
            }

            $blob = addslashes(file_get_contents($image['tmp_name']));
        } else {
            echo "Error uploading file.";
        }

        $query = "INSERT INTO products (title, description, creation_date, modify_date, expiration_date, netto_value, vat, amount, availability_status, category, weight, image) 
            VALUES ('" . $title . "', '" . $description . "', '" . $creation_date . "', '" . $modify_date . "', '" . $expiration_date . "', 
            '" . $netto_value . "', '" . $vat . "', '" . $amount . "', '" . $availability_status . "', '" . $category . "', '" . $weight . "', '" . $blob . "')"; # zapytanie SQL dodające nowy wpis w bazie danych
        mysqli_query($link, $query); # wykonanie poprzedniego zapytania
        header("Location: create_product.php"); # przekierowanie na stronę create_product
        echo ListaProdukt(mysqli_connect($dbhost, $dbuser, $dbpass, $baza)); # ponowne wywołanie funkcji w celu odświeżenia wyników
    }

    if (isset($_POST['btn-back'])) {
        header("Location: cms.php");
    }
    ?>

    <?php ob_end_flush(); ?>
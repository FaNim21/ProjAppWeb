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
    echo EdytujProdukt(); # wywołanie funkcji edycji kategorii
    echo ListaProdukt(); # wywołanie funkcji wyświetlania kategorii z danymi potrzebnymi do połączenia z bazą danych

    if (isset($_POST['btn-edit-p'])) { # gdy został wciśnięty przycisk o wartości name=btn-edit-p
        $product_id = $_POST['id'];
        $title = $_POST['title']; # pobierany jest tytuł podany w inpucie i przypisywany do zmiennej $title
        $description = $_POST['description']; # pobierany jest rodzic kategorii podany w inpucie i przypisywany do zmiennej $description
        $modify_date = date("Y-m-d H:i:s"); # pobierana jest data podana w inpucie i przypisywana do zmiennej $modify_date
        $expiration_date = $_POST['expiration_date']; # pobierana jest data podana w inpucie i przypisywana do zmiennej $expiration_date
        $netto_value = $_POST['netto_value']; # pobierana jest cena netto podana w inpucie i przypisywana do zmiennej $netto_value
        $vat = $_POST['vat']; # pobierany jest vat podany w inpucie i przypisywany do zmiennej $vat
        $amount = $_POST['amount']; # pobierana jest ilość podana w inpucie i przypisywana do zmiennej $amount
        $category = $_POST['category']; # pobierana jest kategoria produktu podana w inpucie i przypisywana do zmiennej $category
        $weight = $_POST['weight']; # pobierana jest waga podana w inpucie i przypisywana do zmiennej $weight
        if (isset($_POST['availability_status'])) { # jeśli status jest ustawiony na true
            $status = 1; # pobierany jest status podany w inpucie i przypisywany do zmiennej $status
        } else {
            $status = 0; # w przeciwnym wypadku status jest równy 0
        }
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

        global $link; # połączenie z bazą przypisane do $link
        $query = "UPDATE products SET title='$title', description='$description', modify_date='$modify_date', 
            expiration_date='$expiration_date', netto_value='$netto_value', vat='$vat', amount='$amount', availability_status='$status',
            category='$category', weight='$weight', image='$blob' WHERE id='$product_id'";
        $result = mysqli_query($link, $query);
        header("Location: edit_product.php"); # przekierowanie na stronę edit_product
    }

    if (isset($_POST['btn-back'])) {
        header("Location: cms.php");
    }
    ?>
</body>

</html>
<?php ob_end_flush(); ?>
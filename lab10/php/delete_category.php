<?php
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
    <?php
    echo UsunKategorie();
    echo ListaKategorii();

    if (isset($_POST['btn-delete-k'])) {
        $category_id = $_POST['k_id'];
        $query = "DELETE FROM categories WHERE id = '" . $category_id . "'";
        mysqli_query($link, $query);
        header("Location: delete_category.php");

        echo ListaPodstron();
    }
    ?>
</body>

</html>
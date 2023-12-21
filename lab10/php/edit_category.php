<?php
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
    echo EdytujKategorie();
    echo ListaKategorii();

    if (isset($_POST['btn-edit-k'])) {
        $category_id = $_POST['k_id'];
        $category_name = $_POST['category_name'];
        $parent = $_POST['parent'];

        $link = mysqli_connect($dbhost, $dbuser, $dbpass, $baza);

        $query = "SELECT * FROM categories WHERE id='$category_id'";
        $result = mysqli_query($link, $query);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result);
            $existing_name = $row['category_name'];
            $existing_parent = $row['parent'];
            if ($existing_name == $category_name && $existing_parent == $parent) {
                echo "Kategoria o podanym tytule i zawartości już istnieje.";
            } elseif ($existing_name == $category_name) {
                $query = "UPDATE categories SET category_name='$category_name', parent='$parent' WHERE id='$category_id'";
                $result = mysqli_query($link, $query);
                echo "Zawartość strony została zmieniona.";
            } elseif ($existing_parent == $parent) {
                $query = "UPDATE categories SET category_name='$category_name', parent='$parent' WHERE id='$category_id'";
                $result = mysqli_query($link, $query);
                echo "Tytuł strony został zmieniony.";
            } else {
                $query = "UPDATE categories SET category_name='$category_name', parent='$parent' WHERE id='$category_id'";
                $result = mysqli_query($link, $query);
            }
            header("Location: edit_category.php");
        }
    }
    ?>
</body>

</html>
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
    echo UsunPodstrone();
    echo ListaPodstron();

    // Po wcisnieciu btn-delete w formularzu UsunPodstrone usuwa podstrone
    if (isset($_POST['btn-delete'])) {
        $page_id = $_POST['p_id'];
        $query = "DELETE FROM page_list WHERE id = '" . $page_id . "'";
        mysqli_query($link, $query);
        header("Location: delete_page.php");

        echo ListaPodstron();
    }

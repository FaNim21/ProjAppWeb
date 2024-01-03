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
    echo StworzPodstrone();
    echo ListaPodstron();

    // Po wcisnieciu btn-create w formularzu StworzPodstrone tworzy podstrone
    if (isset($_POST['btn-create'])) {
        $page_title = $_POST['page_title'];
        $page_content = $_POST['page_content'];
        $status = $_POST['p_status'];
        if ($status)
            $active_status = 1;
        else
            $active_status = 0;

        $query = "INSERT INTO page_list (page_title, page_content, status) VALUES ('" . $page_title . "', '" . $page_content . "', '" . $active_status . "')";
        mysqli_query($link, $query);
        header("Location: create_page.php");
        echo ListaPodstron();
    }

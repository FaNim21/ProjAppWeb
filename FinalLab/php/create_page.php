<link rel="stylesheet" href="../css/page.css">

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
        $active_status = $status ? 1 : 0;
    
        // Using prepared statement to prevent SQL injection
        $query = "INSERT INTO page_list (page_title, page_content, status) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($link, $query);
    
        // Check if the statement was prepared successfully
        if ($stmt) {
            // Bind parameters to the prepared statement
            mysqli_stmt_bind_param($stmt, "ssi", $page_title, $page_content, $active_status);
    
            // Execute the prepared statement
            mysqli_stmt_execute($stmt);
    
            // Close the statement
            mysqli_stmt_close($stmt);
    
            // Redirect after successful insertion
            header("Location: create_page.php");
            exit; // Add exit to stop further execution
        } else {
            // Handle the error if the statement was not prepared successfully
            echo "Error: " . mysqli_error($link);
        }
    }

    if(isset($_POST['btn-back'])){ 
        header("Location: cms.php");
    }

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
        echo EdytujPodstrone();
        echo ListaPodstron();

        if(isset($_POST['btn-edit'])){ 
            $page_id = $_POST['p_id']; 
            $title = $_POST['page_title']; 
            $content = $_POST['page_content']; 
            if(isset($_POST['p_status'])) {
                $status = $_POST['p_status'];
            } else {
                $status = 0;
            }
        
            $query = "SELECT * FROM page_list WHERE id='$page_id'";
            $result = mysqli_query($link, $query);
        
            if(mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result);
                $existing_title = $row['page_title'];
                $existing_content = $row['page_content'];
                if ($existing_title == $title && $existing_content == $content) {
                    echo "Podstrona o podanym tytule i zawartości już istnieje.";
                } elseif ($existing_title == $title) {
                    $query = "UPDATE page_list SET page_content='$content', status='$status' WHERE id='$page_id'";
                    $result = mysqli_query($link, $query);
                    echo "Zawartość strony została zmieniona.";
                } elseif ($existing_content == $content) {
                    $query = "UPDATE page_list SET page_title='$title', status='$status' WHERE id='$page_id'";
                    $result = mysqli_query($link, $query);
                    echo "Tytuł strony został zmieniony.";
                } else {
                    $query = "UPDATE page_list SET page_title='$title', page_content='$content', status='$status' WHERE id='$page_id'";
                    $result = mysqli_query($link, $query);
                }
            }
        }
    ?>
</body>
</html>
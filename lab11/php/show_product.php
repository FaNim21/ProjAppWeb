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
        echo ListaProdukt() # wywołanie funkcji wyświetlania produktów z danymi potrzebnymi do połączenia z bazą danych
    ?>
</div>
?>
</body>
</html>
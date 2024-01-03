<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="pl" />
    <title>Komputer moją pasją</title>
    <meta name="Author" content="Filip Gorczyca" />
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="#">
    <title>CMS</title>
</head>

<body>
    <?php
    session_start();
    require_once("../cfg.php");
    require_once("../admin/admin.php");

    echo FormularzLogowania();

    // Po wcisnieciu inputu x1_submit i przy prawidlowym wypelnieniu formularzu logowania przenosi do panelu cms
    if (isset($_POST['x1_submit'])) {
        $user = mysqli_real_escape_string($link, $_POST['login_email']);
        $password = mysqli_real_escape_string($link, $_POST['login_pass']);

        if ($user == $login && $password == $pass) {
            $_SESSION['user'] = $user;
            $_SESSION['admin_logged_in'] = true;
            header("Location: cms.php");
        } else {
            echo "Błędne dane. Proszę spróbować ponownie.";
            echo FormularzLogowania();
        }
    }
    if ((isset($_SESSION['admin_logged_in'])) && ($_SESSION['admin_logged_in'] == true)) {
        header('Location: cms.php');
        exit();
    }

    // Po wcisnieciu inputu x1_przypomnijHaslo wyswietla formularz w celu przypomnienia hasla
    if (isset($_POST['x1_przypomnijHaslo'])) {
        // $_FORMULARZ['version'] = 'przypomnij';
        header('Location: contact_page.php');
    }

    // Po wcisnieciu inputu x1_kontakt wyswietla formularz w celu kontaktu
    if(isset($_POST['x1_kontakt'])){
        // $_FORMULARZ['version'] = 'kontakt';
        header('Location: contact_page.php');
    }
    ?>
</body>

</html>
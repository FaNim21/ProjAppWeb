<!DOCTYPE html>
<html lang="pl">
<html>

<?php
require_once('../admin/admin.php'); # import pliku z funkcjami administracyjnimi
?>

<head>
    <link rel="stylesheet" href="../css/shop.css">
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="pl" />
    <title>Sklep</title>
    <meta name="Author" content="Filip Gorczyca" />
    <link rel="stylesheet" href="../css/shop.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>

<body>
    <div class="menu">
        <a href="../index.php?page=glowna&id=1">Strona główna</a>
        <a href="../index.php?page=historia&id=2">Historia</a>
        <a href="../index.php?page=csgo&id=3">CS:GO</a>
        <a href="../index.php?page=cs2&id=4">CS2</a>
        <a href="../index.php?page=kontakt&id=5">Kontakt</a>
        <a href="../index.php?page=skrypty&id=6">Skrypty</a>
        <a href="../index.php?page=filmy&id=7">Filmy</a>
        <a href="shop.php">Sklep</a>
        <a class="cta" href="admin_page.php">Logowanie</a>
    </div>

    <section class="main-content">
        <?php
        session_start(); # rozpoczęcie nowej sesji / wznowienie istniejącej
        function PokazProdukty()
        {
            require('../cfg.php'); # import pliku konfiguracyjnego
            $query = "SELECT * from products"; # zapytanie SQL wybierające wszystkie dane z tabeli products
            $result = mysqli_query($link, $query); # wykonanie zapytania zapisane do zmiennej $result
            echo '<table class="shop-table">'; # Tabela 
            echo '<tr>';
            echo "<th>Zdjęcie</th>";
            echo "<th>Nazwa</th>";
            echo "<th>Opis</th>";
            echo "<th>Cena</th>";
            echo "<th>Ilość</th>";
            echo "<th>Koszyk</th>";
            echo '</tr>';
            while ($row = mysqli_fetch_array($result)) { # pętla while iterująca przez wiersze wyniku zapytania tworząc nowy wiersz w tabeli HYML dla każdego z nich
                echo '<tr>';
                echo '<td><img src="data:image/png;base64,' . base64_encode($row['image']) . '" width="50%" height="50%"/></td>';
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . $row["description"] . "</td>";
                echo "<td>" . $row["netto_value"] . "</td>";
                $remainingQuantity = max(0, $row["amount"] - ($_SESSION['cart'][$row['id']]['value'] ?? 0));
                echo "<td>" . $remainingQuantity . "</td>";
                echo "<td> <form action='shop.php' method='post'>
                <input type='hidden' name='id' value='" . $row['id'] . "'>
                <input type='submit' class='button' id='button' value='Dodaj', name='addCart'>
                </form>
                </td>";
                echo '</tr>';
            }

            echo '</table>';
        }
        ?>

        <a href="cart.php" class="button-koszyk">Koszyk</a> <!--Przycisk przekierowujący do koszyka -->

        <?php
        function DodajDoKoszyka()
        {
            require("../cfg.php"); # import pliku konfiguracyjnego
            $product_id = $_POST['id'];
            $query = "SELECT amount FROM products WHERE id = $product_id"; # zapytanie pobierające ilość produktu z tabeli products gdzie id produktu jest równe temu pobranemu z tablicy wyżej
            $result = mysqli_query($link, $query); # wykonanie zapytania zapisane do zmiennej $result
            $product = mysqli_fetch_assoc($result);
            if ($product['amount'] <= 0) { # sprawdzenie dostępności produktu
                echo "Brak produktu na stanie";
            } else # jeśli produkt jest na stanie zwiększa jego ilość w koszyku sesji
            {
                if (!isset($_SESSION['cart'][$product_id])) {
                    $_SESSION['cart'][$product_id] = [
                        'id' => $product_id,
                        'value' => 1
                    ];
                } else {
                    $_SESSION['cart'][$product_id]['value']++;
                }
                header('Location: shop.php');
            }
        }
        ?>
        <?php
        if (isset($_POST['addCart'])) { # Sprawdzenie czy przycisk Dodaj został naciśnięty
            DodajDoKoszyka(); # Wywołanie funkcji DodajDoKoszyka()
        }
        ?>


        <?php
        PokazProdukty(); # Wywołanie funkcji PokazProdukty()
        ?>
    </section>
    <footer>
        <p>
            <?php
            $nr_indeksu = '164370';
            $nrGrupy = '2';
            echo 'Autor: Filip Gorczyca ' . $nr_indeksu . ' grupa ' . $nrGrupy;
            ?>
        </p>
    </footer>
</body>

</html>
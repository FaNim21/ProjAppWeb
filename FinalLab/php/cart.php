<link rel="stylesheet" href="../css/cart.css">

<!DOCTYPE html>
<html lang="pl">

<head>
    <h2>KOSZYK</h2>
</head>

<body>
    <a href="shop.php" class="button-shop">Powrót</a>
    <?php
    session_start(); # rozpoczęcie nowej sesji / wznowienie istniejącej

    if (isset($_POST["emptyCart"])) { # sprawdzenie czy zmienna emptyCart jest ustawiona i jeśli jest to czyści zawartość koszyka z sesji
        unset($_SESSION['cart']);
        exit();
    }

    function pokazKoszyk()
    {
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { # Sprawdzenie czy istnieje sesja koszyka i czy jest ona pusta
            require('../cfg.php'); # import pliku konfiguracyjnego
            $products = []; # pusta tablica products
            $ids = implode(',', array_keys($_SESSION['cart']));  # pobieranie danych produktów z tabeli "products" (produkty) na podstawie identyfikatorów produktów znajdujących się w koszyku
            $query = "SELECT * FROM products WHERE id IN ($ids)";
            $result = mysqli_query($link, $query);
            while ($row = mysqli_fetch_assoc($result)) { # utworzenie tablicy produktów, i dodawanie do niej produktów przez iterację
                $products[] = $row;
            }
            
            echo "<ul>";
            $totalBrutto = 0;
            $totalNetto = 0;
            foreach ($products as $product) {
                echo $product["title"];
                echo "<li>";
                echo '<td><img src="data:image/png;base64,' . base64_encode($product['image']) . '" width="50%" height="50%"/></td>';
                echo "<p>Tytuł: " . $product["title"] . "</p>";
                echo "<p>Cena netto: " . $product["netto_value"] . "zł</p>";
                echo "<p>Ilość: " . $_SESSION['cart'][$product['id']]['value'] . "</p>";
                echo "<form action='cart.php' method='post'>
                    <input type='hidden' name='id' value='" . $product['id'] . "'>
                    <input type='submit' value='Usuń' name='deleteProduct'>
                </form>";
                echo "</li>";

                $nettoProductVal = $product['netto_value']; # pobranie ceny netto
                $vat = $product['vat']; # pobranie wartości vat
                $totalValue = $nettoProductVal * (1 + $vat / 100); # wartość brutto
                $value = $_SESSION['cart'][$product['id']]['value'];
                $totalBrutto += ($totalValue * $value); # suma brutto wszystkich przedmiotów w koszyku
                $totalNetto += ($nettoProductVal * $value); # suma netto wszystkich przedmiotów w koszyku
            }

            echo "<b>Łączna kwota Netto:</b> $totalNetto zł";
            echo "<br/>";
            echo "<b>Łączna kwota Brutto:</b> $totalBrutto zł";
            echo "</ul>";
        } else {
            echo "W koszyku nie ma zawartości";
        }
    }

    function usunProdukt()
    {
        $id = $_POST['id']; # pobranie identyfikatora produktu z tablicy $_POST
        if (isset($_SESSION['cart'][$id]) && $_SESSION['cart'][$id]['value'] - 1 > 0) { # sprawdzene czy istnieje produkt o danym identyfikatorze w koszyku i czy ilość jest większa niż 1. Jeśli tak, to funkcja zmniejsza ilość produktu o 1, a jeśli nie, to usuwa produkt z koszyka.
            $_SESSION['cart'][$id]['value']--;
        } else {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: cart.php');
    }

    if (isset($_POST['deleteProduct'])) {
        usunProdukt();
    }
    ?>

    <div id="cart">
        <?php
        pokazKoszyk();
        ?>
    </div>
</body>

</html>
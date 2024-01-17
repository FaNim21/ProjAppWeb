<?php

require_once('../cfg.php');
require_once('../class/category.php');

/*EDYCJA STRON*/
function FormularzLogowania()
{
    $wynik = '
        <div class="logowanie-container">
            <h1 class="heading">Panel CMS:</h1>
            <div class="logowanie">
                <form method="POST" name="LoginForm" enctype="multipart/form-data" action="' . $_SERVER['REQUEST_URI'] . '">
                    <table>
                        <tr><td class="log4_t"></td><td><input type="text" name="login_email" class="logowanie" placeholder="email"/></td></tr>
                        <tr><td class="log4_t"></td><td><input type="password" name="login_pass" class="logowanie" placeholder="password"/></td></tr>
                        <tr><td>&nbsp;</td><td><input type="submit" name="x1_submit" class="button" value="Zaloguj" /></td></tr>
                        <tr><td>&nbsp;</td><td><input type="submit" name="x1_przypomnijHaslo" class="button" value="Przypomnij Hasło" /></td></tr>
                        <tr><td>&nbsp;</td><td><input type="submit" name="x1_kontakt" class="button" value="Kontakt" /></td></tr>
                        <tr><td>&nbsp;</td><td><input type="submit" name="x1_back" class="button" value="Powrot" /></td></tr>
                    </table>
                </form>
            </div>
        </div>
    ';
    return $wynik;
}

function ListaPodstron()
{
    global $link;

    $query = "SELECT * FROM page_list";
    $result = mysqli_query($link, $query);

    echo '<table>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Tytuł podstrony</th>';
    echo '<th>Opcje</th>';
    echo '</tr>';
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['page_title'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}

function EdytujPodstrone()
{
    $wynik = '
        <div class="editForm">
        <form action="' . $_SERVER['REQUEST_URI'] . '" method="POST">
            <h1>Edytuj stronę: </h1>
                <input type="number" name="p_id" placeholder="ID strony">
                <input type="text" name="page_title" placeholder="Tytuł strony">
                <textarea name="page_content" rows="20" cols="70 "placeholder="Treść strony"></textarea>
                <label><input type="checkbox" name="p_status" class="checkbox">Aktywna?</label>
                <div>
                    <div><input type="submit" value="edytuj" class="edit" name="btn-edit"></div>
                    <div><input type="submit" value="powrot" class="edit" name="btn-back"></div>
                </div>
            </form>
        </div>
        ';
    return $wynik;
}

function StworzPodstrone()
{
    $wynik = '
        <div class="createForm">
        <form action="' . $_SERVER['REQUEST_URI'] . '" method="POST">
            <h1>Dodaj stronę: </h1>
                <input type="number" name="p_id" placeholder="ID strony">
                <input type="text" name="page_title" placeholder="Tytuł strony">
                <textarea name="page_content" rows="20" cols="70 "placeholder="Treść strony"></textarea>
                <label><input type="checkbox" name="p_status" class="checkbox">Aktywna?</label>
                <div>
                    <div><input type="submit" value="stworz" class="create" name="btn-create"></div>
                    <div><input type="submit" value="powrot" class="edit" name="btn-back"></div>
                </div>
            </form>
        </div>
        ';
    return $wynik;
}

function UsunPodstrone()
{
    $wynik = '
        <div class="deleteForm">
        <form action="' . $_SERVER['REQUEST_URI'] . '" method="POST">
            <h1>Usuń stronę: </h1>
                <input type="number" name="p_id" placeholder="ID strony">
                <div>
                    <div><input type="submit" value="usun" class="delete" name="btn-delete"></div>
                    <div><input type="submit" value="powrot" class="edit" name="btn-back"></div>
                </div>
            </form>
        </div>
        ';
    return $wynik;
}


/*KATEGORIE I PRODUKTY*/
function Kategorie()
{ # wyświetlanie listy wszystkich kategorii z bazy danych (READ)
    global $link;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['btnAdd'])) {
            $category = new Category();
            $category->setCategoryName($_POST['new_category_name']);
            $category->setParent((int)$_POST['new_parent']);
            mysqli_query($link, $category->add());
        } elseif (isset($_POST['btnEdit'])) {
            $category = (getCategories($_POST['id']))[$_POST['id']];
            if (isset($category['main'])) {
                $category = $category['main'];
                $category->setCategoryName($_POST['category_name']);
                $category->setParent($_POST['parent']);
                $category->setId($_POST['id']);
                if ($category->changed()) {
                    echo 'EDITED';
                    mysqli_query($link, $category->edit());
                } else {
                    echo 'NOT EDITED';
                }
            } else {
                echo 'Category not found';
            }
        } elseif (isset($_POST['btnDel'])) {
            $category = (getCategories($_POST['id']))[$_POST['id']]['main'];
            mysqli_query($link, $category->delete());
        } elseif (isset($_POST['btnBack'])) {
            header("Location: cms.php");
        }
    }
    $categories = getCategories();
    echo '<table >';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Nazwa kategorii</th>';
    echo '<th>Rodzic</th>';
    echo '</tr>';
    foreach ($categories as $id => $category) {
        if (isset($category['main']))
            renderTree($categories, $id);
    }
    echo '</table>';
    echo '<form action="' . $_SERVER['REQUEST_URI'] . '" method="POST" id="new_category">'
        . '<br/><div class="nowy">Nowy rekord<br/>'
        . 'Nazwa Kategorii: <input type="text" name="new_category_name"/>'
        . '&nbsp;Rodzic<input type="text" name="new_parent"/>'
        . '</div></form> <input type="submit" name="btnAdd" value="Nowy" form="new_category"/>'
        . '<input type="submit" name="btnBack" value="Powrot" form="new_category"/>';
}

function getCategories($id = null)
{
    global $link;
    $categories = [];
    $query = 'SELECT c.* FROM categories AS c';
    if ($id) $query .= ' WHERE c.id = ' . $id;
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_object($result, "Category")) {
        if ($row->getParent() != 0) {
            if (isset($categories[$row->getParent()]))
                $categories[$row->getParent()]["childrens"][] = $row->getId();
            else
                $categories[$row->getParent()] = ["childrens" => [$row->getId()]];
        }
        $categories[$row->getId()]['main'] = $row;
    }
    return $categories;
}

function renderTree($categories, $id)
{
    $row = $categories[$id]['main'];
    echo '<tr>';
    echo '<form action="' . $_SERVER['REQUEST_URI'] . '" id="category_' . $row->getId() . '" method="POST"></form>';
    echo '<td>' . $row->getId() . '</td>';
    echo '<td><input type="text" name="category_name" value="' . $row->getCategoryName() . '" form="category_' . $row->getId() . '"/></td>';
    echo '<td><input type="text" name="parent" value="' . $row->getParent() . '" form="category_' . $row->getId() . '"/></td>';
    echo '<td class="buttons">'
        . '<input type="hidden" name="id" value="' . $row->getId() . '" form="category_' . $row->getId() . '"/>'
        . '<input type="submit" name="btnEdit" value="Edytuj" form="category_' . $row->getId() . '"/>'
        . '<input type="submit" name="btnDel" value="Usuń" form="category_' . $row->getId() . '"/>'
        . '</td>';
    echo '</tr>';
    if (isset($categories[$id]['childrens'])) {
        foreach ($categories[$id]['childrens'] as $parentId) {
            renderTree($categories, $parentId);
        }
    }
}

function ListaProdukt()
{ # wyświetlanie listy wszystkich podstron z bazy danych (READ)
    global $link;
    $query = "SELECT * FROM products";
    $result = mysqli_query($link, $query);

    echo '<table>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Nazwa</th>';
    echo '<th>Opis</th>';
    echo '<th>Data utworzenia</th>';
    echo '<th>Data modyfikacji</th>';
    echo '<th>Data wygaśnięcia</th>';
    echo '<th>Cena netto</th>';
    echo '<th>Vat</th>';
    echo '<th>Ilość</th>';
    echo '<th>Status dostępności</th>';
    echo '<th>Kategoria</th>';
    echo '<th>Waga</th>';
    echo '<th>Zdjęcie</th>';
    echo '</tr>';
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['title'] . '</td>';
        echo '<td>' . $row['description'] . '</td>';
        echo '<td>' . $row['creation_date'] . '</td>';
        echo '<td>' . $row['modify_date'] . '</td>';
        echo '<td>' . $row['expiration_date'] . '</td>';
        echo '<td>' . $row['netto_value'] . '</td>';
        echo '<td>' . $row['vat'] . '</td>';
        echo '<td>' . $row['amount'] . '</td>';
        echo '<td>' . $row['availability_status'] . '</td>';
        echo '<td>' . $row['category'] . '</td>';
        echo '<td>' . $row['weight'] . '</td>';
        echo '<td><img class="image" src="data:image/png;base64,' . base64_encode($row['image']) . '"/></td>';
        echo '</tr>';
    }
    echo '</table>';
}

function StworzProdukt()
{ # tworzenie nowej kategorii w bazie danych (CREATE)
    $wynik = '
        <div class="createForm">
        <form action="' . $_SERVER['REQUEST_URI'] . '" method="POST" enctype="multipart/form-data">
            <h1>Dodaj Produkt: </h1>
                <input type="number" name="id" placeholder="ID">
                <input type="text" name="title" placeholder="Nazwa">
                <input type="textarea" name="description" placeholder="Opis">
				<input type="date" name="expiration_date" placeholder="Data wygaśnięcia">
				<input type="number" name="netto_value" placeholder="Cena netto">
				<input type="number" name="vat" placeholder="Vat">
				<input type="number" name="amount" placeholder="Ilość">
				<label for="totalAmt"><input type="checkbox" step=0.01 id="totalAmt" name="availability_status" class="checkbox">Dostępne?</label>
				<input type="text" name="category" placeholder="Kategoria">
				<input type="text" name="weight" placeholder="Waga">
                <input type="file" name="image" accept="image/*" placeholder="Zdjęcie"/>
                <div>
                    <div><input type="submit" value="stworz" class="create" name="btn-create-p"></div>
                    <div><input type="submit" value="powrot" class="create" name="btn-back"></div>
                </div>
            </form>
        </div>
        ';
    return $wynik;
}

function UsunProdukt()
{ # usuwanie istniejącego produktu z bazy danych (DELETE)
    $wynik = '
        <div class="deleteForm">
        <form action="' . $_SERVER['REQUEST_URI'] . '" method="POST">
            <h1>Usuń produkt: </h1>
                <input type="number" name="id" placeholder="ID produktu">
                <div>
                    <div><input type="submit" value="usun" class="delete" name="btn-delete-p"></div>
                    <div><input type="submit" value="powrot" class="create" name="btn-back"></div>
                </div>
            </form>
        </div>
        ';
    return $wynik;
}

function EdytujProdukt()
{ # edycja danej podstrony z bazy danych (UPDATE)
    $wynik = '
        <div class="editForm">
        <form action="' . $_SERVER['REQUEST_URI'] . '" method="POST" enctype="multipart/form-data">
            <h1>Edytuj produkt: </h1>
				<input type="number" name="id" placeholder="ID">
				<input type="text" name="title" placeholder="Nazwa">
				<input type="textarea" name="description" placeholder="Opis">
				<input type="date" name="expiration_date" placeholder="Data wygaśnięcia">
				<input type="number" step=0.01 id="totalAmt" name="netto_value" placeholder="Cena netto">
				<input type="number" name="vat" placeholder="Vat">
				<input type="number" name="amount" placeholder="Ilość">
				<label><input type="checkbox" name="availability_status" class="checkbox">Dostępne?</label>
				<input type="text" name="category" placeholder="Kategoria">
				<input type="text" name="weight" placeholder="Waga">
				<input type="file" name="image" placeholder="Zdjęcie">
                <div>
                    <div><input type="submit" value="edytuj" class="edit" name="btn-edit-p"></div>
                    <div><input type="submit" value="powrot" class="create" name="btn-back"></div>
                </div>
            </form>
        </div>
        ';
    return $wynik;
}

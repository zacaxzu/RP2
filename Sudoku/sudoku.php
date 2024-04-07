<h1>Sudoku 6×6!</h1>
Igrač:
<?php
$ime_igraca = $_POST["ime_igraca"];
echo $ime_igraca;
?>
<br>
Broj pokušaja:

<?php
session_start();
include('ispis_sudokua.php');

if (!isset($_SESSION['polje_2'])) {
    inicijalizacija($_SESSION['polje_2'], $polje);
}
ispis_tablice($polje, $polje);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['odabir_poteza'])) {
        $potezType = $_POST['odabir_poteza'];
        echo $potezType;
        if ($potezType === 'unesi_broj') {
            echo '<br>' . 'Kliknut unesi_broj' . '<br>';
            $broj = $_POST['upisan_broj'];
            echo 'Upisan broj je: ' . $broj . '<br>';
            $broj_retka = $_POST['broj_retka'] - 1;
            echo 'broj_retka: ' . $broj_retka . '<br>';
            $broj_stupca = $_POST['broj_stupca'] - 1;
            echo 'broj_stupca: ' . $broj_stupca . '<br>';

            dodaj_broj($_SESSION['polje_2'], $broj, $broj_retka, $broj_stupca);
        } else if ($potezType === 'obrisi_broj') {
            echo 'Kliknut obrisi_broj';
        } else if ($potezType === 'reset_igre') {
            echo 'Kliknut reset_igre';
            unset($_SESSION['polje_2']);
            inicijalizacija($_SESSION['polje_2'], $polje);
        }
    }
}

ispis_tablice($_SESSION['polje_2'], $polje);
?>
<br>

<?php include('odabir_poteza.html'); ?>
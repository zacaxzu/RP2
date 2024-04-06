<h1>Sudoku 6×6!</h1>
Igrač:
<?php
$ime_igraca = $_POST["ime_igraca"];
echo $ime_igraca;
?>
<br>
Broj pokušaja:

<?php
include('ispis_sudokua.php');
include('odabir_poteza.html');
?>

<br>
<?php
if (isset($_POST['odabir_poteza'])) {
    $potezType = $_POST['odabir_poteza'];
    echo $potezType;
    if ($potezType === 'unesi_broj') {
        echo '<br>' . 'Kliknut unesi_broj' . '<br>';
        $broj = $_POST['upisan_broj'];
        echo 'Upisan broj je: ' . $broj . '<br>';
        $broj_retka = $_POST['broj_retka'];
        echo 'broj_retka: ' . $broj_retka . '<br>';
        $broj_stupca = $_POST['broj_stupca'];
        echo 'broj_stupca: ' . $broj_stupca . '<br>';

        $polje[$broj_retka][$broj_stupca] = $broj;
        echo 'Novi broj: ' . $polje[$broj_retka][$broj_stupca];
    } else if ($potezType === 'obrisi_broj') {
        echo 'Kliknut obrisi_broj';
    } else if ($potezType === 'reset_igre') {
        echo 'Kliknut reset_igre';
    }
}
?>
<br>
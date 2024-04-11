<h1>Sudoku 6×6!</h1>

<?php
?>
<br>
Broj pokušaja:

<?php
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){   
    if(isset($_POST['ime_igraca'])){
        $ime_igraca = $_POST["ime_igraca"];
        echo 'Igrač: $ime_igraca';
    }
}
    
echo 'Igrač:' . $ime_igraca;

include('ispis_sudokua.php');

if (!isset($_SESSION['polje_2'])) {
    inicijalizacija($_SESSION['polje_2'], $polje);
    inicijalizacija_pomocnog_polja($_SESSION['polje_3'], $polje);
}
//ispis_tablice($polje, $polje);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['odabir_poteza'])) {
        $potezType = $_POST['odabir_poteza'];
        echo $potezType;
        if ($potezType === 'unesi_broj') {
            //echo 'Upisan broj je: ' . $broj . '<br>';
            $broj_retka = $_POST['broj_retka'] - 1;
            //echo 'broj_retka: ' . $broj_retka . '<br>';
            $broj_stupca = $_POST['broj_stupca'] - 1;
            //echo 'broj_stupca: ' . $broj_stupca . '<br>';
            //echo '<br>' . 'Kliknut unesi_broj' . '<br>';
            $broj = $_POST['upisan_broj'];
            //provjera unosa
            if (!preg_match('/^[0-6]$/', $broj)) {
                echo 'Nije unesen broj!';
                $polje_2 = $_SESSION['polje_2'];
                $broj = $polje_2[$broj_retka][$broj_stupca];
            } 
            if(validan_potez($_SESSION['polje_2'])){
                echo 'Usao u validan_potez!<br>';
                dodaj_broj($_SESSION['polje_3'], 1, $broj_retka, $broj_stupca);
                dodaj_broj($_SESSION['polje_2'], $broj, $broj_retka, $broj_stupca);
            }
            elseif(!validan_potez($_SESSION['polje_2'])){
                dodaj_broj($_SESSION['polje_3'], 0, $broj_retka, $broj_stupca);
                dodaj_broj($_SESSION['polje_2'], $broj, $broj_retka, $broj_stupca);
            }
            //echo 'Validan potez return: ' . validan_potez($_SESSION['polje_2']);
            //if(validan_potez($_SESSION['polje_2'])){
                //dodaj_broj($_SESSION['polje_2'], $broj, $broj_retka, $broj_stupca);
            //}
            //else{
            //    echo 'Potez nije validan!';
            //}
            
        } 
        else if ($potezType === 'obrisi_broj') {
            echo 'Kliknut obrisi_broj';
            $broj_retka = $_POST['redak_obrisi'] - 1;
            //echo 'broj_retka: ' . $broj_retka . '<br>';
            $broj_stupca = $_POST['stupac_obrisi'] - 1;
            //echo 'broj_stupca: ' . $broj_stupca . '<br>';
            if($polje[$broj_retka][$broj_stupca] == null){
                obrisi_broj($_SESSION['polje_2'], $polje, $broj_retka, $broj_stupca);
            }
        } 
        else if ($potezType === 'reset_igre') {
            echo 'Kliknut reset_igre';
            unset($_SESSION['polje_2']);
            unset($_SESSION['polje_3']);
            inicijalizacija($_SESSION['polje_2'], $polje);
            inicijalizacija_pomocnog_polja($_SESSION['polje_3'], $polje);
        }
        //usporedba_polja_fix($_SESSION['polje_2'], $_SESSION['polje_3'], $polje);
        ispis_tablice($_SESSION['polje_2'], $polje, $_SESSION['polje_3']);
        echo '<br>';
        ispis_tablice_2($_SESSION['polje_2']);
        echo '<br>';
        ispis_tablice_2($_SESSION['polje_3']);
    }
}

?>
<br>

<?php include('odabir_poteza.html'); ?>
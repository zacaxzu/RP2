

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ime_igraca'])) {
        $_SESSION['ime_igraca'] = $_POST["ime_igraca"];
    }
}
// Accessing the player's name from the session variable

if (isset($_SESSION['ime_igraca'])) {
    echo 'Igrač: ' . $_SESSION['ime_igraca'] . '<br>';
} else {
    echo 'Igrač nije postavljen.';
}


include('ispis_sudokua.php');

if (!isset($_SESSION['polje_2'])) {
    inicijalizacija_broja_pokusaja($broj_pokusaja);
    inicijalizacija($_SESSION['polje_2'], $polje);
    inicijalizacija_pomocnog_polja($_SESSION['polje_3'], $polje);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the restart button is pressed and increment $broj_pokusaja
    if (isset($_POST['restart'])) {
        $_SESSION['broj_pokusaja']++;
    }
    echo 'Broj pokusaja: ' . $_SESSION['broj_pokusaja'] . '<br>';
}
//ispis_tablice($polje, $polje);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['odabir_poteza'])) {
        $potezType = $_POST['odabir_poteza'];
        //echo $potezType;
        if ($potezType === 'unesi_broj') {
            $broj_retka = $_POST['broj_retka'] - 1;
            $broj_stupca = $_POST['broj_stupca'] - 1;
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
        } 
        else if ($potezType === 'obrisi_broj') {
            //echo 'Kliknut obrisi_broj';
            $broj_retka = $_POST['redak_obrisi'] - 1;
            //echo 'broj_retka: ' . $broj_retka . '<br>';
            $broj_stupca = $_POST['stupac_obrisi'] - 1;
            //echo 'broj_stupca: ' . $broj_stupca . '<br>';
            if($polje[$broj_retka][$broj_stupca] == null){
                echo '<br>Usao u prvi if!<br>';
                obrisi_broj($_SESSION['polje_2'], $polje, $_SESSION['polje_3'], $broj_retka, $broj_stupca);
            }
        }
        else if ($potezType === 'reset_igre') {
            //echo 'Kliknut reset_igre';
            unset($_SESSION['polje_2']);
            unset($_SESSION['polje_3']);
            inicijalizacija($_SESSION['polje_2'], $polje);
            inicijalizacija_pomocnog_polja($_SESSION['polje_3'], $polje);
        }
        if(provjera_zavrsetka_igre($_SESSION['polje_3'])){
            echo 'Čestitam pobijedili ste!';
        }
        //usporedba_polja_fix($_SESSION['polje_2'], $_SESSION['polje_3'], $polje);
        usporedba_polja_fix($_SESSION['polje_2'], $_SESSION['polje_3'], $polje);
        //echo '<br>Ispis polje_2:';
        ispis_tablice($_SESSION['polje_2'], $polje, $_SESSION['polje_3']);
        /*
        echo '<br>Ispis polje_2: ';
        ispis_tablice_2($_SESSION['polje_2']);
        echo '<br>Ispis polje_3: ';
        ispis_tablice_2($_SESSION['polje_3']);
        echo '<br>Ispis polje: ';
        ispis_tablice_2($polje);
        */
    }
}

?>
<br>

<?php include('odabir_poteza.html'); ?>
<h1>Sudoku 6x6!</h1>

<?php
session_start();
include('ispis_sudokua.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ime_igraca'])) {
        $_SESSION['ime_igraca'] = $_POST["ime_igraca"];
        $_SESSION['broj_pokusaja'] = 0;  
    }

    if (isset($_SESSION['ime_igraca'])) {
        echo 'Igrač: ' . $_SESSION['ime_igraca'] . '<br>';
    } else {
        echo 'Igrač nije postavljen.';
    }

    if (isset($_POST['odabir_sudokua'])) {
        $_SESSION['odabir_sudokua'] = $_POST['odabir_sudokua'];

        if ($_POST['odabir_sudokua'] === 'sudoku1') {
            $_SESSION['polje'] = $polje1;
        } elseif ($_POST['odabir_sudokua'] === 'sudoku2') {
            $_SESSION['polje'] = $polje2;
        }
    }
    
    if (!isset($_SESSION['broj_pokusaja'])) {
        $_SESSION['broj_pokusaja'] = 0;  
    }
    else {
        echo 'Broj pokusaja: ' . $_SESSION['broj_pokusaja'] . '<br><br>';
    }
    

    if (isset($_POST['ime_igraca'])) {
        inicijalizacija($_SESSION['polje_2'], $_SESSION['polje']);
        inicijalizacija_pomocnog_polja($_SESSION['polje_3'], $_SESSION['polje']);
        //ispis_tablice($_SESSION['polje_2'], $polje, $_SESSION['polje_3']);  
    }
}

if (!isset($_SESSION['polje_2'])) {
    inicijalizacija($_SESSION['polje_2'], $polje);
    inicijalizacija_pomocnog_polja($_SESSION['polje_3'], $polje);
}

//echo 'Broj pokusaja: ' . $_SESSION['broj_pokusaja'] . '<br><br>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //var_dump($_POST);
    if (isset($_POST['odabir_poteza'])) {
        $potezType = $_POST['odabir_poteza'];
        //echo $potezType;
        if ($potezType === 'unesi_broj') {
            if (isset($_POST['sudoku_cell'])) {
                $sudokuCells = $_POST['sudoku_cell'];

                foreach ($sudokuCells as $i => $row) {
                    foreach ($row as $j => $cell) {
                        // Do something with the cell value
                        //echo "Row: {$i}, Column: {$j}, Value: {$cell}<br>";
                        if($cell !== "" && $_SESSION['polje'][$i][$j] === null && validan_potez_2($_SESSION['polje_2'], $cell, $i, $j)){
                            dodaj_broj($_SESSION['polje_3'], 1, $i, $j);
                            dodaj_broj($_SESSION['polje_2'], $cell, $i, $j);
                        }else if($cell !== "" && $_SESSION['polje'][$i][$j] === null && !validan_potez_2($_SESSION['polje_2'], $cell, $i, $j)){
                            dodaj_broj($_SESSION['polje_3'], 0, $i, $j);
                            dodaj_broj($_SESSION['polje_2'], $cell, $i, $j);
                        }
                    }
                }
            }
        } 
        else if ($potezType === 'obrisi_broj') {
            //echo 'Kliknut obrisi_broj';
            $broj_retka = $_POST['redak_obrisi'] - 1;
            //echo 'broj_retka: ' . $broj_retka . '<br>';
            $broj_stupca = $_POST['stupac_obrisi'] - 1;
            //echo 'broj_stupca: ' . $broj_stupca . '<br>';
            if($_SESSION['polje'][$broj_retka][$broj_stupca] == null){
                //echo '<br>Usao u prvi if!<br>';
                obrisi_broj($_SESSION['polje_2'], $_SESSION['polje'], $_SESSION['polje_3'], $broj_retka, $broj_stupca);
            }
        }
        else if ($potezType === 'reset_igre') {
            //echo 'Kliknut reset_igre';
            $_SESSION['broj_pokusaja']++;
            unset($_SESSION['polje_2']);
            unset($_SESSION['polje_3']);
            inicijalizacija($_SESSION['polje_2'], $_SESSION['polje']);
            inicijalizacija_pomocnog_polja($_SESSION['polje_3'], $_SESSION['polje']);
        }
        if(provjera_zavrsetka_igre($_SESSION['polje_3'])){
            echo 'Čestitam pobijedili ste!';
        }
        usporedba_polja_fix($_SESSION['polje_2'], $_SESSION['polje_3'], $_SESSION['polje']);
    }
}
include('odabir_poteza.php');
?>
<br>

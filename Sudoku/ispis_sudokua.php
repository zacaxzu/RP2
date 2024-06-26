<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sudoku</title>
</head>

<body>
  <h1>Sudoku 6×6!</h1>
  <?php
  $polje1 = array(
    array(null, null, 4, null, null, null),
    array(null, null, null, 2, 3, null),
    array(3, null, null, null, 6, null),
    array(null, 6, null, null, null, 2),
    array(null, 2, 1, null, null, null),
    array(null, null, null, 5, null, null),
  );

  $polje2 = array(
    array(6, 2, null, 5, null, 3),
    array(null, null, null, null, null, null),
    array(5, null, null, null, 3, null),
    array(null, 6, null, null, 2, null),
    array(null, null, null, 3, 4, 6),
    array(3, null, 6, null, null, null),
  );

  $polje = array();

  function inicijalizacija_odabira_polja(&$polje, $odabrano_polje)
  {
    $polje = $odabrano_polje;
  }

  function inicijalizacija(&$polje_2, &$polje)
  {
    $polje_2 = $polje;
  }

  function inicijalizacija_pomocnog_polja(&$polje_3, &$polje)
  {
    $polje_3 = $polje; 
    for ($i = 0; $i < 6; $i++) {
      for ($j = 0; $j < 6; $j++) {
        if ($_SESSION['polje'][$i][$j] !== null) {
          $polje_3[$i][$j] = 2; 
        }
      }
    }
  }

  function inicijalizacija_broja_pokusaja(&$broj_pokusaja)
  {
    $broj_pokusaja = 0;
  }

  function dodaj_broj(&$polje_2, $broj, $redak, $stupac)
  {
    $polje_2[$redak][$stupac] = $broj;
  }

  function validan_potez($polje_2)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_POST['odabir_poteza'])) {
        $potezType = $_POST['odabir_poteza'];
        if ($potezType === 'unesi_broj') {
          $validan = 1;
          $broj = $_POST['upisan_broj'];
          //echo 'Upisan broj je: ' . $broj . '<br>';
          $broj_retka = $_POST['broj_retka'] - 1;
          //echo 'broj_retka: ' . $broj_retka . '<br>';
          $broj_stupca = $_POST['broj_stupca'] - 1;
          //echo 'broj_stupca: ' . $broj_stupca . '<br>';
          $validan = provjera_stupca_retka($polje_2, $broj, $broj_stupca, $broj_retka);
          //echo '$validan: ' . $validan . '<br>';
          if ($validan) $validan = provjera_bloka($polje_2, $broj, $broj_stupca, $broj_retka);
          //echo '$validan: ' . $validan . '<br>';
          return $validan;
        }
      }
    }
  }

  function validan_potez_2(&$polje_21, $broj1, $broj_retka1, $broj_stupca1)
  {
    $polje_2 = $polje_21;
    $broj = $broj1;
    //echo '$broj: ' . $broj;
    $broj_stupca = $broj_stupca1;
    $broj_retka = $broj_retka1;
    $validan = true;
    $validan = provjera_stupca_retka($polje_2, $broj, $broj_stupca, $broj_retka);
    if ($validan) $validan = provjera_bloka($polje_2, $broj, $broj_stupca, $broj_retka);
    return $validan;
  }

  function provjera_stupca_retka($polje_2, $broj, $broj_stupca, $broj_retka)
  {
    if (isset($polje_2) && is_array($polje_2) && isset($polje_2[$broj_retka])) {
      for ($i = 0; $i < 6; $i++) {
        if (isset($polje_2[$broj_retka][$i]) && $polje_2[$broj_retka][$i] == $broj && $i !== $broj_stupca) {
          //echo 'Uneseni broj: ' . $broj . ' već se nalazi u odabranom retku!<br>';
          return 0;
        }
        if (isset($polje_2[$i][$broj_stupca]) && $polje_2[$i][$broj_stupca] == $broj && $i !== $broj_retka) {
          //echo 'Ušao u provjera_stupca_retka.<br>';
          //echo 'Uneseni broj: ' . $broj . ' već se nalazi u odabranom stupcu!';
          return 0;
        }
      }
      return 1;
    }
  }

  function provjera_bloka($polje_2, $broj, $broj_stupca, $broj_retka)
  {
    if ((floor($broj_stupca / 3)) == 0) $stupac_bloka = 0;
    else $stupac_bloka = 1;
    if ((floor($broj_retka / 2)) == 0) $redak_bloka = 0;
    else if ((floor($broj_retka / 2)) == 1) $redak_bloka = 1;
    else if ((floor($broj_retka / 2)) == 2) $redak_bloka = 2;

    if ($redak_bloka === 0 && $stupac_bloka === 0) {
      //echo 'Ušao u $redak_bloka === 0 && $stupac_bloka === 0';
      for ($i = $redak_bloka; $i < 2; $i++) {
        for ($j = $stupac_bloka; $j < 3; $j++) {
          if (($polje_2[$i][$j] == $broj) && ($i !== $broj_retka && $j !== $broj_stupca)) {
            return 0;
          }
        }
      }
    } else if ($redak_bloka === 0 && $stupac_bloka === 1) {
      //echo 'Ušao u $redak_bloka === 0 && $stupac_bloka === 1';
      for ($i = $redak_bloka; $i < 2; $i++) {
        for ($j = $stupac_bloka + 2; $j < 6; $j++) {
          if ($polje_2[$i][$j] == $broj && ($i !== $broj_retka && $j !== $broj_stupca)) {
            return 0;
          }
        }
      }
    } else if ($redak_bloka === 1 && $stupac_bloka === 0) {
      //echo 'Ušao u $redak_bloka === 1 && $stupac_bloka === 0';
      for ($i = $redak_bloka + 1; $i < 4; $i++) {
        for ($j = $stupac_bloka; $j < 3; $j++) {
          if ($polje_2[$i][$j] == $broj && ($i !== $broj_retka && $j !== $broj_stupca)) {
            return 0;
          }
        }
      }
    } else if ($redak_bloka === 1 && $stupac_bloka === 1) {
      //echo 'Ušao u $redak_bloka === 1 && $stupac_bloka === 1';
      for ($i = $redak_bloka + 1; $i < 4; $i++) {
        for ($j = $stupac_bloka + 2; $j < 6; $j++) {
          if ($polje_2[$i][$j] == $broj && ($i !== $broj_retka && $j !== $broj_stupca)) {
            return 0;
          }
        }
      }
    } else if ($redak_bloka === 2 && $stupac_bloka === 0) {
      //echo 'Ušao u $redak_bloka === 2 && $stupac_bloka === 0';
      for ($i = $redak_bloka + 2; $i < 6; $i++) {
        for ($j = $stupac_bloka; $j < 3; $j++) {
          if ($polje_2[$i][$j] == $broj && ($i !== $broj_retka && $j !== $broj_stupca)) {
            return 0;
          }
        }
      }
    } else if ($redak_bloka === 2 && $stupac_bloka === 1) {
      //echo 'Ušao u $redak_bloka === 2 && $stupac_bloka === 1';
      for ($i = $redak_bloka + 2; $i < 6; $i++) {
        for ($j = $stupac_bloka + 2; $j < 6; $j++) {
          if ($polje_2[$i][$j] == $broj && ($i !== $broj_retka && $j !== $broj_stupca)) {
            return 0;
          }
        }
      }
    }
    return 1;
  }

  function obrisi_broj(&$polje_2, $polje, &$polje_3, $broj_retka, $broj_stupca)
  {
    //echo '<br>$broj_stupca: ' . $broj_stupca . '<br>';
    //echo '$broj_retka: ' . $broj_retka . '<br>';
    if ($polje[$broj_retka][$broj_stupca] == null) {
      //echo '<br>Usao u drugi if brisanja!<br>';
      $polje_2[$broj_retka][$broj_stupca] = null;
      $polje_3[$broj_retka][$broj_stupca] = null;
    }
  }

  //Podešava polje_3 blue/red
  function usporedba_polja_fix($polje_2, &$polje_3, &$polje)
  {
    for ($i = 0; $i < 6; $i++) {
      for ($j = 0; $j < 6; $j++) {
        /*
        echo 'PROVJERA_STUPCA_RETKA: ' . provjera_stupca_retka($polje_2, $polje_2[$i][$j], $j, $i) . '<br>';
        echo '<br>PROVJERA_BLOKA: ' . provjera_bloka($polje_2, $polje_2[$i][$j], $j, $i) . '<br>';
        echo '$polje[$i][$j]: ' . $polje[$i][$j] . '<br>';
        */
        if ($_SESSION['polje'][$i][$j] !== null) {
          //echo '$polje[$i][$j]' . $polje[$i][$j] . '<br>';
          dodaj_broj($polje_3, 2, $i, $j);
        } elseif (
          provjera_stupca_retka($polje_2, $polje_2[$i][$j], $j, $i) &&
          provjera_bloka($polje_2, $polje_2[$i][$j], $j, $i) &&
          $_SESSION['polje'][$i][$j] == null
        ) {
          //echo 'Drugi if: $polje[$i][$j] = ' . $polje[$i][$j] . '<br>';
          dodaj_broj($polje_3, 1, $i, $j);
        } elseif (
          !provjera_stupca_retka($polje_2, $polje_2[$i][$j], $j, $i) ||
          !provjera_bloka($polje_2, $polje_2[$i][$j], $j, $i) &&
          $_SESSION['polje'][$i][$j] == null
        ) {
          dodaj_broj($polje_3, 0, $i, $j);
        } else {
          dodaj_broj($polje_3, null, $i, $j);
        }
      }
    }
  }

  function provjera_zavrsetka_igre($polje_3)
  {
    for ($i = 0; $i < 6; $i++) {
      for ($j = 0; $j < 6; $j++) {
        if ($polje_3[$i][$j] == 0) return 0;
      }
    }
    return 1;
  }

  function isEditable($polje, $i, $j)
  {
    return $polje[$i][$j] === null;
  }

  function ispis_tablice($polje_2, $polje, $polje_3)
  {
    echo '<form method="post" action="sudoku.php">';
    echo '<table>';
    for ($i = 0; $i < 6; $i++) {
      echo "<tr>";
      for ($j = 0; $j < 6; $j++) {
        $cellValue = $polje_2[$i][$j];
        $isValid = validan_potez_2($polje_2, $cellValue, $i, $j);

        $class = '';

        if (!isEditable($polje, $i, $j)) {
          $class = 'zadani_brojevi';
        } else {
          $class = 'editable';
          $class .= $isValid ? ' dodani_brojevi' : ' nevalidni_dodani_brojevi';
        }

        if ($i === 1 || $i === 3) {
          $class .= ' horizontalna_linija';
        }
        if ($j === 2) {
          $class .= ' vertikalna_linija';
        }

        if ($cellValue === null) {
          ?>
          <input type="hidden" name="broj_retka" value="<?php echo $i; ?>">
          <input type="hidden" name="broj_stupca" value="<?php echo $j; ?>">
          <?php
          echo "<td class='$class'><input class='input-celija' type='text' name='cell[$i][$j]' value='{$polje_2[$i][$j]}' maxlength='1'></td>";
          //echo '$i: ' . $i . ' $j: ' . $j . '<br>';
        } else {
          echo "<td class='$class'>$cellValue</td>";
        }
      }
      echo "</tr>";
    }
  echo '</table>';
  ?>;
  <?php
  echo '</form>';
}


function ispis_tablice_2($polje_2)
      {
        echo '<table>';
        for ($i = 0; $i < 6; $i++) {
          echo "<tr>";
          for ($j = 0; $j < 6; $j++) {
            echo "<td class='dodani_brojevi'>" . $polje_2[$i][$j] . "</td>";
          }
        }
        echo '</table>';
      }

function validNumbers($grid, $row, $col)
      {
        $valid = range(1, 6); // All numbers from 1 to 6 are considered valid by default

        // Remove numbers already in the same row
        for ($i = 0; $i < 6; $i++) {
          if ($grid[$row][$i] !== null && in_array($grid[$row][$i], $valid)) {
            unset($valid[array_search($grid[$row][$i], $valid)]);
          }
        }

        // Remove numbers already in the same column
        for ($i = 0; $i < 6; $i++) {
          if ($grid[$i][$col] !== null && in_array($grid[$i][$col], $valid)) {
            unset($valid[array_search($grid[$i][$col], $valid)]);
          }
        }

        // Remove numbers already in the same 2x3 box
        $boxRowStart = floor($row / 2) * 2;
        $boxColStart = floor($col / 3) * 3;

        for ($i = $boxRowStart; $i < $boxRowStart + 2; $i++) {
          for ($j = $boxColStart; $j < $boxColStart + 3; $j++) {
            if ($grid[$i][$j] !== null && in_array($grid[$i][$j], $valid)) {
              unset($valid[array_search($grid[$i][$j], $valid)]);
            }
          }
        }

        return $valid;
      }


        ?>

</body>

</html>
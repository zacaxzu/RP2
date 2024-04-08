<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="ispis_sudokua.css" />
</head>

<body>
  <br />
  <?php
  $polje = array(
    array(null, null, 4, null, null, null),
    array(null, null, null, null, null, null),
    array(3, null, null, null, 6, null),
    array(null, 6, null, null, null, 2),
    array(null, 2, 1, null, null, null),
    array(null, null, null, 5, null, null),
  );

  function inicijalizacija(&$polje_2, &$polje)
  {
    $polje_2 = $polje;
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
          $validan = true;
          $broj = $_POST['upisan_broj'];
          $broj_retka = $_POST['broj_retka'] - 1;
          $broj_stupca = $_POST['broj_stupca'] - 1;
          $validan = provjera_stupca_retka($polje_2, $broj, $broj_stupca, $broj_retka);
          if($validan) $validan = provjera_bloka($polje_2, $broj, $broj_stupca, $broj_retka);
          return $validan;
        }
      }
    }
  }

  function provjera_stupca_retka($polje_2, $broj, $broj_stupca, $broj_redka)
  {
    for ($i = 0; $i < 6; $i++) {
      var_dump($polje_2[$broj_redka][$i]);
      var_dump($broj);
      if ($polje_2[$broj_redka][$i] == $broj) {
        echo 'Uneseni broj: ' . $broj . ' već se nalazi u odabranom retku!<br>';
        return false;
      }
      if ($polje_2[$i][$broj_stupca] == $broj) {
        echo 'Uneseni broj: ' . $broj . ' već se nalazi u odabranom stupcu!';
        return false;
      }
    }
    return true;
  }

  function provjera_bloka($polje_2, $broj, $broj_stupca, $broj_redka)
  {
    if ((floor($broj_stupca / 3)) == 0) $stupac_bloka = 0;
    else $stupac_bloka = 1;
    if ((floor($broj_redka / 2)) == 0) $redak_bloka = 0;
    else if ((floor($broj_redka / 2)) == 1) $redak_bloka = 1;
    else if ((floor($broj_redka / 2)) == 2) $redak_bloka = 2;

    echo '<br>$broj_stupca: ' . $broj_stupca . '<br>';
    echo '$broj_retka: ' . $broj_redka . '<br>';
    echo 'floor($broj_stupca / 3): ' . floor($broj_stupca / 3) . '<br>';
    echo '(floor($broj_redka / 2): ' . floor($broj_redka / 2) . '<br>';
    
    echo 'provjera_bloka: $i = ' . $redak_bloka . ' $j = ' . $stupac_bloka;
    if ($redak_bloka === 0 && $stupac_bloka === 0)
    {
      echo 'Ušao u $redak_bloka === 0 && $stupac_bloka === 0';
      for ($i = $redak_bloka; $i < 2; $i++) {
        for ($j = $stupac_bloka; $j < 3; $j++) {
          if ($polje_2[$i][$j] == $broj) {
            return false;
          }
        }
      }
    }
    else if ($redak_bloka === 0 && $stupac_bloka === 1)
    {
      echo 'Ušao u $redak_bloka === 0 && $stupac_bloka === 1';
      for ($i = $redak_bloka; $i < 2; $i++) {
        for ($j = $stupac_bloka + 2; $j < 6; $j++) {
          if ($polje_2[$i][$j] == $broj) {
            return false;
          }
        }
      }
    } 
    else if ($redak_bloka === 1 && $stupac_bloka === 0) 
    {
      echo 'Ušao u $redak_bloka === 1 && $stupac_bloka === 0';
      for ($i = $redak_bloka + 1; $i < 4; $i++) {
        for ($j = $stupac_bloka; $j < 3; $j++) {
          if ($polje_2[$i][$j] == $broj) {
            return false;
          }
        }
      }
    } 
    else if ($redak_bloka === 1 && $stupac_bloka === 1) 
    {
      echo 'Ušao u $redak_bloka === 1 && $stupac_bloka === 1';
      for ($i = $redak_bloka + 1; $i < 4; $i++) {
        for ($j = $stupac_bloka + 2; $j < 6; $j++) {
          if ($polje_2[$i][$j] == $broj) {
            return false;
          }
        }
      }
    } 
    else if ($redak_bloka === 2 && $stupac_bloka === 0) 
    {
      echo 'Ušao u $redak_bloka === 2 && $stupac_bloka === 0';
      for ($i = $redak_bloka + 2; $i < 6; $i++) {
        for ($j = $stupac_bloka; $j < 3; $j++) {
          if ($polje_2[$i][$j] == $broj) {
            return false;
          }
        }
      }
    } 
    else if ($redak_bloka === 2 && $stupac_bloka === 1) 
    {
      echo 'Ušao u $redak_bloka === 2 && $stupac_bloka === 1';
      for ($i = $redak_bloka + 2; $i < 6; $i++) {
        for ($j = $stupac_bloka + 2; $j < 6; $j++) {
          if ($polje_2[$i][$j] == $broj) {
            return false;
          }
        }
      }
    } 
    return true;
  }

  function obrisi_broj(&$polje_2, $polje, $broj_stupca, $broj_retka)
  {
    echo '<br>$broj_stupca: ' . $broj_stupca . '<br>';
    echo '$broj_retka: ' . $broj_retka . '<br>';
    if($polje[$broj_retka][$broj_stupca] == null)
    {
      echo 'Usao u if!<br>';
      $polje_2[$broj_retka][$broj_stupca] = null;
    }
  }

  ?>
  <table>
    <?php
    function ispis_tablice($polje_2, $polje)
    {
      echo '<table>';
      for ($i = 0; $i < 6; $i++) {
        echo "<tr>";
        for ($j = 0; $j < 6; $j++) {
          if ($j === 5 && $polje[$i][$j] != null) {
            if ($i === 1 || $i === 3) {
              echo "<th class='zadani_brojevi horizontalna_linija'>" . $polje_2[$i][$j] . "</th>";
            } else {
              echo "<th class='zadani_brojevi'>" . $polje_2[$i][$j] . "</th>";
            }
          } else if ($polje[$i][$j] != null) {
            if ($j === 2) {
              if ($i === 1 || $i === 3) {
                echo "<td class='zadani_brojevi vertikalna_linija horizontalna_linija'>" . $polje_2[$i][$j] . "</td>";
              } else {
                echo "<td class='zadani_brojevi vertikalna_linija'>" . $polje_2[$i][$j] . "</td>";
              }
            } else {
              if ($i === 1 || $i === 3) {
                echo "<td class='zadani_brojevi horizontalna_linija'>" . $polje_2[$i][$j] . "</td>";
              } else {
                echo "<td class='zadani_brojevi'>" . $polje_2[$i][$j] . "</td>";
              }
            }
          } else if ($j === 5 && $polje[$i][$j] === null) {
            if ($i === 1 || $i === 3) {
                echo "<th class='dodani_brojevi horizontalna_linija'>" . $polje_2[$i][$j] . "</th>";
            } else {
              echo "<th class='dodani_brojevi'>" . $polje_2[$i][$j] . "</th>";
            }
          } else if ($polje[$i][$j] === null) {
            if ($j === 2) {
              if ($i === 1 || $i === 3) {
                echo "<td class='dodani_brojevi horizontalna_linija vertikalna_linija'>" . $polje_2[$i][$j] . "</td>";
              } else {
                echo "<td class='dodani_brojevi vertikalna_linija'>" . $polje_2[$i][$j] . "</td>";
              }
            } else {
              if ($i === 1 || $i === 3) {
                echo "<td class='dodani_brojevi horizontalna_linija'>" . $polje_2[$i][$j] . "</td>";
              } else {
                echo "<td class='dodani_brojevi'>" . $polje_2[$i][$j] . "</td>";
              }
            }
          }
        }
        echo "</tr>";
      }
      echo '</table>';
    }
    ?>
  </table>
  <br>

  <br />
</body>

</html>
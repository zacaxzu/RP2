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
    array(null, null, 4, null, null, 3),
    array(null, null, 5, null, null, null),
    array(3, null, 2, null, 6, null),
    array(null, 6, null, null, null, 2),
    array(null, 2, 1, null, null, null),
    array(null, null, null, 5, null, null),
  );
  
  function inicijalizacija( &$polje_2, &$polje)
  {
    $polje_2 = $polje;
  }

  function dodaj_broj(&$polje_2, $broj, $redak, $stupac)
  {
    $polje_2[$redak][$stupac] = $broj;
  }

/*
  dodaj_broj($polje_2, 1, 1, 0);
  dodaj_broj($polje_2, 2, 0, 0);

*/
  ?>


<table>
  <?php
  function ispis_tablice($polje_2, $polje){
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
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

  function dodaj_broj(&$polje_2, $broj, $redak, $stupac)
  {
    $polje_2[$redak][$stupac] = $broj;
  }

  $polje_2 = $polje;
  dodaj_broj($polje_2, 1, 1, 0);
  /*
  <table id="grid">
    <tr>
      <td class="cell"></td>
      <td class="cell"></td>
      <td class="cell-3"><strong>4</strong></td>
      <td class="cell"></td>
      <td class="cell"></td>
      <td class="cell"><strong>3</strong></td>
    </tr>
    <tr>
      <td class="cell"></td>
      <td class="cell"></td>
      <td class="cell-9"><strong>5</strong></td>
      <td class="cell"><strong>2</strong></td>
      <td class="cell"><strong>3</strong></td>
      <td class="cell"></td>
    </tr>
    <tr class="middle_line">
      <td class="cell"><strong>3</strong></td>
      <td class="cell"></td>
      <td class="cell-15"><strong>2</strong></td>
      <td class="cell"></td>
      <td class="cell"><strong>6</strong></td>
      <td class="cell"></td>
    </tr>
    <tr>
      <td class="cell"></td>
      <td class="cell"><strong>6</strong></td>
      <td class="cell-21"></td>
      <td class="cell"></td>
      <td class="cell"></td>
      <td class="cell"><strong>2</strong></td>
    </tr>
    <tr>
      <td class="cell"></td>
      <td class="cell"><strong>2</strong></td>
      <td class="cell-27"><strong>1</strong></td>
      <td class="cell"></td>
      <td class="cell"></td>
      <td class="cell"></td>
    </tr>
    <tr>
      <td class="cell"></td>
      <td class="cell"></td>
      <td class="cell-33"></td>
      <td class="cell"><strong>5</strong></td>
      <td class="cell"></td>
      <td class="cell"></td>
    </tr>
  </table>
  */
  ?>
  <table>
    <?php
    for ($i = 0; $i < 6; $i++) {
      echo "<tr>";
      for ($j = 0; $j < 6; $j++) {
        if ($j === 5 && $polje[$i][$j] != null) {
          echo "<th class='zadani_brojevi'>" . $polje_2[$i][$j] . "</th>";
        } else if ($polje[$i][$j] != null) {
          if ($j === 2) {
            echo "<td class='zadani_brojevi vertikalna_linija'>" . $polje_2[$i][$j] . "</td>";
          } else {
            echo "<td class='zadani_brojevi'>" . $polje_2[$i][$j] . "</td>";
          }
        } else if ($j === 5 && $polje[$i][$j] === null) {
          echo "<th class='dodani_brojevi'>" . $polje_2[$i][$j] . "</th>";
        } else if ($polje[$i][$j] === null) {
          if ($j === 2) {
            echo "<td class='zadani_brojevi vertikalna_linija'>" . $polje_2[$i][$j] . "</td>";
          } else {
            echo "<td class='dodani_brojevi'>" . $polje_2[$i][$j] . "</td>";
          }
        }
      }
      echo "</tr>";
    }
    ?>
  </table>


  <br />
</body>

</html>
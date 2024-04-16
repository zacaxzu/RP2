<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sudoku</title>
  <link rel="stylesheet" href="odabir_poteza.css" />
</head>

<body>
  <form method="post" action="ispis.php">
    <br>

    <table class="ispis-tablice">
      <?php
      // Assuming $_SESSION['polje_2'] is your Sudoku grid
      for ($i = 0; $i < 6; $i++) {
        echo "<tr class='redak-tr'>";
        for ($j = 0; $j < 6; $j++) {
          $cellValue = $_SESSION['polje_2'][$i][$j];
          //$isEditable = isEditable($polje, $i, $j);
          $isValid = validan_potez_2($_SESSION['polje_2'][$i][$j], $cellValue, $i, $j);
          //echo '$isValid: ' . $isValid . '<br>';

          $class = '';

          // Check if the cell value is non-null in $polje
          if (!isEditable($_SESSION['polje'], $i, $j)) {
            //echo 'Usao u isEditable.<br>';
            $class = 'zadani_brojevi';
          } else {
            $class = 'editable';
            if ($_SESSION['polje_3'][$i][$j] == 0) {
              //echo '$_SESSION["polje_3"][$i][$j] == 0: ' . $_SESSION['polje_3'][$i][$j] . '<br>';
              $class .= ' nevalidni_dodani_brojevi';
            } else if ($_SESSION['polje_3'][$i][$j] == 1) {
              //echo '$_SESSION["polje_3"][$i][$j] == 1: ' . $_SESSION['polje_3'][$i][$j] . '<br>';
              $class .= ' dodani_brojevi';
            }
          }

          if ($i == 1 || $i == 3) {
            //echo ' Usao u horizontalna linija<br>';
            $class .= ' horizontalna_linija';
          }
          if ($j == 2) {
            //echo ' Usao u vertikalna linija<br>';
            $class .= ' vertikalna_linija';
          }
          //echo '$class: ' . $class . '<br>';

          
          if ($cellValue === null) {
            $validNumbers = validNumbers($_SESSION['polje_2'], $i, $j);
            echo "<td class='redak-td $class'><input class='input-celija' type='text' name='sudoku_cell[$i][$j]' value='{$_SESSION['polje_2'][$i][$j]}' maxlength='1' pattern='[1-6]' title='Upiši broj između 1 i 6!'><br>";

            foreach ($validNumbers as $number) {
              echo "<span class='valid-number'>$number</span>";
            }

            echo "</td>";
          } else {
            echo "<td class='redak-td $class'>$cellValue</td>";
          }
        }
        echo "</tr>";
      }
      ?>
    </table>

    <input type="radio" name="odabir_poteza" value="unesi_broj" id="odabir_unesi_broj" />
    Unos brojeva pomoću textboxeva.

    <br />
    <input type="radio" name="odabir_poteza" value="obrisi_broj" id="odabir_obrisi_broj" />
    Obrisi broj iz retka
    <select name="redak_obrisi" value="redak_obrisi">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
    </select>
    i stupca
    <select name="stupac_obrisi" value="stupac_obrisi">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
    </select>

    <br />
    <input type="radio" name="odabir_poteza" value="reset_igre" id="odabir_reset" />
    Želim sve ispočetka!

    <br />
    <button name="submit" type="submit">Izvrši akciju!</button>
  </form>
</body>

</html>
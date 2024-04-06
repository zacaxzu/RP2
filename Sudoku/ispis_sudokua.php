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
    array(" ", " ", 4, " ", " ", 3),
    array(" ", " ", 5, " ", " ", " "),
    array(3, " ", 2, " ", 6, " "),
    array(" ", 6, " ", " ", " ", 2),
    array(" ", 2, 1, " ", " ", " "),
    array(" ", " ", " ", 5, " ", " "),
  );

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
        if ($j === 5) {
          echo "<th class='zadani_brojevi'>" . $polje[$i][$j] . "</th>";
        } else {
          echo "<td class='zadani_brojevi'>" . $polje[$i][$j] . "</td>";
        }
      }
      echo "</tr>";
    }
    ?>
  </table>


  <br />
</body>

</html>
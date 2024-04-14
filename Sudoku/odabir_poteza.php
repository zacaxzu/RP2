<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sudoku</title>
  <style>
    input {
      margin-bottom: 10px;
    }
  </style>
</head>

<body>
  <form method="post" action="sudoku.php">
    <br>
    <input type="radio" name="odabir_poteza" value="unesi_broj" id="odabir_unesi_broj" />
    Unesi broj

    
      <input type="text" name="upisan_broj" id="upisan_broj"/> u redak
      <select name="broj_retka" value="broj_retka">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
      </select>
      i stupac
      <select name="broj_stupca" value="broj_stupca">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
      </select>
      

    <table>
      <?php 
      /*
      for ($i = 0; $i < 6; $i++) : ?>
        <tr>
          <?php for ($j = 0; $j < 6; $j++) : ?>
            <td>
              <button type="submit" name="cell" value="<?= $i ?>,<?= $j ?>" style="width:100%; height:100%; border:none; background:none;">
                <?php echo $_SESSION['polje_2'][$i][$j] ?? ''; ?>
              </button>
            </td>
          <?php endfor; ?>
        </tr>
      <?php endfor; */?>
    </table>

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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sudoku</title>
</head>

<body>
    <h1>Sudoku 6×6!</h1>
    <form action="ispis.php" method="POST">
        Unesi svoje ime:
        <input type="text" id="ime_igraca" name="ime_igraca" />
        <button type="submit" value="zapocni_igru">Započni igru!</button>
        <br>
        Odaberi sudoku:
        <input type="radio" name="odabir_sudokua" value="sudoku1" id="sudoku1" checked />
        Sudoku 1 <br>
        <input type="radio" name="odabir_sudokua" value="sudoku2" id="sudoku2" />
        Sudoku 2
    </form>
</body>

</html>


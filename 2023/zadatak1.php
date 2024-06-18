<?php
require_once __DIR__ . '/libraryservice.class.php';
$ls = new LibraryService();

$kalodonti = $ls->getAllIgraFromKalodonti('proba');
foreach ($kalodonti as $kalodont) {
    echo $kalodont->rijec . ' ';
}
$kalodont = $ls->getKalodontById(5);
echo '<br>Prvi kalodont: ' . $kalodont->rijec . '<br>';

var_dump($_POST['odabir_akcije']);
echo '<br>';
echo 'Vrsta igre: <br>';
var_dump($_POST['vrsta_igre']);
echo '<br>';
echo 'selected_kolodonti: ';
var_dump($_POST['selected_kolodonti']);

echo '<br> Igre: <br>';
$igre = $ls->getAllDistinctIgra();
foreach ($igre as $igra) {
    echo $igra . ' ';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadatak 1</title>
    <style>
        table,
        td {
            border: 1px solid;
        }

        .red-row {
            background-color: red;
        }
    </style>
</head>

<body>
    <form action="zadatak1.php" method="post">
        <table>
            <tr>
                <td></td>
                <td>riječ</td>
                <td>igrač</td>
            </tr>
            <?php
            $prethodnaRijec = ''; // Initialize a variable to store the previous word

            foreach ($kalodonti as $kalodont) {
                $trenutnaRijec = $kalodont->rijec;
                $rowClass = '';

                if ($prethodnaRijec !== '') {
                    $prvaDvaSlovaPrethodne = substr($prethodnaRijec, -2);
                    $prvaDvaSlovaTrenutne = substr($trenutnaRijec, 0, 2);

                    if ($prvaDvaSlovaPrethodne !== $prvaDvaSlovaTrenutne) {
                        $rowClass = 'red-row';
                    }
                }

                echo '<tr class="' . $rowClass . '">';
                echo '<td><input type="checkbox" name="selected_kolodonti[]" value="' . htmlspecialchars($kalodont->id) . '"></td>';
                echo '<td>' . htmlspecialchars($trenutnaRijec) . '</td>';
                echo '<td>' . htmlspecialchars($kalodont->igrac) . '</td>';
                echo '</tr>';

                $prethodnaRijec = $trenutnaRijec; // Update the previous word
            }
            ?>
        </table>
        <p>Odaberi akciju:</p>
        <input type="radio" id="igra" name="odabir_akcije" value="igra">
        <label for="igra">Odaberi igru za prikaz:
            <select name="vrsta_igre">
                <?php
                foreach ($igre as $igra) {
                    echo '<option value="' . $igra . '">' . $igra . '</option>';
                }
                ?>
            </select>
        </label><br>

        <input type="radio" id="diskvalifikacija" name="odabir_akcije" value="diskvalifikacija">
        <label for="diskvalifikacija">Diskvalificiraj označene riječi!</label><br>
        <button type="submit">Izvrši akciju!</button>

        <br>
        Kazneni bodovi do sada:

    </form>
</body>

</html>
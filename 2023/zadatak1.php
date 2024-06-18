<?php
session_start(); // Start the session

require_once __DIR__ . '/kalodontController.class.php';
$controller = new KalodontController();
$data = $controller->handleRequest();

// Store vrsta_igre in session if submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['odabir_akcije']) && $_POST['odabir_akcije'] === 'igra' && isset($_POST['vrsta_igre'])) {
    $_SESSION['vrsta_igre'] = htmlspecialchars($_POST['vrsta_igre']);
}

extract($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadatak 1</title>
    <style>
        table, td {
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
                    $selected = ($igra === $_SESSION['vrsta_igre']) ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($igra) . '" ' . $selected . '>' . htmlspecialchars($igra) . '</option>';
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

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
        <?php if (!empty($selectedIgra)) : ?>
            <p>Odabrana igra: <?php echo $selectedIgra; ?></p>
        <?php endif; ?>

        <?php if (!empty($selectedKolodonti)) : ?>
            <p>Diskvalificirane riječi: <?php echo implode(', ', $selectedKolodonti); ?></p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>

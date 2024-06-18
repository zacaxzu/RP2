<?php
require_once __DIR__ . '/model/libraryservice.class.php';

$kolegij = isset($_POST['ime_kolegija']) ? $_POST['ime_kolegija'] : '';
$selectedStudenti = isset($_POST['studenti']) ? $_POST['studenti'] : [];

$ls = new LibraryService();
$studenti = $ls->getAllStudentiFromKolegij($kolegij);
$prostorije = $ls->getAllProstorije();

$selectedStudentiObjects = [];
$remainingStudenti = [];
foreach ($studenti as $student) {
    if (in_array($student->id, $selectedStudenti)) {
        $selectedStudentiObjects[] = $student;
    } else {
        $remainingStudenti[] = $student;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/view/zadatak1.css">
    <title>zadatak1_raspored</title>
</head>

<body>
    <h1>Raspored za kolegij: <?php echo htmlspecialchars($kolegij); ?></h1>
    <form method="post" action="zadatak1_raspored.php">
        <input type="hidden" name="ime_kolegija" value="<?php echo htmlspecialchars($kolegij); ?>">

        Neraspoređeni studenti <br>
        Studenti Odaberi <br>
        <?php
        foreach ($remainingStudenti as $student) {
            echo htmlspecialchars($student->ime) . '<input type="checkbox" name="studenti[]" value="' . htmlspecialchars($student->id) . '"><br>';
        }
        ?>

        <label for="prostorije">Raspored za odabrane studente u prostoriju </label>
        <select name="prostorija" id="prostorija">
            <?php
            foreach ($prostorije as $prostorija) {
                echo '<option value="' . htmlspecialchars($prostorija->ime) . '">' . htmlspecialchars($prostorija->ime) . '</option>';
            }
            ?>
        </select>
        <button type="submit">Rasporedi!</button><br>
    </form>

    <div id="raspored">
        Raspored za <br>
        <?php
        foreach ($selectedStudentiObjects as $student) {
            echo htmlspecialchars($student->ime) . '<br>';
        }
        ?>
    </div>
</body>

</html>
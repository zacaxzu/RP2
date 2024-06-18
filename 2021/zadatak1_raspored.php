<?php
require_once __DIR__ . '/model/libraryservice.class.php';

$kolegij = isset($_POST['ime_kolegija']) ? $_POST['ime_kolegija'] : '';
$selectedStudenti = isset($_POST['selected_studenti']) ? (is_array($_POST['selected_studenti']) ? $_POST['selected_studenti'] : explode(',', $_POST['selected_studenti'])) : [];
$remainingStudenti = isset($_POST['remaining_studenti']) ? (is_array($_POST['remaining_studenti']) ? $_POST['remaining_studenti'] : explode(',', $_POST['remaining_studenti'])) : [];

$ls = new LibraryService();

// If this is the initial load or if the kolegij changes
if (empty($selectedStudenti) && empty($remainingStudenti)) {
    $studenti = $ls->getAllStudentiFromKolegij($kolegij);
    $prostorije = $ls->getAllProstorije();

    foreach ($studenti as $student) {
        $remainingStudenti[] = $student->id;
    }
} else {
    $prostorije = $ls->getAllProstorije();

    // Convert IDs back to objects
    $remainingStudenti = array_map(function ($id) use ($ls) {
        return $ls->getStudentById($id);
    }, $remainingStudenti);

    $selectedStudenti = array_map(function ($id) use ($ls) {
        return $ls->getStudentById($id);
    }, $selectedStudenti);
}

// Handle form submission to move students
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'Rasporedi') {
        $selectedIds = $_POST['studenti'] ?? [];
        foreach ($selectedIds as $id) {
            $student = $ls->getStudentById($id);
            if ($student) {
                $selectedStudenti[] = $student;
                $remainingStudenti = array_filter($remainingStudenti, function ($remainingStudent) use ($id) {
                    return $remainingStudent->id != $id;
                });
            }
        }
    } elseif ($action == 'Vrati') {
        $selectedIds = $_POST['selected_studenti'] ?? [];
        foreach ($selectedIds as $id) {
            $student = $ls->getStudentById($id);
            if ($student) {
                $remainingStudenti[] = $student;
                $selectedStudenti = array_filter($selectedStudenti, function ($selectedStudent) use ($id) {
                    return $selectedStudent->id != $id;
                });
            }
        }
    }

    // Convert objects back to IDs to preserve the state between requests
    $remainingStudenti = array_map(function ($student) {
        return $student->id;
    }, $remainingStudenti);

    $selectedStudenti = array_map(function ($student) {
        return $student->id;
    }, $selectedStudenti);
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
        <input type="hidden" name="remaining_studenti" value="<?php echo htmlspecialchars(implode(',', $remainingStudenti)); ?>">
        <input type="hidden" name="selected_studenti" value="<?php echo htmlspecialchars(implode(',', $selectedStudenti)); ?>">
        <input type="hidden" name="action" value="">

        <h2>Neraspoređeni studenti</h2>
        Studenti Odaberi <br>
        <?php
        foreach ($remainingStudenti as $id) {
            $student = $ls->getStudentById($id);
            if ($student) {
                echo htmlspecialchars($student->ime) . '<input type="checkbox" name="studenti[]" value="' . htmlspecialchars($student->id) . '"><br>';
            }
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
        <button type="submit" name="action" value="Rasporedi">Rasporedi!</button><br>

        <h2>Raspored za</h2>
        <?php
        foreach ($selectedStudenti as $id) {
            $student = $ls->getStudentById($id);
            if ($student) {
                echo htmlspecialchars($student->ime) . '<input type="checkbox" name="selected_studenti[]" value="' . htmlspecialchars($student->id) . '"><br>';
            }
        }
        ?>
        <button type="submit" name="action" value="Vrati">Vrati</button>
    </form>
</body>

</html>
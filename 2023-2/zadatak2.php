<?php

session_start();

$stabla = [
    ["redak" => 1, "stupac" => 2],
    ["redak" => 5, "stupac" => 3],
    ["redak" => 4, "stupac" => 5],
    ["redak" => 3, "stupac" => 3],
    ["redak" => 2, "stupac" => 5]
];

$broj_satora_u_retku  = [2, 0, 2, 0, 1];
$broj_satora_u_stupcu = [1, 1, 0, 1, 2];

// Initialize the grid
if (!isset($_SESSION['zauzeta_polja'])) {
    $_SESSION['zauzeta_polja'] = array_fill(0, 5, array_fill(0, 5, ''));

    foreach ($stabla as $stablo) {
        $_SESSION['zauzeta_polja'][$stablo['redak'] - 1][$stablo['stupac'] - 1] = 'X';
    }
}

$zauzeta_polja = &$_SESSION['zauzeta_polja'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'getTrees':
            echo json_encode($stabla);
            break;

        case 'getRowTents':
            $row = intval($_POST['row']);
            if (isset($broj_satora_u_retku[$row - 1])) {
                echo $broj_satora_u_retku[$row - 1];
            } else {
                echo "Nevažeći redak";
            }
            break;

        case 'getColumnTents':
            $column = intval($_POST['column']);
            if (isset($broj_satora_u_stupcu[$column - 1])) {
                echo $broj_satora_u_stupcu[$column - 1];
            } else {
                echo "Nevažeći stupac";
            }
            break;

        case 'toggleTent':
            $row = intval($_POST['row']) - 1;
            $column = intval($_POST['column']) - 1;
            if ($row < 0 || $row > 4 || $column < 0 || $column > 4) {
                echo "Nevažeća pozicija";
                break;
            }

            if ($zauzeta_polja[$row][$column] === 'Š') {
                // Ukloni šator
                $zauzeta_polja[$row][$column] = '';
                echo "tent_removed";
                break;
            } elseif ($zauzeta_polja[$row][$column] === '') {
                // Provjera je li šator susjedan stablu
                $susjedna_stabla = false;
                $direkcije = [[-1, 0], [1, 0], [0, -1], [0, 1]];
                foreach ($direkcije as $direkcija) {
                    $novi_red = $row + $direkcija[0];
                    $novi_stupac = $column + $direkcija[1];
                    if ($novi_red >= 0 && $novi_red < 5 && $novi_stupac >= 0 && $novi_stupac < 5) {
                        if ($zauzeta_polja[$novi_red][$novi_stupac] === 'X') {
                            $susjedna_stabla = true;
                            break;
                        }
                    }
                }

                if (!$susjedna_stabla) {
                    echo "Šator mora biti susjedan stablu";
                    break;
                }

                // Provjera broja šatora u retku i stupcu
                $trenutni_satori_u_retku = array_count_values($zauzeta_polja[$row])['Š'] ?? 0;
                $trenutni_satori_u_stupcu = array_count_values(array_column($zauzeta_polja, $column))['Š'] ?? 0;

                if ($trenutni_satori_u_retku >= $broj_satora_u_retku[$row] || $trenutni_satori_u_stupcu >= $broj_satora_u_stupcu[$column]) {
                    echo "Prekoračen broj šatora u retku ili stupcu";
                    break;
                }

                // Postavi šator
                $zauzeta_polja[$row][$column] = 'Š';
                echo "tent_placed";
                break;
            } else {
                echo "Polje je već zauzeto";
                break;
            }

        default:
            echo "Nevažeći upit";
            break;
    }
}

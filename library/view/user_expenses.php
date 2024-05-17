<?php require_once __DIR__ . '/_header.php'; ?>
<table>
    <?php
    echo '<tr>';
    echo '<td>' . $user->username . '</td>';
    echo '<td><b>' .  'Expense Description' . '<b></td>';
    echo '<td><b>' .  'Cost' . '<b></td>';
    echo '</tr>';

    foreach ($userExpenses as $expense) {

        echo '<tr>';
        echo '<td>' . '' . '</td>';
        echo '<td>' . $expense->description . '</td>';
        echo '<td>' . '+' . $expense->cost . ' &euro;</td>';
        echo '</tr>';
    }

    foreach ($partExpenses as $part) {

        echo '<tr>';
        echo '<td>' . '' . '</td>';
        echo '<td>' . $part->description . '</td>';
        echo '<td>' . '-' . $part->part_cost . ' &euro;</td>';
        echo '</tr>';
    }

    echo '<tr>';
    echo '<td><b>' . '' . '<b></td>';
    echo '<td><b>' .  '' . '<b></td>';
    echo '<td><b>' .  'Total' . '<b></td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>' . '' . '</td>';
    echo '<td>' . '' . '</td>';
    echo '<td>' . $predznak . $total . ' &euro;</td>';
    echo '</tr>';
    ?>
</table>
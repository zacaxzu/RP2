<?php require_once __DIR__ . '/_header.php'; ?>
<table>
    <?php
        echo '<tr>';
        echo '<td>' . '$expense->id_user' . '</td>';
        echo '<td>' .  '$expense->description' . '</td>';
        echo '<td>' .  '$expense->cost' . ' &euro;</td>';
        echo '</tr>';

    foreach ($userExpenses as $expense) {
        echo '<tr>';
        echo '<td>' . $expense->id_user . '</td>';
        echo '<td>' .  $expense->description . '</td>';
        echo '<td>' .  $expense->cost . ' &euro;</td>';
        echo '</tr>';
    }

        echo '<tr>';
        echo '<td>' .  '$part->id' . '</td>';
        echo '<td>' .  '$part->id_expense' . '</td>';
        echo '<td>' . '$part->id_user' . '</td>';
        echo '<td>' .  '$part->cost' . ' &euro;</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>' . 'Expense ID' . '</td>';
        echo '<td>' .  'Expense Description' . '</td>';
        echo '<td>' .  'Cost' . '</td>';
        echo '</tr>';

    foreach ($userExpenseDescriptions as $expenseId => $descriptions){
        foreach ($descriptions as $description){
            echo '<tr>';
                echo '<td>' . $expenseId . '</td>';
                echo '<td>' . $description . '</td>';
                echo '<td>' . $description->cost . '&euro;</td>';
            echo '</tr>';
        }
    }

    ?>
</table>
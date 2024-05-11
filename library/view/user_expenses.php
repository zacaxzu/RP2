<?php require_once __DIR__ . '/_header.php'; ?>
<table>
    <?php
    foreach ($userExpenses as $expense) {
        echo '<tr>';
        echo '<td>' . $expense->id_user . '</td>';
        echo '<td>' .  $expense->description . '</td>';
        echo '<td>' .  $expense->cost . '&euro;</td>';
        echo '</tr>';
    }
    ?>
</table>
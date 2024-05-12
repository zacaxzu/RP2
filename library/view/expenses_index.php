<?php require_once __DIR__ . '/_header.php'; ?>

<table>
    <tr>
        <th>Ime</th>
        <th>Description</th>
        <th>Cost</th>
    </tr>
    <?php
    foreach ($userExpenses as $user) {
        echo '<tr>';
        echo '<td>' . $user->username . '</td>';
        echo '<td>' . $user->description . '</td>';
        echo '<td>' . $user->cost . '</td>';
        echo '</tr>';
    }
    ?>
</table>

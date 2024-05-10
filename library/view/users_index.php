<?php require_once __DIR__ . '/_header.php'; ?>

<table>
    <tr>
        <th>Ime</th>
        <th>Total paid</th>
    </tr>
    <?php
    foreach ($userList as $user) {
        echo '<tr>';
        echo '<td>' . $user->username . '</td>';
        echo '<td>' .  $user->total_paid - $user->total_debt . '</td>';
        echo '</tr>';
    }
    ?>
</table>

<?php require_once __DIR__ . '/_footer.php'; ?>
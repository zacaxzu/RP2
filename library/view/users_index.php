<?php require_once __DIR__ . '/_header.php'; ?>
<link rel="stylesheet" href="/users_index.css">

<table>
    <tr>
        <th>Ime</th>
        <th>Total paid</th>
        <th>Total debt</th>
        <th>Total paid - Total debt</th>
    </tr>
    <?php
    foreach ($userList as $user) {
        echo '<tr>';
        echo '<td><a href="balance.php?rt=users/history&id_user=' . $user->id . '">' . $user->username . '</a></td>';
        echo '<td>' .  $user->total_paid . ' &euro;</td>';
        echo '<td>' .  $user->total_debt . ' &euro;</td>';
        echo '<td>' .  $user->total_paid - $user->total_debt . ' &euro;</td>';
        echo '</tr>';
    }
    ?>
</table>
<?php require_once __DIR__ . '/_header.php'; ?>

<form action="/balance.php?rt=newexpenses/add" method="post">
    <table>
        <tr>
            <td><label for="description">Description</label></td>
            <td><input type="text" name="description" id="description" required></td>
        </tr>
        <tr>
            <td><label for="cost">Cost in &euro;</label></td>
            <td><input type="number" name="cost" id="cost" required></td>
        </tr>
        <tr>
            <td>For</td>
            <td>
                <?php
                if (!empty($userList)) {
                    foreach ($userList as $user) {
                        echo '<input type="checkbox" name="users[]" value="' . $user->id . '" id="user_' . $user->id . '"> ' . htmlspecialchars($user->username) . '<br>';
                    }
                } else {
                    echo 'No users found.';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td><button type="submit" name="addExpense">Add new expense!</button></td>
        </tr>
    </table>
</form>
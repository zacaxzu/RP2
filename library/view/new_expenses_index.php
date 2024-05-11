<?php require_once __DIR__ . '/_header.php'; ?>

<form action="" method="post">
    <table>
        <tr>
            <td> <label for="">Description</label> </td>
            <td> <input type="text" name="" id=""> </td>
        </tr>
        <tr>
            <td> <label for="">Cost in &euro;</label> </td>
            <td> <input type="number" name="" id=""> </td>
        </tr>
        <tr>
            <td>For</td>
            <td>
                <?php
                foreach ($userList as $user) {
                    
                    echo '<input type="checkbox" name="" id=""> ' . $user->username . '<br>';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td><button>Add new expense!</button></td>
        </tr>
    </table>
</form>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf8" />
    <title>Login</title>
</head>

<body>
    <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
        Korisničko ime:
        <input type="text" name="username" />
        <br />
        Password:
        <input type="password" name="password" />
        <br />
        <button type="submit" name="gumb" value="login">Ulogiraj se!</button>
        <button type="submit" name="gumb" value="novi">Stvori novog korisnika!</button>

        <?php
        $error = $_GET['error'] ?? '';
        if (!empty($error)) {
        echo "<p>" . htmlspecialchars(urldecode($error)) . '<br>' . 'Pokušaj opet!' .'</br>' ."</p>";
        }
        ?>
    </form>
</body>

</html>
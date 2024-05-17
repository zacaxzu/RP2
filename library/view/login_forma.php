<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf8" />
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
        Korisničko ime:
        <input type="text" name="username" />
        <br />
        Password:
        <input type="password" name="password"/>
        <br />
        <button type="submit" name="gumb" value="login">Ulogiraj se!</button>
        <button type="submit" name="gumb" value="novi">Stvori novog korisnika!</button>

        <?php
        $error = $_GET['error'] ?? '';
        if (!empty($error)) {
            echo "<p>" . htmlspecialchars(urldecode($error)) . '<br>' . 'Pokušaj opet!' . '</br>' . "</p>";
        }
        ?>
    </form>

</body>

</html>
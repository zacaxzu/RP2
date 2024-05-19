<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post" action="/balance.php?rt=registracija/registracija">
        Odaberite korisničko ime:
        <input type="text" name="username" />
        <br />
        Odaberite lozinku:
        <input type="password" name="password" />
        <br />
        Vaša mail-adresa:
        <input type="text" name="email" />
        <br />
        <button type="submit" name="gumb" value="registracija">Stvori korisnički račun!</button>
    </form>

    <p>
        Povratak na <a href="balance.php">početnu stranicu</a>.
    </p>

    <?php
    $errorMsg = $_GET['errorMsg'] ?? '';
    if ($errorMsg !== '')
        echo '<p>Greška: ' . $errorMsg . '</p>';
    ?>

</body>

</html>
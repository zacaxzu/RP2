<?php
function procesiraj_login()
{
    // Provjeri sastoji li se ime samo od slova; ako ne, crtaj login formu.
    if (!isset($_POST["username"]) || preg_match('/[a-zA-Z]{1, 20}/', $_POST["username"]))
        crtaj_loginForma();

    // Možda se ne šalje password; u njemu smije biti bilo što.
    if (!isset($_POST["password"]))
        crtaj_loginForma();

    // Sve je OK, provjeri jel ga ima u bazi.
    $db = DB::getConnection('rp2.studenti.math.hr', 'baca', 'student', 'pass.mysql');

    try {
        $st = $db->prepare('SELECT password FROM users WHERE username=:username');
        $st->execute(array('username' => $_POST["username"]));
    } catch (PDOException $e) {
        crtaj_loginForma('Greška:' . $e->getMessage());
        return;
    }

    $row = $st->fetch();

    if ($row === false) {
        // Taj user ne postoji, upit u bazu nije vratio ništa.
        crtaj_loginForma('Ne postoji korisnik s tim imenom.');
        return;
    } else {
        // Postoji user. Dohvati hash njegovog passworda.
        $hash = $row['password'];

        // Da li je password dobar?
        if (password_verify($_POST['password'], $hash)) {
            // Dobar je. Ulogiraj ga.
            crtaj_uspjesnoUlogiran($_POST['username']);
            return;
        } else {
            // Nije dobar. Crtaj opet login formu s pripadnom porukom.
            crtaj_loginForma('Postoji user, ali password nije dobar.');
            return;
        }
    }
}

function crtaj_uspjesnoUlogiran($username)
{
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf8" />
        <title>Login</title>
    </head>

    <?php require_once __DIR__ . '/_header.php'; ?>

    <body>
        Čestitamo, uspješno ste se ulogirali, <?php echo htmlspecialchars($username); ?>!
    </body>

    </html>
    <?php require_once __DIR__ . '/_footer.php'; ?>
<?php
}
?>
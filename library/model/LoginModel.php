<?php
require_once dirname(__DIR__) . '/app/database/db.class.php';

class LoginModel {
    public function verifyCredentials() {
        // Perform database query to verify credentials
        // Return true if credentials are valid, false otherwise
        if (!isset($_POST["username"]) || !isset($_POST["password"])) {
            crtaj_loginForma();
            return;
        }

        // Get database connection
        $db = DB::getConnection('rp2.studenti.math.hr', 'baca', 'student', 'pass.mysql');

        try {
            // Prepare and execute the SQL query to select password based on username
            $st = $db->prepare('SELECT password_hash FROM dz2_users WHERE username=:username');
            $st->execute(array(':username' => $_POST["username"]));

            // Fetch the result row
            $row = $st->fetch();

            if ($row === false) {
                // User does not exist, display appropriate message
                crtaj_loginForma('Ne postoji korisnik s tim imenom.');
                return;
            } else {
                // User exists, verify password
                $hash = $row['password_hash'];

                if (password_verify($_POST['password'], $hash)) {
                    // Password is correct, display successful login message
                    crtaj_uspjesnoUlogiran($_POST['username']);
                    return 1;
                } else {
                    // Password is incorrect, display appropriate message
                    header("Location: zadatak.php");
                    exit;
                }
            }
        } catch (PDOException $e) {
            // Error occurred, display error message
            crtaj_loginForma('Greška prilikom provjere korisnika: ' . $e->getMessage());
            return;
        }
    }
}
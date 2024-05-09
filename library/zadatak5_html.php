<?php

// Iscrtava formu za ulogiravanje / kreiranje noviog korisnika.
function crtaj_loginForma($message = '')
{
?>
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
		</form>

		<?php
		if ($message !== '')
			echo '<p>' . $message . '</p>';
		?>
	</body>

	</html>
<?php
}


// Ispiše poruku za uspješno ulogiranog korisnika.
function crtaj_uspjesnoUlogiran()
{
?>
	<?php require_once __DIR__ . '/view/_header.php'; ?>

	<!DOCTYPE html>
	<html>

	<head>
		<meta charset="utf8" />
		<title>Login</title>
		<link rel="stylesheet" href="login.css" />
	</head>

	<body>
		Čestitam uspješno ste se ulogirali <?php echo htmlspecialchars($_POST['username']); ?>!
	</body>

	</html>
	<?php require_once __DIR__ . '/view/_footer.php'; ?>
<?php
}

?>
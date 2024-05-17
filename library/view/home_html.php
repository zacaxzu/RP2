<?php require_once __DIR__ . '/_header.php'; ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf8" />
	<title>Login</title>
	<link rel="stylesheet" href="login.css" />
</head>

<body>
	<?php
	if (isset($_COOKIE['username'])) {
		echo "Čestitam uspješno ste se ulogirali " . htmlspecialchars($_COOKIE['username']) . "!";
	} else {
		echo "Čestitam uspješno ste se ulogirali!";
	}
	?>
</body>

</html>
<?php require_once __DIR__ . '/_footer.php'; ?>
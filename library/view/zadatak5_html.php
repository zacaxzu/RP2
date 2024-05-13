
<?php require_once __DIR__ . '/_header.php'; ?>

	<!DOCTYPE html>
	<html>

	<head>
		<meta charset="utf8" />
		<title>Login</title>
		<link rel="stylesheet" href="login.css" />
	</head>

	<body>
		Čestitam uspješno ste se ulogirali <?php echo htmlspecialchars($_SESSION['username']); ?>!
	</body>

	</html>
	<?php require_once __DIR__ . '/_footer.php'; ?>

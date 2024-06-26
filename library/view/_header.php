<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf8">
	<title>Balance</title>
	<link rel="stylesheet" href="/view/_header.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="balance.php?rt=login/home">Balance</a>
			</div>
			<ul class="nav navbar-nav">
				<li class="active"><a href="balance.php?rt=users/index">Overview</a></li>
				<li><a href="balance.php?rt=expenses/index">Expenses</a></li>
				<li><a href="balance.php?rt=newexpenses/index">New expense</a></li>
				<li><a href="balance.php?rt=settleup/index">Settle up!</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a>Hello <?php echo htmlspecialchars($_COOKIE['username']); ?>! </a></li>
				<li>
					<form method="post" action="balance.php?rt=login/logout">
						<button type="submit" name="logout" value="logout" class="btn btn-link navbar-btn">Logout</button>
					</form>
				</li>
			</ul>
		</div>
	</nav>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf8">
	<title>Druga zadaća</title>
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
				<a class="navbar-brand" href="#">Balance</a>
			</div>
			<ul class="nav navbar-nav">
				<li class="active"><a href="index.php?rt=users/index">Overview</a></li>
				<li><a href="index.php?rt=expences/index">Expenses</a></li>
				<li><a href="#">New expense</a></li>
				<li><a href="#">Settle up!</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a>Hello <?php echo htmlspecialchars($_POST['username']); ?>! </a></li>
				<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
			</ul>
		</div>
	</nav>
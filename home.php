<?php
	session_start();

	if(!$_SESSION['islogin']) {
		header("Location: index.php");
	}
?>
<html>
	<head>
		<title>LinkedOut</title>
	</head>
	<body>
		<h1>You're logged in as <?php print $_SESSION['username'];?></h2>
	</body>
</html>

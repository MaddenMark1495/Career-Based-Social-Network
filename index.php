<?php
	session_start();

	if($_SESSION['islogin']) {
		header("Location: home.php");
	}
	$error = '';
	require '../secure/db.conf';

	if(isset($_POST['submit'])) { // Was the form submitted?

		$link = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ("Connection Error " . mysqli_error($link));

		$sql = 'SELECT `user_id`, `hashed_password` FROM `linkedout`.`users` WHERE username = "';
		$query = $sql . $_POST['username'] . '";';
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_assoc($result);
		if (password_verify($_POST['password'], $row['hashed_password'])) {
			// Set session variables
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['view_id'] = $_SESSION['user_id'];
			$_SESSION['islogin'] = '1';
			//redirect
			header("Location: home.php");
		} else {
			$error = 'Username and/or Password are incorrect!';
		}
	}
?>
<html>
	<head>
		<!--  I USE BOOTSTRAP BECAUSE IT MAKES FORMATTING/LIFE EASIER -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"><!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"><!-- Optional theme -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script><!-- Latest compiled and minified JavaScript -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">

		<title>LinkedOut</title>

    	<style>
            #loginbox{
              background-color: #cccccc;
            }
            .w3-btn{
                width:150px;
            }
		</style>
	</head>
	<body>
	    <div id="rownav">
	        <div class="col-sm-12">
	            <nav class="navbar navbar-inverse navbar-fixed-top">
	              <div class="container-fluid">
	                <div class="navbar-header">
	                  <a class="navbar-brand" href="#">LinkedOut</a>
	                </div>
	              </div>
	            </nav>
	        </div>
	    </div>

	    <div id="rowspace">
	        <div class="col-sm-12">
	            <div class="page-header">
	                <h1></h1>
	            </div>
	        </div>
	    </div>

    	<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-4 col-xs-3"></div>
                <div id="loginbox">
					<div class="col-md-4 col-sm-4 col-xs-6">
						<h2>Login</h2>
						<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
							<div class="row form-group">
								<input class='form-control' type="text" name="username" placeholder="username">
							</div>
							<div class="row form-group">
								<input class='form-control' type="password" name="password" placeholder="password">
							</div>
							<div class="row form-group">
								<input class="w3-btn w3-hover-green" type="submit" name="submit" value="Login"/>
	                            <a href="register.php" class="w3-btn w3-hover-blue">Register</a>
	                            <!--<input class=" btn btn-info" type="submit" name="logout" value="Logout"/>-->
							</div>
						</form>
					</div>
				</div>
        	</div>
		</div>
		<?php
				echo "<h4>".$error."<h4>";
		 ?>
	</body>
</html>

<?php
	session_start();

	if($_SESSION['islogin']) {
		header("Location: home.php");
	}

	$message = "";
    require '../secure/db.conf';

	if(isset($_POST['submit'])) { // Was the form submitted?
		$link = mysqli_connect("$dbhost","$dbuser","$dbpass","$dbname") or die ("Connection Error " . mysqli_error($link));

		$sql = "INSERT INTO `linkedout`.`users` (`username`, `hashed_password`, `fname`, `lname`, `user_email`) VALUES (?, ?, ?, ?, ?)";

		if ($stmt = mysqli_prepare($link, $sql)) {
			if(strcmp($_POST['password'], $_POST['cpassword']) == 0) {

				$user = $_POST['username'];
				$hpass = password_hash($_POST['password'], PASSWORD_DEFAULT);
				$fname = $_POST['firstname'];
				$lname = $_POST['lastname'];
				$email = $_POST['email'];

				if(mysqli_stmt_bind_param($stmt, "sssss", $user, $hpass, $fname, $lname, $email)) {
					if(mysqli_stmt_execute($stmt)) {
						$message = "<h4>Success</h4>";
					} else {
						$message = "<h4>Failed</h4>";
					}
				} else {
					$message = "bind fail";
				}
			} else {
				$message = "<h4>Passwords Do Not Match</h4>";
			}
		} else {
			$message = "prepare fail";
		}
		$link->close();
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
		<style>
		.w3-btn{width:150px;}
		h4 {
			text-align: center
		}
		</style>
	<title>LinkedOut</title>
</head>

<body>
    <div class="rownav">
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

    <div class="rowspace">
        <div class="col-sm-12">
            <div class="page-header">
                <h1></h1>
            </div>
        </div>
    </div>
    <div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-4 col-xs-3"></div>
				<div class="col-md-4 col-sm-4 col-xs-6">
					<h2>Create a user</h2>
					<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">

                        <div class="row form-group">
                        		<label class='inputdefault'>First Name</label>
								<input class='form-control' type="text" name="firstname" placeholder="First Name">
						</div>
                        <div class="row form-group">
                        		<label class='inputdefault'>Last Name</label>
								<input class='form-control' type="text" name="lastname" placeholder="Last Name">
						</div>
                        <div class="row form-group">
                        		<label class='inputdefault'>Email Address</label>
								<input class='form-control' type="email" name="email" placeholder="E-Mail Address">
						</div>
						<div class="row form-group">
                        		<label class='inputdefault'>User Name</label>
								<input class='form-control' type="text" name="username" placeholder="Username">
						</div>
						<div class="row form-group">
                        		<label class='inputdefault'>Password</label>
								<input class='form-control' type="password" name="password" placeholder="Password">

						</div>
						<div class="row form-group">
                        		<label class='inputdefault'>Confirm Password</label>
								<input class='form-control' type="password" name="cpassword" placeholder="Confirm Password">

						</div>
						<div class="row form-group">
								<input class=" w3-btn w3-hover-blue" type="submit" name="submit" value="Register"/>
                                <a href="index.php" class="w3-btn w3-hover-red">Back to Login</a>
						</div>
					</form>
				</div>
			</div>
			<?php echo $message; ?>
		</div>
	</body>
</html>

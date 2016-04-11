<?php
	session_start();
    include db.conf;
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
        <?php
				?>
			<div class="row">
				<div class="col-md-4 col-sm-4 col-xs-3"></div>
				<div class="col-md-4 col-sm-4 col-xs-6">
					<h2>Create a user</h2>
					<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
                        
                        <div class="row form-group">
                        		<label class='inputdefault'>First Name</label>
								<input class='form-control' type="text" name="firstname" placeholder="firstname">
						</div>
                        
                        <div class="row form-group">
                        		<label class='inputdefault'>Last Name</label>
								<input class='form-control' type="text" name="lastname" placeholder="lastname">
						</div>
                        
                        
                        <div class="row form-group">
                        		<label class='inputdefault'>Email</label>
								<input class='form-control' type="email" name="email" placeholder="email">
						</div>
                                            
						<div class="row form-group">
                        		<label class='inputdefault'>User Name</label>
								<input class='form-control' type="text" name="username" placeholder="username">
						</div>
						<div class="row form-group">
                        		<label class='inputdefault'>Password</label>
								<input class='form-control' type="password" name="password" placeholder="password">
						</div>
						<div class="row form-group">
								<input class=" w3-btn w3-hover-blue" type="submit" name="submit" value="Register"/>
                                <a href="index.php" class="w3-btn w3-hover-red">Back</a>
						</div>
                        
                        
                        
					</form>
                    
				</div>
			</div>
			<?php
				if(isset($_POST['submit'])) { // Was the form submitted?
					
					$link = mysqli_connect("$dbhost","$dbuser","$dbpass","$dbname") or die ("Connection Error " . mysqli_error($link));
					$sql = "INSERT INTO users(usertype,username,salt,hashed_password) VALUES ('c',?,?,?)";
					if ($stmt = mysqli_prepare($link, $sql)) {
						$user = $_POST['username'];
						$salt = mt_rand();
						$hpass = sha1($salt.$_POST['password'])  or die("bind param"); 
						mysqli_stmt_bind_param($stmt, "sss", $user, $salt, $hpass) or die("bind param");
						if(mysqli_stmt_execute($stmt)) {
							echo "<h4>Success</h4>";
						} else {
							echo "<h4>Failed</h4>";
						}
						
						
						$query2='INSERT INTO logins(username) VALUES("' . $_POST['username'].'");';
						mysqli_query($link, $query2);
						
					} else {
						die("prepare failed");
					}
				}
			?>
		</div>
    
    
    
    
    
    </td>
  </tr>
</table>
</body>
</html>

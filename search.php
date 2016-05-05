<?php
	session_start();
	if(!$_SESSION['islogin']){
		$_SESSION['username'] = 'user';
		$_SESSION['user_id'] = 1;
		$_SESSION['islogin'] = 1;
		//header("Location: index.php");
	}
	if(isset($_POST['view'])){
		$id = $_POST['view_id'];
		header("Location: ViewProfile.php?user_id=$id");
	}
	$uid = $_SESSION['user_id'];
	require "../secure/db.conf";
	if(!$link = new mysqli($dbhost, $dbuser, $dbpass, $dbname)){
		die("Connection Error: " . $link->error);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Search</title>
		<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open Sans">
		<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
		<style>
			.nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus{
				color: black;
				background-color: #33ff77
			}
	       #name_row{
			   border: 1px solid grey;
			   background-color:#FFFFFF;
	           margin-bottom: 15px;
	           margin-top: 15px
		   }
			#background{
				border: 1px solid grey;
				background-color: #FFFFFF
			}
			.row{
				margin-bottom: 100px
			}
			.col-centered{
				float: none;
				display: inline-block;
				vertical-align: middle;
				padding-top: 20px;
				padding-bottom: 20px
			}
			body{
				background-color: #f2f2f2;
				text-align: center
			}
			h4, h5, p{
				padding-left: 10px
			}
			nav div.container-fluid{
				padding-left: 100px;
				padding-right: 100px
			}
		</style>
	</head>
	<body>
		<div class="row" id="row0">
			<div class="col-sm-12">
				<nav class="navbar navbar-inverse navbar-fixed-top">
					<div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" id="Icon" href="index.php">LinkedOut</a>
						</div>
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<form action="search.php" class="navbar-form navbar-left" role="search" method="post">
								<div class="form-group">
									<input name="search" type="text" class="form-control" placeholder="" required>
								</div>
								<button type="submit" class="btn btn-default">Search</button>
							</form>
							<ul class="nav navbar-nav navbar-right">
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['username']; ?> <span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="ViewProfile.php?user_id=<?php echo $_SESSION['user_id'];?>">View Profile</a></li>
										<li><a href="editprofile.php">Edit Profile</a></li>
										<li><a href="connections.php">Connections</a></li>
										<li><a href="logout.php">Logout</a></li>
										<li role="separator" class="divider"></li>
										<li><a href="Top10.php">Top 10 Users</a></li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
		</div>
		<?php
			if(isset($_POST['search'])){
				$search = $_POST['search'];
				$first = strtok($search, " ");
				$last = strtok($search, " ");
				echo "<h1>Search results for \"$search\"</h1>";
				$sql="SELECT * FROM users WHERE fname LIKE '%$first%' OR lname LIKE '%$last%' ORDER BY lname ASC";
				if($result = $link->query($sql)){
					$num = $result->num_rows;
					echo "Number of results: $num<br><br>";
					while($row = $result->fetch_assoc()){
						echo "<div class='col-sm-2 col-centered' id ='name_row'>";
						//Name
						echo "<b>Name: ".$row['fname']." ".$row['lname']."</b>";
						//Occupation
						$title = $row['cur_title'];
						$company = $row['cur_company'];
						if($title or $company){
							echo "<br>Occupation: ";
							if($title){
								echo $title;
								if($company){
									echo ", ";
								}
							}
							if($company){
								echo $company;
							}
						}
						//Location
						$city = $row['city'];
						$state_id = $row['state'];
						if($state_id){
							$output = $link->query("SELECT state FROM states WHERE idstates=$state_id");
							$state_row = $output->fetch_assoc();
							$state = $state_row['state'];
							$output->free();
						}
						if($city or $state){
							echo "<br>Location: ";
							if($city){
								echo $city;
								if($state){
									echo ", ";
								}
							}
							if($state){
								echo $state;
							}
						}
						?>
						<!--View Profile-->
						<div id="button">
							<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
								<input name="view_id" type="hidden" value="<?=$row['user_id'];?>">
								<input name="view" type="submit" class="w3-btn w3-hover-green" value="View Profile">
							</form>
						</div></div>
						<?php
					}
					$result->free();
				}else{
					echo "Query Error: ".$link->error;
				}
			}else{
				echo "Error: no search input";
			}
			$link->close();
		?>
	</body>
</html>

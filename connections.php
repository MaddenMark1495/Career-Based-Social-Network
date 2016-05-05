<?php
	session_start();
	require '../secure/db.conf';

	if(!$_SESSION['islogin']) {
		$_SESSION['username'] = 'user';
		$_SESSION['islogin'] = 1;
		$_SESSION['user_id'] = 1;
		//header("Location: index.php");
	}
/*
	if(isset($_POST['view'])) {
		$id = $_POST['view_id'];
		header("Location: ViewProfile.php?user_id=$id");
	}
*/
	$uid = $_SESSION['user_id'];

	$message = '';
	$link = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

	if(isset($_POST['remove'])) {
		$id = $_POST['view_id'];
		$sql = "DELETE FROM links WHERE (user_id=$uid AND linked_user_id=$id) OR (user_id=$id AND linked_user_id=$uid)";
		$link->query($sql);
	}
?>
<!DOCTYPE html>
<html>
    <head>
		<title>Connections </title>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="page1.css">
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open Sans">
		<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">

	    <style>
	        .row{
	        	margin-bottom: 30px;
	        }
			.name_row{
				border: 1px solid grey;
				background-color:#FFFFFF;
				margin-bottom: 15px;
				margin-top: 15px;
				height: 100px;
			}
			#profile_pic{
				border: 1px solid grey;
				background-color:#FFFFFF;
			}
			body{
				background-color:#f2f2f2;
			}
			h4, h5, h6, p{
				padding-left: 10px;
			}
			#button{
	            float:right;
	            display:inline;
	        }
		    .dropdown{
		        display:inline;
		    }
		    #search_row{
		            margin-bottom: 15px;
		           margin-top: 15px;
		    }
		    #search_bar{
		        float:right;
		        display:inline;
		    }
			nav div.container-fluid {
				padding-left: 100px;
				padding-right: 100px;
			}
	    </style>
    </head>
    <body>
		<div class="row" id="row0">
            <div class="col-sm-12">
                <nav class="navbar navbar-inverse navbar-fixed-top">
					<div class="container-fluid">
                    	<!-- Brand and toggle get grouped for better mobile display -->
	                    <div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" id="Icon" href="index.php">LinkedOut</a>
	                    </div>

                    	<!-- Collect the nav links, forms, and other content for toggling -->
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
										<!--<li class="dropdown-header">Nav header</li>-->
										<li><a href="Top10.php">Top 10 Users</a></li>
										<!-- <li><a href="#">One more separated link</a></li> -->
									</ul>
								</li>
							</ul>
						</div><!-- /.navbar-collapse -->
					</div><!-- /.container-fluid -->
				</nav>
			</div>
		</div>

		<br>
		<br>
		<br>

	    <div class="row" id="row1">
			<div class="col-sm-4"></div>
			<div class="col-sm-4" id ="button_toolbar">
	            <h1 style="text-align: center">Connections</h1>
	        </div>
		 	<div class="col-sm-4"></div>
		</div>
<?php
	$sql = "SELECT * FROM users ";
	$sql .=	"INNER JOIN (SELECT linked_user_id, linked_date FROM links WHERE user_id=$uid UNION ";
	$sql .= "SELECT user_id, linked_date FROM links WHERE linked_user_id=$uid) AS user_links ";
	$sql .= "WHERE users.user_id=user_links.linked_user_id ";
	$sql .= "ORDER BY lname ASC";

	$result = $link->query($sql);
	$i = 2;
	while($row = $result->fetch_assoc()) {
		//print_r($row);
?>
		<div class="row" id="row<?=$i?>">
			<div class="col-sm-1"></div>
			<div class="col-sm-1"></div>
			<div class="col-sm-8 name_row">
				<h4 id="name"><?php echo $row['fname'] . " " . $row['lname']; ?></h4>
				<div id="button">
					<form action=<?=$_SERVER['PHP_SELF']?> method="POST">
						<a href="ViewProfile.php?user_id=<?=$row['user_id']?>" class="w3-btn w3-hover-blue">View Profile</a>
						<input name="view_id" type="hidden" value="<?=$row['user_id'];?>">
						<input name="remove" type="submit" class="w3-btn w3-hover-green" value="Unconnect">
					</form>
				</div>
<?php
		if($row['cur_title'] && $row['cur_company']) {
?>
				<h6 id="job"><?php echo $row['cur_title'] . " at " . $row['cur_company']; ?></h6>
<?php
		} else if($row['cur_title' && !$row['cur_company']]){
?>
				<h6 id="job"><?php echo $row['cur_title']; ?></h6>
<?php
		} else if($row['cur_company' && !$row['cur_title']]) {
?>
				<h6 id="job"><?php echo $row['cur_company']; ?></h6>
<?php
		} else {
			echo "<h6>No Current Job Information</h6>";
		}
		if($row['state']) {
			$sid = $row['state'];
			$res = $link->query("SELECT state FROM states WHERE idstates=$sid");
			$srow = $res->fetch_assoc();
			$res->free();

			if($row['city']) {
?>
				<h6 id="location"><?php echo $row['city'] . ", " . $srow['state']; ?></h6>
<?php
			} else {
?>
				<h6 id="location"><?php echo $srow['state']; ?></h6>
<?php
			}
		} else {
			if($row['city']) {
?>
				<h6 id="location"><?php echo $row['city']; ?></h6>
<?php
			}
			else {
				echo "<h6>No Location Information</h6>";
			}
		}
?>
			</div>
			<div class="col-sm-1"></div>
			<div class="col-sm-1"></div>
		</div>
<?php
		$i++;
	}
	$result->free();
?>
	</body>
</html>

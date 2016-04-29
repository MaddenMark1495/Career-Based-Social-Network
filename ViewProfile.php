<?php
	session_start();

	//redirect if not logged in
	if(!$_SESSION['islogin']) {
		$_SESSION['username'] = 'user';
		$_SESSION['islogin'] = 1;
		$_SESSION['user_id'] = 1;
		//header("Location: index.php");
	}

	$uid = $_SESSION['user_id'];
	//user get variable to determine which profile to load
	if(isset($_GET['user_id'])) {
		$view_id = $_GET['user_id'];
	} else {
		$view_id = 1;
	}

	require '../secure/db.conf';
    // Create connection
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	$message = '';
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	if($_SESSION['user_id'] != $view_id) {
		$sql = "UPDATE users SET profile_views = profile_views+1 WHERE user_id=$view_id";
		$conn->query($sql);
	}

	if(isset($_POST['unconnect'])) {
		$id = $_POST['view_id'];
		$sql = "DELETE FROM links WHERE (user_id=$uid AND linked_user_id=$id) OR (user_id=$id AND linked_user_id=$uid)";
		if($conn->query($sql)) {
			$message = "Successfully Unconnected";
		} else {
			$message = "Failed to Unconnect";
		}
	}
	if(isset($_POST['connect'])) {
		$id = $_POST['view_id'];
		$date = date_create()->format('Y-m-d');
		$sql = "INSERT INTO links VALUES ($uid, $id, '$date')";
		if($conn->query($sql)) {
			$message = "Successfuly Connected";
		} else {
			$message = "Failed to Connect";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>Profile</title>
<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open Sans">
		<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">

    <style>
        .row{
        	margin-bottom: 30px
        }

       #background, #profile{
		   border: 1px solid grey;
		   background-color:#FFFFFF;
	   }
	   #profile_pic{
		   border: 1px solid grey;
		   background-color:#FFFFFF;
	   }

	   .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus {
		   color:black;
		   background-color:#33ff77;
	   }
	   body{
		   background-color:#f2f2f2;
	   }
	   h4, h5, p{
		   padding-left: 10px;
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
		<div class="col-sm-4" id ="button_toolbar"></div>
	 	<div class="col-sm-4"></div>
	</div>

    <div class="row" id = "row2">

        <div class="col-sm-4"></div>

        <div class="col-sm-4" id="profile_info">
<?php
	$sql = "SELECT * FROM users INNER JOIN states on users.state=states.idstates WHERE user_id=$view_id";
	$result = $conn->query($sql);

	$row = $result->fetch_assoc();
	$result->free();
?>
			<div id="profile">
				<h4 id="fullname"><?php echo $row['fname'] . " " . $row['lname']; ?></h4>
	            <h4 id ="cur_title"><?php echo $row['cur_title']; ?></h4>
				<h4 id="cur_company"><?php echo $row['cur_company']; ?></h4>
	            <h4 id = "address"><?php echo $row['city'] . ", " . $row['state']; ?></h4>
			</div>
        </div>
        <div class="col-sm-4">
			<form action="ViewProfile.php?user_id=<?=$view_id?>" method="POST">
				<input type="hidden" name="view_id" value="<?=$view_id?>">
<?php
	if($uid != $view_id) {
		$sql = "select * from users ";
		$sql .=	"inner join (select linked_user_id, linked_date from links where user_id=$uid union ";
		$sql .= "select user_id, linked_date from links where linked_user_id=$uid) as user_links ";
		$sql .= "where users.user_id=user_links.linked_user_id";

		$friend = false;
		$result = $conn->query($sql);
		while($frow = $result->fetch_assoc()) {
			if($view_id == $frow['user_id']) {
				$friend = true;
			}
		}
		$result->free();

		if($friend) {
			//show unconnect button
?>
				<input type="submit" name="unconnect" value="Unconnect" class="w3-btn w3-hover-green">
<?php
		} else {
			//show add connect button
?>
				<input type="submit" name="connect" value="Connect with <?=$row['fname']?>" class="w3-btn w3-hover-green">
<?php
		}
	}
?>
			</form>
			<p><?=$message?></p>
		</div>

    </div>

    <div class="row" id="row3">
        <div class="col-sm-1"></div>
        <div class="col-sm-1"></div>
        <div class="col-sm-8">
            <div id = "background">
            	<h2>Background</h2>
            	<h4>Summary</h4>
<?php
	echo "<p id='summary'>" . $row['summary'] . "</p>";
?>
				<hr>
				<h4>Experience</h4>
<?php
	$sql = "SELECT * FROM work_experience WHERE user_id=$view_id";
	$result = $conn->query($sql);
	$n = $result->num_rows;
	$count=0;
	echo "<ul>";
	while($row = $result->fetch_assoc()) {
		++$count;
		echo "<div>";
		echo "<p id='job_title'>Title: " . $row['title'] . "</p>";
		echo "<p id='job_date'>Date: " . $row['start_date'] . " to " . $row['end_date'] . "</p>";
		echo "<p id='job_description'>Description:</p><p>" . $row['description'] . "</p>";
		echo "</div>";
		if($count < $n) {
			echo "<hr>";
		}
	}
	echo "</ul>";
	$result->free();
?>
				<hr>
				<h4>Education</h4>
				<ul id="education_list">
<?php
	$sql = "SELECT * FROM education INNER JOIN major on education.major_idx=major.major_idx INNER JOIN degree_type on education.deg_type_idx = degree_type.deg_type_idx WHERE education.user_id=$view_id";
	$result = $conn->query($sql);

	while($row = $result->fetch_assoc()) {
		echo "<li>" . $row['school'] . ": " . $row['start_year'] . " - " . $row['end_year'] . ": " . $row['degree_type_name']. " in " . $row['major_name'] . "</li>";
	}
	$result->free();
?>
				</ul>
				<hr>
				<h4>Skills</h4>
				<ul id="skills_list">
<?php
	$sql = "SELECT skills.skill from user_skills inner join skills on user_skills.skills_id=skills.skills_id where user_skills.user_id=$view_id";
	$result = $conn->query($sql);
	$n = $result->num_rows;
	$count = 0;
	while($row = $result->fetch_assoc()) {
		++$count;
		echo $row['skill']; //"<li>" . $row['skill'] . "</li>";
		if($count < $n) {
			echo ", ";
		}
	}
	$result->free();
	$conn->close();
?>
				</ul>
			</div>
			<div class="col-sm-1"></div>
			<div class="col-sm-1"></div>
		</div>
	</div>
</body>
</html>

<?php
	session_start();
/*
	//redirect if not logged in
	if(!$_SESSION['islogin']) {
		header("Location: index.php");
	}
*/
	//user get variable to determine which profile to load
	//$view_id = $_GET['user_id'];

	//hardcoded for testing
	$_SESSION['username'] = 'user';
	$_SESSION['user_id'] = 1;

	$view_id = 1;

	require '../secure/db.conf';
    // Create connection
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	if($_SESSION['user_id'] != $view_id) {
		$sql = "UPDATE users SET profile_views = profile_views+1 WHERE user_id=$view_id";
		$conn->query($sql);
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
        <link rel="stylesheet" type="text/css" href="page1.css">
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open Sans">


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

	                    <form class="navbar-form navbar-left" role="search">
	                    	<div class="form-group">
	          					<input type="text" class="form-control" placeholder="People, jobs, Etc.">
	        				</div>
	        				<button type="submit" class="btn btn-default">Search</button>
	      				</form>

	                	<ul class="nav navbar-nav navbar-right">
							<li class="dropdown">
				              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['username']; ?> <span class="caret"></span></a>
					              <ul class="dropdown-menu">
					                <li><a href="ViewProfile.php?user_id=<?php echo $_SESSION['user_id'];?>">View Profile</a></li>
					                <li><a href="editprofile.php">Edit Profile</a></li>
									<li><a href="#">Who are you stalking?</a></li>
					                <li><a href="logout.php">Logout</a></li>
					                <li role="separator" class="divider"></li>
					                <!--<li class="dropdown-header">Nav header</li>-->
					                <li><a href="Top10.php">Top 10 Users</a></li>
					                <li><a href="#">One more separated link</a></li>
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
			<ul class="nav nav-pills">
				<?php
					//if($_SESSION['user_id'] == $_GET['user_id']) {
					//	echo "<li role='presentation'><a href='editprofile.php?user_id=$view_id'>Edit Profile</a></li>";
					//}
				 ?>
				 <!-- <li role="presentation"><a href="">Edit Profile</a></li> -->
				 <!-- <li role="presentation" class="active"><a href="#">Profile</a></li>
				 <li role="presentation"><a href="#">Connections</a></li>
				 <li role="presentation"><a href="#">Groups</a></li>
				 <li role="presentation"><a href="Top10.php">Top 10</a></li> -->
		 	</ul>
	 	</div>
	 	<div class="col-sm-4"></div>
	</div>

    <div class="row" id = "row2">
        <div class="col-sm-1"></div>
        <div class="col-sm-1"></div>

        <div class="col-sm-4" id="profile_info">
<?php
	$sql = "SELECT * FROM users INNER JOIN states on users.state=states.idstates WHERE user_id=$view_id";
	$result = $conn->query($sql);

	$row = $result->fetch_assoc();
?>
			<div id="profile">
				<h4 id="fullname"><?php echo $row['fname'] . " " . $row['lname']; ?></h4>
	            <h4 id ="cur_title"><?php echo "cur_title";//echo $row['cur_title']; ?></h4>
				<h4 id="cur_company"><?php echo "cur_company";//echo $row['cur_company']; ?></h4>
	            <h4 id = "address"><?php echo $row['city'] . ", " . $row['state']; ?></h4>
			</div>
        </div>
        <div class="col-sm-1"></div>
        <div class="col-sm-1"></div>
    </div>

    <div class="row" id="row3">
        <div class="col-sm-1"></div>
        <div class="col-sm-1"></div>
        <div class="col-sm-8">
            <div id = "background">
            	<h2>Background</h2>
            	<h4>Summary</h4>
<?php
	echo "<p id='summary'>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit,</p>";
	//echo "<p id='summary'>" . $row['summary'] . "</p>";
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
			echo "hr";
		}
	}
	echo "</ul>";
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
?>
				</ul>
				<hr>
				<h4>Followed Groups - i think we need to remove</h4>
				<ul id="followed_list">
<?PHP
    $sql = "SELECT DISTINCT organizations.org_name from users_orgs inner join users on users.user_id=users_orgs.user_id inner join organizations on organizations.org_id=users_orgs.org_id where users.user_id=$view_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            //print_r($row);
            echo "<li>".$row['org_name']."</li>";
        }
    } else {
        echo "0 results";
    }

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

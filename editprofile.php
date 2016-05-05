<?php
	session_start();
	require '../secure/db.conf';

	if(!$_SESSION['islogin']) {
		$_SESSION['username'] = 'user';
		$_SESSION['islogin'] = 1;
		$_SESSION['user_id'] = 1;
		//header("Location: index.php");
	}

	$uid = $_SESSION['user_id'];

	$message = '';
	$link = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if(isset($_POST['submit1'])) { // Was the form submitted?
		$sql = "UPDATE users SET fname=?, lname=?, cur_title=?, cur_company=?, city=?, state=? WHERE user_id=?";

		if ($stmt = $link->prepare($sql)) {
			$fname = $_POST['firstname'];
			$lname = $_POST['lastname'];
			$title = $_POST['cur_title'];
			$comp = $_POST['cur_company'];
			$city = $_POST['city'];
			$state = $_POST['state'];
			$stmt->bind_param("sssssii", $fname, $lname, $title, $comp, $city, $state, $uid);
			if($stmt->execute()) {
				$message = "Success: Information Updated";
			} else {
				$message = "Failed: Information Not Updated";
			}
			$stmt->close();
		} else {
			$message = "prepare fail";
		}
	}
	if(isset($_POST['submit2'])) {
		$sql = "UPDATE users SET summary=? WHERE user_id=?";

		if($stmt = $link->prepare($sql)) {
			$summary = $_POST['summary'];
			$stmt->bind_param("si", $summary, $uid);
			if($stmt->execute()) {
				$message = "Success: Summary Update";
			} else {
				$message = "Failed: Summary Not Updated";
			}
			$stmt->close();
		}
	}
	if(isset($_POST['delete_work'])) {
		$sql = "DELETE FROM work_experience WHERE user_id=? AND experience_entry=?";
		if($stmt = $link->prepare($sql)) {
			$rowid = $_POST['row_id'];
			$stmt->bind_param("ii", $uid, $rowid);
			if($stmt->execute()) {
				$message = "Success: Experience Deleted";
			} else {
				$message = "Failed: Experience Not Deleted";
			}
		}
	}
	if(isset($_POST['submit3'])) { // Was the form submitted?
		$sql = "UPDATE work_experience SET title=?, company=?, start_date=?, end_date=?, description=? WHERE user_id=? AND experience_entry=?";

		if ($stmt = $link->prepare($sql)) {
			$title = $_POST['title'];
			$company = $_POST['company'];
			$start = $_POST['start_date'] ? $_POST['start_date'] : NULL;
			$end = $_POST['end_date'] ? $_POST['start_date'] : NULL;
			$description = $_POST['description'];
			$entry = $_POST['row_id'];
			$stmt->bind_param("sssssii", $title, $company, $start, $end, $description, $uid, $entry);
			if($stmt->execute()) {
				$message = "Success: Experience Updated";
			} else {
				$message = "Failed: Experience Not Updated";
			}
			$stmt->close();
		} else {
			$message = "prepare fail";
		}
	}
	if(isset($_POST['submit3new'])) {
		$sql = "INSERT INTO work_experience VALUES (?, ?, ?, ?, ?, ?, ?)";
		if($stmt = $link->prepare($sql)) {
			$entry = $_POST['row_id'];
			$company = $_POST['company'];
			$title = $_POST['title'];
			$start = $_POST['start_date'] ? $_POST['start_date'] : NULL;
			$end = $_POST['end_date'] ? $_POST['start_date'] : NULL;
			$description = $_POST['description'];
			$stmt->bind_param("iisssss", $uid, $entry, $company, $title, $start, $end, $description);
			if($stmt->execute()) {
				$message = "Success: Experience Added";
			} else {
				$message = "Failed: Experience Not Added";
				$message = $title . " " . $start . " " . $end;
			}
			$stmt->close();
		} else {
			$message = "prepare fail";
		}
	}
	if(isset($_POST['delete_ed'])) {
		$sql = "DELETE FROM education WHERE user_id=? AND education_entry=?";
		if($stmt = $link->prepare($sql)) {
			$entry = $_POST['row_id'];
			$stmt->bind_param("ii", $uid, $entry);
			if($stmt->execute()) {
				$message = "Success: Education Deleted";
			} else {
				$message = "Failed: Education Not Deleted";
			}
		} else {
			$message = "prepare fail";
		}
	}
	if(isset($_POST['submit4'])) { // Was the form submitted?
		$major = $_POST['major_name'];
		if($_POST['new_major'] != '') {
			$sql = "INSERT INTO major (major_name) VALUES (?)";
			if($stmt = $link->prepare($sql)) {
				$major_name = $_POST['new_major'];
				$stmt->bind_param("s", $major_name);
				$stmt->execute();
				$major = $link->insert_id;
				$stmt->close();
			} else {
				$message = "prepare fail";
			}
		}
		$degree = $_POST['degree_type'];
		if($_POST['new_degree'] != '') {
			$sql = "INSERT INTO degree_type (degree_type_name) VALUES (?)";
			if($stmt = $link->prepare($sql)) {
				$degree_type = $_POST['new_degree'];
				$stmt->bind_param("s", $degree_type);
				$stmt->execute();
				$degree = $link->insert_id;
				$stmt->close();
			} else {
				$message = "prepare fail";
			}
		}
		$sql = "UPDATE education SET school=?, deg_type_idx=?, major_idx=?, start_year=?, end_year=? WHERE user_id=? AND education_entry=?";
		if($stmt = $link->prepare($sql)) {
			$entry = $_POST['row_id'];
			$school = $_POST['school'];
			$start = $_POST['start_year'] ? $_POST['start_year'] : NULL;
			$end = $_POST['end_year'] ? $_POST['end_year'] : NULL;
			$stmt->bind_param("siissii", $school, $degree, $major, $start, $end, $uid, $entry);
			if($stmt->execute()) {
				$message = "Success: Education Updated";
			} else {
				$message = "Failed: Education Not Updated";
			}
		} else {
			$message = "prepare fail";
		}
	}
	if(isset($_POST['submit4new'])) {
		$major = $_POST['major_name'];
		if($_POST['new_major'] != '') {
			$sql = "INSERT INTO major (major_name) VALUES (?)";
			if($stmt = $link->prepare($sql)) {
				$major_name = $_POST['new_major'];
				$stmt->bind_param("s", $major_name);
				$stmt->execute();
				$major = $link->insert_id;
				$stmt->close();
			} else {
				$message = "prepare fail";
			}
		}
		$degree = $_POST['degree_type'];
		if($_POST['new_degree'] != '') {
			$sql = "INSERT INTO degree_type (degree_type_name) VALUES (?)";
			if($stmt = $link->prepare($sql)) {
				$degree_type = $_POST['new_degree'];
				$stmt->bind_param("s", $degree_type);
				$stmt->execute();
				$degree = $link->insert_id;
				$stmt->close();
			} else {
				$message = "prepare fail";
			}
		}
		$sql = "INSERT INTO education VALUES (?, ?, ?, ?, ?, ?, ?)";
		if($stmt = $link->prepare($sql)) {
			$entry = $_POST['row_id'];
			$school = $_POST['school'];
			$start = $_POST['start_year'] ? $_POST['start_year'] : NULL;
			$end = $_POST['end_year'] ? $_POST['end_year'] : NULL;
			$stmt->bind_param("iisiiss", $uid, $entry, $school, $degree, $major, $start, $end);
			if($stmt->execute()) {
				$message = "Success: Education Added";
			} else {
				$message = "Failed: Education Not Added";
			}
			$stmt->close();
		} else {
			$message = "prepare fail";
		}
	}
	if(isset($_POST['submit5'])) { // Was the form submitted?
	$sql = "UPDATE skills inner join user_skills on user_skills.skills_id=skills.skills_id SET skills.skill =? where user_skills.user_id=? AND skills.skills_id = ?";

		if ($stmt = $link->prepare($sql)) {
		for( $i = 1; $i < $_POST['skill_id']; $i++)
			$skill=$_POST['skill'.$i];
			$stmt->bind_param("sss", $skill, $uid,$i);
			if($stmt->execute()) {
				$message = "Success: hmmm";
			} else {
				$message = "Failed: hmmm";
			}
			$stmt->close();
		} else {
			$message = "prepare fail";
		}
	}
	if(isset($_POST['deleteprofile'])) {
		$id = $_POST['user'];
		$sql = "DELETE FROM users WHERE user_id=$id";
		if($link->query($sql)) {
			header("Location: logout.php");
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
		select {
			width: 225px;
		}
		#row3, #row2{
			text-align: center;
		}
        .row{
			margin-bottom: 30px
        }
        #profile_info{
        border: 1px solid grey ;
        background-color:#FFFFFF;
        }
		#background{
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
        body {
            background-color:#f2f2f2;
        }
        h4, h5, p{
            padding-left: 10px;
        }
		nav div.container-fluid {
			padding-left: 100px;
			padding-right: 100px;
		}
		textarea {
			width: 50%;
			height: 150px;
			resize: none;
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
 					                <li><a href="Top10.php">Top 10 Users</a></li>
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
		<div class="col-sm-4">
<?php
	if($message) {
?>
			<div class="alert alert-info">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Info!</strong> <?=$message?>
			</div>
<?php
	}
?>
		</div>
		<div class="col-sm-4"></div>
	</div>

	<div class="row" id = "row2">
		<div class="col-sm-4"></div>
		<div class="col-sm-4" id="profile_info">
<?php
	$sql = "SELECT * FROM users where user_id=$uid";
	$result = $link->query($sql);
	$user_row = $result->fetch_assoc();
?>
			<form id="user" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
				<h4 id="fullname">Full Name
					<input class ='form-control' type ="text" name = "firstname" placeholder="First Name" value="<?php echo $user_row['fname']; ?>">
					<input class ='form-control' type="text" name="lastname" placeholder="Last Name" value="<?php echo $user_row['lname']; ?>">
				</h4>

				<h4 id = "occupation">Occupation
					<input class = 'form-control' type ="text" name ="cur_title" placeholder="Current Title" value="<?php echo $user_row['cur_title']; ?>">
					<input class = 'form-control' type="text" name="cur_company" placeholder="Current Company" value = "<?php echo $user_row['cur_company']; ?>">
				</h4>
				<h4 id = "address">City, State
					<input class = 'form-control' type ="text" name = "city" placeholder="City" value="<?php echo $user_row['city']; ?>">
					<select form="user" name="state">
						<option value="51" selected></option>
<?php
	$sql = "SELECT * FROM states";
	$result = $link->query($sql);
	while($row = $result->fetch_assoc()) {
		if($row['idstates'] != 51) {
			if($row['idstates'] == $user_row['state']) {
				echo "<option value='" . $row['idstates'] . "' selected>" . $row['state'] . "</option>";
			} else {
				echo "<option value='" . $row['idstates'] . "'>" . $row['state'] . "</option>";
			}
		}
	}
	$result->free();
?>
					</select>
				</h4>
				<input type="hidden" name="user" value="<?=$uid?>">
				<input class=" w3-btn w3-hover-blue" type="submit" name="submit1" value="Save Changes">
				<input type="submit" name="deleteprofile" class="w3-btn w3-hover-red" value="Delete Profile">
			</form>
			<br>
		</div>
		<div class="col-sm-4"></div>
	</div>
    <div class="row" id="row3">
        <div class="col-sm-1"></div>
        <div class="col-sm-1"></div>
        <div class="col-sm-8">
            <div id = "background">
				<h1><b>Background</b></h1>
				<h4>Summary</h4>
<!-- Form for Summary -->
				<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
					<p><textarea name="summary" placeholder="Summary"><?php echo $user_row['summary']; ?></textarea></p>
					<p><input class=" w3-btn w3-hover-blue" type="submit" name="submit2" value="Save Changes"></p>
				</form>
				<hr>
				<h1><b>Experience</b></h1>
<?php
	$sql = "SELECT * FROM work_experience WHERE user_id=$uid";
	$result = $link->query($sql);
	$i=0;
	while($row = $result->fetch_assoc()) {
		$i++;
?>
				<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
					<h5>Job Title <br>
						<input name="title" type="text" placeholder="Job Title" value="<?php echo $row['title']; ?>">
					</h5>
					<h5>Company <br>
						<input name="company" type="text" placeholder="Job Title" value="<?php echo $row['company']; ?>">
					</h5>
					<h5>Start - End  (YYYY-MM-DD)<br>
						<input name="start_date" type="text" placeholder="Start Date" value="<?php echo $row['start_date']; ?>">-
						<input name="end_date" type ="text" placeholder="End Date" value="<?php echo $row['end_date']; ?>">
					</h5>
					<p><textarea name="description" placeholder="Description"><?php echo $row['description']; ?></textarea></p>
					<input type="hidden" name="row_id" value="<?=$i?>">
					<div class="button">
					<input class="w3-btn w3-hover-blue" type="submit" name="submit3" value="Save Changes">
					<input class="w3-btn w3-hover-red" type="submit" name="delete_work" value="Delete Entry">
					</div>
				</form>
				<hr>
<?php
	}
	$result->free();
	$i++;
?>
				<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
					<h5>Job Title <br>
						<input name="title" type="text" placeholder="Job Title">
					</h5>
					<h5>Company <br>
						<input name="company" type="text" placeholder="Company">
					</h5>
					<h5>Start - End  (YYYY-MM-DD)<br>
						<input name="start_date" type="text" placeholder="Start date">-
						<input name="end_date" type ="text" placeholder="End date">
					</h5>
					<p><textarea name="description" placeholder="Description"></textarea></p>
					<input type="hidden" name="row_id" value="<?=$i?>">
					<p><input class="w3-btn w3-hover-blue" type="submit" name="submit3new" value="Save New"></p>
				</form>
				<br>
				<hr>
				<h1><b>Education</b></h1>
<?php
	$sql = "SELECT * FROM education INNER JOIN major on education.major_idx=major.major_idx INNER JOIN degree_type on education.deg_type_idx = degree_type.deg_type_idx WHERE education.user_id=$uid";
	$result = $link->query($sql);
	$i = 0;
	while($row = $result->fetch_assoc()) {
		$i++;
?>
				<form id="school<?=$i?>" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
					<h5>School <br>
						<input name="school" type="text" placeholder="School" value="<?php echo $row['school']; ?>">
					</h5>
					<h5>Years <br>
						<input name="start_year" type="text" placeholder="Start Year" value="<?php echo $row['start_year']; ?>">-
						<input name="end_year" type="text" placeholder="End Year" value="<?php echo $row['end_year']; ?>">
					</h5>
					<h5>Major <br>
						<select form="school<?=$i?>" name="major_name">
<?php
		$sql = "SELECT * FROM major";
		$maj_result = $link->query($sql);
		while($maj_row = $maj_result->fetch_assoc()) {
			if($maj_row['major_idx'] == $row['major_idx']) {
				echo "<option value='" . $maj_row['major_idx'] . "' selected>" . $maj_row['major_name'] . "</option>";
			} else {
				echo "<option value='" . $maj_row['major_idx'] . "'>" . $maj_row['major_name'] . "</option>";
			}
		}
		$maj_result->free();
?>
						</select> OR Enter New: <input name="new_major" type="text" placeholder="Major">
					</h5>
					<h5>Degree Type <br>
						<select form="school<?=$i?>" name="degree_type">
<?php
		$sql = "SELECT * FROM degree_type";
		$deg_result = $link->query($sql);
		while($deg_row = $deg_result->fetch_assoc()) {
			if($deg_row['deg_type_idx'] == $row['deg_type_idx']) {
				echo "<option value='" . $deg_row['deg_type_idx'] . "' selected>" . $deg_row['degree_type_name'] . "</option>";
			} else {
				echo "<option value='" . $deg_row['deg_type_idx'] . "'>" . $deg_row['degree_type_name'] . "</option>";
			}
		}
		$deg_result->free();
?>
						</select>  OR Enter New: <input name="new_degree" type="text" placeholder="Degree">
					</h5>
					<input type="hidden" name="row_id" value="<?=$i?>">
					<input class="w3-btn w3-hover-blue" type="submit" name="submit4" value="Save Changes">
					<input class="w3-btn w3-hover-red" type="submit" name="delete_ed" value="Delete Entry">
				</form>
				<hr>
<?php
	}
	$result->free();
	$i++;
?>
				<form id="school<?=$i?>" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
					<h5>School <br>
						<input name="school" type="text" placeholder="School">
					</h5>
					<h5>Years <br>
						<input name="start_year" type="text" placeholder="Start Year">-
						<input name="end_year" type="text" placeholder="End Year">
					</h5>
					<h5>Major <br>
						<select form="school<?=$i?>" name="major_name">
<?php
	$sql = "SELECT * FROM major";
	$maj_result = $link->query($sql);
	while($maj_row = $maj_result->fetch_assoc()) {
		echo "<option value='" . $maj_row['major_idx'] . "'>" . $maj_row['major_name'] . "</option>";
	}
	$maj_result->free();
?>
						</select>  OR Enter New: <input name="new_major" type="text" placeholder="Major">
					</h5>
					<h5>Degree Type <br>
						<select form="school<?=$i?>" name="degree_type">
<?php
	$sql = "SELECT * FROM degree_type";
	$deg_result = $link->query($sql);
	while($deg_row = $deg_result->fetch_assoc()) {
		echo "<option value='" . $deg_row['deg_type_idx'] . "'>" . $deg_row['degree_type_name'] . "</option>";
	}
	$deg_result->free();
?>
						</select>  OR Enter New: <input name="new_degree" type="text" placeholder="Degree">
					</h5>
					<input type="hidden" name="row_id" value="<?=$i?>">
					<p><input class="w3-btn w3-hover-blue" type="submit" name="submit4new" value="Save New"></p>
				</form>
                <br>

<?php
	$link->close();
?>
			</div>
		</div>
	</div>
</body>
</html>

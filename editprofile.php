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
				$message = "<h4>Success</h4>";
			} else {
				$message = "<h4>Failed</h4>";
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
				$message ="<h4>Success</h4>";
			} else {
				$message ="<h4>Failed</h4>";
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
				$message = "<h4>Successfully Deleted</h4>";
			} else {
				$message = "<h4>Failed to Delete</h4>";
			}
		}
	}
	if(isset($_POST['submit3'])) { // Was the form submitted?
		$sql = "UPDATE work_experience SET title=?, company=?, start_date=?, end_date=?, description=? WHERE user_id=? AND experience_entry=?";
		print_r($_POST);
		if ($stmt = $link->prepare($sql)) {
			for( $i = 1; $i < $_POST['exp_entries']; $i++) {
				$title = $_POST['title'.$i];
				$company = $_POST['company'.$i];
				$start = $_POST['start_date'.$i];
				$end = $_POST['end_date'.$i];
				$description = $_POST['description'];
				$stmt->bind_param("sssssii", $title, $company, $start, $end, $description, $uid, $i);
				if($stmt->execute()) {
					$message = "<h4>Success</h4>";
				} else {
					$message = "<h4>Failed</h4>";
				}
			}
			$stmt->close();
			if(isset($_POST['title'.$i])) {
				$sql = "INSERT INTO work_experience VALUES (?, ?, ?, ?, ?, ?, ?)";
				if ($stmt = $link->prepare($sql)) {
					$title = $_POST['title'.$i];
					$company = $_POST['company'.$i];
					$start = $_POST['start_date'.$i];
					$end = $_POST['end_date'.$i];
					$description = $_POST['description'];
					$stmt->bind_param("iisssss", $uid, $i, $title, $company, $start, $end, $description);
					if($stmt->execute()) {
						$message = "<h4>Success</h4>";
					} else {
						$message = "<h4>Failed</h4>";
					}
					$stmt->close();
				} else {
					$message = "prepare fail";
				}
			}
		} else {
			$message = "prepare fail";
		}
	}


	if(isset($_POST['submit4'])) { // Was the form submitted?

	}

	if(isset($_POST['submit5'])) { // Was the form submitted?

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
		<div class="col-sm-4" style='text-align: center'><?php echo $message; ?></div>
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
<?php
	$sql = "SELECT * FROM states";
	$result = $link->query($sql);
	while($row = $result->fetch_assoc()) {
		if($row['idstates'] == $user_row['state']) {
			echo "<option value='" . $row['idstates'] . "' selected>" . $row['state'] . "</option>";
		} else {
			echo "<option value='" . $row['idstates'] . "'>" . $row['state'] . "</option>";
		}
	}
	$result->free();
?>
					</select>
				</h4>
				<p> <input class=" w3-btn w3-hover-blue" type="submit" name="submit1" value="Save"></p>
			</form>
		</div>
        <div class="col-sm-4"></div>
	</div>
    <div class="row" id="row3">
        <div class="col-sm-1"></div>
        <div class="col-sm-1"></div>
        <div class="col-sm-8">
            <div id = "background">
				<h2>Background</h2>
				<h4>Summary</h4>
<!-- Form for Summary -->
				<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
					<p><textarea name="summary" placeholder="Summary"><?php echo $user_row['summary']; ?></textarea></p>
					<p><input class=" w3-btn w3-hover-blue" type="submit" name="submit2" value="Save"></p>
				</form>
				<hr>
				<h4>Experience</h4>
<?php
	$sql = "SELECT * FROM work_experience WHERE user_id=$uid";
	$result = $link->query($sql);
?>
				<form action="<?=$_SERVER['PHP_SELF']?>" method="POST" id="work_form">
				</form>
<?php
	$i=0;
	while($row = $result->fetch_assoc()) {
		$i++;
?>
					<h5>Job Title <br>
						<input form="work_form" name="title<?=$i?>" type="text" placeholder="Job Title" value="<?php echo $row['title']; ?>">
					</h5>
					<h5>Company <br>
						<input form="work_form" name="company<?=$i?>" type="text" placeholder="Job Title" value="<?php echo $row['company']; ?>">
					</h5>
					<h5>Start - End <br>
						<input form="work_form" name="start_date<?=$i?>" type="text" placeholder="Start date" value="<?php echo $row['start_date']; ?>">-
						<input form="work_form" name="end_date<?=$i?>" type ="text" placeholder="End date" value="<?php echo $row['end_date']; ?>">
					</h5>
					<p><input form="work_form" name="description<?=$i?>" type ="text" placeholder="Description" value="<?php echo $row['description']; ?>"></p>
					<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
						<input type="hidden" name="row_id" value="<?=$i?>">
						<input name="delete_work" type="submit" class="w3-btn w3-hover-blue" value="Delete Entry">
					</form>
					<p><hr></p>
<?php

	}
	$i++;
?>
					<h5>Job Title <br>
						<input form="work_form" name="title<?=$i?>" type="text" placeholder="Job Title">
					</h5>
					<h5>Company <br>
						<input form="work_form" name="company<?=$i?>" type="text" placeholder="Job Title">
					</h5>
					<h5>Start - End (YYYY-MM-DD)<br>
						<input form="work_form" name="start_date<?=$i?>" type="text" placeholder="Start date">-
						<input form="work_form" name="end_date<?=$i?>" type ="text" placeholder="End date">
					</h5>
					<p><input form="work_form" name="description<?=$i?>" type ="text" placeholder="Description"></p>
					<input form="work_form" type="hidden" name="exp_entries" value="<?=$i?>">
					<p><input form="work_form" class="w3-btn w3-hover-blue" type="submit" name="submit3" value="Save"></p>
				</form>
				<br>
				<hr>
				<h4>Education</h4>
<?php

?>
				<ul>
					<li>School   -   Date</li>
					<input name="school" type ="text" placeholder="school" value="<?php echo $erow['school']; ?>"><input name = "start_year"  type ="text"  placeholder="Start year" value="<?php echo $erow['start_year']; ?>">-<input name = "end_year"  type ="text"  placeholder="End year" value="<?php echo $erow['end_year']; ?>">
					<input class=" w3-btn w3-hover-blue" type="submit" name="submit4" value="Save">
				</ul>
                <hr>
				<h4>Skills</h4>
				<ul id="skils_list">
					<li>Skill</li>
					<textarea id = "skill1" placeholder="Skill" value="<?php echo $srow['skill1']; ?>"></textarea>
					<li>Skill</li>
					<textarea id = "skill2" placeholder="Skill" value="<?php echo $srow['skill2']; ?>"></textarea>
					<li>Skill</li>
					<textarea id = "skill3" placeholder="Skill" value="<?php echo $srow['skill3']; ?>"></textarea>
					<p> <input class=" w3-btn w3-hover-blue" type="submit" name="submit5" value="Save"></p>
				</ul>
			</div>
			<div  align="center">
				<div   align="center"></div>
			</div>
		</div>
	</div>
<?php
	$link->close();
?>
</body>
</html>

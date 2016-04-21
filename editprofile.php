<?php
	session_start();
	//require '../secure/db.conf';
/*
	if(!$_SESSION['islogin']) {
		header("Location: index.php");
	}
	if($_SESSION['user_id'] != $_GET['user_id']) {
		$viewid = $_GET['user_id']
		header("Location: ViewProfile.php?user_id=$viewid");
	}

*/
$dbhost = "us-cdbr-azure-central-a.cloudapp.net";
	$dbuser = "bc5440dcdc748f";
	$dbpass = "d3dc6711";
	$dbname = "linkedout";
	$_SESSION['user_id'] = 21;
	//$uid = $_GET['user_id'];
	$uid = $_SESSION['user_id'];

	$message = '';

	if(isset($_POST['submit1'])) { // Was the form submitted?

		$link = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ("Connection Error " . mysqli_error($link));

		$sql = "UPDATE users SET fname=?, lname=?, city=?, state =? WHERE user_id=?";

		if ($stmt = mysqli_prepare($link, $sql)) {
			$fname = $_POST['firstname'];
			$lname = $_POST['lastname'];
			$city = $_POST['city'];
			$state = $_POST['state'];
			mysqli_stmt_bind_param($stmt, "sssss", $fname, $lname, $city, $state,$uid) or die("bind param");
			if(mysqli_stmt_execute($stmt)) {
				$message = "<h4>Success</h4>";
			} else {
				$message = "<h4>Failed</h4>";
			}
		} else {
			$message = "prepare fail";
		}
	}
	//$link = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if(isset($_POST['submit3'])) { // Was the form submitted?


		$link = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ("Connection Error " . mysqli_error($link));

		$sql = "UPGRADE work_experience SET title =?, start_date =?, end_date =?,description = ? WHERE user_id =? ";
		//$sql0 = "UPDATE users SET fname =?, lname =?, city =?,state =?  WHERE user_id = ?";
		if ($stmt = mysqli_prepare($link, $sql)) {

						$title = $_POST['job_title'];
						$start = $_POST['start_date'];
						$end = $_POST['end_date'];
						$description = $_POST['job_description'];
						mysqli_stmt_bind_param($stmt, "sssss", $title, $start, $end, $description,$uid) or die("bind param");
						if(mysqli_stmt_execute($stmt)) {
							$message ="<h4>Success</h4>";
						} else {
							$message ="<h4>Failed</h4>";
						}
		}else{
			$message = " prepare fail";
		}
	}


	if(isset($_POST['submit4'])) { // Was the form submitted?


		$link = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ("Connection Error " . mysqli_error($link));

		$sql = "UPGRADE education SET school =?, start_year =?, end_year =? WHERE user_id =? ";

		if ($stmt = mysqli_prepare($link, $sql)) {

						$school = $_POST['schoool'];
						$start = $_POST['start_year'];
						$end = $_POST['end_year'];

						mysqli_stmt_bind_param($stmt, "ssss", $school,$start, $end, $uid) or die("bind param");
						if(mysqli_stmt_execute($stmt)) {
							$message = "<h4>Success</h4>";
						} else {
							$message ="<h4>Failed</h4>";
						}
		}else{
			$message = " prepare fail";
		}
	}

	if(isset($_POST['submit5'])) { // Was the form submitted?


		$link = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ("Connection Error " . mysqli_error($link));

		$sql1 = "UPGRADE skills SET skill =? WHERE user_id =? AND skills_id = ?";

		if ($stmt1 = mysqli_prepare($link, $sql1)) {

						$skill = $_POST['skill1'];
						$sillid = 1;
						mysqli_stmt_bind_param($stmt1, "sss", $skill,$uid, $skillid) or die("bind param");
						if(mysqli_stmt_execute($stmt1)) {
							$message = "<h4>Success</h4>";
						} else {
							$message = "<h4>Failed</h4>";
						}
		}else{
			$message = " prepare fail";
		}
		$sql2 = "UPGRADE skills SET skill =? WHERE user_id =? AND skills_id = ?";

		if ($stmt = mysqli_prepare($link, $sql2)) {

						$skill = $_POST['skill2'];
						$sillid = 2;
						mysqli_stmt_bind_param($stmt2, "sss", $skill,$uid, $skillid) or die("bind param");
						if(mysqli_stmt_execute($stmt2)) {
							$message ="<h4>Success</h4>";
						} else {
							$message ="<h4>Failed</h4>";
						}
		}else{
			$message = " prepare fail";
		}
		$sql3 = "UPGRADE skills SET skill =? WHERE user_id =? AND skills_id = ?";

		if ($stmt3 = mysqli_prepare($link, $sql3)) {

						$skill = $_POST['skill3'];
						$sillid = 3;
						mysqli_stmt_bind_param($stmt3, "sss", $skill,$uid, $skillid) or die("bind param");
						if(mysqli_stmt_execute($stmt3)) {
							$message = "<h4>Success</h4>";
						} else {
							$message ="<h4>Failed</h4>";
						}
		}else{
			$message = " prepare fail";
		}

	}
	$link = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
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
                          <li><a href="logout.php">Logout</a></li>
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
              <li role="presentation" class="active"><a href="#">Edit Profile</a></li>
              <li role="presentation"><a href="ViewProfile.php?user_id=<?php echo $uid; ?>">Profile</a></li>
              <li role="presentation"><a href="#">Connections</a></li>
            <li role="presentation"><a href="#">Groups</a></li>
            </ul>
           </div>
           <div class="col-sm-4"></div>

    </div>



    <div class="row" id = "row2">

        <div class="col-sm-1">
        </div>

        <div class="col-sm-1">
        </div>



        <div class="col-sm-4">

            <img id="profile_pic" src="/mmadden1495.centralus.cloudapp.azure.com/public_html/default.jpg" alt="default_pic" class="img-responsive">

        </div>

        <div class="col-sm-4" id="profile_info">
			<?php
				$sql = "SELECT * FROM users where user_id=$uid";

				$result = $link->query($sql);
				$user_row = $result->fetch_assoc();
			 ?>
			<form id="user" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <h4 id="fullname">Full Name
            <input class = 'form-control' type ="text" name = " firstname" placeholder="First Name" value="<?php echo $user_row['fname']; ?>">
          <input class = 'form-control' type ="text" name = " lastname" placeholder="Last Name" value="<?php echo $user_row['lname']; ?>">
          </h4>

          <h4 id = "occupation">Occupation
            <input class = 'form-control' type ="text" name = " occupation" placeholder="occupation">
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
				<?php
				$id =1;
				$sql = "SELECT * FROM education where user_id=$id";

				$es = $link->query($sql);
				$erow = $es->fetch_assoc();
			 ?>
          <h4 id="School">School
             <input class = 'form-control' type ="text" name = "school" placeholder="School" value="<?php echo $erow['school']; ?>">
             </h4>
            Status:<p id="status">
              <textarea id = "status" placeholder="Status"></textarea>
            </p>

            <p> <input class=" w3-btn w3-hover-blue" type="submit" name="submit1" value="Save"></p>
			</form>
        </div>

        <div class="col-sm-1">
        </div>

        <div class="col-sm-1">
        </div>


    </div>


    <div class="row" id="row3">


        <div class="col-sm-1">
        </div>

        <div class="col-sm-1">
        </div>

        <div class="col-sm-8">


			<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <div id = "background">
             <?php
				$sql = "SELECT * FROM work_experience where user_id=$uid";

				$ws = $link->query($sql);
				$wrow = $ws->fetch_assoc();
			 ?>
            <h2>Background</h2>
            <h4>Summary</h4>
            <p id="summary"><textarea id = "summary" placeholder="Summary"></textarea></p>
            <p> <input class=" w3-btn w3-hover-blue" type="submit" name="submit2" value="Save"></p>
           <hr>
         <h4>Experience</h4>

            <h5 id="job_title">Job Title <br>
            <input name = "job_title"  type ="text" placeholder="Job Title" value="<?php echo $wrow['title']; ?>"></h5>


            <h5 id="job_date">Date - Date <br>
            <input name = "start_date"  type ="text"  placeholder="Start date" value="<?php echo $wrow['start_date']; ?>">-<input name = "end_date"  type ="text" placeholder="End date" value="<?php echo $wrow['end_date']; ?>"></h5>

            <p id="job_description"><input id = "job_description" type ="text" placeholder="Description" value="<?php echo $wrow['description']; ?>"></p>
            <p> <input class=" w3-btn w3-hover-blue" type="submit" name="submit3" value="Save"></p>

              <br>

            <hr>
            <h4>Education</h4>

            <ul id="reccomend_list">
            <li>School   -   Date</li>
            <input name = "school"  type ="text"  placeholder="school"value="<?php echo $erow['school']; ?>"> <input name = "start_year"  type ="text"  placeholder="Start year" value="<?php echo $erow['start_year']; ?>">-<input name = "end_year"  type ="text"  placeholder="End year" value="<?php echo $erow['end_year']; ?>">

            </p>
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
             <p>
              <textarea id = "skill3" placeholder="Skill" value="<?php echo $srow['skill3']; ?>"></textarea>


             </p>
             <p> <input class=" w3-btn w3-hover-blue" type="submit" name="submit5" value="Save"></p>
            </ul>
            <hr>
             <h4>Reccomendations</h4>
            <ul id="reccomend_list">
            <li>Reccomneded by this person</li>
            <li>Reccomended by this person</li>
            <li>Reccomended by this person</li>
            <input class=" w3-btn w3-hover-blue" type="submit" name="submit6" value="Save">
            </ul>
            <hr>
            <h4>Followed Groups</h4>
            <ul id="followed_list">
            <li>Following this company</li>
            <li>Following this company</li>
            <li>Following this company</li>
            <input class=" w3-btn w3-hover-blue" type="submit" name="submit7" value="Save">
            </ul>

            </div>

				</form>
        <div  align="center">
        <div   align="center">

            <p><a href="#top"  class=" w3-btn w3-hover-blue">TOP</a>


            </p>
          </blockquote>
        </div>


        </div>


        </div>
		<?php
			echo $message;
			$link->close();
		?>
        </div>

</body>

</html>

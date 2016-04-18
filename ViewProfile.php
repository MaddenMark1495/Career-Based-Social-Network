<?php
	session_start();

/*
	//redirect if not logged in
	if(!$_SESSION['islogin']) {
		header("Location: index.php");
	}
*/
	//$_SESSION['view_id'] = $_GET['user_id'];

	//hardcoded for testing
	$_SESSION['username'] = 'user';
	$_SESSION['user_id'] = 1;
	$_SESSION['view_id'] = 1;

	$view_id = $_SESSION['view_id'];

	require '../secure/db.conf';
    // Create connection
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
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
						<li><a href="ViewProfile.php?user_id=<?php echo $_SESSION['user_id'];?>"><?php echo $_SESSION['username']; ?><li>
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
              <li role="presentation"><a href="#">Edit Profile</a></li>
              <li role="presentation" class="active"><a href="#">Profile</a></li>
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

            <img id="profile_pic" src="default.jpg" alt="default_pic" class="img-responsive">

        </div>

        <div class="col-sm-4" id="profile_info">

            <h4 id="fullname">Full Name:
<?PHP
                        $sql = "SELECT fname, lname from users where user_id=$view_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
         //print_r($row);
         echo $row['fname'];
         echo " ";
         echo $row['lname'];
     }
} else {
     echo "0 results";
}

?></h4>

            <h4 id = "occupation">Occupation:</h4>
            <h4 id = "address">
<?PHP
$sql = "SELECT users.city,states.state from users inner join states on users.state=states.idstates where user_id=$view_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
         //print_r($row);
         echo $row['city'];
         echo ", ";
         echo $row['state'];
     }
} else {
     echo "0 results";
}

?></h4>
            <h4 id="School">School:
<?PHP
$sql = "SELECT education.school from education inner join users on education.user_id=users.user_id where users.user_id=$view_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
         //print_r($row);
         echo $row['school'];
     }
} else {
     echo "0 results";
}

?></h4>
            Status:<p id="status">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas feugiat turpis et convallis aliquam. Nulla dictum felis vitae lacus sollicitudin convallis. Sed gravida mattis augue, et mattis leo lacinia ut.</p>

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



            <div id = "background">
            <h2>Background</h2>
            <h4>Summary</h4>
            <p id="summary">"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit,</p>
           <hr>
          <h4>Experience</h4>
            <h5 id="job_title">Job title:
<?PHP
                $sql = "SELECT work_experience.title from work_experience where work_experience.user_id=$view_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        //print_r($row);
                        echo $row['title'];
                    }
                } else {
                    echo "0 results";
                }

?>
                </h5>
            <h5 id="job_date">Date:
<?PHP
                $sql = "SELECT work_experience.start_date,work_experience.end_date from work_experience where work_experience.user_id=$view_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        //print_r($row);
                        echo $row['start_date'];
                        echo " - ";
                        echo $row['end_date'];
                    }
                } else {
                    echo "0 results";
                }

?>
                </h5>
            <p id="job_desciption">
<?PHP
                $sql = "SELECT work_experience.description from work_experience where work_experience.user_id=$view_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        //print_r($row);
                        echo $row['description'];
                    }
                } else {
                    echo "0 results";
                }

?></p>
              <br>
            <hr>
            <h4>Education</h4>
            <ul id="education_list">
            <li>School:   <?PHP
                $sql = "SELECT education.school from education where education.user_id=$view_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        //print_r($row);
                        echo $row['school'];
                    }
                } else {
                    echo "0 results";
                }

?> Date
<?PHP
                $sql = "SELECT education.start_year,education.end_year from education where education.user_id=$view_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        //print_r($row);
                        echo $row['start_year'];
                        echo "-";
                        echo $row['end_year'];
                    }
                } else {
                    echo "0 results";
                }

?>
                </li>
			</ul>
			<hr>
            <h4>Skills</h4>
            <ul id="skills_list">
            <li>Skill:
<?PHP
                $sql = "SELECT skills.skill from user_skills inner join users on users.user_id=user_skills.user_id inner join skills on user_skills.skills_id=skills.skills_id where users.user_id=$view_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
					$rownum = 0;
                    while($row = $result->fetch_assoc()) {
                        //print_r($row);
                        echo $row['skill'];
						$rownum++;
						if($rownum < $result->num_rows) {
							echo ", ";
						}
                    }
                } else {
                    echo "0 results";
                }

?>
                </li>
            </ul>
            <hr>
             <h4>Recommendations</h4>
            <ul id="recommend_list">
            <li>Recommended by this person</li>
            <li>Recommended by this person</li>
            <li>Recommended by this person</li>
            </ul>
            <hr>
            <h4>Followed Groups</h4>
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

    ?>
            </ul>

            </div>


        <div class="col-sm-1">
        </div>

        <div class="col-sm-1">
        </div>

        </div>

        </div>

</body>

</html>

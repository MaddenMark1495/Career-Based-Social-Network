<?php
	session_start();
/*
	if(!$_SESSION['islogin']) {
		header("Location: index.php");
	}
*/
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
              <li role="presentation"><a href="#">Profile</a></li>
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

            <h4 id="fullname">Full Name</h4>
            <h4 id = "occupation">Occupation</h4>
            <h4 id = "address">City, State</h4>
            <h4 id="School">School</h4>
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
            <h5 id="job_title">Job title</h5>
            <h5 id="job_date">Date - Date</h5>
            <p id="job_desciption">"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
              <br>
            <h5 id="job_title">Job title</h5>
            <h5 id="job_date">Date - Date</h5>
            <p id="job_desciption">"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
            <hr>
            <h4>Education</h4>
            <ul id="reccomend_list">
            <li>School   -   Date</li>
            <li>School   -   Date</li>
            </ul>
                <hr>
              <h4>Skills</h4>
            <ul id="skils_list">
            <li>Skill</li>
            <li>Skill</li>
            <li>Skill</li>
            </ul>
            <hr>
             <h4>Reccomendations</h4>
            <ul id="reccomend_list">
            <li>Reccomneded by this person</li>
            <li>Reccomended by this person</li>
            <li>Reccomended by this person</li>
            </ul>
            <hr>
            <h4>Followed Groups</h4>
            <ul id="followed_list">
            <li>Following this company</li>
            <li>Following this company</li>
            <li>Following this company</li>
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

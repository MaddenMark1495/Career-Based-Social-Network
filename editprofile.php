
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
            
            <img id="profile_pic" src="/mmadden1495.centralus.cloudapp.azure.com/public_html/default.jpg" alt="default_pic" class="img-responsive">
        
        </div>
        
        <div class="col-sm-4" id="profile_info">
            
            <h4 id="fullname">Full Name
            <input class = 'form-control' type ="text" name = " firstname" placeholder="Firstname">
          <input class = 'form-control' type ="text" name = " lastname" placeholder="Lastname">
          </h4>
            
          <h4 id = "occupation">Occupation
            <input class = 'form-control' type ="text" name = " occupation" placeholder="occupation">
            </h4>
          <h4 id = "address">City, State
          <input class = 'form-control' type ="text" name = "city" placeholder="City">
          <input class = 'form-control' type ="text" name = "state" placeholder="State">              
          </h4>
     
          <h4 id="School">School
             <input class = 'form-control' type ="text" name = "school" placeholder="School">
             </h4>
            Status:<p id="status">
              <textarea id = "status" placeholder="Status"></textarea>
            </p>
            
            <p> <input class=" w3-btn w3-hover-blue" type="submit" name="submit1" value="Save"></p>
            
        </div>
        <?php
	session_start();
	require './secure/db.conf';

	if(isset($_POST['submit1'])) { // Was the form submitted?

		$hash = password_hash("pass", PASSWORD_DEFAULT);
		$link = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ("Connection Error " . mysqli_error($link));

		$sql = "UPGRADE 'linkedout'.'users' SET fname =?, lname =?, city =?,state =?, school =? WHERE `user_id` =?";
		
		if ($stmt = mysqli_prepare($link, $sql)) {
						$userid = $_SESSION['user_id'];
						$fname = $_POST['firstname'];
						$lname = $_POST['lastname'];
						$city = $_POST['city'];
						mysqli_stmt_bind_param($stmt, "ssss", $fname, $lname, $city) or die("bind param");
						if(mysqli_stmt_execute($stmt)) {
							echo "<h4>Success</h4>";
						} else {
							echo "<h4>Failed</h4>";
						}
		}
	}
?>
        
        
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
            <p id="summary"><textarea id = "summary" placeholder="Summary"></textarea></p>
            <p> <input class=" w3-btn w3-hover-blue" type="submit" name="submit2" value="Save"></p>
           <hr>     
          <h4>Experience</h4>
            <h5 id="job_title">Job Title <br> 
            <input name = "job_title"  type ="text" placeholder="Job Title"></h5>
            
            
            <h5 id="job_date">Date - Date <br>
            <input name = "start_date"  type ="text"  placeholder="Start date">-<input name = "end_date"  type ="text" placeholder="End date"></h5>
            
            <p id="job_desciption"><textarea id = "job_desciption" placeholder="Desciption"></textarea></p>
            <p> <input class=" w3-btn w3-hover-blue" type="submit" name="submit3" value="Save"></p>      
              <br>  
                
            <hr>
            <h4>Education</h4>
            <ul id="reccomend_list">
            <li>School   -   Date</li>
            <input name = "School"  type ="text"  placeholder="School"> <input name = "start_year"  type ="text"  placeholder="Start year">-<input name = "end_year"  type ="text"  placeholder="End year">
            <li>School   -   Date</li> 
            <p>
              <input name = "School"  type ="text"  placeholder="School"> 
              <input name = "start_year"  type ="text"  placeholder="Start year">-<input name = "end_year"  type ="text"  placeholder="End year">
            </p>
             <input class=" w3-btn w3-hover-blue" type="submit" name="submit4" value="Save">
            </ul>   
                <hr>
              <h4>Skills</h4>
            <ul id="skils_list">
            <li>Skill</li>
            <textarea id = "skill1" placeholder="Skill"></textarea>
            <li>Skill</li>
             <textarea id = "skill2" placeholder="Skill"></textarea>
            <li>Skill</li>
             <p>
              <textarea id = "skill3" placeholder="Skill"></textarea>
               
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
                
                
        <div  align="center">
        <div   align="center"> 
         
            <p><a href="#top"  class=" w3-btn w3-hover-blue">TOP</a>
              
              
            </p>
          </blockquote>
        </div>
    
        
        </div> 
       
                
        </div>     
                
        </div>
        
</body>

</html>

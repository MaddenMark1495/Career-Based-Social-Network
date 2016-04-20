<?php
	session_start();
	require "../secure/db.conf";
/*
	if(!$_SESSION['islogin']) {
		header("Location: index.php");
	}
*/
	$_SESSION['user_id'] = 1;
	$_SESSION['username'] = user;
	$uid = $_SESSION['user_id'];

	//$_SESSION['user_id'] = 23;
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Top 10</title>

		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="page1.css">
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open Sans">

		<script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
		<script src="jquery-1.12.0.min.js"></script>

		<style>
			.header {
				text-align: center;
			}
			body {
			    background-color: #EEE;
			}
			.top10 .choice, .user .choice {
			    float: left;
			    font-family: arial;
			    font-size: 1.5em;
			    min-width: 500px;
			    text-align: right;
			    margin: 8px 5px;
			}
			.top10 .bar, .user .bar {
				font-family: arial;
				font-size: 1.5em;
				padding: 3px 0px 3px 0px;
				margin: 1px;
				text-align: right;
			    width: 0;
			    height: 35px;
			    background-color: skyblue;
			    float: left;
			}
			.user .bar {
				background-color: red;
			}
			.group:after {
			  content: "";
			  display: table;
			  clear: both;
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

		<div class="header"><h2>Top 10 Users by Profile Views</h2></div>
		<div class="top10"></div>
		<hr>

		<script>

		 	var url = "http://swegroup14.centralus.cloudapp.azure.com/Career-Based-Social-Network/top10server.php";

			//ajax request to get the top 10 list from DB as JSON
			$.getJSON(url, function(data) {
				var top10Bar = d3.select(".top10").selectAll("div").data(data.user),
                    top10Wrapper = top10Bar.enter().append("div").classed("group", true);

				//add the labels with as <a> tags
				top10Wrapper.append("div")
                    .classed("choice", true)
					.append("a")
	                    .text(function(user) {
	                        return user.fname + " " + user.lname;
	                    });

				//quick work to get array of just profile_views for chart scaling
				var pviews = [];
				$.each(data.user, function(index, user) {
					user.profile_views = +user.profile_views;
					pviews.push(user.profile_views);
				});

				//chart scaling
				var x = d3.scale.linear()
				    .domain([0, d3.max(pviews)])
				    .range([0, 500]);

				//add the bars with transition and text and set the width
                top10Wrapper.append("div")
                    .classed("bar", true)
                    .transition()
                    .duration(1000)
					.text(function(user) {
						return user.profile_views;
					})
                    .style("width", function(user) {
                        return x(user.profile_views) + "px";
                    });

				//need to add id to each bar based on the user it represents
				var bars = d3.select(".top10").selectAll(".bar").data(data.user);
				bars.attr("id", function(user) {
					return "id" + user.user_id;
				})

				//for determing if the current user is in the top 10 (thus the ids on the bars)
				var istop10 = false;
				var uid = <?php echo $_SESSION['user_id']; ?>;

				//oops.. need to add the hrefs to the <a> tag labels
				var top10Link = d3.select(".top10").selectAll("a").data(data.user);
				top10Link.attr("href", function(user) {
					//and set istop10 to true if we find a top10 user that matches the current user
					if(user.user_id == uid) {
						istop10 = true;
					}
					return "http://swegroup14.centralus.cloudapp.azure.com/Career-Based-Social-Network/ViewProfile.php?user_id=" + user.user_id;
				});

				<?php
					//this gets the information corresponding to the current user
					$link = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
					$sql = "SELECT user_id, fname, lname, profile_views FROM users WHERE user_id=$uid";

					$result = $link->query($sql);
					$row = $result->fetch_assoc();

					$result->free();
					$link->close();

					//kinda like having it in json
					print "var usr = [" . json_encode($row) . "];";
				?>

				//istop10 = false;
				//last bit of work dependent on if the the user istop10 or not
				if(istop10) {
					//user istop10, color the bar different and add a message
					var usertop10 = d3.select(".top10").select("#id<?php print $_SESSION['user_id']; ?>");
					usertop10.style("background-color", "red");

					d3.select("body").append("div")
						.classed("header", true)
							.append("h2")
							.text("Congratulations! You're in the Top 10");
				} else {
					//the user !istop10, add a chart of their own profile_views
					d3.select("body").append("div")
						.classed("header", true)
							.append("h2")
							.text("Your Profile Views");

					d3.select("body").append("div")
						.classed("user", true);

					var userBar = d3.select(".user").selectAll("div").data(usr),
						userWrapper = userBar.enter().append("div").classed("group", true);

					userWrapper.append("div")
						.classed("choice", true)
						.append("a")
							.text(function(usr) {
								return usr.fname + " " + usr.lname;
							});

					userWrapper.append("div")
						.classed("bar", true)
						.transition()
						.duration(1000)
						.text(function(usr) {
							return usr.profile_views;
						})
						.style("width", function(usr) {
							return x(usr.profile_views) + "px";
						});
				}

			});
		</script>
	</body>
</html>

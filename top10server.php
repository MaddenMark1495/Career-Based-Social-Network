<?php
	require '../secure/db.conf';

	$link = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

	$sql = "SELECT user_id, fname, lname, profile_views FROM users ORDER BY profile_views DESC LIMIT 10";

	$result = $link->query($sql);

	$users = array();
	while($row = $result->fetch_assoc()) {
		$users[] = $row;
	}
	$result->free();
	$link->close();

	$json = "{\"user\":".json_encode($users)."}";
	print $json;
 ?>

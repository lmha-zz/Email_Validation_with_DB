<?php
session_start();

require("new_connection.php");

if(isset($_SESSION['success_message']))
{
	echo "<div class='success'>{$_SESSION['success_message']} </div>";
	unset($_SESSION['success_message']);
}


function email_log()
{
	$_SESSION['rm_email'] = array();
	$query = "SELECT id, email, created_at FROM email_addresses";
	$row = fetch_all($query);
	echo "<div id='list'>";
	echo "<h1>Email Addresses Entered: </h1>";
	{
		foreach ($row as $array) {
			$time = date_create($array['created_at']);
			echo "<p>{$array['email']} ". date_format($time, 'm/d/y h:i A') . "</p>
			<form action='process.php' method='post'>
			<input type='hidden' name='action' value='delete'>
			<input type='hidden' name='email_id' value='{$array['id']}'>";
			echo"<button>Delete</button></form><br>";
		}
	}
	echo "</div>";
}

email_log();

?>

<link rel="stylesheet" type="text/css" href="css.css">
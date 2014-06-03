<?php
session_start();

require("new_connection.php");

if (isset($_POST['action']) && $_POST['action'] == 'validate')
{
	email_validate_and_add($_POST);
}
if(isset($_POST['action']) && $_POST['action'] == 'delete')
{
	foreach ($_POST as $key => $value) {
		$id = intval($_POST['email_id']);
		$query = "DELETE FROM email_addresses WHERE id = '{$id}'";
		run_mysql_query($query);
	}
	unset($_SESSION['rm_email']);
	header("Location: success.php");
}

function email_validate_and_add($array)
{
	$_SESSION['error'] = array();
	if(isset($array['action']) && $array['action'] == 'validate')
	{
		if(empty($array['email']))
		{
			$_SESSION['error'][] = "Email address cannot be blank!";
			header("Location: index.php");
			die();
		}
		else
		{
			if (!filter_var($array['email'], FILTER_VALIDATE_EMAIL))
			{
				$_SESSION['error'][] = "The email address you entered ({$array['email']}) <br>is NOT a valid email address!";
				header("Location: index.php");
				die();
			}
			else
			{
				$email = escape_this_string($array['email']);
				$query = "INSERT INTO email_addresses (email, created_at, updated_at) VALUES ('{$email}', NOW(), NOW())";
				run_mysql_query($query);
				$_SESSION['success_message'] = "The email address you entered ({$array['email']}) <br>is a VALID email address! Thank you!";
				header("Location: success.php");
				die();
			}
		}
	}
}

?>
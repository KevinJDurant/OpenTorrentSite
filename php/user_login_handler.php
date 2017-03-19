<?php
	include_once "password.php";
	include_once "dbaccess.php";

	date_default_timezone_set('Europe/Brussels');

	function register() {
		$db = new Db();

		// Attributes
		$password = $db -> quote($_POST['password']);
		$toValidatePassword = $db -> quote($_POST['tovalidatepassword']);
		$email = $db -> quote($_POST['email']);
		$username = $db -> quote($_POST['username']);

		// Log user join date.
		$mysql_date = date('Y-m-d');

		// Hash the password.
		$hashed_password = password_hash($password, PASSWORD_BCRYPT);

		// Insert everything into the database if passwords match.
		if($password == $toValidatePassword) {
			$key = md5(uniqid(rand(), true));

			$result = $db -> query("INSERT INTO `users` (`email`, `reg_date`, `username`, `password`, `tempkey`) VALUES (" . $email . ",'" .$mysql_date . "'," . $username.",'".$hashed_password ."','".$key ."')"); 

			$userid = $db -> select("SELECT `user_id` FROM `users` WHERE `email`=".$email."");

			$_SESSION["username"] = $_POST['email'];
			$_SESSION["userid"] = $userid;
			$_SESSION["key"] = $key;

			header("Location: ../../index.php");
		} else {
			// GUI Feedback.

		}
	}

	function login() {
		$db = new Db();

		// Attributes
		$password = $db -> quote($_POST['password']);
		$email = $db -> quote($_POST['email']);

		// Get the required data to verify the users login attempt.
		$result = $db -> select("SELECT `user_id`,`password`,`email` FROM `users` WHERE `email`=".$email."");

		// Verify the password.
		if (password_verify($password, $result[0]['password'])) {
			$key = md5(uniqid(rand(), true));

			$insertResult = $db -> query("UPDATE `users` SET `tempkey`='".$key."' WHERE `email`=".$email."");

			// Set session data.
			$_SESSION["username"] = $result[0]['email'];
			$_SESSION["userid"] = $result[0]['user_id'];
			$_SESSION["key"] = $key;

			// Redirect the user.
			header("Location: ../../index.php?welcome");
		} else {
			// GUI Feedback.
			
		}
	}
?>
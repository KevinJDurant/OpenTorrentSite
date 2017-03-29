<?php
	include_once "libs/password.php";
	include_once "libs/database.php";

	date_default_timezone_set('Europe/Brussels');

	/**
	 * Starts the login process.
	 *
	 */
	function login() {
		if(valid_login_postdata()) {
			$db = new Db();
			
			$password = $db -> quote(htmlspecialchars($_POST['password']));
			$email = $db -> quote(htmlspecialchars($_POST['email']));

			if(valid_password(htmlspecialchars($_POST['password']))) {
				$result = $db -> select("SELECT `user_id`,`username`,`password`,`email` FROM `users` WHERE `email`=".$email."");
				if(count($result) != 0) {
					if (password_verify($password, $result[0]['password'])) {
						$key = md5(uniqid(rand(), true));
						$db -> query("UPDATE `users` SET `tempkey`='".$key."' WHERE `email`=".$email."");

						$_SESSION["username"] = $result[0]['username'];
						$_SESSION["email"] = $result[0]['email'];
						$_SESSION["userid"] = $result[0]['user_id'];
						$_SESSION["key"] = $key;

						header("Location: ../../index.php");
					} else {
						exit(form_feedback("Wrong email or password."));
					}
				} else {
					exit(form_feedback("User not found."));
				}
			} else {
				exit(form_feedback("The password you entered was shorter than 8 characters."));
			}
		} else {
			exit(form_feedback("Please enter your credentials."));
		}
	}

	/**
	 * Checks if the password is longer than 8 characters.
	 *
	 * @param string of password.
	 * @return boolean.
	 */
	function valid_password($password) {
		if(strlen($password) >= 8) return true;
		return false;
	}

	/**
	 * Checks if the login form post variables aren't empty.
	 *
	 * @return boolean.
	 */
	function valid_login_postdata() {
		if(!empty($_POST['password']) && !empty($_POST['email'])) return true;
		return false;
	}

	/**
	 * Unhides the formfeedback and displays error text.
	 *
	 * @param string of error.
	 * @return javascript.
	 */
	function form_feedback($error) {
		echo '<script>';
		echo 'var element = document.getElementById("feedback").removeAttribute("style");';
		echo 'var element = document.getElementById("feedback").innerHTML ="'.$error.'";';
		echo '</script>';
	}
?>
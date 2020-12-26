<?php
	include_once "libs/password.php";
	include_once "libs/database.php";

	date_default_timezone_set('Europe/Brussels');

	/**
	 * Starts the register process.
	 *
	 */
	function register($inviteCode=null) {
		$db = new Db();

		$password = $db -> quote(htmlspecialchars($_POST['password']));
		$toValidatePassword = $db -> quote(htmlspecialchars($_POST['tovalidatepassword']));
		$email = $db -> quote(htmlspecialchars($_POST['email']));
		$username = $db -> quote(htmlspecialchars($_POST['username']));
		$mysql_date = $db -> quote(date('Y-m-d'));

		if(valid_register_postdata()) {
			if(!is_temp_mail(htmlspecialchars($_POST['email']))) {
				if(passwords_match($password,$toValidatePassword)) {
					if(valid_password(htmlspecialchars($_POST['password']))) {
						if(!already_registered($email,$username,$db)) {
							$hashed_password = password_hash($password, PASSWORD_BCRYPT);
							$key = md5(uniqid(rand(), true));
							if($inviteCode==null){
								$inviteCode = "''";
							}
							$result = $db -> query("INSERT INTO `users` (`email`, `reg_date`, `username`, `password`, `tempkey`, `invitecode`) VALUES (" . $email . "," .$mysql_date . "," . $username.",'".$hashed_password ."','".$key ."', $inviteCode)"); 
							$userid = $db -> select("SELECT `user_id` FROM `users` WHERE `email`=".$email."");
							update_inviteCode($db, $inviteCode);
							$_SESSION["username"] = htmlspecialchars($_POST['username']);
							$_SESSION["email"] = htmlspecialchars($_POST['email']);
							$_SESSION["userid"] = $userid[0]['user_id'];
							$_SESSION["key"] = $key;

							header("Location: ../../index.php");
							exit;
						} else {
							return form_feedback("This email or username is already being used.");
						}
					} else {
						return (form_feedback("Password should be longer than 8 characters."));
					}
				} else {
					return (form_feedback("The provided passwords don't match."));
				}
			} else {
				return (form_feedback("Please use a valid email address."));
			}
		} else {
			return (form_feedback("Please fill out the form."));
		}
	}

	/**
	 * Checks if the register form post variables aren't empty.
	 *
	 * @return boolean.
	 */
	function valid_register_postdata() {
		if(!empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['tovalidatepassword']) && !empty($_POST['username'])) return true;
		return false;
	}

	/**
	 * Checks if the provided email address is blacklisted.
	 *
	 * @param string of email.
	 * @return boolean.
	 */
	function is_temp_mail($mail) {
    	$mail_domains_ko = file('https://raw.githubusercontent.com/pypa/pypi-legacy/master/disposable_email_blacklist.conf', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    	return in_array(explode('@', htmlspecialchars($mail))[1], $mail_domains_ko);
	}

	/**
	 * Checks if the passwords match at register.
	 *
	 * @param string of password.
	 * @param string of confirmed password.
	 * @return boolean.
	 */
	function passwords_match($password,$confirm) {
    	if($password == $confirm) return true;
		return false;
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
	 * Checks if there is already a user registered using this mail address or username.
	 *
	 * @param string of mail.
	 * @param string of username.
	 * @param object of database.
	 * @return boolean.
	 */
	function already_registered($mail, $username, $db) {
		$mailresult = $db -> select("SELECT `email` FROM `users` WHERE `email`=".$mail."");
		$userresult = $db -> select("SELECT `username` FROM `users` WHERE `username`=".$username."");
		if(count($mailresult) == 0 && count($userresult) == 0) return false;
		return true;
	}

	/**
	 * Unhides the formfeedback and displays error text.
	 *
	 * @param string of error.
	 * @return javascript.
	 */
	function form_feedback($error) {
		$text = '<script>';
		$text .= 'var element = document.getElementById("feedback").removeAttribute("style");';
		$text .= 'var element = document.getElementById("feedback").innerHTML ="'.$error.'";';
		$text .= '</script>';
		return $text;
	}
?>
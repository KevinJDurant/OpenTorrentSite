<?php 
// PHP code that handles both registration and validation. Your website is by law required to have HTTPS.
// Setting the default timezone. (change this setting)
include_once "password.php";
date_default_timezone_set('Europe/Brussels');
	
function register() {
	//(change these values)
	$servername = "localhost";
	$username = "root";
	$dbpassword = "usbw";
	$dbname = "usersdb";
	//Connecting to the db.
	$conn = new mysqli($servername, $username, $dbpassword, $dbname);
	if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
	
	$password = htmlentities($_POST['password2']);
	$email = htmlentities($_POST['email2']);
	$username = htmlentities($_POST['username']);
	$cpassword = htmlentities($_POST['cpassword']);
	
	//Log user join date.
	$mysql_date = date( 'Y-m-d' );

	//Hash the password.
	$hashed_password = password_hash($password, PASSWORD_BCRYPT);

	//Insert everything into the database if passwords match.
	if($password == $cpassword) {
		$user_sql = 'INSERT INTO users (email, reg_date, username, password)' .
		"VALUES ('$email', '$mysql_date', '$username', '$hashed_password')";
		mysqli_query($conn, $user_sql) or die(mysql_error());
		mysqli_close($conn);
	}
}

function login() {
	//(change these values)
	$servername = "localhost";
	$username = "root";
	$dbpassword = "usbw";
	$dbname = "usersdb";
	
	//Connecting to the db.
	$conn = new mysqli($servername, $username, $dbpassword, $dbname);
	if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
	
	//htmlentities to prevent XSS
	$password = htmlentities($_POST['password']);
	$email = htmlentities($_POST['email']);
	
	//Verifying the user's login attempt.
	$sql = "SELECT password, username FROM users WHERE email='$email'";
	$result = mysqli_query($conn, $sql) or die(mysql_error());
	$hash = mysqli_fetch_assoc($result);

	if (password_verify($password, $hash['password'])) {
		//Convert this to cookies
		echo "
            <script type=\"text/javascript\">
            document.getElementById('loginbtn').innerHTML = '"; echo $hash['username']; echo "';
			document.getElementById('uploadbtn').className = 'pure-button';
            </script>
        ";
	} else {
		echo 'There was a problem with your username or password.';
	}
}
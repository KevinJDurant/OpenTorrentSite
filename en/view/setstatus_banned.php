<?php
	include_once "../../php/libs/database.php";
	include_once "../../php/libs/UserHelper.php";
    
	date_default_timezone_set('Europe/Brussels');

	$db = new Db();

	if (!isset($_SESSION)) {
		session_start();
	}

	$message = 'Account Status Changed: Banned';

	if (UserHelper::verifyAdministrator($db, $_SESSION['userid'], $_SESSION["key"])) {
		$query = "UPDATE users SET uploaderstatus = -1 WHERE user_id = %d;";
		$result = $db->query(sprintf($query, intval($_GET['user_id'])));
	} else {
		$message = 'Insufficient privileges!';
	}

	header("Location: preferences.php?msg=" . $message);
?>

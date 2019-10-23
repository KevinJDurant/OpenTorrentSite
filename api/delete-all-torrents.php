<?php
	include_once "../php/libs/database.php";
	include_once "../php/libs/UserHelper.php";
    
	date_default_timezone_set('Europe/Brussels');

	$db = new Db();

	$message = 'Users Torrents Removed';

	if (!isset($_SESSION)) {
		session_start();
	}

	if (UserHelper::verifyAdministrator($db, $_SESSION['userid'], $_SESSION["key"])) {
		$query = "DELETE FROM torrents WHERE userid = %d;";
		$result = $db->query(sprintf($query, intval($_GET['user_id'])));
	} else {
		$message = 'Insufficient privileges!';
	}

	header("Location: /en/view/preferences.php?msg=" . $message);

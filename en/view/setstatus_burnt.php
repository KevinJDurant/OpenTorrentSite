<?php
	include_once "../../php/libs/database.php";
    
	date_default_timezone_set('Europe/Brussels');

	$db = new Db();

	$db->query("DELETE FROM torrents WHERE userid=".$_GET['user_id']."");

	header("Location: preferences.php?msg=Users Torrents Removed");
?>

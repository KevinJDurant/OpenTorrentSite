<?php
	include_once "../../php/libs/database.php";
    
	date_default_timezone_set('Europe/Brussels');

	$db = new Db();

	$db->query("UPDATE `users` SET `uploaderstatus`=0 WHERE user_id=".$_GET['user_id']."");

	header("Location: preferences.php?msg=Account Status Changed: User");
?>

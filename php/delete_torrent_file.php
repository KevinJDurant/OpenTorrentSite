<?php
	include_once "libs/database.php";
    
	date_default_timezone_set('Europe/Brussels');

	$db = new Db();

	$db->query("DELETE FROM `torrents` WHERE `id`=".$_GET['delete_id']."");

	header("Location: ../index.php?msg=File Deleted Successfully!!!");
?>
<?php
	include_once "../../php/libs/database.php";
    
	date_default_timezone_set('Europe/Brussels');

	$db = new Db();

	$db->query("DELETE FROM `torrents` WHERE `id`=".$_GET['delete_id']."");

	header("Location: my-torrents.php?msg=Torrent Deleted Successfully");
?>

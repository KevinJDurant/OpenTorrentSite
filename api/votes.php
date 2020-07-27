<?php
    include_once "../php/libs/database.php";
    include_once "../php/libs/UserHelper.php";

    date_default_timezone_set('Europe/Brussels');

    $db = new Db();

    if (!isset($_SESSION)) {
        session_start();
    }
    
	$do=$_POST['d'];
	$torrentid=$_POST['torrent'];
	$userid=$_POST['userid'];

    $queryinsert = "INSERT INTO `votes` (`id`, `torrentid`, `userid`, `hasvoted`) VALUES (null, '$torrentid', '$userid', '$do')";
    $querycheck = "select count(id) as c from `votes` where `torrentid`='$torrentid' and `userid`='$userid'";
    $updatequery = "update `votes` set `hasvoted`='$do' where `torrentid`='$torrentid' and `userid`='$userid'";
	
	$count=($db->select($querycheck)[0]['c']);
	if($count!=null && $count>0){
		$db->query($updatequery);
	}else{
		$db->query($queryinsert);
	}
		$votesQ = $db->select("SELECT SUM(hasvoted) AS `Total_Votes` FROM `votes` WHERE `torrentid`=".$torrentid."");
		if ($votesQ[0]["Total_Votes"] === NULL) {
			$votes = 0;
		}else{
			$votes=$votesQ[0]["Total_Votes"];
		}
	echo $votes;

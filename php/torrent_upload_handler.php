<?php
	require_once 'torrent_metadata_handler.php';
	require_once 'torrent_scrapedata_handler.php';
	require_once "dbaccess.php";

    session_start();
	date_default_timezone_set('Europe/Brussels');

	$db = new Db();
	$scraper = new Scrapeer\Scraper();

	$target_dir = "../torrents/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$torrentFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	if (file_exists($target_file)) {
	    echo "Sorry, file already exists.";
	    $uploadOk = 0;
	}

	if ($_FILES["fileToUpload"]["size"] > 400000) {
	    echo "Sorry, your file is too large.";
	    $uploadOk = 0;
	}

	if($torrentFileType != "torrent") {
	    echo "Sorry, only torrent files are allowed.";
	    $uploadOk = 0;
	}

	if ($uploadOk == 0) {
		// Something else is wrong ... display error.
	} else {
	    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

	    	$torrent = new Torrent($target_file);

	    	$userid = $_SESSION["userid"];
	    	$categoryid = $db -> quote($_POST['categoryId']);
	    	$description = $db -> quote($_POST['description']);
	    	$name = $db -> quote($torrent->name());
	    	if("" != trim($_POST['name'])){ $name = $db -> quote($_POST['name']); }
	    	$uploaddate = $db -> quote(date('Y-m-d'));
	    	$size = $db -> quote($torrent->size(2));
			$hash = array($torrent->hash_info());
	    	$magnet = $db -> quote($torrent->magnet());
	    	$files = $db -> quote(serialize($torrent->content()));
	    	$trackers = formatTrackerArray($torrent->announce());
	    	$info = $scraper->scrape($hash, $trackers);

	    	$seeders = $info[$hash[0]]['seeders'];
	    	$leechers = $info[$hash[0]]['leechers'];

	    	$sanitizedname = $db->quote(str_replace( array( '\'', '"', ',' , ';', '<', '_','.','>' ), ' ', $name));

	    	$result = $db -> query("INSERT INTO `torrents` (`userid`,`categoryid`,`description`,`name`,`uploaddate`,`size`,`seeders`,`leechers`,`hash`,`magnet`,`files`) VALUES (" . $db -> quote($userid) . "," .$categoryid . "," . $description.",".$sanitizedname .",".$uploaddate .",".$size .",".$seeders .",".$leechers .",".$db -> quote($hash[0]) .",".$magnet .",".$files .")"); 

	        unlink($target_file);

	        header("Location: ../en/view/torrent.php?hash=".$hash[0]."&id=".$userid."&success");
	        exit;
	    } else {
	        echo "Sorry, there was an error uploading your file.";
	    }
	}

	/**
	 * Converts torrent-rw announcelist to compatible Scrapeer array.
	 *
	 * @param array|string of tracker.
	 * @return array List of results.
	 */
	function formatTrackerArray($announce) {
		$trackers = array();
		foreach ($announce as $key => $value) {
	    	array_push($trackers, $value[0]);
	    }
	    return $trackers;
	}

	
?>
<?php
	require_once 'libs/parser.php';
	require_once 'libs/scraper.php';
	require_once 'libs/database.php';

	date_default_timezone_set('Europe/Brussels');
	
	/**
	 * Starts the upload process.
	 *
	 */
	function upload() {
		$scraper = new Scrapeer\Scraper();

		$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/torrents/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$torrentFileType = pathinfo($target_file,PATHINFO_EXTENSION);

		if (file_exists($target_file)) {
			unlink($target_file);
			exit(form_feedback("Sorry your file is already in use by another process, please try again later."));
		}

		if ($_FILES["fileToUpload"]["size"] > 500000) {
			exit(form_feedback("Your file is too large."));
		}

		if($torrentFileType != "torrent") {
			unlink($target_file);
			exit(form_feedback("Only .torrent files are allowed."));
		}

		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			if(valid_upload_formdata()) {
				if(valid_description(htmlspecialchars($_POST['description']))) {
					$db = new Db();
					if(category_exists($db)) {
						$key = htmlspecialchars($_SESSION["key"]);
						$userid = htmlspecialchars($_SESSION["userid"]);
						if(valid_user($key,$userid,$db)) {
							$torrent = new Torrent($target_file);
							$hash = array($torrent->hash_info());
							$categoryid = $db -> quote(htmlspecialchars($_POST['categoryId']));
							$description = $db -> quote(htmlspecialchars($_POST['description']));
							$uploaddate = $db -> quote(date('Y-m-d'));
							if(!torrent_exists($hash[0],$userid,$db)) {
								$name = $db -> quote($torrent->name());
								if("" != trim($_POST['name'])){ $name = $db -> quote($_POST['name']); }
								$size = $db -> quote($torrent->size(2));
								$magnet = $db -> quote($torrent->magnet());
								$files = $db -> quote(serialize($torrent->content()));
								$trackers = formatTrackerArray($torrent->announce());
								$info = $scraper->scrape($hash, $trackers);
								$seeders = handle_stats($info[$hash[0]]['seeders']);
								$leechers = handle_stats($info[$hash[0]]['leechers']);
								$sanitizedname = sanitize_name($name,$db);
								$db -> query("INSERT INTO `torrents` (`userid`,`categoryid`,`description`,`name`,`uploaddate`,`size`,`seeders`,`leechers`,`hash`,`magnet`,`files`) VALUES (" . $db -> quote($userid) . "," .$categoryid . "," . $description.",".$sanitizedname .",".$uploaddate .",".$size .",".$seeders .",".$leechers .",".$db -> quote($hash[0]) .",".$magnet .",".$files .")"); 
								unlink($target_file);
								header("Location: ../view/torrent.php?hash=".$hash[0]."&id=".$userid);
								exit;
							} else {
								unlink($target_file);
								exit(form_feedback("You already uploaded this torrent."));
							}
						} else {
							unlink($target_file);
							exit(form_feedback("Could not verify who you are."));
						}
					} else {
						unlink($target_file);
						exit(form_feedback("Invalid category."));
					}
				} else {
					unlink($target_file);
					exit(form_feedback("Description is too long."));
				}
			} else {
				unlink($target_file);
				exit(form_feedback("Invalid form data."));
			}
		} else {
			exit(form_feedback("There seems to be an error moving your file."));
		}
	}

	/**
	 * Converts Torrent RW announcelist to compatible Scrapeer array.
	 *
	 * @param array| string of tracker.
	 * @return array List of results.
	 */
	function formatTrackerArray($announce) {
		$trackers = array();
		foreach ($announce as $key => $value) {
	    	array_push($trackers, $value[0]);
	    }
	    return $trackers;
	}

	/**
	 * Checks if the category exists.
	 *
	 * @return boolean.
	 */
	function category_exists($db) {
		$catId = $db -> quote(htmlspecialchars($_POST['categoryId']));
		$catDb = $db -> select("SELECT `id` FROM `categories` WHERE `id`=".$catId."");
		if(count($catDb) == 0) return false;
		return true;
	}

	/**
	 * Checks if the session key and username matches the key and username in the database.
	 *
	 * @param string of key.
	 * @param int of userid.
	 * @return boolean.
	 */
	function valid_user($key, $userid, $db) {
		$result = $db -> select("SELECT `user_id`,`tempkey` FROM `users` WHERE `user_id`=".$userid." AND `tempkey`=".$key."");
		if(count($result) < 1) return false;
		return true;
	}

	/**
	 * Checks if the user already has a torrent with that hash.
	 *
	 * @param string of hash.
	 * @param string of tracker.
	 * @return boolean.
	 */
	function torrent_exists($hash, $uploaderid, $db) {
		$result = $db -> select("SELECT `userid`,`hash` FROM `torrents` WHERE `userid`=".$uploaderid." AND `hash`=".$db->quote($hash)."");
		if(count($result) == 0) return false;
		return true;
	}

	/**
	 * Checks if the description is not too long.
	 *
	 * @param array|string of description.
	 * @return boolean.
	 */
	function valid_description($description) {
		if(strlen($description) > 21844) return false;
		return true;
	}

	/**
	 * Checks if the upload form post variables aren't empty.
	 *
	 * @return boolean.
	 */
	function valid_upload_formdata() {
		if(!empty($_POST['categoryId'])) return true;
		return false;
	}

	/**
	 * Clears certain character of the torrent name.
	 *
	 * @param string of name.
	 * @return string.
	 */
	function sanitize_name($name,$db) {
		$sanitizedname = $db->quote(str_replace( array( '\'', '"', ',' , ';', '<', '_','.','>' ), ' ', $name));
		return $sanitizedname;
	}

	/**
	 * Handles seeders & leechers invalid output timeout when outgoing UDP requests are blocked.
	 *
	 * @param int of stat.
	 * @return int.
	 */
	function handle_stats($stat) {
		if(!is_numeric($stat)) return 0;
		return $stat;
	}

	/**
	 * Unhides the formfeedback and displays error text.
	 *
	 * @param string of error.
	 * @return javascript.
	 */
	function form_feedback($error) {
		echo '<script>';
		echo 'var element = document.getElementById("feedback").removeAttribute("style");';
		echo 'var element = document.getElementById("feedback").innerHTML ="'.$error.'";';
		echo '</script>';
	}
?>
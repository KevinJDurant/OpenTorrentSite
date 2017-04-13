<?php
	include_once "libs/database.php";
    
	date_default_timezone_set('Europe/Brussels');

	/**
	 * Get the 10 most popular torrents of each category per day.
     * Generates JSON to save database queries.
	 *
	 * @return array.
	 */

	/**
	 * Gets the 10 most seeded torrents of a category of the last 7 days.
	 *
	 * @return array.
	 */
	 function get_popular_per_cat($cat,$db) {
		 $catID = $cat;
		 $torrents = $db -> select("SELECT DATE_FORMAT(t.uploaddate, '%m/%d/%Y'), t.userid,t.categoryid,t.name,t.uploaddate,t.size,t.seeders,t.leechers,t.hash,t.magnet,u.username,u.uploaderstatus,c.id,c.categoryname FROM `torrents` t INNER JOIN `users` u ON t.userid=u.user_id INNER JOIN `categories` c ON t.categoryid=c.id WHERE (t.uploaddate BETWEEN NOW() - INTERVAL 7 DAY AND NOW()) AND (t.categoryid=$catID) ORDER by t.seeders desc LIMIT 10");
		 return $torrents;
	 }

    /**
	 * Checks if there already is a JSON for today's torrents.
	 *
	 * @param date.
	 * @return boolean.
	 */
	function already_generated($date) {
        // Logic.
		return false;
	}
?>
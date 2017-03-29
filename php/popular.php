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
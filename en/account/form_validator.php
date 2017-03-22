<?php
	include_once "../../php/dbaccess.php";

	// OOP
	// Check tempkey
	// Validate account
	// Check torrent


	/**
	 * Checks if the provided email address is blacklisted.
	 *
	 * @param string|string of username.
	 * @return boolean.
	 */
	function is_temp_mail($mail) {
    	$mail_domains_ko = file('../../config/disposable_email_blacklist.conf', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    	return in_array(explode('@', $mail)[1], $mail_domains_ko);
	}



?>
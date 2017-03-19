<?php
	// Start the session if none is present.
    if (!isset($_SESSION)) {
        session_start();
    }

    // Get the config.
	$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/plugins.ini');
	
?>
<?php
	/** This checks the config.ini and if the website is in private mode it'll disable the register
	***	page and redirect every user to the login page.
	***/

	/*
	* TODO:
	*
	* Check username an key in database. Plugin is 70% finished.
	*/

	// Start the session if none is present.
    if (!isset($_SESSION)) {
        session_start();
    }

    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config/plugins.ini');
    $url = $_SERVER['REQUEST_URI']."/en/account/login.php";

    if(!pageIsAllowed($config['signup'], $config['private'])) {
    	if($config['port'] != "0000"){
    		$port = $config['port'];
    		header("Location: http://{$_SERVER['SERVER_NAME']}:$port/en/account/login.php");
    		exit;
    	}
    	header("Location: http://{$_SERVER['SERVER_NAME']}/en/account/login.php");
        exit;
    }

	function sessionAlreadyAvailable() {
	    if(isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
	       return true;
	    } else {
	       return false;
	    }
	}

	function pageIsAllowed($signup,$private) {
		if(sessionAlreadyAvailable()) {
			return true;
		} elseif($signup && $private) {
			if(basename($_SERVER['PHP_SELF']) == 'login.php' || basename($_SERVER['PHP_SELF']) == 'register.php'){
				return true;
			} else {
				return false;
			}
		} elseif (!$signup && $private) {
			if(basename($_SERVER['PHP_SELF']) == 'login.php') {
				return true;
			} else {
				return false;
			}
		} elseif (!$private && $signup) {
			return true;
		} elseif (!$private && !$signup) {
			if(basename($_SERVER['PHP_SELF']) == 'register.php') {
				return false;
			} else {
				return true;
			}
		} else {
			echo "Error in private_signup_plugin: can't determine if page is allowed.";
		}
	}
?>

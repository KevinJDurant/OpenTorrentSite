<?php
	/** This checks the config.ini and if the website is in private mode it'll disable the register
	***	page and redirect every user to the login page.
	***/

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
		// We are allowed to signup and view torrents after logging in.
		if(sessionAlreadyAvailable()) {
			return true;
		} elseif($signup && $private) {
			// We won't be redirected if the current page is called login.php or register.php.
			if(basename($_SERVER['PHP_SELF']) == 'login.php' || basename($_SERVER['PHP_SELF']) == 'register.php'){
				// The page is either called login or register so we are allowed to be on this page.
				return true;
			} else {
				// The page is not called login or register so we are not allowed to be on this page.
				return false;
			}
		// We are not allowed to register, only to login if we have an account.
		} elseif (!$signup && $private) {
			if(basename($_SERVER['PHP_SELF']) == 'login.php') {
				// We are on the login page and are allowed to access it.
				return true;
			} else {
				// We are not on login.php so we are not allowed to be on this page.
				return false;
			}
		// We are allowed to visit every page and can register.
		} elseif (!$private && $signup) {
			return true;
		// We are allowed to visit every page but aren't allowed to register.
		} elseif (!$private && !$signup) {
			// If we are on the register page then we redirect.
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
<?php
$configPlugin = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config/plugins.ini');
	function already_exist($code, $db) {
		$cres = $db->select("SELECT `code` FROM `invitations` WHERE `code`=".$code);
		if(count($cres) == 0) return false;
		return true;
	}

	function NotUsedInviteCode($code, $db) {
		$cres = $db->select("SELECT `code` FROM `invitations` WHERE used!=1 and `code`=".$code);
		if(count($cres) == 0) return false;
		return true;
	}
	
	function update_inviteCode($db, $code) {
		if($code==null){
			return false;
		}
	$cres = $db->query("update `invitations` set used=1 WHERE `code`=".$code);
	}
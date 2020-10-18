<?php

$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config/config.ini.php');
// Start the session.
if (!isset($_SESSION)) {
	session_start();
}

$error = '';

if(!isset($_SESSION["username"])) {
	
	$error = '<label class="text-danger">Login Required.</label>';
}
//add_comment.php

$connect = new PDO('mysql:host=localhost;dbname='.$config['dbname'], $config['username'], $config['password']);

$comment_name = $_SESSION["username"];

if($error == '')
{
	$query = "delete from comments where comment_id = :comment_id";
	$statement = $connect->prepare($query);
	$statement->execute(array(
		':comment_id' => $_POST["comment_id"]
	));
	$error = '<label class="text-success">Comment Deleted.</label>';
}

$data = array(
 'error'  => $error
);

echo json_encode($data);

?>
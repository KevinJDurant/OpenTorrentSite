<?php

$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config/config.ini.php');
// Start the session.
if (!isset($_SESSION)) {
	session_start();
}

$error = '';

if(!isset($_SESSION["username"])){
	$error = '<label class="text-danger">Login Required.</label>';
}
//add_comment.php

$connect = new PDO('mysql:host=localhost;dbname='.$config['dbname'], $config['username'], $config['password']);

$comment_content = '';

if(empty($_POST["comment_content"]))
{
 $error .= '<p class="text-danger">Comment is required</p>';
}
else
{
 $comment_content = $_POST["comment_content"];
}

if($error == '')
{
	if(intval($_POST["comment_id"])<1){
		$query = "INSERT INTO comments (parent_comment_id, comment, comment_sender_name, userid, torrent_id) VALUES(:parent_comment_id, :comment, :comment_sender_name, :userid, :torrent_id)";
		$statement = $connect->prepare($query);
		$statement->execute(array(
			':parent_comment_id' => $_POST["comment_id"],
			':comment'    => $comment_content,
			':comment_sender_name' => $_SESSION["username"],
			':userid'    => $_SESSION["userid"],
			':torrent_id' => intval($_POST["torrent_id"])
		));
		/*if (!$statement->execute()) {
			print_r($statement->errorInfo());
		}*/
		$error = '<label class="text-success">Comment Added</label>';
	}else{
		
		$query = "update comments set comment = :comment where comment_id = :comment_id";
		$statement = $connect->prepare($query);
		$statement->execute(array(
			':comment'    => $comment_content,
			':comment_id'    => $_POST["comment_id"],
		));
		/*if (!$statement->execute()) {
			print_r($statement->errorInfo());
		}*/
		$error = '<label class="text-success">Comment Updated</label>';
	}
}

$data = array(
 'error'  => $error
);

echo json_encode($data);

?>
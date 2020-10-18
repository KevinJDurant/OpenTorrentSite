<?php

if (!isset($_SESSION)) {
	session_start();
}

$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config/config.ini.php');
//fetch_comment.php

$connect = new PDO('mysql:host=localhost;dbname='.$config['dbname'], $config['username'], $config['password']);
//parent_comment_id = '0' 
$query = "SELECT * FROM comments where torrent_id='".intval($_POST['torrent_id'])."' ORDER BY comment_id DESC";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
$output = '';

$query2 = "SELECT `username`,`uploaderstatus`,`user_id`  FROM `users` WHERE `user_id`=".$_SESSION["userid"];

$statement2 = $connect->prepare($query2);

$statement2->execute();

$uploader = $statement2->fetchAll();

foreach($result as $row)
{
	$append = '';
    if(isset($_SESSION["username"]) && ($_SESSION["userid"]==$row["userid"] || $uploader[0]["uploaderstatus"]==99)) {
		$append .= ' <button style="margin-top: -5px;margin-right: -5px;" type="button" class="btn btn-sm btn-default delete pull-right" id="'.$row["comment_id"].'">Delete</button>';
		$append .= ' <button style="margin-top: -5px;margin-right: -5px; margin-right:5px" type="button" class="btn btn-sm btn-default EDIT pull-right" id="'.$row["comment_id"].'">Edit</button>';
	}
 $output .= '
 <div class="panel panel-primary">
  <div class="panel-heading">By <b>'.$row["comment_sender_name"].'</b> on <i>'.$row["date"].'</i>'.$append.'</div>
  <div class="panel-body">'.$row["comment"].'</div>
  <div class="panel-footer hidden" align="right"><button type="button" class="btn btn-default reply" id="'.$row["comment_id"].'">Reply</button></div>
 </div>
 ';
 //$output .= get_reply_comment($connect, $row["comment_id"]);
}

echo $output;


function get_reply_comment($connect, $parent_id = 0, $marginleft = 0)
{
 $query = "
 SELECT * FROM comments WHERE parent_comment_id = '".$parent_id."'
 ";
 $output = '';
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $count = $statement->rowCount();
 if($parent_id == 0)
 {
  $marginleft = 0;
 }
 else
 {
  $marginleft = $marginleft + 48;
 }
 if($count > 0)
 {
  foreach($result as $row)
  {
   $output .= '
   <div class="panel panel-default" style="margin-left:'.$marginleft.'px">
    <div class="panel-heading">By <b>'.$row["comment_sender_name"].'</b> on <i>'.$row["date"].'</i> <button type="button" class="btn btn-sm btn-default delete pull-right" id="'.$row["comment_id"].'">Delete</button></div>
    <div class="panel-body">'.$row["comment"].'</div>
    <div class="panel-footer hidden" align="right"><button type="button" class="btn btn-default reply" id="'.$row["comment_id"].'">Reply</button></div>
   </div>
   ';
   $output .= get_reply_comment($connect, $row["comment_id"], $marginleft);
  }
 }
 return $output;
}

?>

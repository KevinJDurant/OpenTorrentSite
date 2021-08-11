<?php

if (!isset($_SESSION)) {
	session_start();
}
if (isset($_POST['page'])) {
	$pageno = intval($_POST['page']);
	if($pageno<1){
		$pageno = 1;
	}
} else {
	$pageno = 1;
}
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config/config.ini.php');
$configPlugin = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config/plugins.ini');
$no_of_records_per_page = intval($configPlugin['Comments_Per_Page']);
$offset = ($pageno-1) * $no_of_records_per_page;

//fetch_comment.php

$connect = new PDO('mysql:host=localhost;dbname='.$config['dbname'], $config['username'], $config['password']);

$total_pages_sql = "SELECT COUNT(*) as total FROM comments where torrent_id='".intval($_POST['torrent_id'])."'";
$resultQ = $connect->prepare($total_pages_sql);
$resultQ->execute();
$resultQ = $resultQ->fetchAll();
$total_rows = $resultQ[0]['total'];
$total_pages = ceil($total_rows / $no_of_records_per_page);

		
//parent_comment_id = '0' 
$query = "SELECT * FROM comments where torrent_id='".intval($_POST['torrent_id'])."' ORDER BY comment_id DESC LIMIT $offset, $no_of_records_per_page";

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

?>
    <ul class="pagination">
        <li><a href="javascript:;"<?php echo " onclick=\"load_comment_page(".(1).',this);"'; ?>>First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="javascript:;"<?php if($pageno <= 1){ } else { echo " onclick=\"load_comment_page(".($pageno - 1).',this);"'; } ?>>Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="javascript:;"<?php if($pageno >= $total_pages){  } else { echo " onclick=\"load_comment_page(".($pageno + 1).',this);"'; } ?>>Next</a>
        </li>
        <li><a href="javascript:;"<?php echo " onclick=\"load_comment_page(".($total_pages).',this);"'; ?>>Last</a></li>
    </ul>
<?php

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

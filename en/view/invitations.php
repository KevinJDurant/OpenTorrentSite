<?php

    // Start the output buffer.
    ob_start();
    session_start();
    date_default_timezone_set('Europe/Brussels');

    include_once "../../php/libs/database.php";
    include_once "../../php/libs/UserHelper.php";

    // Include constants.
    include_once "./../../php/constants.php";
    if(empty($_SESSION["userid"])) {
        header("Location: ../../index.php");
        exit;
    }


    $db = new Db();
    $userid = $_SESSION["userid"];

    include_once "../../plugins/private_invite_plugin.php";
	if(isset($_POST['code']) && !empty($_POST['code'])){
		$code = $db->quote($_POST['code']);
		if(!already_exist($code, $db)){
			$result = $db->query("INSERT INTO `invitations` (userid, code) VALUES ($userid, $code)");
			if($result){
				$message = 'Code Saved.';
			}
		}else{
			$message = 'Code Already Exist';
		}
	}



	$totalinvitations = $db->select("SELECT COUNT(id) AS 'Total' FROM invitations WHERE userid=".$userid)[0]["Total"];

	// Check user uploaderstatus
	$uploaderstatus = $db->select("SELECT uploaderstatus AS 'vipstatus' FROM users WHERE user_id=".$userid."");
	$invitations = $db->select("SELECT code,used FROM invitations WHERE userid=".$userid);

	// Total User Count
	$total_user = $db->select("SELECT count(u.user_id) as 'Total Users' FROM users u,invitations i WHERE i.userid=$userid and u.invitecode=i.code");

	// Results Per Page
	$total_result_per_page = 5;
	$total_user_page = ceil($total_user[0]['Total Users'] / $total_result_per_page);
	$current_page = 1;

	// Get Current Page
	if(isset($_GET['page']) && !empty($_GET['page'] && intval($_GET['page']) > 0)){
		$current_page = intval($_GET['page']);
	}
	$start_result = $total_result_per_page * ($current_page - 1);

	// User List
	$userlist = $db->select("SELECT u.user_id,u.reg_date,u.username,u.uploaderstatus,u.invitecode FROM users u,invitations i WHERE i.userid=$userid and u.invitecode=i.code limit $start_result,$total_result_per_page");
	
	
    ?>



<!DOCTYPE html>

<html lang="en">



<head>

    <!-- Standard Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?php echo META_DESCRIPTION;?>">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Browse | <?php echo SITE_NAME;?></title>


    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Bootstrap CSS -->
    <link href="../../css/1-col-portfolio.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/custom.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="../../css/favicon.png"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../../index.php"><?php echo SITE_NAME;?></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
				    <li>
                        <a href="../../news.php">News</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                <?php
                    if(!isset($_SESSION["username"])) {
                        echo '<li><a href="../account/register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>';
                        echo '<li><a href="../account/login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
                    } else {
                        echo '<li><a href="../upload/upload.php"><span class="glyphicon glyphicon-upload"></span> Upload</a></li>';
						echo '
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$_SESSION["username"].' <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="my-torrents.php"><span class="glyphicon glyphicon-book"></span> Torrents</a>
                                    </li>
                                    <li>
                                        <a href="preferences.php"><span class="glyphicon glyphicon-cog"></span> Preferences</a>
                                    </li>
                                    <li>
                                        <a href="#"><span class="glyphicon glyphicon-pencil"></span> Invites</a>
                                    </li>
                                    <li>
                                        <a href="../account/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                                    </li>
                                </ul>
                            </li>';

                    }

                ?>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>



    <!-- Page Content -->
    <div class="container">
         <?php

            if (isset($_GET['msg']) && !empty($_GET['msg'])) {
                echo '<h3 class="alert alert-success text-center">' . $_GET['msg'] . '</h3>';
            }
         ?>

         <?php
            if (isset($message)) {
                echo '<h3 class="alert alert-success text-center">' . $message . '</h3>';
            }
         ?>



        <!-- Search -->

        <div class="row">
            <div class="col-lg-12">
                <form action="../search/search.php">
                    <div class="input-group">
                        <div class="input-group-btn search-panel">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span id="search_concept">Category</span> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="1">Movies</a></li>
                              <li><a href="2">Television</a></li>
                              <li><a href="3">Music</a></li>
                              <li><a href="4">Games</a></li>
                              <li><a href="5">Software</a></li>
                              <li><a href="6">Anime</a></li>
                              <li><a href="7">Books</a></li>
                              <li><a href="8">XXX</a></li>
                              <li><a href="9">Other</a></li>
                              <li class="divider"></li>
                              <li><a href="all">Anything</a></li>
                            </ul>
                        </div>
                        <input type="hidden" name="category" value="all" id="category">         
                        <input type="text" class="form-control" name="query" placeholder="Search term...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <!-- /.row -->



		<!-- Account Control Panel -->
        <div class="row">
            <div class="col-lg-12">
			<h1>Invite Codes</h1>		

    <!-- jQuery -->
    <script src="../../js/jquery.js"></script>
		<?php if(count($invitations)<3) { ?>
			<button type="button" class="btn btn-primary addcode" data-toggle="modal" data-target="#exampleModal">Add Code</button>
			<form method="POST" action="">

			<!-- Modal -->
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Invitation Code</h5>
				  </div>
				  <div class="modal-body">
					<input type="text" name="code" class="form-control codeinput" placeholder="Enter Code" required>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				  </div>
				</div>
			  </div>
			</div>
			</form>
			
			<script>
				function makeid(length) {
				   var result           = '';
				   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
				   var charactersLength = characters.length;
				   for ( var i = 0; i < length; i++ ) {
					  result += characters.charAt(Math.floor(Math.random() * charactersLength));
				   }
				   return result;
				}

				$(document).on('click','.addcode',function(){
					$('.codeinput').val(makeid(7));
				});

			</script>

		<?php } ?>
            <br />
			
			<!-- User Table -->

			<?php
				if(count($invitations) !== 0) {
					$i=1;
					foreach ($invitations as $key => $row) {
						echo "<p><b>Code #$i: </b>".$row['code']." - ".($row['used']==1? 'USED' : 'UNUSED')."</p>";
						$i++;
					}
				}
                ?>
				<br>

		<?php

		if(count($userlist) !== 0) {
			echo '<table class="table table-striped" id="User List">
				<thead>
				<tr>
				<th width="20%"><span class="glyphicon glyphicon-sort"></span></small>Username</th>
				<th width="20%"><span class="glyphicon glyphicon-sort"></span></small>Register Date</th>
				<th width="20%"><span class="glyphicon glyphicon-sort"></span></small>Invite Code</th>
				</tr>
				</thead>
				<tbody>';

		foreach ($userlist as $key => $row) {
			echo '<tr>
				<td class="Name" data-label="Username"><a href="user-torrents.php?userid='.$row["user_id"].'"> '.$row["username"]. UserHelper::displayUserIcon($row['uploaderstatus']) . '</span></a></td>
				<td data-label="Register Date">'.$row["reg_date"].'</td>
				<td data-label="User ID">'.$row["invitecode"].'</td>
				</tr>';
			}
		echo '</tbody></table>';
		}

		?>

		</div>
        </div>
		
		<?php 
		if ($total_user_page > 0){ ?>
			<nav aria-label="Page navigation example">
			<ul class="pagination" style="width: 100%;">
			<?php if ($current_page>1) { ?>
			<li class="page-item"><a class="page-link" style="float: left;" href="?page=<?=$current_page-1?>">Previous</a></li>

			<?php }
			if ($current_page<$total_user_page) { ?>
				<li class="page-item">
				<a class="page-link" style="float: right;" href="?page=<?=$current_page+1?>">Next</a>
				</li>
			<?php } ?>
			</ul>
			</nav>
			<?php } ?>

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p><?php echo FOOTER_TEXT;?></p>
                </div>
            </div>
            <!-- /.row -->
        </footer>
    </div>
    <!-- /.container -->
	
    <!-- Bootstrap Core JavaScript -->
    <script src="../../js/bootstrap.min.js"></script>

    <!-- Torrent Card -->
    <script src="../../js/torrentcard.js"></script>
	<script>
    $(document).ready(function(e){
        $('.search-panel .dropdown-menu').find('a').click(function(e) {
            e.preventDefault();
            var param = $(this).attr("href").replace("#","");
            var concept = $(this).text();
            $('.search-panel span#search_concept').text(concept);
            $('.input-group #category').val(param);
        });
    });

	</script>

    

    <!-- Tablesort -->

    <script src="../../js/jquery.tablesorter.js"></script>
    <script>

    $(document).ready(function() {
        $("#mytorrents").tablesorter();
    });


    // JS code for show Confirm alert
    let deleteLinks = document.querySelectorAll('.delete');
    for (let i = 0, l = deleteLinks.length; i < l; i++) {
      deleteLinks[i].addEventListener('click', function(event) {
          event.preventDefault();
          let choice = confirm(this.getAttribute('data-confirm'));
          if (choice) {
            window.location.href = this.getAttribute('href');
          }
      });
    }
	
    </script>
</body>
</html>

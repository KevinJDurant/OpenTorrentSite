<?php
    // Start the output buffer.
    ob_start();
    session_start();
    date_default_timezone_set('Europe/Brussels');

    include_once "../../php/libs/database.php";
    include_once "../../php/libs/UserHelper.php";
    include_once "../../plugins/private_signup_plugin.php";

    if(empty($_SESSION["userid"])) {
        header("Location: ../../index.php");
        exit;
    }

    $db = new Db();
    
    $userid = $_SESSION["userid"];
	
	// User Upload Count
	$totaluseruploads = $db->select("SELECT COUNT(id) AS 'Total User Uploads' FROM torrents WHERE userid=".$userid."");
	
	// Check user uploaderstatus
	$uploaderstatus = $db->select("SELECT uploaderstatus AS 'vipstatus' FROM users WHERE user_id=".$userid."");
	
	if ($uploaderstatus[0]["vipstatus"] === '99')
	{
	    // Get User Count
        $usercount = $db->select("SELECT COUNT(user_id) AS 'Total Users' FROM users");

        // Total Website Upload Count
        $totaluploads = $db->select("SELECT COUNT(id) AS 'Total Uploads' FROM torrents");

        // Get user list
        $userlist = $db->select("SELECT user_id,reg_date,username,uploaderstatus FROM users WHERE uploaderstatus < 99");
	}
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Standard Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="OpenTorrentSite: Free Software, Games and Music!">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Browse | OpenTorrentSite</title>

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
                <a class="navbar-brand" href="../../index.php">OpenTorrentSite</a>
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
                                        <a href="#"><span class="glyphicon glyphicon-cog"></span> Preferences</a>
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
            <?php
                if ($uploaderstatus[0]["vipstatus"] === '99')
                {
                    echo '<h1>Admin Control Panel</h1>';
                }
                else
                {
                    echo '<h1>User Control Panel</h1>';
                }
			?>
            <br />
			
		<!-- User Account Information -->	
			<?php
                echo '<b>Account Uploads: </b>' ;
                echo $totaluseruploads[0]["Total User Uploads"];

                // User and Torrent Stats
                if ($uploaderstatus[0]["vipstatus"] === '99')
                {
                    echo '  |  <b>Total Uploads: </b>' ;
                    echo $totaluploads[0]["Total Uploads"];
                    echo '  |  <b>Total Users: </b>' ;
                    echo $usercount[0]["Total Users"];
                }

                echo "</br>";

                // Show user status
                echo '<b>Account Status: </b>';
                switch ($uploaderstatus[0]["vipstatus"]) {
                    case 99:
                        echo ' Administrator <img src="../../css/vip.png" alt="VIP User">';
                        break;
                    case 3:
                        echo ' VIP User <img src="../../css/vip.png" alt="VIP User">';
                        break;
                    case 2:
                        echo ' Trusted User <img src="../../css/trusted.png" alt="Trusted User">';
                        break;
                    case -1:
                        echo 'Banned User';
                        break;
                    default:
                        echo ' User';
                }
			?>
            <br />
            <br />
			<!-- User Table -->
			<?php
				if ($uploaderstatus[0]["vipstatus"] === '99')
					{
					    echo '<table class="table table-striped" id="User List">
                            <thead>
                                <tr>
                                    <th width="20%"><span class="glyphicon glyphicon-sort"></span></small>Username</th>
                                    <th width="20%"><span class="glyphicon glyphicon-sort"></span></small>Register Date</th>
                                    <th width="20%"><span class="glyphicon glyphicon-sort"></span></small>User ID</th>
                                    <th width="20%"><span class="glyphicon glyphicon-sort"></span></small>Access Level</th>
                                    <th width="20%">Options</th>
                                </tr>
                              </thead>
                              <tbody>';

                        if(count($userlist) !== 0) {
                            foreach ($userlist as $key => $row) {
                            echo '<tr>
                                <td class="Name" data-label="Username"><a href="user-torrents.php?userid='.$row["user_id"].'"> '.$row["username"]. UserHelper::displayUserIcon($row['uploaderstatus']) . '</span></a></td>
                                <td data-label="Register Date">'.$row["reg_date"].'</td>
                                <td data-label="User ID">'.$row["user_id"].'</td>
                                <td data-label="Access Level">'.UserHelper::translateUserStatus($row["uploaderstatus"]).'</td>
                                <td data-label="Options">
                                    <a href="#"></span></a>							
                                    <a href="setstatus_vip.php?user_id='.$row["user_id"].'" alt="VIP Status"  class="delete" data-confirm="Give user VIP status?"><span class="glyphicon glyphicon-heart"></span></a>
                                    <a href="setstatus_trusted.php?user_id='.$row["user_id"].'" alt="StatusDown"  class="delete" data-confirm="Give user Trusted status?"><span class="glyphicon glyphicon-star"></span></a>
                                    <a href="setstatus_user.php?user_id='.$row["user_id"].'" alt="StatusDown"  class="delete" data-confirm="Set regular user status?"><span class="glyphicon glyphicon-star-empty"></span></a>
                                    <a href="setstatus_banned.php?user_id='.$row["user_id"].'" alt="Ban"  class="delete" data-confirm="Ban User?"><span class="glyphicon glyphicon-ban-circle"></span></a>
                                    <a href="setstatus_burnt.php?user_id='.$row["user_id"].'" alt="Ban"  class="delete" data-confirm="Remove all users torrents?"><span class="glyphicon glyphicon-trash"></span></a>
                                </td>
                                </tr>';
                            }
                        }

                        echo '</tbody></table>';
					}
                ?>
            </div>
        </div>
            <!-- /.row -->
        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright © Your Website 2019</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="../../js/jquery.js"></script>

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

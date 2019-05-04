<?php
    // Start the output buffer.
    ob_start();
    session_start();
    date_default_timezone_set('Europe/Brussels');

    include_once "../../php/libs/database.php";
    include_once "../../plugins/private_signup_plugin.php";

    if(empty($_SESSION["userid"])) {
        header("Location: ../../index.php");
        exit;
    }

    $db = new Db();
    
    $userid = $_SESSION["userid"];

    $torrents = $db -> select("SELECT t.id as 'torrents_id', t.userid,t.categoryid,t.name,t.uploaddate,t.size,t.seeders,t.leechers,t.hash,t.magnet,u.username,u.uploaderstatus,c.id,c.categoryname FROM `torrents` t INNER JOIN `users` u ON t.userid=u.user_id INNER JOIN `categories` c ON t.categoryid=c.id WHERE t.userid=".$userid."");

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

    <title>Browse | OpenTorrents</title>

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
                                        <a href=""><span class="glyphicon glyphicon-book"></span> Torrents</a>
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

        if(isset($_GET['msg'])){

        

         ?>

         <h3 class="alert alert-success text-center"><?php echo $_GET['msg']; ?></h3>

         <?php 

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

        <!-- Torrents -->
        <div class="row">
            <div class="col-lg-12">
            <h1>My torrents</h1>
                <?php
                    echo '<table class="table table-striped" id="mytorrents">
                            <thead>
                                <tr>
                                    <th width="50%"><span class="glyphicon glyphicon-sort"></span></small>Name</th>
                                    <th width="10%"><span class="glyphicon glyphicon-sort"></span></small>Size</th>
                                    <th width="10%"><span class="glyphicon glyphicon-sort"></span></small>Age</th>
                                    <th width="10%"><span class="glyphicon glyphicon-sort"></span></small>Seeds</th>
                                    <th width="10%"><span class="glyphicon glyphicon-sort"></span></small>Leech</th>
                                    <th width="10%">Download</th>
                                </tr>
                              </thead>
                              <tbody>';
                    if(count($torrents) != 0) {
                        foreach ($torrents as $key[] => $row) {
                        $ymd = new DateTime($row["uploaddate"]); $today = new DateTime(); $diff=date_diff($ymd,$today);
                        echo '<tr>
                            <td class="Name" data-label="Name"><a href="../view/torrent.php?hash='.$row["hash"].'&id='.$row["userid"].'">'.$row["name"].'</a>
                                <small>by '.$row["username"].'</small>
                            </td>
                            <td data-label="Size">'.$row["size"].'</td>
                            <td data-label="Age">'. $diff->format("%ad").'</td>
                            <td data-label="Seeds">'.$row["seeders"].'</td>
                            <td data-label="Leech">'.$row["leechers"].'</td>
                            <td data-label="Download">
                                <a href="'.$row["magnet"].'"><span class="glyphicon glyphicon-magnet link"></span></a>
                                <a href="delete_torrent_file.php?delete_id='.$row["torrents_id"].'"  class="delete" data-confirm="Are you sure you want to permanently remove this torrent from the database?"><span class="glyphicon glyphicon-trash link"></span></a>
                            </td>
                        </tr>';
                        }
                    }
                    echo '</tbody></table>';
                ?>
            </div>
        </div>
            <!-- /.row -->
        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2017</p>
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
    var deleteLinks = document.querySelectorAll('.delete');

for (var i = 0; i < deleteLinks.length; i++) {
  deleteLinks[i].addEventListener('click', function(event) {
      event.preventDefault();

      var choice = confirm(this.getAttribute('data-confirm'));

      if (choice) {
        window.location.href = this.getAttribute('href');
      }
  });
}
    </script>
</body>
</html>

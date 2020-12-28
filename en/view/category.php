<?php
    // Start the output buffer.
    ob_start();

    include_once "../../php/libs/database.php";
    include_once "../../php/libs/UserHelper.php";
    include_once "../../php/popular.php";
    include_once "../../plugins/private_signup_plugin.php";

    // Include constants.
    include_once "./../../php/constants.php";

    // Start the session.
    if (!isset($_SESSION)) {
        session_start();
    }

    if(empty($_GET["id"])) {
        header("Location: ../../index.php");
        exit;
    }

	// Get Category Information
    $db = new Db();
    $cat_id= $db->escape(intval($_GET['id']));
    $categories = $db->select("SELECT * from categories where id=".$cat_id);

    if(count($categories) === 0) {
        header("Location: ../../en/status/404.php"); exit;
    }

	// Page Count
	$total_result_per_page = 10;
    $total_torrent = count(get_popular_per_cat_count($cat_id,$db));
    $total_torrent_page = ceil($total_torrent / $total_result_per_page);
    $current_page = 1;

    if(isset($_GET['page']) && !empty($_GET['page'] && intval($_GET['page']) > 0)){
		$current_page = intval($_GET['page']);
	}

    $start_result = $total_result_per_page * ($current_page - 1);
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

    <title>Torrent | <?php echo SITE_NAME;?></title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Bootstrap CSS -->
    <link href="../../css/1-col-portfolio.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/custom.css" rel="stylesheet">

    <!-- Editor TinyMCE -->
    <script src="../../js/tinymce/tinymce.min.js"></script>

    <script>
        tinymce.init({
          selector: 'textarea',
          theme: 'modern',
          readonly : 1,
          toolbar: false,
          menubar: false,
          statusbar: false,
          plugins: "autoresize",
          content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i'
          ]
         });
    </script>

    <style>h1{
    text-align: center;}
        .mce-panel {
            border: none !important;
        }.pagination {
		display: block;
    height: 35px;}
    </style>

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
                                            <a href="invitations.php"><span class="glyphicon glyphicon-pencil"></span> Invites</a>
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
        <!-- /.row -->

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
                <!-- Categories starts-->
                <?php
                    foreach ($categories as $cat) {
                        $torrents = get_popular_per_cat($cat['id'],$db,$start_result,$total_result_per_page);
                        echo '<h1>'.$cat["categoryname"].'</h1>';
                        echo '<table class="table table-striped" id="'.$cat["id"].'">
                                <thead>
                                    <tr>
                                        <th width="50%"><small><span class="glyphicon glyphicon-sort"></span></small>Name</th>
                                        <th width="10%"><small><span class="glyphicon glyphicon-sort"></span></small>Size</th>
                                        <th width="10%"><small><span class="glyphicon glyphicon-sort"></span></small>Age</th>
                                        <th width="10%"><small><span class="glyphicon glyphicon-sort"></span></small>Seeds</th>
                                        <th width="10%"><small><span class="glyphicon glyphicon-sort"></span></small>Leech</th>
                                        <th width="10%">Download</th>
                                    </tr>
                                  </thead>
                                  <tbody>';
                        foreach ($torrents as $key => $row) {
                            $ymd = new DateTime($row["uploaddate"]); $today = new DateTime(); $diff=date_diff($ymd,$today);
                            if($row["categoryname"] == $cat["categoryname"]) {
                                echo '<tr>
                                    <td class="Name" data-label="Name"><a href="torrent.php?hash='.$row["hash"].'&id='.$row["userid"].'">'.$row["name"].'</a>
                                        <small>by <a href="user-torrents.php?userid='.$row["userid"].'">'.$row["username"]. UserHelper::displayUserIcon($row['uploaderstatus']) .'</a></small>
                                    </td>
                                    <td data-label="Size">'.$row["size"].'</td>
                                    <td data-label="Age">'. $diff->format("%ad").'</td>
                                    <td data-label="Seeds">'.$row["seeders"].'</td>
                                    <td data-label="Leech">'.$row["leechers"].'</td>
                                    <td data-label="Download">                                        
                                        <a href="'.$row["magnet"].'"><span class="glyphicon glyphicon-magnet link"></span></a>
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
			<?php if ($total_torrent_page > 0){ ?>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
			            <?php if ($current_page>1) { ?>
                            <li class="page-item"><a class="page-link" style="float: left;" href="?id=<?=$cat_id?>&page=<?=$current_page-1?>">Previous</a></li>
                        <?php }
                        if ($current_page<$total_torrent_page) { ?>
                            <li class="page-item">
                                <a class="page-link" style="    float: right;" href="?id=<?=$cat_id?>&page=<?=$current_page+1?>">Next</a>
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

    <!-- jQuery -->
    <script src="../../js/jquery.js"></script>
	
    <!-- Torrent Card -->
    <script src="../../js/torrentcard.js"></script>

    <script>
    $(document).ready(function(e){
        $('.search-panel .dropdown-menu').find('a').click(function(e) {
            e.preventDefault();
            let param = $(this).attr("href").replace("#","");
            let concept = $(this).text();
            $('.search-panel span#search_concept').text(concept);
            $('.input-group #category').val(param);
        });
    });
    </script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../js/bootstrap.min.js"></script>
</body>
</html>

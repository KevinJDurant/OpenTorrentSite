<?php
    // Start the output buffer.
    ob_start();

    include_once "../../php/libs/database.php";
    include_once "../../plugins/private_signup_plugin.php";
    include_once "../../php/libs/UserHelper.php";

    // Include constants.
    include_once "./../../php/constants.php";

    // Start the session.
    if (!isset($_SESSION)) {
        session_start();
    }

    if(empty($_GET["hash"]) || empty($_GET["id"])) {
        header("Location: ../../index.php");
        exit;
    } else {
        // Database object.
        $db = new Db();

        // Quote and escape values.
        $hash =  $db->quote($_GET["hash"]);
        $id =  $db->quote($_GET["id"]);

        // Get the corresponding values.
        $torrent = $db->select("SELECT * FROM `torrents` WHERE `hash`=".$hash." AND `userid`=".$id."");
		
		$torrent_id=$torrent[0]["id"];
		// Count torrent votes
		$votes = $db->select("SELECT SUM(hasvoted) AS `Total Votes` FROM `votes` WHERE `torrentid`=".$torrent_id."");
		if ($votes[0]["Total Votes"] === NULL) {
        $votes = 0;
		}

        // Change this to the torrent 404 page.
        if(count($torrent) === 0) {
            header("Location: ../../en/status/404.php"); exit;
        }
        $uploader = $db -> select("SELECT `username`,`uploaderstatus`,`user_id`  FROM `users` WHERE `user_id`=".$id."");
    }
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
          selector: '#list_to_convert',
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

    <style>
        .mce-panel {
            border: none !important;
        }
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
                    <hr>
                </div>
            </div>

            <!-- /.row -->

        <div class="row">
            <!-- Blog Post Content Column -->
            <div class="col-lg-8">
                <!-- Torrent name -->
                <h1><?php echo $torrent[0]["name"]; ?></h1>

                <!-- Uploader -->
                <p class="lead">
                    by <a href="user-torrents.php?userid=<?php echo $uploader[0]["user_id"]; ?>"><?php echo $uploader[0]["username"]; echo UserHelper::displayUserIcon($uploader[0]["uploaderstatus"]);?></a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $torrent[0]["uploaddate"]; ?></p>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">
                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Stats &amp; Download</h4>
                        Size: <?php echo $torrent[0]["size"]; ?> <br/>
                        Seeders: <span id="seederCount"><?php echo $torrent[0]["seeders"]; ?></span> <br/>
                        Leechers: <span id="leecherCount"><?php echo $torrent[0]["leechers"]; ?></span> <br/>
						Rating: <span id="voteCount"><?php echo $votes[0]["Total Votes"]; ?></span> <br/>
                        <br />
                        <a href="<?php echo $torrent[0]["magnet"]; ?>"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-magnet"></span></button></a>                        
                        <?php $time = $torrent[0]["LastRefresh"]; 
						if(time()>$time){ ?><button type="button" class="btn btn-primary"  id="refresh-torrent" data-magnet="<?php echo $torrent[0]["magnet"]; ?>"><span class="glyphicon glyphicon-refresh"></span></button><?php } ?>
						<a href="javascript:;" onclick="vote_('1');"><button type="button" class="btn btn-primary"  id="vote-up"><span class="glyphicon glyphicon-thumbs-up"></span></button></a>
						<a href="javascript:;" onclick="vote_('-1');"><button type="button" class="btn btn-primary" id="vote-down"><span class="glyphicon glyphicon-thumbs-down"></span></button></a>
						
						

                    <script>
                        let refreshButton = document.getElementById('refresh-torrent');

                        var calling = false;

                        refreshButton.addEventListener('click', function ()
                        {
                            let clientConfirms = confirm('This will refresh the torrents seed/peer data. Are you sure you want to do this?');

                            if (clientConfirms && !calling)
                            {
                                calling = true;
                                let magnet = this.getAttribute('data-magnet');
								$.ajax({
									 method: "POST",
									url: "/api/update-seeders.php",
									data: { magnet: btoa(magnet), id:<?php echo $_GET['id']; ?> }
								   })
								  .done(function( response ) {
									    calling = false;
										$('#refresh-torrent').hide();
                                        response = JSON.parse(response);
										if(response.leechers!=null){
											$('#leecherCount').text(response.leechers);
										}
										if(response.seeders!=null){
											$('#seederCount').text(response.seeders);
										}
								  });
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- Blog Post Content Column -->
            <div class="col-lg-8">
			
			
                <hr>

                <?php
                    if($torrent[0]["imdb"] != null) {
                        echo '<!-- Preview Image -->';
                        echo '<img class="img-responsive" src="http://placehold.it/900x300" alt=""><hr>';
                    }
                ?>                

                <!-- Torrent description + files tree -->
                <textarea id="list_to_convert">
                    <?php echo $torrent[0]["description"]; ?>
                </textarea>

				<div class="row">
					<!-- Blog Post Content Column -->
					<div class="col-lg-12">
					<?php   if(isset($_SESSION["username"])) {	 ?>
						<form method="POST" id="comment_form">
							<div class="form-group">
							 <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Enter Comment" rows="5"></textarea>
							</div>
							<div class="form-group">
							 <input type="hidden" name="comment_id" id="comment_id" value="0" />
							 <input type="hidden" name="torrent_id" value="<?=$torrent_id?>" />
							 <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
							</div>
						</form>
					   <span id="comment_message"></span>
					   <br />
					   <?php } ?>
					   <div id="display_comment"></div>
					</div>
				</div>
			</div>
			
			
    <!-- jQuery -->
    <script src="../../js/jquery.js"></script>
							
				<script>
				var torrent_id = <?=$torrent_id?>;
				$(document).ready(function(){
				 
				 $('#comment_form').on('submit', function(event){
				  event.preventDefault();
				  var form_data = $(this).serialize();
				  $.ajax({
				   url:"../../api/add_comment.php",
				   method:"POST",
				   data:form_data,
				   dataType:"JSON",
				   success:function(data)
				   {
					if(data.error != '')
					{
					 $('#comment_form')[0].reset();
					 $('#comment_message').html(data.error);
					 $('#comment_id').val('0');
					 load_comment();
					}
				   }
				  })
				 });

				 load_comment();

				 function load_comment()
				 {
				  $.ajax({
				   url:"../../api/fetch_comment.php",
				   method:"POST",
				   data:{torrent_id:torrent_id},
				   success:function(data)
				   {
					$('#display_comment').html(data);
				   }
				  })
				 }

				 $(document).on('click', '.reply', function(){
				  var comment_id = $(this).attr("id");
				  $('#comment_id').val(comment_id);
				 });
				 
				 $(document).on('click', '.EDIT', function(){
				  var comment_id = $(this).attr("id");
				  $('#comment_content').val($.trim($(this).parent().parent().find('.panel-body').text()));
				  $('#comment_id').val(comment_id);
				  
					$('html, body').animate({
						scrollTop: $("#comment_content").offset().top - 100
					}, 200);
					$("#comment_content").focus();
				 });
				 
				 $(document).on('click', '.delete', function(){
				  var comment_id = $(this).attr("id");
					  
					  $.ajax({
					   url:"../../api/delete_comment.php",
					   method:"POST",
					   data:{comment_id: comment_id,torrent_id:torrent_id},
					   dataType:"JSON",
					   success:function(data)
					   {
						$('#comment_message').html(data.error);
						load_comment();
					   }
					  })
				 });
				 
				});
				</script>

            <div class="col-lg-4">
                <hr/>      
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Filename</th>
                        <th>Size</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $i = 0;
                        foreach (unserialize($torrent[0]["files"]) as $f[] => $key) {
                            echo '<tr>';
                            echo '<td>'. $f[$i] . '</td><td>'. formatBytes($key) .'</td>';
                            echo '</tr>';
                            $i++;
                        }
                      ?>
                    </tbody>
                  </table>

			</div>
		</div>
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

	
    <!-- Torrent Card -->
    <script src="../../js/torrentcard.js"></script>

    <script>
	function vote_(i){
		<?php 
    if(!empty($_SESSION["username"])) { ?>
		$.ajax({
     method: "POST",
    url: "/api/votes.php",
    data: { d: i, userid: <?=$_SESSION["userid"]?>,torrent:<?=$torrent_id?> }
   })
  .done(function( msg ) {
	  $('#voteCount').html(msg);
  });
	<?php }else{ ?>
	alert("You must be logged in to use this feature.");
	<?php } ?>
	}
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

    <?php
        function formatBytes($bytes, $precision = 2) { 
            $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

            $bytes = max($bytes, 0); 
            $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
            $pow = min($pow, count($units) - 1); 
            
            $bytes /= (1 << (10 * $pow)); 

            return round($bytes, $precision) . ' ' . $units[$pow]; 
        } 
    ?>
</body>
</html>

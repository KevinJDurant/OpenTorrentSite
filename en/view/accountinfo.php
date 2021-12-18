<?php
    // Start the output buffer.
    ob_start();
    session_start();
    date_default_timezone_set('Europe/Brussels');

    include_once "../../php/libs/database.php";
    include_once "../../php/libs/UserHelper.php";
    include_once "../../plugins/private_signup_plugin.php";

    // Include constants.
    include_once "./../../php/constants.php";

    if(empty($_SESSION["userid"])) {
        header("Location: ../../index.php");
        exit;
    }

    $db = new Db();
    $userid = $_SESSION["userid"];
	
	$acc_info = $db->select("SELECT * FROM users WHERE user_id=".$userid)[0];
	
	if(isset($_POST['action'])){
		if($_POST['action']=='pass'){
			$currentpass = $db->quote(htmlspecialchars($_POST['current']));
			$newpassword = $db->quote(htmlspecialchars($_POST['password']));
			if(password_verify($currentpass, $acc_info['password'])){
				$hashed_password = password_hash($newpassword, PASSWORD_BCRYPT);
				$db->query("UPDATE `users` SET `password`='".$hashed_password."' WHERE `user_id`=".$userid."");
				$success = 'Password changed successfully.';
			}else{
				$error = "Current Password Incorrect";
			}
		}
		if($_POST['action']=='mail'){
			$email = $db->quote(htmlspecialchars($_POST['email']));
			$mailresult = $db->select("SELECT `email` FROM `users` WHERE `email`=".$email."");
			if(count($mailresult)<1){
				$db->query("UPDATE `users` SET `email`=$email WHERE `user_id`=$userid");
				$success = 'Email changed successfully.';
			}else{
				$error = "Email already in use.";
			}
		}
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
        
	<script>
	function event_switch_theme_mode(){
		var mode = localStorage.getItem('theme_mode');
		if(mode==null || mode=='light'){return true;}
		var link = document.createElement("link");
		link.type = "text/css";
		link.rel = "stylesheet";
		link.id = "theme_mode_css";
		link.href = '../../css/themes/'+mode+'.css';
		document.head.appendChild(link);
	}
	event_switch_theme_mode();
	</script>
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
                                        <a href="#"><span class="glyphicon glyphicon-cog"></span> Preferences</a>
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

         <?php
            if (isset($_GET['msg']) && !empty($_GET['msg'])) {
                echo '<h3 class="alert alert-success text-center">' . $_GET['msg'] . '</h3>';
            }
			
            if (isset($success)) {
                echo '<h3 class="alert alert-success text-center">' .$success. '</h3>';
            }
			
            if (isset($error)) {
                echo '<h3 class="alert alert-danger text-center">' .$error. '</h3>';
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
               echo '<h1>Account Information</h1>';
			?>
            <br />
			
		<!-- User Account Information -->	
				
		<div class="row">
			<div class="col-sm-4">
                <form action="accountinfo.php" method="post">
				<h3>Update your password</h3>
				<label>Current Password</label>
				<div class="form-group"> 
					<input type="password" class="form-control" placeholder="Current Password" required name="current"> 
				</div> 
				   <label>New Password</label>
				<div class="form-group"> 
					<input type="password" class="form-control" placeholder="New Password" required id="password"> 
				</div> 
				   <label>Confirm Password</label>
				<div class="form-group"> 
					<input type="password" class="form-control" placeholder="Confirm Password" required id="confirm_password" name="password"> 
					<span id='message'></span>
				</div> 
				<div class="form-group"> 
					<input type="submit" class="form-control btn btn-primary" value="Submit"> 
				</div> 
				<input type="hidden" name="action" value="pass">
				</form>
			</div> 
			<div class="col-sm-4">
                <form action="accountinfo.php" method="post">
				<h3>Update your email</h3>
				<label>New email</label>
				<div class="form-group"> 
					<input type="email" class="form-control" placeholder="Enter new email" required name="email"> 
				</div> 
				<div class="form-group"> 
					<input type="submit" class="form-control btn btn-primary" value="Submit"> 
				</div> 
				<input type="hidden" name="action" value="mail">
				</form>
			</div>  
		</div>
  
            <br />
            <br />
            </div>
        </div>
            <!-- /.row -->
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

    <!-- Bootstrap Core JavaScript -->
    <script src="../../js/bootstrap.min.js"></script>

    <!-- Torrent Card -->
    <script src="../../js/torrentcard.js"></script>

    <script>
    $(document).ready(function(e){
		$('#password, #confirm_password').on('keyup', function () {
		  if ($('#password').val() == $('#confirm_password').val()) {
			$('#message').html('');
			if($('#password').val().length<8){
				$('#message').html('Enter minimum 8 charecter.').css('color', 'red');
			}
		  } else {
			$('#message').html('Password does not match.').css('color', 'red');
		  }
		});

        $('.search-panel .dropdown-menu').find('a').click(function(e) {
            e.preventDefault();
            var param = $(this).attr("href").replace("#","");
            var concept = $(this).text();
            $('.search-panel span#search_concept').text(concept);
            $('.input-group #category').val(param);
        });
    });
    </script>
    
</body>
</html>

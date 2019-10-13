<?php
    ob_start();
    session_start();

    include_once "../../plugins/private_signup_plugin.php";

    // Redirect if the user is already logged in.
    if(isset($_SESSION["username"])) {
        header("Location: ../../index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Standard Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="OpenTorrentSite: an easy to setup torrent website!">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register | OpenTorrentSite</title>

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
                            echo '<li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>';
                            echo '<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
                        } else {
                            echo '<li><a href="../upload/upload.php"><span class="glyphicon glyphicon-upload"></span> Upload</a></li>';
                            echo '
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$_SESSION["username"].' <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="../view/my-torrents.php"><span class="glyphicon glyphicon-book"></span> Torrents</a>
                                        </li>
                                        <li>
                                            <a href="https://torrents.azukachan.com/en/view/preferences.php"><span class="glyphicon glyphicon-cog"></span> Preferences</a>
                                        </li>
                                        <li>
                                            <a href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
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

        <!-- Login -->
        <div class="row">
            <!-- (col-lg-12) -->
            <div class="col-md-8">
            <h1>Register</h1>
            <hr>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" data-toggle="validator" id="form">
                    <div id="feedback" style="display: none;" class="alert alert-danger"></div>

                    <!-- (username) -->
                    <div class="form-group row">
                      <label for="inputUsername" class="col-sm-2 col-form-label">Username</label>
                      <div class="col-sm-10">
                        <input name="username" type="text" class="form-control" id="inputUsername" placeholder="Username" data-minlength="4" data-error="Username must be longer than 4 characters" required>
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>

                    <!-- (mail) -->
                    <div class="form-group row">
                      <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                        <input name="email" type="email" class="form-control" id="inputEmail" placeholder="Email" data-error="Invalid email address" required>
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>

                    <!-- (password) -->
                    <div class="form-group row">
                      <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                      <div class="col-sm-10">
                        <input name="password" type="password" class="form-control" id="inputPassword3" placeholder="Password" data-minlength="8" required>
                        <div class="help-block">Minimum of 8 characters</div>
                      </div>
                    </div>

                    <!-- (passwordToValidate) -->
                    <div class="form-group row">
                      <label for="inputPassword" class="col-sm-2 col-form-label">Confirm password</label>
                      <div class="col-sm-10">
                        <input name="tovalidatepassword" type="password" class="form-control" id="inputPassword" placeholder="Password" data-match="#inputPassword3" data-match-error="Passwords don't match" data-minlength="8" required>
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>

                    <!-- (checkbox) -->
                    <div class="form-group row">
                      <label class="col-sm-2"></label>
                      <div class="col-sm-10">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input name="remember" class="form-check-input" type="checkbox" data-error="Please accept our terms" required> I accept the TOS
                          </label>
                          <div class="help-block with-errors"></div>
                        </div>
                      </div>
                    </div>

                    <!-- (submit) -->
                    <div class="form-group row">
                    <label class="col-sm-2"></label>
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Register</button>
                      </div>
                    </div>

                </form>
            </div>
        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>OpenTorrentSite | <a href="https://github.com/KevinJDurant/OpenTorrentSite">KevinJDurant</a> | <a href="https://torrents.azukachan.com">AzukaChan</a></p>
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

    <!-- Validator -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>

    <!-- Login handling -->
    <?php
        include_once "../../php/register.php";

        if (!empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['tovalidatepassword']) && !empty($_POST['username'])) {
            register();
        }
    ?>

</body>
</html>
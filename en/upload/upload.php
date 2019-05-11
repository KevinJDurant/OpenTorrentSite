<?php
    ob_start();
    session_start();

    // Include plugin.
    include_once "../../plugins/private_signup_plugin.php";

    // Redirects if the user is not logged in.
    if(empty($_SESSION["username"])) {
        header("Location: ../account/login.php");
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

    <title>Upload | OpenTorrentSite</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Bootstrap CSS -->
    <link href="../../css/1-col-portfolio.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../css/custom.css" rel="stylesheet">

    <!-- Editor TinyMCE
    Cloud:<script src="//cloud.tinymce.com/stable/tinymce.min.js"></script>
    ToDo: Limit characters server & clientwise -->
    <script src="../../js/tinymce/tinymce.min.js"></script>

    <script>
        tinymce.init({
          selector: 'textarea',
          theme: 'modern',
          plugins: [
            'advlist autolink lists link image charmap preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons paste textcolor colorpicker textpattern imagetools toc'
          ],
          toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
          toolbar2: 'preview media | forecolor backcolor emoticons',
          content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i'
          ]
         });
    </script>

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

        <!-- (Upload) -->
        <div class="row">
            <!-- (col-lg-12) -->
            <div class="col-md-8">
            <h1>Upload</h1>
            <hr>
                <!-- (start form) -->
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                    <div id="feedback" style="display: none;" class="alert alert-danger"></div>
                    <!-- (name) -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="ubuntu-16.10-desktop-i386.iso">
                        <small id="nameHelp" class="form-text text-muted">If left blank it will take the .torrent name.</small>
                    </div>
                    <!-- (category) -->
                    <div class="form-group">
                        <label for="categoryId">Category*</label>
                        <select class="form-control" id="categoryId" name="categoryId">
                            <option value="1" selected>Movies</option>
                            <option value="2">Television</option>
                            <option value="3">Music</option>
                            <option value="4">Games</option>
                            <option value="5">Software</option>
                            <option value="6">Anime</option>
                            <option value="7">Books</option>
                            <option value="8">XXX</option>
                            <option value="9">Other</option>
                        </select>
                    </div>
                    <!-- (description) -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="15"></textarea>
                    </div>
                    <!-- (file) -->
                    <div class="form-group">
                        <label for="exampleInputFile">Choose .torrent*</label>
                        <input type="file" class="form-control-file" name="fileToUpload" id="fileToUpload" aria-describedby="fileHelp" required>
                        <small id="fileHelp" class="form-text text-muted">Please don't close the page while submitting your torrent file, processing may take up to 30 seconds.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit .torrent</button>
                </form>
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

    <!-- Login handling -->
    <?php
        include_once "../../php/upload.php";

        if (!empty($_POST['categoryId']) && !empty($_FILES["fileToUpload"])) {
            upload();
        }
    ?>
</body>
</html>
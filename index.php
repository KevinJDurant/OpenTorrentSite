<?php
if (!isset($_SESSION))
  {
    session_start();
  }
?>
<!DOCTYPE html>
<html lang="nl">
<head>
	<!-- Standard Meta -->
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="OpenTorrentSite: an easy to setup torrent website!">
	<meta name="author" content="Kevin Durant">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Site Properties -->
	<title>Quickpage | OpenTorrentSite</title>
	<!-- Google analytics -->
	<!-- Site Includes (css|js) -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/pure-min.css">
	<link rel="stylesheet" href="css/index.css">
	<link rel='shortcut icon' type='image/x-icon' href='images/favico.ico' />
	<!--[if lte IE 8]>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/grids-responsive-old-ie-min.css">
	<![endif]-->
	<!--[if gt IE 8]><!-->
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/grids-responsive-min.css">
	<!--<![endif]-->
</head>

<body class="container">
	<div class="pure-g">
		<!-- title -->
		<div class="title pure-u-1">OpenTorrentSite</div>
		<!-- searchbar -->
		<div class="pure-u-1">
			<form class="pure-form">
				<center>
					<input class="black pure-input-1-2" type="text" placeholder="Search...">
				</center>
			 </form>
		</div>
		<!-- cards -->
		<div class="pure-u-1">
			<center>
				<div class="pure-u-1-2">
					<a href="en/browse.php"><img alt="card image" class="card" src="images/cards/movies-card-min.png"></a>
					<a href="en/browse.php"><img alt="card image" class="card" src="images/cards/television-card-min.png"></a>
					<a href="en/browse.php"><img alt="card image" class="card" src="images/cards/music-card-min.png"></a>
					<a href="en/browse.php"><img alt="card image" class="card" src="images/cards/games-card-min.png"></a>
					<a href="en/browse.php"><img alt="card image" class="card" src="images/cards/software-card-min.png"></a>
					<a href="en/browse.php"><img alt="card image" class="card" src="images/cards/anime-card-min.png"></a>
					<a href="en/browse.php"><img alt="card image" class="card" src="images/cards/books-card-min.png"></a>
					<a href="en/browse.php"><img alt="card image" class="card" src="images/cards/xxx-card-min.png"></a>
				</div>
			</center>
		</div>
	</div>
</body>
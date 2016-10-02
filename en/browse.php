<?php
if (!isset($_SESSION)) {
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
	<title>Browse | OpenTorrentSite</title>
	<!-- Google analytics -->
	<!-- Site Includes (css|js) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<link rel="stylesheet" href="../css/normalize.css">
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/pure-min.css">
	<link rel="stylesheet" href="../css/browse.css">
	<link rel="stylesheet" href="../css/footer.css">
	<link rel='shortcut icon' type='image/x-icon' href='../images/favico.ico' />
	<!--[if lte IE 8]>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/grids-responsive-old-ie-min.css">
	<![endif]-->
	<!--[if gt IE 8]><!-->
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/grids-responsive-min.css">
	<!--<![endif]-->
</head>

<body class="container">
	<div class="pure-g">
		<!-- (navigation) -->
		<div id="navigation" class="pure-u-1">
			<div class="pure-menu pure-menu-horizontal">
				<ul class="pure-menu-list" id="menu">
					<!-- title -->
					<li id="title" class="pure-menu-item pure-menu"><a href="../index.php" class="pure-menu-link hidesmall">openTorrentSite</a></li>
					<!-- nav -->
					<li class="pure-menu-item pure-menu-has-children pure-menu-allow-hover">
						<a href="#" id="menuLink1" class="pure-menu-link">Section</a>
						<ul class="pure-menu-children">
							<li class="pure-menu-item"><a href="#" class="pure-menu-link">Movies</a></li>
							<li class="pure-menu-item"><a href="#" class="pure-menu-link">Television</a></li>
							<li class="pure-menu-item"><a href="#" class="pure-menu-link">Music</a></li>
							<li class="pure-menu-item"><a href="#" class="pure-menu-link">Games</a></li>
							<li class="pure-menu-item"><a href="#" class="pure-menu-link">Software</a></li>
							<li class="pure-menu-item"><a href="#" class="pure-menu-link">Anime</a></li>
							<li class="pure-menu-item"><a href="#" class="pure-menu-link">Books</a></li>
							<li class="pure-menu-item"><a href="#" class="pure-menu-link">XXX</a></li>
						</ul>
					</li>
					<!-- search -->
					<li class="pure-menu-item pure-menu">
						<form class="pure-form">
							<input class="pure-input-1" type="text" style="box-shadow: none; border: none; height: 100%;" placeholder="search...">
						</form>
					</li>
					<!-- login -->
					<li id="btns" class="pure-menu-item pure-menu right">
						<!-- upload button -->
						<button id="uploadbtn" class="pure-button pure-button-disabled" disabled><i class="fa fa-upload" aria-hidden="true"></i>Upload</button>
						<!-- login button -->
						<a href="login.php"><button type="button" id="loginbtn" class="button-success pure-button">Login</button></a>
					</li>
				</ul>
			</div>
		</div>
		<!-- (torrents) -->
		<div id="populartorrents" class="pure-u-1 pure-u-md-3-4">
			<div class="left">
				<p class="category">Movies</p>
				<!-- demo table -->
				<table class="pure-table popular">
					<thead>
						<tr>
							<th>TORRENT</th>
							<th>SIZE</th>
							<th>AGE</th>
							<th>SEED</th>
							<th>LEECH</th>
						</tr>
					</thead>
					<tbody>
						<tr class="pure-table-odd">
							<td data-label="torrent">Ubuntu 16.04.1 LTS 
								<a href="magnet:?xt=urn:btih:4344503b7e797ebf31582327a5baae35b11bda01&dn=ubuntu-16.04-desktop-amd64.iso"><i class="fa fa-magnet"></i></a>
								<a href="http://releases.ubuntu.com/16.04/ubuntu-16.04-desktop-amd64.iso.torrent"><i class="fa fa-download"></i></a>
								<a href="#"><i class="fa fa-comments" aria-hidden="false"></i></a><br>
								<span>By: Admin</span>
							</td>
							<td data-label="size">1.4 GB</td>
							<td data-label="age">15/06/2009</td>
							<td data-label="seed">1601</td>
							<td data-label="leech">23</td>
						</tr>
						<tr class="pure-table-even">
							<td data-label="torrent">Ubuntu 16.04.1 LTS 
								<a href="magnet:?xt=urn:btih:4344503b7e797ebf31582327a5baae35b11bda01&dn=ubuntu-16.04-desktop-amd64.iso"><i class="fa fa-magnet"></i></a>
								<a href="http://releases.ubuntu.com/16.04/ubuntu-16.04-desktop-amd64.iso.torrent"><i class="fa fa-download"></i></a>
								<a href="#"><i class="fa fa-comments" aria-hidden="false"></i></a><br>
								<span>By: Admin</span>
							</td>
							<td data-label="size">1.4 GB</td>
							<td data-label="age">15/06/2009</td>
							<td data-label="seed">1601</td>
							<td data-label="leech">23</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<!-- (community) -->
		<div id="community" class="pure-u-1 pure-u-md-1-4">
			<div class="left">
				<p class="category">Social</p>
				<table class="pure-table">
					<thead>
						<tr>
							<th>Platforms</th>
						</tr>
					</thead>
					<tbody>
						<tr class="pure-table-even">
							<td>
								<a href=""><i class="fa fa-facebook-square fa-lg" aria-hidden="false"></i></a>
								<a href=""><i class="fa fa-reddit-square fa-lg" aria-hidden="false"></i></a>
								<a href=""><i class="fa fa-github-square fa-lg" aria-hidden="false"></i></a>
								<a href=""><i class="fa fa-twitter-square fa-lg" aria-hidden="false"></i></a>
							</td>
						</tr>
					</tbody>
				</table>
				<!-- searches -->
				<p class="category">Queries</p>
				<table class="pure-table">
					<thead>
						<tr>
							<th>Recent</th>
						</tr>
					</thead>
					<tbody>
						<tr class="pure-table-even">
							<td>
								<a href="">Linux</a>
							</td>
						</tr>
						<tr class="pure-table-odd">
							<td>
								<a href="">Ubuntu</a>
							</td>
						</tr>
						<tr class="pure-table-even">
							<td>
								<a href="">Loyalty music</a>
							</td>
						</tr>
					</tbody>
				</table>
				<!-- announcements -->
			</div>
		</div>
		<!-- (footer) -->
		<div id="footer" class="pure-u-1">
			<div>&copy; OpenTorrentSite.com
				<div class="fright">
					<span>TERMS &amp; CONDITIONS</span>
					<span>PRIVACY POLICY</span>
					<span>DMCA</span>
				</div>
			</div>
		</div>
	</div>
</body>
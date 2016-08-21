<!DOCTYPE html>
<head>		
	<!-- Standard Meta -->
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	
	<!-- Site Properties -->
	<title>Home | OTS</title>
	<link rel="stylesheet" href="https://necolas.github.io/normalize.css/4.1.1/normalize.css">
	<link rel="stylesheet" href="css/pure-min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/modal.css">
</head>
<body>
	<!-- Navigation -->
	<nav>
		<div class="pure-menu pure-menu-horizontal">
			<ul class="pure-menu-list" id="menu">
				<li class="pure-menu-item pure-menu-selected"><a href="index.html" class="pure-menu-link hidesmall">openTorrentSite</a></li>
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
				<li class="pure-menu-item">
					<form class="pure-form">
						<input class="pure-input-1" type="text" style="box-shadow: none; border: none; height: 100%;" placeholder="search...">
					</form>
				</li>
			</ul>
			<button id="loginbtn" class="button-success pure-button" data-toggle="modal" data-target="#loginmodal" style="float: right;">Login</button>
			<button id="uploadbtn" class="pure-button pure-button-disabled" style="float: right;" disabled><i class="fa fa-upload" aria-hidden="true"></i>Upload</button>
		</div>
	</nav>
	
	<!-- Login modal -->
	<div id="loginmodal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-header">
			<h1 id="myModalLabel" style="margin: 0;">Welcome.</h1>
		</div>

		<div class="modal-body">
			<form class="pure-form pure-form-stacked" action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="post" onkeypress="return event.keyCode != 13;">
				<legend>Not yet registered? <a href="" data-toggle="modal" data-target="#registermodal" data-dismiss="modal"><u>Click here</u>.</a></legend>

				<label for="email">Email</label>
				<input id="email" name="email" type="text" placeholder="Email" required>

				<label for="password">Password</label>
				<input id="password" name="password" type="password" placeholder="Password" required>

				<label class="pure-checkbox">
					<input type="checkbox" name="remember"> Remember me
				</label>
		</div>
		<div class="modal-footer">
			<button class="pure-button" data-dismiss="modal" aria-hidden="true">Close</button>
			<button type="submit" class="pure-button pure-button-primary">Submit</button>
		</div>
		</form>
	</div>
	
	<!-- Register modal -->
	<div id="registermodal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="registermodallabel" aria-hidden="true" style="display: none;">
		<div class="modal-header">
			<h1 id="registermodallabel" style="margin: 0;">Join us!</h1>
		</div>

		<div class="modal-body">
			<form class="pure-form pure-form-stacked" action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="post" onkeypress="return event.keyCode != 13;">
			<legend>Min. 6 characters, include numbers!</legend>
				<label for="name2">Username</label>
				<input id="name2" name="username" type="text" placeholder="Username" maxlength="10" required>
				
				<label for="email2">Email</label>
				<input id="email2" name="email2" type="text" placeholder="Email" maxlength="30" required>

				<label for="password2">Password</label>
				<input id="password2" name="password2" type="password" placeholder="Password" required>

				<label for="cpassword">Confirm password</label>
				<input id="cpassword" name="cpassword" type="password" placeholder="Password" required>
				
				<label class="pure-checkbox">
					<input type="checkbox" name="tos" required> I read and accept the TOS
				</label>
		</div>
		<div class="modal-footer">
			<button class="pure-button" data-dismiss="modal" aria-hidden="true">Close</button>
			<button type="submit" class="pure-button pure-button-primary">Submit</button>
		</div>
		</form>
	</div>
	
	<!-- Site content -->
	<div class="container">		
		<div class="searches">
		<p class="category">Social</p>
			<table class="pure-table" style="width:100%;">
			<thead>
				<tr>
					<th>Platforms</th>
				</tr>
			</thead>
			<tbody>
				<tr class="pure-table-even search">
					<td>
						<a href=""><i class="fa fa-facebook-square fa-lg" aria-hidden="false"></i></a>
						<a href=""><i class="fa fa-reddit-square fa-lg" aria-hidden="false"></i></a>
						<a href=""><i class="fa fa-github-square fa-lg" aria-hidden="false"></i></a>
						<a href=""><i class="fa fa-twitter-square fa-lg" aria-hidden="false"></i></a>
					</td>
				</tr>
			</tbody>
		</table>
			<p class="category">Feeds</p>
			<table class="pure-table" style="width:100%;">
			<thead>
				<tr>
					<th>Recent searches</th>
				</tr>
			</thead>
			<tbody>
				<tr class="pure-table-odd search">
					<td>royalty free music</td>
				</tr>
				<tr class="pure-table-even search">
					<td>abandonware</td>
				</tr>
				<tr class="pure-table-odd search">
					<td>artwork</td>
				</tr>
				<tr class="pure-table-even search">
					<td>abandonware</td>
				</tr>
				<tr class="pure-table-odd search">
					<td>artwork</td>
				</tr>
				<tr class="pure-table-even search">
					<td>abandonware</td>
				</tr>
				<tr class="pure-table-odd search">
					<td>artwork</td>
				</tr>
				<tr class="pure-table-even search">
					<td>abandonware</td>
				</tr>
			</tbody>
		</table>
		<table class="pure-table" style="width:100%;">
			<thead>
				<tr>
					<th>Recent blogposts</th>
				</tr>
			</thead>
			<tbody>
				<tr class="pure-table-odd search">
					<td>royalty free music</td>
				</tr>
				<tr class="pure-table-even search">
					<td>abandonware</td>
				</tr>
				<tr class="pure-table-odd search">
					<td>artwork</td>
				</tr>
				<tr class="pure-table-even search">
					<td>abandonware</td>
				</tr>
				<tr class="pure-table-odd search">
					<td>artwork</td>
				</tr>
				<tr class="pure-table-even search">
					<td>abandonware</td>
				</tr>
				<tr class="pure-table-odd search">
					<td>artwork</td>
				</tr>
				<tr class="pure-table-even search">
					<td>abandonware</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div>
		<!-- Begin demo table -->
		<p class="category">Movies</p>
		<div class="flow"><table class="pure-table">
			<thead>
				<tr>
					<th width="65vw">TORRENT NAME</th>
					<th width="10vw">SIZE</th>
					<th width="10vw">AGE</th>
					<th width="10vw">SEED</th>
					<th width="10vw">LEECH</th>
				</tr>
			</thead>
			<tbody>
				<tr class="pure-table-odd">
					<td>Ubuntu 16.04.1 LTS 
						<a href="magnet:?xt=urn:btih:4344503b7e797ebf31582327a5baae35b11bda01&dn=ubuntu-16.04-desktop-amd64.iso"><i class="fa fa-magnet right"></i></a>
						<a href="http://releases.ubuntu.com/16.04/ubuntu-16.04-desktop-amd64.iso.torrent"><i class="fa fa-download right"></i></a>
						<a href="#"><i class="fa fa-comments right" aria-hidden="false"></i></a><br>
						<span class="uploader">By: Admin</span>
					</td>
					<td>1.4 GB</td>
					<td>15/06/2009</td>
					<td>1601</td>
					<td>23</td>
				</tr>

				<tr class="pure-table-even">
					<td>Ubuntu 16.04.1 LTS 
						<a href="magnet:?xt=urn:btih:4344503b7e797ebf31582327a5baae35b11bda01&dn=ubuntu-16.04-desktop-amd64.iso"><i class="fa fa-magnet right"></i></a>
						<a href="http://releases.ubuntu.com/16.04/ubuntu-16.04-desktop-amd64.iso.torrent"><i class="fa fa-download right"></i></a>
						<a href="#"><i class="fa fa-comments right" aria-hidden="false"></i></a><br>
						<span class="uploader">By: Admin</span>
					</td>
					<td>1.4 GB</td>
					<td>15/06/2009</td>
					<td>1601</td>
					<td>23</td>
				</tr>
			</tbody>
		</table></div>
		
		<p class="category">Television</p>
		<div class="flow"><table class="pure-table">
			<thead>
				<tr>
					<th width="65vw">TORRENT NAME</th>
					<th width="10vw">SIZE</th>
					<th width="10vw">AGE</th>
					<th width="10vw">SEED</th>
					<th width="10vw">LEECH</th>
				</tr>
			</thead>
			<tbody>
				<tr class="pure-table-odd">
					<td>Ubuntu 16.04.1 LTS 
						<a href="magnet:?xt=urn:btih:4344503b7e797ebf31582327a5baae35b11bda01&dn=ubuntu-16.04-desktop-amd64.iso"><i class="fa fa-magnet right"></i></a>
						<a href="http://releases.ubuntu.com/16.04/ubuntu-16.04-desktop-amd64.iso.torrent"><i class="fa fa-download right"></i></a>
						<a href="#"><i class="fa fa-comments right" aria-hidden="false"></i></a><br>
						<span class="uploader">By: Admin</span>
					</td>
					<td>1.4 GB</td>
					<td>15/06/2009</td>
					<td>1601</td>
					<td>23</td>
				</tr>

				<tr class="pure-table-even">
					<td>Ubuntu 16.04.1 LTS 
						<a href="magnet:?xt=urn:btih:4344503b7e797ebf31582327a5baae35b11bda01&dn=ubuntu-16.04-desktop-amd64.iso"><i class="fa fa-magnet right"></i></a>
						<a href="http://releases.ubuntu.com/16.04/ubuntu-16.04-desktop-amd64.iso.torrent"><i class="fa fa-download right"></i></a>
						<a href="#"><i class="fa fa-comments right" aria-hidden="false"></i></a><br>
						<span class="uploader">By: Admin</span>
					</td>
					<td>1.4 GB</td>
					<td>15/06/2009</td>
					<td>1601</td>
					<td>23</td>
				</tr>
			</tbody>
		</table></div>
		
		<div class="flow"><p class="category">Music</p>
		<table class="pure-table">
			<thead>
				<tr>
					<th width="65vw">TORRENT NAME</th>
					<th width="5vw">SIZE</th>
					<th width="10vw">AGE</th>
					<th width="10vw">SEED</th>
					<th width="10vw">LEECH</th>
				</tr>
			</thead>
			<tbody>
				<tr class="pure-table-odd">
					<td>Ubuntu 16.04.1 LTS 
						<a href="magnet:?xt=urn:btih:4344503b7e797ebf31582327a5baae35b11bda01&dn=ubuntu-16.04-desktop-amd64.iso"><i class="fa fa-magnet right"></i></a>
						<a href="http://releases.ubuntu.com/16.04/ubuntu-16.04-desktop-amd64.iso.torrent"><i class="fa fa-download right"></i></a>
						<a href="#"><i class="fa fa-comments right" aria-hidden="false"></i></a><br>
						<span class="uploader">By: Admin</span>
					</td>
					<td>1.4 GB</td>
					<td>15/06/2009</td>
					<td>1601</td>
					<td>23</td>
				</tr>

				<tr class="pure-table-even">
					<td>Ubuntu 16.04.1 LTS 
						<a href="magnet:?xt=urn:btih:4344503b7e797ebf31582327a5baae35b11bda01&dn=ubuntu-16.04-desktop-amd64.iso"><i class="fa fa-magnet right"></i></a>
						<a href="http://releases.ubuntu.com/16.04/ubuntu-16.04-desktop-amd64.iso.torrent"><i class="fa fa-download right"></i></a>
						<a href="#"><i class="fa fa-comments right" aria-hidden="false"></i></a><br>
						<span class="uploader">By: Admin</span>
					</td>
					<td>1.4 GB</td>
					<td>15/06/2009</td>
					<td>1601</td>
					<td>23</td>
				</tr>
			</tbody>
		</table></div>
		
		<p class="category">Games</p>
		<div class="flow"><table class="pure-table">
			<thead>
				<tr>
					<th width="65vw">TORRENT NAME</th>
					<th width="10vw">SIZE</th>
					<th width="10vw">AGE</th>
					<th width="10vw">SEED</th>
					<th width="10vw">LEECH</th>
				</tr>
			</thead>
			<tbody>
				<tr class="pure-table-odd">
					<td>Ubuntu 16.04.1 LTS 
						<a href="magnet:?xt=urn:btih:4344503b7e797ebf31582327a5baae35b11bda01&dn=ubuntu-16.04-desktop-amd64.iso"><i class="fa fa-magnet right"></i></a>
						<a href="http://releases.ubuntu.com/16.04/ubuntu-16.04-desktop-amd64.iso.torrent"><i class="fa fa-download right"></i></a>
						<a href="#"><i class="fa fa-comments right" aria-hidden="false"></i></a><br>
						<span class="uploader">By: Admin</span>
					</td>
					<td>1.4 GB</td>
					<td>15/06/2009</td>
					<td>1601</td>
					<td>23</td>
				</tr>

				<tr class="pure-table-even">
					<td>Ubuntu 16.04.1 LTS 
						<a href="magnet:?xt=urn:btih:4344503b7e797ebf31582327a5baae35b11bda01&dn=ubuntu-16.04-desktop-amd64.iso"><i class="fa fa-magnet right"></i></a>
						<a href="http://releases.ubuntu.com/16.04/ubuntu-16.04-desktop-amd64.iso.torrent"><i class="fa fa-download right"></i></a>
						<a href="#"><i class="fa fa-comments right" aria-hidden="false"></i></a><br>
						<span class="uploader">By: Admin</span>
					</td>
					<td>1.4 GB</td>
					<td>15/06/2009</td>
					<td>1601</td>
					<td>23</td>
				</tr>
			</tbody>
		</table></div>
		
		<p class="category">Software</p>
		<div class="flow"><table class="pure-table">
			<thead>
				<tr>
					<th width="65vw">TORRENT NAME</th>
					<th width="10vw">SIZE</th>
					<th width="10vw">AGE</th>
					<th width="10vw">SEED</th>
					<th width="10vw">LEECH</th>
				</tr>
			</thead>
			<tbody>
				<tr class="pure-table-odd">
					<td>Ubuntu 16.04.1 LTS 
						<a href="magnet:?xt=urn:btih:4344503b7e797ebf31582327a5baae35b11bda01&dn=ubuntu-16.04-desktop-amd64.iso"><i class="fa fa-magnet right"></i></a>
						<a href="http://releases.ubuntu.com/16.04/ubuntu-16.04-desktop-amd64.iso.torrent"><i class="fa fa-download right"></i></a>
						<a href="#"><i class="fa fa-comments right" aria-hidden="false"></i></a><br>
						<span class="uploader">By: Admin</span>
					</td>
					<td>1.4 GB</td>
					<td>15/06/2009</td>
					<td>1601</td>
					<td>23</td>
				</tr>

				<tr class="pure-table-even">
					<td>Ubuntu 16.04.1 LTS 
						<a href="magnet:?xt=urn:btih:4344503b7e797ebf31582327a5baae35b11bda01&dn=ubuntu-16.04-desktop-amd64.iso"><i class="fa fa-magnet right"></i></a>
						<a href="http://releases.ubuntu.com/16.04/ubuntu-16.04-desktop-amd64.iso.torrent"><i class="fa fa-download right"></i></a>
						<a href="#"><i class="fa fa-comments right" aria-hidden="false"></i></a><br>
						<span class="uploader">By: Admin</span>
					</td>
					<td>1.4 GB</td>
					<td>15/06/2009</td>
					<td>1601</td>
					<td>23</td>
				</tr>
			</tbody>
		</table></div>
		
		<p class="category">Anime</p>
		<div class="flow"><table class="pure-table">
			<thead>
				<tr>
					<th width="65vw">TORRENT NAME</th>
					<th width="10vw">SIZE</th>
					<th width="10vw">AGE</th>
					<th width="10vw">SEED</th>
					<th width="10vw">LEECH</th>
				</tr>
			</thead>
			<tbody>
				<tr class="pure-table-odd">
					<td>Ubuntu 16.04.1 LTS 
						<a href="magnet:?xt=urn:btih:4344503b7e797ebf31582327a5baae35b11bda01&dn=ubuntu-16.04-desktop-amd64.iso"><i class="fa fa-magnet right"></i></a>
						<a href="http://releases.ubuntu.com/16.04/ubuntu-16.04-desktop-amd64.iso.torrent"><i class="fa fa-download right"></i></a>
						<a href="#"><i class="fa fa-comments right" aria-hidden="false"></i></a><br>
						<span class="uploader">By: Admin</span>
					</td>
					<td>1.4 GB</td>
					<td>15/06/2009</td>
					<td>1601</td>
					<td>23</td>
				</tr>

				<tr class="pure-table-even">
					<td>Ubuntu 16.04.1 LTS 
						<a href="magnet:?xt=urn:btih:4344503b7e797ebf31582327a5baae35b11bda01&dn=ubuntu-16.04-desktop-amd64.iso"><i class="fa fa-magnet right"></i></a>
						<a href="http://releases.ubuntu.com/16.04/ubuntu-16.04-desktop-amd64.iso.torrent"><i class="fa fa-download right"></i></a>
						<a href="#"><i class="fa fa-comments right" aria-hidden="false"></i></a><br>
						<span class="uploader">By: Admin</span>
					</td>
					<td>1.4 GB</td>
					<td>15/06/2009</td>
					<td>1601</td>
					<td>23</td>
				</tr>
			</tbody>
		</table></div>
		
		<p class="category">Books</p>
		<div class="flow"><table class="pure-table">
			<thead>
				<tr>
					<th width="65vw">TORRENT NAME</th>
					<th width="10vw">SIZE</th>
					<th width="10vw">AGE</th>
					<th width="10vw">SEED</th>
					<th width="10vw">LEECH</th>
				</tr>
			</thead>
			<tbody>
				<tr class="pure-table-odd">
					<td>Ubuntu 16.04.1 LTS 
						<a href="magnet:?xt=urn:btih:4344503b7e797ebf31582327a5baae35b11bda01&dn=ubuntu-16.04-desktop-amd64.iso"><i class="fa fa-magnet right"></i></a>
						<a href="http://releases.ubuntu.com/16.04/ubuntu-16.04-desktop-amd64.iso.torrent"><i class="fa fa-download right"></i></a>
						<a href="#"><i class="fa fa-comments right" aria-hidden="false"></i></a><br>
						<span class="uploader">By: Admin</span>
					</td>
					<td>1.4 GB</td>
					<td>15/06/2009</td>
					<td>1601</td>
					<td>23</td>
				</tr>

				<tr class="pure-table-even">
					<td>Ubuntu 16.04.1 LTS 
						<a href="magnet:?xt=urn:btih:4344503b7e797ebf31582327a5baae35b11bda01&dn=ubuntu-16.04-desktop-amd64.iso"><i class="fa fa-magnet right"></i></a>
						<a href="http://releases.ubuntu.com/16.04/ubuntu-16.04-desktop-amd64.iso.torrent"><i class="fa fa-download right"></i></a>
						<a href="#"><i class="fa fa-comments right" aria-hidden="false"></i></a><br>
						<span class="uploader">By: Admin</span>
					</td>
					<td>1.4 GB</td>
					<td>15/06/2009</td>
					<td>1601</td>
					<td>23</td>
				</tr>
			</tbody>
		</table></div>
		<p></p>
	</div>
	</div>
	<!-- End table -->
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	
	<footer>
		<div id="bottom">
		FAQ 
		ABOUT 
		RULES 
		PRIVACY 
		DMCA 
		CONTACT 
		API 
		DONATE
		<div>
		<span id="copyright">Copyright '16 @ yoursitename.com</span>
	</footer>
	
	<!-- Login php needs to be at the bottom -->
	<?php
		include_once "engine/login_handler.php";
		
		if (isset($_POST['tos']) && $_POST['password2'] && $_POST['email2'] && $_POST['cpassword']) {
			register();
		}
		
		if (isset($_POST['email']) && $_POST['password']) {
			login();
		}
	?>
</body>
</html>
<!DOCTYPE html>
<head>		
	<!-- Standard Meta -->
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	
	<!-- Site Properties -->
	<title>Home | OTS</title>
	<link rel="stylesheet" href="https://necolas.github.io/normalize.css/4.1.1/normalize.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	<link rel="stylesheet" href="css/pure-min.css">
	<link rel="stylesheet" href="css/upload.css">
	
	
</head>
<body>
	<!-- navigation -->
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
			<button id="uploadbtn" class="pure-button pure-button-disabled" style="float: right;"><i class="fa fa-upload" aria-hidden="true"></i>Upload</button>
		</div>
	</nav>
	
	<!-- upload process -->
	<!-- Choose category, pick torrent file & upload, set torrent name, title, imdb, quality, audio language, subtitle language, screenshots, description, magnet, direct link then save-->
	<div class="container">
		
		<p class="category">Upload a torrent</p>
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#home">Category</a></li>
			<li><a data-toggle="tab" href="#menu1">File</a></li>
			<li><a data-toggle="tab" href="#menu2">Properties</a></li>
			<li><a data-toggle="tab" href="#menu3">Review</a></li>
		</ul>

		<div class="tab-content">
			<div id="home" class="tab-pane fade in active">
			  <h3>Pick a category</h3>
			  <p>
			  <form action="engine/upload_handler.php" class="pure-form pure-form-aligned" method="post" enctype="multipart/form-data">
			  
				<label for="option-one" class="pure-radio">
					<input id="option-one" type="radio" name="optionsRadios" value="movies" checked>
					Movies
				</label>

				<label for="option-two" class="pure-radio">
					<input id="option-two" type="radio" name="optionsRadios" value="television">
					Television
				</label>

				<label for="option-three" class="pure-radio">
					<input id="option-three" type="radio" name="optionsRadios" value="music">
					Music
				</label>
				
				<label for="option-four" class="pure-radio">
					<input id="option-four" type="radio" name="optionsRadios" value="games">
					Games
				</label>
				
				<label for="option-five" class="pure-radio">
					<input id="option-five" type="radio" name="optionsRadios" value="software">
					Software
				</label>

				<label for="option-six" class="pure-radio">
					<input id="option-six" type="radio" name="optionsRadios" value="anime">
					Anime
				</label>

				<label for="option-seven" class="pure-radio">
					<input id="option-seven" type="radio" name="optionsRadios" value="books">
					Books
				</label>
				
				<label for="option-eight" class="pure-radio">
					<input id="option-eight" type="radio" name="optionsRadios" value="xxx">
					XXX
				</label>
			</p>
			
			</div>
			<div id="menu1" class="tab-pane fade">
			  <h3>Choose your .torrent</h3>
			  <p><br>
					<input type="file" name="fileToUpload" id="fileToUpload"><br>
			  </p>
			</div>
			<div id="menu2" class="tab-pane fade">
			  <h3>Adjust the properties</h3>
			  <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
			</div>
			<div id="menu3" class="tab-pane fade">
			  <h3>Review your upload</h3>
			  <p>
				<input type="submit" class="pure-button pure-button-primary" value="Upload torrent" name="submit">
				</form>
			  </p>
			</div>
		</div>
	</div>
	
	<!-- footer -->
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
	
	<!-- document ending -->
</body>
</html>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Free Loto help</title>
  <meta name="description" content="Qoqoo Free Loto">

  <!--[if IE]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  
  <link href='http://fonts.googleapis.com/css?family=Combo' rel='stylesheet' type='text/css'>
		
   
  		<link rel="stylesheet" href="css/styles.css" type="text/css">
		<link rel="stylesheet" href="css/ew_style.css" />
		<link rel="stylesheet" href="css/all.css" />
		<link rel="stylesheet" href="css/help.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		
	<!--	//show with one open
		<script> 
			$(function() {
				$( ".accordion" ).accordion();
			});
		</script>
	-->
		<script>
			$(function() {
				$( ".accordion" ).accordion({ autoHeight: true, active: true, collapsible: true, autoHeight: true});
			});
		</script>

</head>

<body>
	<header>
		<div class="content-box">
			<div class="nav-bar">
				<div><a href="index.php"><img class="logo" src="images/qooqo_logo.png" alt="" title=""></a></div>
				<nav>
					<li><a href="index.php"><img src="images/play.png" alt="play" title="play"></a></li>
					<li><a href="winners.php"><img src="images/winners.png" alt="winners" title="winners"></a></li>
					<li><img src="images/help.png" alt="help" title="help"></li>
				</nav>
				<div class="social_box">
					<ul>
						<li><a href=""><img src="images/facebook.gif" alt="facebook" title="facebook"></a></li>
						<li><a href=""><img src="images/google.gif" alt="google" title="google"></a></li>
						<li><a href=""><img src="images/youtube.gif" alt="youtube" title="youtube"></a></li>
					</ul>
				</div>
			</div>
		</div>
	</header>
	<section style='height:auto;'>
	<!-- -------------START Middle Area ----------------->
		<div class="content-box"  style='height:auto;'>
			<div class="free_lotto" style='height:auto;' >
				<div class="lottofaqhelp"></div>
			</div>
			<!-- -------------START Number Box Area ----------------->
			<div id="helpfaq" style='height:auto;margin-bottom:0px;' >
				<div class="downfont" style='height:auto;' >
					<h1 style='font-family: go_boomregular;'>Free Lotto Help</h1>
					<?php include('helpmain.php');?>
					<div class="faq">
										</div>
				</div>
			</div>
		
	<!-- -------------END Middle Area ----------------->		
	    </div>
	</section>
	
<!-- -------------START Footer ----------------->
<footer>
		<div class="content-box">
			<div class="footer_bar" style="top:0px;" > 
				<p>&copy; 2013 qooqo FreeLotto • All rights reserved.</p>
					
				<div class="nav_footer">
					<li><a href="http://www.qooqo.com/index.php/contact.html"><img src="images/contact.png"></a></li>
					<li><a href="download.php"><img src="images/download.png"></a></li>
				</div>				
			</div>
		</div>
	</footer>
<!-- -------------END Footer ----------------->	
</body>
</html>
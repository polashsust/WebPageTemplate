<?php    include_once('common.php');?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Free Loto Result</title>
  <meta name="description" content="Qoqoo Free Loto">
     <link href='http://fonts.googleapis.com/css?family=Combo' rel='stylesheet' type='text/css'>

  <link rel="stylesheet" href="css/styles.css" type="text/css">
  <link rel="stylesheet" href="css/all.css" />
 
  
   <style>
       .test
	   {
	   
	   font-size:22.5px;
	   font-weight:regular;
	   color:#f66754;
	     font-family: 'go_boomregular',helvetica,arial,sans-serif;
	   }
   </style>
   <!--[if lt IE 9]><script src="assets/html5shiv/3.6.1/html5shiv.js"></script><![endif]-->
</head>

<body>
	<header>
		<div class="content-box">
			<div class="nav-bar">
				<div><a href="index.php"><img class="logo" src="images/qooqo_logo.png" alt="" title=""></a></div>
				<nav>
					<li><a href="index.php"><img src="images/play.png" alt="play" title="play"></a></li>
					<li><a href="winners.php"><img src="images/winners.png" alt="winners" title="winners"></a></li>
					<li><a href="help.php"><img src="images/help.png" alt="help" title="help"></a></li>
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
	<section>
	<!-- -------------START Middle Area ----------------->
		<div class="content-box" style='height:auto;' >
			<div class="free_lotto" style='width:400px;'>
				<div class="lottodownloadwinners" style='margin-left:30px;'></div>
			</div>
			<!-- -------------START Number Box Area ----------------->
			<div class="appdown" style='float:left;margin-left:30px;width:510px;height:auto;'>
				<div class="downfont">
				   <h1><span class='test'>Free Lotto Winning loot numbers</span></h1>
				   <div style='width:510px;float:left;'>
				     <div  class="number_plate">
					     <?php include_once('lotto/demo.php');?>
					  </div>
				  </div>	
				</div>
			</div>
			
	<!-- -------------END Middle Area ----------------->		
	    </div>
	</section>
<!-- -------------START Footer ----------------->
<footer>
		<div class="content-box">
			<div class="footer_bar" style='top:130px;'> 
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
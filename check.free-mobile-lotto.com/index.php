<?php
require_once 'lotto/Mobile_Detect.php';
$detect = new Mobile_Detect();

if ($detect->isMobile() && isset($_COOKIE['mobile']))
{
$detect = "false";
}

elseif ($detect->isMobile())
{
header("Location:http://free-mobile-lotto.com");
}

/*
$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
$scriptVersion = $detect->getScriptVersion();
//echo $deviceType;
if($deviceType=='computer' || $deviceType=='tablet')*/
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
  <meta charset="utf-8">
  <title>This is made By Polash, first time github</title>
  <meta name="description" content="Qoqoo Free Loto">
  <link rel="stylesheet" href="css/styles.css" type="text/css">
  <!--[if IE]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  
  <link href='http://fonts.googleapis.com/css?family=Combo' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile.structure-1.3.2.min.css" />
		<!--<script>
		if($deviceType=='computer'){
				window.location.href='http://www.qooqo.com';
								}
		</script> -->
        <script src="js/jquery-1.10.2.min.js"></script>
        <script src="js/jquery.mobile-1.3.2.min.js"></script>
        <script src="js/freelotto.js"></script>
		<script src="js/payment.js"></script>
		<script src="js/fortunor.js"></script>
        <script src="js/frontend.js"></script>
		<link rel="stylesheet" href="css/styles.css" type="text/css">
		<link rel="stylesheet" href="css/ew_style.css" />
		<link rel="stylesheet" href="css/all.css" />
		<link rel="stylesheet" href="git/all.css" />
		<script>
		$().ready(function(){
			// Global game instance
			var game = new Freelotto(
				"lotterynumber",
				"randomize",
				"reset"
			);

			// Global payment gateway communicator
			var payment = new Payment();

            var frontend = new Frontend(
                game,
                $("#lotterychosen"),
                $("#information_row")
            );
            frontend.drawGreyBoxes();
            frontend.changeRequiredNumberCount();

			game.onpayable = function() {
                if (!payment.checkQrCode()) {
                    window.setTimeout(function() { game.checkCanPay(); }, 500);
                    frontend.showPleaseWait(true);
                } else {
                    $(".qoqo_btn_img").attr("src", payment.qrcode_);
                    $(".applink").attr("href", payment.appurl_);
                    payment.pay(this);
                    frontend.showPleaseWait(false);
                }
			};

			game.onnotpayable = function() {
                payment.stopPollingLoop();
				$(".qoqo_btn_img").attr("src", "img/qooqo_logo.png");
				$(".applink").attr("href", "#");
			};

			game.onchoice = function() {
                // Allocate Transaction
                payment.allocateTransaction();

			    // Get number container and empty it
				var $numbercontainer = $("#lotterychosen");
				$numbercontainer.empty();

				$.each(this.numbers_, function (i,v) {
				  var $txt = $("<span></span>").addClass("ui-btn-text").html(v);
				  var $envelope = $("<span></span>").addClass("ui-btn-inner-active").append($txt);
				  $("<a></a>").addClass("ui-btn ui-btn-inline ui-btn-up-a").append($envelope).appendTo($numbercontainer);
                  $numbercontainer.append(" \n");
				});

                frontend.drawGreyBoxes(this.numbers_.length);
				if(this.numbers_.length==7)
				     $(".qoqo_btn_img").attr("src", "images/qrcode.png");
				else
                     $(".qoqo_btn_img").attr("src", "img/qooqo_logo.png");				
                frontend.changeRequiredNumberCount(this.numbers_.length);
			};

			payment.ontransactionallocationfailed = payment.onpollfailed = payment.onpayfailed = function() {
				alert(this.lasterror_);
			};

			payment.onpaymentsucceeded = function() {
				
				window.location.href = "continue.php?reference=" + this.uniqueid_;
			};
			
			// Redirect to continue page

		});
		// start by polash
		function set_url(url)
            {
			   document.location.href=url;
			
			}
		
		</script>
  
         <style>
		    a.ui-link
			{
			  text-decoration:none;
			}
		 </style>
  
</head>

<body>
	<header>
	
		<div class="content-box">
			<div class="nav-bar">
				<div><img class="logo" src="images/qooqo_logo.png" alt="" title=""></div>
				 <!--start by habib-->
				<nav>
					<li><a href="#"><img src="images/play.png" alt="play" title="play"></a></li>
					<li><a href="#" onclick='javscript:set_url("winners.php");'><img src="images/winners.png" alt="winners" title="winners"></a></li>
					<li><a href="#" onclick='javscript:set_url("help.php");' ><img src="images/help.png" alt="help" title="help"></a></li>
				</nav>
				<!--end by habib-->
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
		<div class="content-box" >
			<div class="free_lotto">
				<div class="lotto"></div>
			</div>
			<!-- -------------START Number Box Area ----------------->
			<div class="number_plate">
				<div class="number_box">
					<?php for($i=1;$i<=49;$i++){?>
					<li><a href="#" class="lotterynumber" ><?php echo $i; ?></a></li>
					<?php } ?>
					
       			</div>
				<!-- -------------END Number Box Area ----------------->
				
					<!-- -------------START Delete/ Refresh Area ----------------->
			        <div class="number_icons">
						<a href="#" id="reset" class="btn empty"><img src="images/recycle.gif" ></a>
						<a href="#" id="randomize" class="btn reload"><img src="images/refresh.gif"></a>
				    </div>
					<!-- -------------END Delete/ Refresh Area ----------------->
					
					<!-- -------------START Choise Area ----------------->
					 <div id="information_row">
                        <span>Please choose <span></span> more numbers.</span>
                        <span>Please wait while we are generating your QR-code ...</span>
                        <span>In order to play please click on the QR-code</span>
                    </div>
                   
					
					<div class="your_choice">Your Choice</div>
				
					<div id="lotterychosen" class="grey_bg_rows rows"></div>

					<!-- -------------END Choice Area ----------------->
				
				<!-- -------------START Play with ----------------->
			
					<div class="play_with">
					 
						<div class="play_with_text">Play with</div>
						<div class="qooqo_btn_holder"><a class="qooqo_btn_bg applink ui-link" href="#"><img class="qoqo_btn_img" src="img/qooqo_logo.png" alt="qooqo Btn" style='margin-right:20px;'/></a></div>
                    </div>
		        <!-- ------------- END Play with ----------------->
			</div>
		</div>
	<!-- -------------END Middle Area ----------------->		
	</section>
<!-- -------------START Footer ----------------->
<footer>
		<div class="content-box">
			<div class="footer_bar"> 
				<p>&copy; 2013 qooqo FreeLotto &bull; All rights reserved.</p>
					
				<div class="nav_footer">
					<li><a href="http://www.qooqo.com/index.php/contact.html"><img src="images/contact.png"></a></li>
					<li><a href="download.php"><img src="images/download.png"></a></li>
				</div>				
			</div>
		</div>
	</footer>
<!-- -------------END Footer ----------------->	
<style>
 a
 {
   text decoration:none;
   
 }
 .ui-li .ui-btn-text a.ui-link-inherit {
    overflow: none;
    text-overflow: none;
    white-space: none;
}

</style>

</body>
</html>

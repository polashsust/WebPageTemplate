<?php
// Straight back to index if no reference is specified
if (!isset($_GET["reference"])) {
	header("Location: index.php");
	exit(EXIT_SUCCESS);
}

// qooqo breaks like this:
// nk3d3o4dh82w0n7hszrs8fhsqxsp8gjl4k8lq5vf?transactionid=91ca025a-52f5-4b7c-b39c-248204c37097
// hackmode!
$sReference = $_GET["reference"];
if (false !== ($iOffset = strpos($sReference, "?"))) {
	$sReference = substr($sReference, 0, $iOffset);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Free Lotto</title>
        <link href='http://fonts.googleapis.com/css?family=Combo' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/themes/qooqo.min.css" />
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile.structure-1.3.2.min.css" />
        <link rel="stylesheet" href="css/ew_style.css" />
        <script src="js/jquery-1.10.2.min.js"></script>
        <script src="js/jquery.mobile-1.3.2.min.js"></script>
        <script src="js/payment.js"></script>
		<script src="js/fortunor.js"></script>
		<script>
		$().ready(function(){
			var reference = <?php echo json_encode($sReference) ?>;
			var payment = new Payment();
			
			payment.onpaymentsucceeded = function(){
				// perform fortunor
				var fortunor = new Fortunor(this);
				
				fortunor.onsubmitsucceeded = function(data){
					// Show numbers
					$("#lotterynumbers").html(data.digits.join(', ') + " + " + data.additionaldigit);
					$("#lotterydate").html(data.date);
					
					// Show name
					if (!!data.customer && !!data.customer.gender && !!data.customer.given && !!data.customer.name) {
						$("#salutation").html((data.customer.gender ? "Mr." : "Mrs.") + " "
											+ data.customer.given + " "
											+ data.customer.name);
					}
					
					$("#c_information").hide();
					$("#c_lottery").show();
				};
				
				fortunor.submit();
			};
			
			payment.initUniqueId(reference);
		});
		</script>
    </head>
    <body>
        <div data-role="page" data-theme="a" id="info">
            <div data-role="header" data-position="fixed">
                <a rel="external" data-ajax="false" data-rel="back" href="index.php" class="back_btn">Back</a>
                <h1>
					<img src="img/free-loto.png" alt="Free Lotto" />
				</h1>
            </div>
            <div id="c_information" data-role="content" data-theme="a">
				<h2>Please wait</h2>
				<p>We are currently submitting your lottery numbers...</p>
            </div>
			<div id="c_lottery" data-role="content" data-theme="a" style="display:none">
				<h2>Thank you <span id="salutation"></span></h2>
				<p>Your numbers: <span id="lotterynumbers"></span></p>
				<p>Draw date: <span id="lotterydate"></span></p>
			</div>
        </div><!-- Help -->
    </body>
</html>
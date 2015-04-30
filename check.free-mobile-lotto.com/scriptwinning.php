<?php
require_once 'lotto/dbconnection.php';
require_once 'lotto/PHPMailClass/MySMTPMailer.class.php';
//yesterday
$now  =  time () - (86400) ; 
$date=  ( date ( "Y-m-d" , $now ));

//$date =date('Y-m-d');
//$date = '2013-09-18';
$url = "https://lotto-request.fortunor.de/demoservice/get_draws.php?login=pay4&password=YD1w6HxLeP3K0A9y5z7BzGChr5JHjXDc&lotterydate=$date";
$data = file_get_contents($url);
//print_r($file);

	$data_array = explode(';',$data);
	/* print "<pre>";
	print_r($data_array);
	print "</pre>"; */
	$date_val = $data_array['0'];
	$data_val = $data_array['1'];
	$num_arr = explode(',',$data_array['1']);
	if(count($num_arr)>1){
		 $updatedtime =date('Y-m-d H-i-s');	
		 $sql = mysql_query("select id from lottoresult where date='$date'");
		 $result = mysql_fetch_assoc($sql);
		 if(empty($result)){
			 mysql_query("insert into  lottoresult (date, number1, number2, number3, number4, number5, number6,number7,updatedtime)
			  values('$date_val','$num_arr[0]','$num_arr[1]','$num_arr[2]','$num_arr[3]','$num_arr[4]','$num_arr[5]','$num_arr[6]','$updatedtime')");
			  echo "$data insert successfully!";
          }
	    else
		    {
			$mail = new MySMTPMailerClass;
			echo $body = "There is exist lottery information'$data_val' for the date of ".$date;
	        $subject = 'Notification for lotto lottery';
			$mail->sendMail($subject, $body);
		    }
		}
		
	else
	{		
			$mail = new MySMTPMailerClass;
	              echo $body = 'There is no lottery information for this date '.$date;
	              $subject = 'Notification for lotto lottery';
			$mail->sendMail($subject, $body);
	}
	

/* echo $mydataDate = mysql_real_escape_string($mydataArray[0]);

print "<pre>";
print_r($mydataArray);
print "</pre>"; 

 $mydataArrayAgain = explode(',',$mydataArray[1]); 

print "<pre>";
print_r($mydataArrayAgain);
print "</pre>";
echo $mydataArrayAgain[0];
echo $mydataArrayAgain[6]; 

$date = (empty($mydataArray[0]) ? "NO Date" : $mydataArray[0]); 
$num1 = (empty($mydataArrayAgain[0]) ? "0" : $mydataArrayAgain[0]); 
$num2 = (empty($mydataArrayAgain[0]) ? "0" : $mydataArrayAgain[1]); 
$num3 = (empty($mydataArrayAgain[0]) ? "0" : $mydataArrayAgain[2]); 
$num4 = (empty($mydataArrayAgain[0]) ? "0" : $mydataArrayAgain[3]); 
$num5 = (empty($mydataArrayAgain[0]) ? "0" : $mydataArrayAgain[4]); 
$num6 = (empty($mydataArrayAgain[0]) ? "0" : $mydataArrayAgain[5]); 
$num7 = (empty($mydataArrayAgain[0]) ? "0" : $mydataArrayAgain[6]);
$updatedtime =date('Y-m-d');

$sql = "INSERT INTO lottoresult (date, number1, number2, number3, number4, number5, number6,number7,updatedtime) VALUES ('".$date."',".$num1.",".$num2.",".$num3.",".$num4.",".$num5.",".$num6.",".$num7.",'".$updatedtime."')";
print_r($sql);

$res = mysql_query($sql)OR die(mysql_error()); */
?> 

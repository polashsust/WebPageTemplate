<html lang="en">
<head>
<meta charset="utf-8" />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="css/datepicker.css" />
<style>
   
.ui-btn-inner {
    display: block;
    font-size: 22.88px;
    width: 28px;
    overflow: hidden;
    padding: 0.2em 5px 0px 0.4em;
    position: relative;
	height: 28px;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-family:Combo;
	
	background: none repeat scroll 0 0 #999999;
    color: #FFFFFF;	

}

.ui-btn-inner-active
{
    display: block;
     font-size: 22.88px;
    width: 28px;
    overflow: hidden;
    padding: 0.2em 5px 0px 0.4em;
    position: relative;
	height: 28px;
    text-overflow: ellipsis;
	font-family:Combo;
    white-space: nowrap;
	background: none repeat scroll 0 0 #F76855;
    color: #FFFFFF;	

}
</style>


<script>

$(function() {
 	$('#datepicker').datepicker({
	  maxDate: '+0d',	
      dateFormat: 'dd.mm.yy'
});
});

/* $(function() {
    $( "#datepicker" ).datepicker({maxDate: '+0d'})({
    dateFormat: "mm.dd.yyyy",
    defaultDate: "09.10.2013",
    minDate: "01.01.1925",
    maxDate: "12.31.2014",
    changeMonth: true,
    changeYear: true,
    yearRange: "1925:2015",
    onClose: function(dateText, inst) {
        var validDate = $.datepicker.formatDate( "mm.dd.yy", $('#datepicker').datepicker('getDate'));
            $('#datepicker').datepicker('setDate', validDate);
        }
    });
}); */
//disable future date
//http://articles.tutorboy.com/2010/09/03/jquery-ui-datepicker-disable-specified-dates/ 

/* $(function() {
    $("#datepicker").datepicker({maxDate: '+0d'});
});


 */
/* //shows all date
$(function() {
$( "#datepicker" ).datepicker({
changeMonth: true,
changeYear: true
});
}); */

/*
//disable past dates 
$(function() {
          $('#datepicker').datepicker({minDate: 0});
    }); */
	
/* //wed & friday off
$("#dp").datepicker({
  beforeShowDay: function(date){ return [date.getDay() == 3 || date.getDay() == 5,""]}
});
	 */
</script>
</head>
<body>
     <div id="lotterychosen" class="grey_bg_rows rows" style='margin-bottom:16px;font-size:13px;color:#999999;width:510px;float:left;font-family:arial;' >
			     <div style='margin-right:50px;float:left;width:100px;'>Date
				 </div>
			    <div style='float:left;margin:0px 2px 2px 0px;'>Winning Numbers</div>
	</div>			
<?php
    include_once('dbconnection.php');
 	$now  =  time() - (86400); 
	$date =  (date( "Y-m-d", $now ));
    $htime = strtotime($date)+3600*24;
    $ltime = $htime - 7*24*3600;
	$twoweeks =(date("Y-m-d", $ltime ));
	
	$sql = mysql_query("select * from lottoresult where date between '$twoweeks' and '$date'");
	$num_rows = mysql_num_rows($sql);
	if ($num_rows ==0){
	
	 echo "<span style='color:#F36858; font-family:combo; font-size:14px;'>there is no lottery result information between ".$twoweeks." and ".$date." </span>" ;

	}
  else {
    $check =1;
	for($i=$htime;$i>=$ltime;$i-=(24*3600))
	{	
           $time = time();	
		   $date =date('Y-m-d',$i);
		 $sql = mysql_query("select * from lottoresult where date='$date' ");
		 
		 $row = mysql_fetch_assoc($sql);
		 if(!empty($row)){
		          $sys_date =date('d.m.Y');
		     $date = date('d.m.Y',strtotime($row['date']));
			 if($check==1)
			       $class ='ui-btn-inner-active';
			 else
			      $class ='ui-btn-inner';
			// echo $date ;
			 ?>
			
			 <div id="lotterychosen" class="grey_bg_rows rows" style='width:510px;float:left;' >
			     <div style='margin-right:50px;float:left;font-size:17px;width:100px;<?php if($check==1) {echo "color:#4a4a48;line-height:48px;height:48px;"; }else{echo "color:#adadad;line-height:36px;height:36px;";}?>' ><?php  echo $date ;?>
				 </div>
			    <div style='float:left;margin:0px 2px 2px 0px;'>
				<span class="<?php echo $class;?>"><span class="ui-btn-text"><?php echo $row['number1'];?></span></span>
				</div>
				 <div style='float:left;margin:0px 2px 2px 0px;'>
			    <span class="<?php echo $class;?>"><span class="ui-btn-text"><?php echo $row['number2'];?></span></span>
			    </div>
				 <div style='float:left;margin:0px 2px 2px 0px;'>
			    <span class="<?php echo $class;?>"><span class="ui-btn-text"><?php echo $row['number3'];?></span></span>
				</div>
				 <div style='float:left;margin:0px 2px 2px 0px;'>
			    <span class="<?php echo $class;?>"><span class="ui-btn-text"><?php echo $row['number4'];?></span></span>
				</div>
				 <div style='float:left;margin:0px 2px 2px 0px;'>
			    <span class="<?php echo $class;?>"><span class="ui-btn-text"><?php echo $row['number5'];?></span></span>
				</div>
				 <div style='float:left;margin:0px 2px 2px 0px;'>
			    <span class="<?php echo $class;?>"><span class="ui-btn-text"><?php echo $row['number6'];?></span></span>
				</div>
				 <div style='float:left;margin:0px 2px 2px 0px;'>
			    <span class="<?php echo $class;?>"><span class="ui-btn-text"><?php echo $row['number7'];?></span></span>
				</div>
			 </div>
			 
			  <?php
			  //echo $date .' ; '.$row['number1'].' , '.$row['number2'].' , '.$row['number3'].' , '.$row['number4'].' , '.$row['number5'].' , '.$row['number6'].' , '.$row['number7']."</br>";
		 $check++;
		}
	 
	}
	}
	
?>		
<div style="width:30px; margin-bottom:36px;visibility: hidden;">.</div>
<div id="lotterychosen" class="grey_bg_rows rows" style='width:510px;float:left;' >

<form action="" method='post'>
    
		<span style='color:#F36858; font-family:"go_boomregular"; font-size:22.35px; font-weight:bold; margin-top:20px;'>Search date:&nbsp;&nbsp;&nbsp;&nbsp;</span> 
		<input type="text" name="date_box" id="datepicker"  style='color:#a0a0a0;width:174px;height:40px;padding-left:80px;' value='<?php if(isset($_POST['date_box'])) echo $_POST['date_box']; else echo date('d.m.Y'); ?>'/>
       <input type='submit' name='search' value='Search' style=' color: #fef5f4;width:90px;height:40px;border:0px; font-size:13px;background-color:#f66753;'>
 
  </form>	
</div>	
<?php

    $i=1;
   	if(isset($_POST['search']))
	{
	   
		if(trim($_POST['date_box'])=='' )
		       echo "<span style='color:#F36858; font-family:combo; font-size:14px;'>Please select date</span></br>";
		else if (count( explode('.',$_POST['date_box']))==3)
        {		
		$date_array= explode('.',$_POST['date_box']);	
		
		 $date = $date_array['2'].'.'.$date_array['1'].'.'.$date_array['0'];
	     $sql = mysql_query("select * from lottoresult where date='$date'");
	     $row = mysql_fetch_assoc($sql);
		  if(!empty($row)){
		     
			 $date = date('d.m.Y',strtotime($row['date']));
			 ?>
			  <div id="lotterychosen" class="grey_bg_rows rows" style='width:510px;float:left;' >
			     <div style='margin-right:50px;float:left;font-size:17px;width:100px;color:#adadad;line-height:36px;height:36px;'><?php  echo $date ;?>
				 </div>
			    <div style='float:left;margin:0px 2px 2px 0px;'>
				<span class="ui-btn-inner"><span class="ui-btn-text"><?php echo $row['number1'];?></span></span>
				</div>
				 <div style='float:left;margin:0px 2px 2px 0px;'>
			    <span class="ui-btn-inner"><span class="ui-btn-text"><?php echo $row['number2'];?></span></span>
			    </div>
				 <div style='float:left;margin:0px 2px 2px 0px;'>
			    <span class="ui-btn-inner"><span class="ui-btn-text"><?php echo $row['number3'];?></span></span>
				</div>
				 <div style='float:left;margin:0px 2px 2px 0px;'>
			    <span class="ui-btn-inner"><span class="ui-btn-text"><?php echo $row['number4'];?></span></span>
				</div>
				 <div style='float:left;margin:0px 2px 2px 0px;'>
			    <span class="ui-btn-inner"><span class="ui-btn-text"><?php echo $row['number5'];?></span></span>
				</div>
				 <div style='float:left;margin:0px 2px 2px 0px;'>
			    <span class="ui-btn-inner"><span class="ui-btn-text"><?php echo $row['number6'];?></span></span>
				</div>
				 <div style='float:left;margin:0px 2px 2px 0px;'>
			    <span class="ui-btn-inner"><span class="ui-btn-text"><?php echo $row['number7'];?></span></span>
				</div>
			 </div>
			 <?php 
			 //echo $date .' ; '.$row['number1'].' , '.$row['number2'].' , '.$row['number3'].' , '.$row['number4'].' , '.$row['number5'].' , '.$row['number6'].' , '.$row['number7']."</br></br>";
         $i++;		
		}
		else {
				$date = $date_array['2'].'-'.$date_array['1'].'-'.$date_array['0'];
				$date1 = $date_array['0'].'.'.$date_array['1'].'.'.$date_array['2'];
				$url = "http://lotto-request.fortunor.de/demoservice/get_draws.php?login=pay4&password=YD1w6HxLeP3K0A9y5z7BzGChr5JHjXDc&lotterydate=$date";
				$data = file_get_contents($url);
				$data_array = explode(';',$data);
				$date_val = $data_array['0'];
				$data_val = $data_array['1'];
				$num_arr = explode(',',$data_array['1']); 
			if(count($num_arr)>1){
			   	  $updatedtime =date('Y-m-d H-i-s');	
				 mysql_query("insert into  lottoresult (date, number1, number2, number3, number4, number5, number6,number7,updatedtime)
			       values('$date_val','$num_arr[0]','$num_arr[1]','$num_arr[2]','$num_arr[3]','$num_arr[4]','$num_arr[5]','$num_arr[6]','$updatedtime')");
	
			 ?>
					  <div id="lotterychosen" class="grey_bg_rows rows" style='width:510px;float:left;' >
						 <div style='margin-right:50px;float:left;font-size:17px;width:100px;color:#adadad;line-height:36px;height:36px;'><?php  echo $date1 ;?>
						 </div>
						<div style='float:left;margin:0px 2px 2px 0px;'>
						<span class="ui-btn-inner"><span class="ui-btn-text"><?php echo $num_arr['0'];?></span></span>
						</div>
						 <div style='float:left;margin:0px 2px 2px 0px;'>
						<span class="ui-btn-inner"><span class="ui-btn-text"><?php echo $num_arr['1'];?></span></span>
						</div>
						 <div style='float:left;margin:0px 2px 2px 0px;'>
						<span class="ui-btn-inner"><span class="ui-btn-text"><?php echo $num_arr['2'];?></span></span>
						</div>
						 <div style='float:left;margin:0px 2px 2px 0px;'>
						<span class="ui-btn-inner"><span class="ui-btn-text"><?php echo $num_arr['3'];?></span></span>
						</div>
						 <div style='float:left;margin:0px 2px 2px 0px;'>
						<span class="ui-btn-inner"><span class="ui-btn-text"><?php echo $num_arr['4'];?></span></span>
						</div>
						 <div style='float:left;margin:0px 2px 2px 0px;'>
						<span class="ui-btn-inner"><span class="ui-btn-text"><?php echo $num_arr['5'];?></span></span>
						</div>
						 <div style='float:left;margin:0px 2px 2px 0px;'>
						<span class="ui-btn-inner"><span class="ui-btn-text"><?php echo $num_arr['6'];?></span></span>
						</div>
					 </div>
					 <?php 
					 //echo $date .' ; '.$row['number1'].' , '.$row['number2'].' , '.$row['number3'].' , '.$row['number4'].' , '.$row['number5'].' , '.$row['number6'].' , '.$row['number7']."</br></br>";
				 $i++;		
		      }
			  else
				{
						$date = $date_array['0'].'.'.$date_array['1'].'.'.$date_array['2'];

				  echo "<span style='color:#F36858; font-family:combo; font-size:14px;'>There is no lottery information for the date of ".$date."</span>" ;
				
				}
		 }
  

		}	
       	 else
			{
			  echo "<span style='color:#F36858; font-family:combo; font-size:14px;'>Please select date in correct format.</span>" ;
			
			}		
		
	}

?>
</body>
</html>
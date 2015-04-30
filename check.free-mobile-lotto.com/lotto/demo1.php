<?php
   include_once('dbconnection.php');
	//current date 
	//$date =date('Y-m-d');
    //yesterday
	$now  =  time() - (86400); 
	$date =  (date( "Y-m-d", $now ));
    $htime = strtotime($date);
    $ltime = $htime - 14*24*3600;
	$twoweeks =(date("Y-m-d", $ltime ));
	
	$sql = mysql_query("select * from lottoresult where date between '$twoweeks' and '$date'");
	$num_rows = mysql_num_rows($sql);
	if ($num_rows ==0){
	echo "there is no information between '$twoweeks' and '$date' i.e last two weeks";
	}
	
	else {
	for($i=$ltime;$i<=$htime;$i+=(24*3600))
	{	
		 $time = time();	
		 $date =date('Y-m-d',$i);
		 $sql = mysql_query("select * from lottoresult where date='$date'");
		 
		 $row = mysql_fetch_assoc($sql);
		 if(!empty($row)){
			  echo $row['date'] .' ; '.$row['number1'].' , '.$row['number2'].' , '.$row['number3'].' , '.$row['number4'].' , '.$row['number5'].' , '.$row['number6'].' , '.$row['number7']."</br></br>";
		 }

	}
}
	/* if($row > 0 ){
		 
		  echo $row['date'] .' ; '.$row['number1'].' , '.$row['number2'].' , '.$row['number3'].' , '.$row['number4'].' , '.$row['number5'].' , '.$row['number6'].' , '.$row['number7']."</br></br>";
		  }
		  else {
		  echo "there is no information between '$twoweeks' and '$date' i.e last two weeks";
		  
		  } */
		  
		  	
	function month_box($sel='')
	{
        $month = array("01","02","03","04","05","06","07","08","09","10","11","12", "14");
		$month_detail = array("January","February","March","April","May","June","July","August","September","October","November","December","12");
		$str="";
        for($i=0;$i<count($month);$i++)
        {
		 
			$str .="<option value='".sprintf('%02d',$i)."'>".$month_detail[$i]."</option>";
        }
        return $str;
	}
	
	
	function now()
	{
		return date("Y-m-d H:i:s");
	}
	
	function day_box($sel='')
	{
		$str="";
		for($i=1;$i<=31;$i++)
		{
			
				$str .="<option value='".sprintf('%02d',$i)."'>".sprintf('%02d',$i)."</option>";
		}
		return $str;
	}
	
	function year_box($sel='')
	{
		$str="";
		$year=date('Y');
		for($i=2000;$i<=$year+1;$i++)
		{
			if($i==$sel)
				$str .="<option value='".$i."' selected>".$i."</option>";
			else
				$str .="<option value='".$i."'>".$i."</option>";
		}
		return $str;
	}
	

	
?>		
<form action="" method='post'>
    Search date 
	<select name='day'>
	         <option value=''>Select day</option>
			 <?php echo day_box();?>
	</select>
	<select name='month'>
	         <option value=''>Select month</option>
			 <?php echo month_box();?>
	</select>
	<select name='year'>
	         <option value=''>Select year</option>
			 <?php echo year_box();?>
	</select>
   <input type='submit' name='search' value='Search'>
</form>	

<?php

    
   	if(isset($_POST['search']))
	{
	    
		$check =1;
		if($_POST['day']=="")
		    {
	         echo "<span style='color:red;'>Please select day</span></br>";
			 $check=0; 
			 }
	    if($_POST['month']=="")
		    {
	        echo "<span style='color:red;'>Please select month</span></br>";
			  $check=0; 
			 }
			 
        if($_POST['year']=="")
		    {
	        echo "<span style='color:red;'>Please select year</span></br>";	 
		       $check=0; 
			 }
		if($check==1)
        {		
		$date = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
	    $sql = mysql_query("select * from lottoresult where date='$date'");
		 
		 $row = mysql_fetch_assoc($sql);
		 if(!empty($row)){
		     
			 echo $row['date'] .' ; '.$row['number1'].' , '.$row['number2'].' , '.$row['number3'].' , '.$row['number4'].' , '.$row['number5'].' , '.$row['number6'].' , '.$row['number7']."</br></br>";
		 }
		 else
			{
			  echo "<span style='color:red;'>There is no data for this date ".$date."</span>" ;
			
			}
	    }
	}
	


?>
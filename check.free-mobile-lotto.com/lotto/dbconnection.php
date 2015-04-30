<?php
//create connection
$host="localhost"; // Host name
$username="root"; // Mysql username
$password="p4sql"; // Mysql password
$db_name="freelotto"; // Database name

$db_link = mysql_connect("$host", "$username", "$password") or die("cannot connect");
$db = mysql_select_db("$db_name",$db_link)or die("cannot select DB");
?>



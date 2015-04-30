<?php
include "MySMTPMailer.class.php";

    $subject   = "BPC Lastschrift Export ".date('d.m.Y')." geprueft. // Keine Exporte generiert";
    
    $body     .= "This is test mail from Polash.<br />\n";
    $body     .= "<br />\n";
    $body     .= "Speicherort: $sProjectPath<br />\n";
    $body     .= "Server: $sServerIP<br />\n";
    $body     .= "<br />\n";
    $body     .= "<br />\n";
    $body     .= "Return:";
    $body     .= "<br />\n";
    $body     .= $bcdReturn."<br />\n";

$cde = new MySMTPMailerClass;
var_dump($cde->sendMail($subject, $body));
?>

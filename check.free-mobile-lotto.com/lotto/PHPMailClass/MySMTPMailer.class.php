<?php
require_once('phpmailer/class.phpmailer.php');
/**
 * MySMTPMailerClass
 *
 * MySMTPMailerClass sends an email via SMTP.
 * 
 * @author Christian Herx, herx -at- p4-solutions.de
 * @version $Id: MySMTPMailer.class.php 1 2013-04-12 10:34:21Z herx $
 */
class MySMTPMailerClass
{
    /**
     * sendMail(): Send an email
     *
     * @param    string $sSubject email subject 
     * @param    string $sBody email body 
     *
     * @return   string
     */
    //public function sendMail($sSubject, $sBody, $sAttached_CSV)
	public function sendMail($sSubject, $sBody)
    {
        $mail = new PHPMailer();
        
        $mail->IsSMTP();  // telling the class to use SMTP
        $mail->CharSet    = 'utf-8';
        $mail->Host       =  "mail.pay4.net"; // SMTP server
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = true;
        $mail->Username   = "noreply@pay4.eu";
        $mail->Password   = "si9YQI0i";
        
        $mail->AddAddress("sarker@p4-solutions.de","Polash p4 Solutions");
		//$mail->AddAddress('ellen@example.com');  
        $mail->SetFrom("technik@pay4.eu","Pay4 Technik Department");
        //$mail->AddReplyTo('info@example.com', 'Information');
		//$mail->AddCC('cc@example.com');
		//$mail->AddBCC('bcc@example.com');
		
        $mail->Subject  = $sSubject;
        
        $mail->WordWrap = 150;
		
		//AddAttachment($path,$name,$encoding,$type);
		//$mail->AddAttachment($sAttached_CSV);         // Add attachments
		//$mail->AddAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        
        $mail->IsHTML(true);
        $mail->Body = $sBody;
        
        //$mail->MsgHTML($sBody);
        
        $textMsg = trim(strip_tags($sBody));
        $mail->AltBody = $textMsg;
        
        if(!$mail->Send())
        {
            $body = "";
            return 'Mailer error: ' . $mail->ErrorInfo."\n";
        }
        else
        {
            $body = "";
            return "Message has been sent.\n";
        }
    }
}
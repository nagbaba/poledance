<?php
	$subject = "Title: epolejudge test message";
  $body = "Body: epolejudge test message";
	$headers = "MIME-Version: 1.0\n";
  $headers .= "Content-Type: text/html; charset=windows-1254\n";
  $headers .= "From: Epolejudge website <info@epolejudge.com.au>\n";
  $headers .= "X-Mailer: Epolejudge website";
  mail("testing@completeinternet.com.au",$subject,$body,$headers); 
?>
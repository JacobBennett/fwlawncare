<?php

// extract($_POST);

if(empty($_POST)) { echo "fail"; exit;}

foreach ($_POST as $key => $value) {
	if($value == "") {
		print_r(json_encode(array('status'=>"error", 'message'=>'Please fill out form.')));
		exit;
	}
}

$from_name = $_POST["name"];
$from_email = $_POST["email"];
$to_email = "me@jakebennett.net";
// $to_email = "lawncare@fwlawncare.com";
$mail_body =  $_POST["message"];
$subject = "New email from fwlawncare.com";
$header = "From: ". $from_name . " <" . $from_email . ">\r\n"; //optional headerfields 

mail($to_email, $subject, $mail_body, $header); //mail command :) 


print_r(json_encode(array('status'=>"success", 'message'=>'<h3>Thanks for your e-mail</h3><p>We will be in touch soon</p>')));

?>
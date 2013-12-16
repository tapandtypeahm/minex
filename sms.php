<?php
$url="http://www.freesmsgateway.com/api_send";
$post_contacts=array('9824143009');
$json_contacts=json_encode($post_contacts);
$fields=array('access_token'=>'e12e04e569a4e39f92a44857d4ba1400',
				'message'=>urlencode('this is a test message from tapandtype.com'),
				'send_to'=>"post_contacts",
				'post_contacts'=>urlencode($json_contacts));
				
$fields_string="";

foreach($fields as $key=>$value)
{
	$fields_string=$fields_string.$key."=".$value."&";
	}				
rtrim($fields_string);

$ch=curl_init();

curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);

$result=curl_exec($ch);
curl_close($ch);



 ?>
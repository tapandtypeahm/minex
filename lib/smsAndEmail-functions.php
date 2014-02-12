<?php 
require_once("cg.php");
require_once("common.php");
require_once("bd.php");

function sendAnEmail()
{
	

}

function sendanSMS()
{
	
}

function sendanSMSTemp()
{
	$mobile_no_array=array('8128080412','9428592016','9978919232');
	foreach($mobile_no_array as $mobile_no)
	{
	$message= "A new MDI has been initiated. Please login in to your system to get more info.";
	$url = 'bulksms.mysmsmantra.com:8080/WebSMS/SMSAPI.jsp';

    /* $_GET Parameters to Send */
    $params = array('username' => 'jeetpatel', 'password' => '1167847497', 'sendername' => 'mainex', 'mobileno' => $mobile_no, 'message' => $message);

    /* Update URL to container Query String of Paramaters */
    $url .= '?' . http_build_query($params);

    /* cURL Resource */
    $ch = curl_init();

    /* Set URL */
    curl_setopt($ch, CURLOPT_URL, $url);

    /* Tell cURL to return the output */
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    /* Tell cURL NOT to return the headers */
    curl_setopt($ch, CURLOPT_HEADER, false);

    /* Execute cURL, Return Data */
    $data = curl_exec($ch);

    /* Check HTTP Code */
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    /* Close cURL Resource */
    curl_close($ch);
	}
}
?>
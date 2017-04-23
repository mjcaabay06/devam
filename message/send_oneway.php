<?php
//
session_start();
include("../include/configuration.php");
include("../include/general_functions.php");

if($_POST){
	switch(strtolower($_POST['action'])){
		case "sendmsg":
			$parameters = array(
			    'apikey' => 'eb8d6ed63c89ee953de368b110328f18', //API KEY
			    'number' => '09177629194',
			    'message' => urldecode($_POST['message']),
			    'sendername' => 'SEMAPHORE'
			);			
			$response = sendViaSemaphore($parameters);
			if(!empty($response) && strtolower($response[0]->status) == 'queued'){
				echo "<div style='text-align:center;'><h1>Message Sent!</h1></div>";
			}
		break;
		default:
		break;
	}
}
?>
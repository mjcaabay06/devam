<?php
session_start();
include("../include/configuration.php");
include("../include/general_functions.php");

if($_POST){
	switch(strtolower($_POST['action'])){
		case "sendmsg":
			$errorSending = array();
			$diffError = '';
			$getReceivers = getMsgReceivers();
			$parameters = array(
			    //'apikey' => 'eb8d6ed63c89ee953de368b110328f18', //API KEY
			    'apikey' => '544da9805f3e16674cb81361a29dec43',
			    'message' => urldecode($_POST['message']),
			    'sendername' => 'SEMAPHORE'
			);
			foreach($getReceivers as $receiver){
				$parameters['number'] = trim($receiver['mobile_number']);		
				$response = sendViaSemaphore($parameters);

				if(empty($response) || !isset($response[0]->status)){
					if(isset($response[0])){ //different error
						$diffError = $response[0];
					}
					$errorSending[] = $receiver['mobile_number'];
				}
			}
			
			if(empty($errorSending)){
				echo "<div style='text-align:center;'><h1>Message Sent!</h1></div>";
			}else{
				$mnumbers = '';
				foreach($errorSending as $mobileNumber){
					$mnumbers .= $mobileNumber."<br/>";
				}
				echo "<h4>There was an error sending text message to the following mobile numbers:</h4><br/>".$mnumbers;
				if($diffError != ''){
					echo "<br/><br/>Reason:<br/>".$diffError;
				}	
			}
		break;
		case 'sendsnglmsg':
			$errorSending = array();
			$diffError = '';
			$getReceivers = getMsgReceivers();
			$parameters = array(
			    //'apikey' => 'eb8d6ed63c89ee953de368b110328f18', //API KEY
			    'apikey' => '544da9805f3e16674cb81361a29dec43',
			    'number' => trim($_POST['phone']),
			    'message' => urldecode($_POST['message']),
			    'sendername' => 'SEMAPHORE'
			);
			$response = sendViaSemaphore($parameters);

			if(empty($response) || !isset($response[0]->status)){
				if(isset($response[0])){ //different error
					$diffError = $response[0];
				}
				$errorSending = $_POST['phone'];
			}
			
			if(empty($errorSending)){
				echo "<div style='text-align:center;'><h1>Message Sent!</h1></div>";
			}else{
				echo "<h4>There was an error sending text message tO:</h4><br/>".$errorSending;
				if($diffError != ''){
					echo "<br/><br/>Reason:<br/>".$diffError;
				}	
			}
		break;
		default:
			echo "You are not allowed to access this page.";
		break;
	}
}else{
	echo "You are not allowed to access this page.";
}
?>
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
			    'apikey' => '5fba8ff3f13680b72a029080e0d3a96e',
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
		default:
			echo "You are not allowed to access this page.";
		break;
	}
}else{
	echo "You are not allowed to access this page.";
}
?>
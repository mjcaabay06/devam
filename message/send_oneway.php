<?php
if($_POST){
	switch(strtolower($_POST['action'])){
		case "sendmsg":

			$parameters = array(
			    'apikey' => 'eb8d6ed63c89ee953de368b110328f18', //API KEY
			    'number' => '09177629194',
			    'message' => 'Hi Fella! We just want to inform you about our new system that will surely help you. If you have other question you can just message us through some codes. Thank you!',
			    
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

function sendViaSemaphore($parameters){
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL,'http://api.semaphore.co/api/v4/messages' );
	curl_setopt( $ch, CURLOPT_POST, 1 );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	$output = curl_exec( $ch );
	curl_close ($ch);

	return json_decode($output);
}

?>
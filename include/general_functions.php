<?php

function checkLogin($username, $password){
	global $dbh;	
	$isAuthenticated = false;

	$chkLogin = $dbh->prepare("SELECT * FROM users WHERE username = :uname AND password = :pass AND user_type_id = 1");
	$chkLogin->execute(array(":uname" => $username, ":pass" => encryptPass($password)));
	$results = $chkLogin->fetch();

	if(!empty($results)){
		$_SESSION['AuthId'] = $results['id'];
		$_SESSION['username'] = $results['username'];
		$isAuthenticated = true;
	}

	return $isAuthenticated;
}

function encryptPass($password){
	$cryptKey = 'encrypt-pass';
	$cryptPass = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $password, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );

	return $cryptPass;
}

function decryptPass($password){
	$cryptKey = 'encrypt-pass';
	$dcrypt = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode($password ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");

	return $dcrypt;
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
<?php
include("../include/configuration.php");
session_start();

if($_POST){
	if(checkLogin($_POST['username'], $_POST['passwd'])){
		header("Location: admin/");		
	}else{		
		echo "You are not authenticated.";
	}
}

function checkLogin($username, $password){
	global $dbh;	
	$isAuthenticated = false;

	$chkLogin = $dbh->prepare("SELECT * FROM users WHERE username = :uname AND password = :pass AND user_type_id = 1");
	$chkLogin->execute(array(":uname" => $username, ":pass" => base64_decode($password)));
	$results = $chkLogin->fetch();

	if(!empty($results)){
		$_SESSION['AuthId'] = $results['id'];	
		$isAuthenticated = true;
	}

	return $isAuthenticated;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="row">	
				<form id="frmlogin" action="" method="post" style="width:500px;margin: 0 auto;">
					<input type="hidden" name="action" value="addmsg"/>
					<div class="form-group">
						<input class="form-control" type="text" name="username" id="username" placeholder="Username" />
					</div>
					<div class="form-group">
						<input class="form-control" type="text" name="password" id="password" placeholder="Password" />
					</div>
					<div class="form-group">
						<input class="form-control btn" type="submit" id="sublogin" value="Send" />
					</div>	
				</form>
			</div>
		</div>
	</body>
	<script>
		$("#frmlogin").validate({
			rules: {
				username: 'required',
				password: 'required'
			},
			submitHandler: function(form){
				form.submit();
			}
		});
	</script>
</html>
<?php
	session_start();
	include("../include/configuration.php");
	include("../include/general_functions.php");

	if($_POST){
		if(checkLogin($_POST['username'], $_POST['password'])){
			header("Location: ./");		
		}else{		
			$errorMessage = "You are not authenticated.";
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>DevAm</title>
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<link href="../css/custom.css" rel="stylesheet">
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						
					</div>
				</div>
			</div>
		</nav>
		<div class="container main-container">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2>User Login</h2>
						</div>
						<div class="panel-body">
							<!-- <form>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Username" />
								</div>
								<div class="form-group">
									<input type="password" class="form-control" placeholder="Password" /> -->
							<?php if($errorMessage != ''){?>	
								<div style="background-color: #d81717;color: #fff;margin-bottom: 12px;padding: 3px 9px;">
									<?=$errorMessage;?>
								</div>
							<?php } ?>
							<form id="frmlogin" action="" method="post">
								<div class="form-group">
									<input type="text" class="form-control" name="username" placeholder="Username" />
								</div>
								<div class="form-group">
									<input type="password" class="form-control" name="password" placeholder="Password" />
								</div>
								<div class="form-group col-sm-3 pull-right">
								<div class="row">
									<input type="submit" name="btn-submit" value="Login" class="form-control btn btn-primary" />
								</div>
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
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

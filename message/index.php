<?php
session_start();

if(!isset($_SESSION['AuthId']) || empty($_SESSION['AuthId'])){
	header("Location: login.php");
	exit;
}else{
	include("../include/configuration.php");
	include("../include/general_functions.php");
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
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<style>
			.msg-user-btn{
				border: 1px solid #000;
				border-radius: 5px;
				cursor: pointer;
				text-align: center;
			}
		</style>
	</head>
	<body>
		<div class="container main-container">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<div class="panel panel-default">
						<div class="panel-body" id="sndmsg-dv">
							<form method="post" action="">
								<div class="msg-user">
									<textarea class="form-control" name="message" id="msg" style="resize: none;height: 200px;margin-bottom: 20px;">Hi! We just want to inform you about our new system that will surely help your business! You can send us keyword to check the status of a product in International Market. Send us the keyword using this format: CMP<Product><CountryCode> Example: CMPRiceJP&#13;&#10;&#13;&#10;List of Crops you can check:&#13;&#10;Rice&#13;&#10;Sugar&#13;&#10;Coconuts&#13;&#10;Abaca&#13;&#10;Fruit&#13;&#10;Corn&#13;&#10;Rubber&#13;&#10;&#13;&#10;Country:&#13;&#10;Japan - JP&#13;&#10;United States - US&#13;&#10;&#13;&#10;We hope for your success! Have a great day!</textarea>
								</div>
								<div class="btn msg-user-btn" onclick="sendmsg();">Send them a message</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		function sendmsg(){
			$.ajax({
				url: "send_oneway.php",
				type: "post",
				data: {action:"sendmsg", message: encodeURIComponent($("#msg").val())},
				success: function(response){
					$("#sndmsg-dv").html(response);
				}
			});
		}
	</script>
</html>



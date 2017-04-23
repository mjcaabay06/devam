<?php
include("../include/configuration.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<style>
			.msg-users{
				border: 1px solid #000;
				border-radius: 5px;
				cursor: pointer;
				text-align: center;
			}
		</style>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">	
				<div class="col-md-12" id="sndmsg-dv">
					<div class="msg-users" onclick="sendmsg();"><h1>Send them a message!</h1></div>
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		function crmsg(){
			$.ajax({
				url: "message_window.php",
				data: {test: "test"},
				success: function(response){
					console.log(response);
				}
			});
		}

		function sendmsg(){
			$.ajax({
				url: "send_oneway.php",
				type: "post",
				data: {action:"sendmsg"},
				success: function(response){
					console.log(response);
					$("#sndmsg-dv").hmtl(response);
				}
			});
		}
	</script>
</html>



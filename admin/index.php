<?php
session_start();
include("../include/configuration.php");
include("../include/general_functions.php");

if(!isset($_SESSION['AuthId']) || empty($_SESSION['AuthId'])){
	header("Location: login.php");
	exit;
}
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>DevAm</title>
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>

		<link href="../css/custom.css" rel="stylesheet">
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-12">
						<div class="navbar-header hidden">aa</div>
						<ul class="nav navbar-nav">
							<li><a href="list-farmers.php">Farmers</a></li>
						</ul>
						<ul class="nav navbar-nav">
							<li><a href="list-products.php">Products</a></li>
						</ul>
						<ul class="nav navbar-nav">
							<li><a href="list-category.php">Categories</a></li>
						</ul>

						<div class="pull-right">
							<div class="dropdown">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						    		<?php echo $_SESSION['username']; ?>
						    		<span style="margin-left: 10px;margin-right: -5px;" class="caret"></span>
						    	</button>
						    	<ul class="dropdown-menu pull-right">
						    		<li class="hidden"><a href="#"><span class="hidden-sm"><span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;&nbsp;</span>Change Password</a></li>
									<li><a href="logout.php"><span class="hidden-sm"><span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;&nbsp;</span>Sign Out</a></li>
						    	</ul>
					    	</div>
						</div>
					</div>
				</div>
			</div>
		</nav>
		<div class="container main-container">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2>Send SMS Message</h2>
						</div>
						<div class="panel-body">
							<form method="post" action="">
								<div class="form-group msg-user">
									<textarea class="form-control" name="message" id="msg" style="resize: none;height: 200px;margin-bottom: 20px;">Hi! We just want to inform you about our new system that will surely help your business! You can send us keyword to check the status of a product in International Market. Send us the keyword using this format: CMP<Product><CountryCode> Example: CMPRiceJP&#13;&#10;&#13;&#10;List of Crops you can check:&#13;&#10;Rice&#13;&#10;Sugar&#13;&#10;Coconuts&#13;&#10;Abaca&#13;&#10;Fruit&#13;&#10;Corn&#13;&#10;Rubber&#13;&#10;&#13;&#10;Country:&#13;&#10;Japan - JP&#13;&#10;United States - US&#13;&#10;&#13;&#10;We hope for your success! Have a great day!</textarea>
								</div>
								<div class="form-group col-sm-4 pull-right">
									<div class="row">
										<input type="button" onclick="sendmsg();" name="btn-submit" value="Send them a message" class="form-control btn btn-primary msg-user-btn" />
									</div>
								</div>
							</form>
						</div>
					</div>
					<!-- <div class="panel panel-default">
						<div class="panel-body" id="sndmsg-dv">
							<form method="post" action="">
								<div class="msg-user">
									<textarea class="form-control" name="message" id="msg" style="resize: none;height: 200px;margin-bottom: 20px;">Hi! We just want to inform you about our new system that will surely help your business! You can send us keyword to check the status of a product in International Market. Send us the keyword using this format: CMP<Product><CountryCode> Example: CMPRiceJP&#13;&#10;&#13;&#10;List of Crops you can check:&#13;&#10;Rice&#13;&#10;Sugar&#13;&#10;Coconuts&#13;&#10;Abaca&#13;&#10;Fruit&#13;&#10;Corn&#13;&#10;Rubber&#13;&#10;&#13;&#10;Country:&#13;&#10;Japan - JP&#13;&#10;United States - US&#13;&#10;&#13;&#10;We hope for your success! Have a great day!</textarea>
								</div>
								<div class="btn msg-user-btn" onclick="sendmsg();">Send them a message</div>
							</form>
						</div>
					</div> -->
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
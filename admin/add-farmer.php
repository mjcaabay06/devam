<?php
	include('../include/configuration.php');

	if ($_POST['btn-submit']) {
		$insertFarmerInfo = $dbh->prepare("insert into farmer_infos(first_name, middle_name, last_name, mobile_number, telephone_number, created_at, updated_at, user_id) values(:first_name,:middle_name,:last_name,:mobile_number, :telephone_number, NOW(), NOW(), :user_id)");
		$insertFarmerInfo->execute(array(
				':first_name' => $_REQUEST['first_name'],
				':middle_name' => $_REQUEST['middle_name'],
				':last_name' => $_REQUEST['last_name'],
				':mobile_number' => $_REQUEST['mobile_number'],
				':telephone_number' => $_REQUEST['telephone_number'],
				':user_id' => 1,
			));
		header("Location: list-farmers.php");
	}
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Bootstrap 101 Template</title>

		<!-- Bootstrap -->
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<link href="../css/custom.css" rel="stylesheet">

		<script src="../js/jquery-3.2.0.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>

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
						

						<div class="pull-right">
							<div class="dropdown">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						    		Marc Caabay (Admin)
						    		<span style="margin-left: 10px;margin-right: -5px;" class="caret"></span>
						    	</button>
						    	<ul class="dropdown-menu pull-right">
						    		<li><a href="#"><span class="hidden-sm"><span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;&nbsp;</span>Change Password</a></li>
									<li><a href="#"><span class="hidden-sm"><span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;&nbsp;</span>Sign Out</a></li>
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
					<div class="page-header" style="margin-top: 0">
						<h3>
							<a href="list-farmers.php">
								<span class="glyphicon glyphicon-chevron-left"></span>
							</a>
							Add New Farmer
						</h3>
					</div>
					<form method="post" action="" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-3 control-label" for="first_name">First Name</label>
							<div class="col-sm-9">
								<input id="first_name" type="text" class="form-control" name="first_name" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="middle_name">Middle Name</label>
							<div class="col-sm-9">
								<input id="middle_name" type="text" class="form-control" name="middle_name" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="last_name">Last Name</label>
							<div class="col-sm-9">
								<input id="last_name" type="text" class="form-control" name="last_name" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="mobile_number">Mobile Number</label>
							<div class="col-sm-9">
								<input id="mobile_number" type="text" class="form-control" name="mobile_number" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="telephone_number">Telephone Number</label>
							<div class="col-sm-9">
								<input id="telephone_number" type="text" class="form-control" name="telephone_number" />
							</div>
						</div>
						<div class="form-group col-sm-3 pull-right">
							<input type="submit" name="btn-submit" value="Save" class="form-control btn btn-primary" />
						</div>
					</form>
				</div>
			</div>
		</div>
		
	</body>
</html>
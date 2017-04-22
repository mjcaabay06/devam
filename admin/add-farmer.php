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
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<form method="post" action="">
			<input type="text" name="first_name" placeholder="First Name" /> <br/>
			<input type="text" name="middle_name" placeholder="Middle Name" /><br/>
			<input type="text" name="last_name" placeholder="Last Name" /><br/>
			<input type="text" name="mobile_number" placeholder="Mobile Number" /><br/>
			<input type="text" name="telephone_number" placeholder="Telephone Number" /><br/>
			<input type="submit" name="btn-submit">
		</form>
	</body>
</html>
<?php
	include('../include/configuration.php');

	if ($_POST['btn-submit']) {
		$insertProduct = $dbh->prepare("insert into product_categories(category_name, created_at, updated_at, user_id) values(:category_name, NOW(), NOW(), :user_id)");
		$insertProduct->execute(array(
				':category_name' => $_REQUEST['category_name'],
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
			<input type="text" name="category_name" placeholder="Category Name" /> <br/>
			<input type="submit" name="btn-submit">
		</form>
	</body>
</html>
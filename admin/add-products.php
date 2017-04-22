<?php
	include('../include/configuration.php');

	if ($_POST['btn-submit']) {
		$insertProduct = $dbh->prepare("insert into products(product_name, product_code, product_category_id, created_at, updated_at, user_id) values(:product_name, :product_code, :product_category_id,  NOW(), NOW(), :user_id)");
		$insertProduct->execute(array(
				':product_name' => $_REQUEST['product_name'],
				':product_code' => $_REQUEST['product_code'],
				':product_category_id' => $_REQUEST['product_category_id'],
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
			<input type="text" name="product_name" placeholder="Product Name" /> <br/>
			<input type="text" name="product_code" placeholder="Product Code" /><br/>
			<select name="product_category_id">
				<?php
					$selProdCat = $dbh->prepare("select * from product_categories");
					$selProdCat->execute();

					while($pc = $selProdCat->fetch()):
				?>
					<option value="<?php echo $pc['id'] ?>" <?php echo $pcid == $pc['id'] ? 'selected' : ''; ?>><?php echo $pc['category_name'] ?></option>
				<?php endwhile; ?>
			</select><br/>
			<input type="submit" name="btn-submit">
		</form>
	</body>
</html>
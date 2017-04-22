<?php
	include('../include/configuration.php');

	$isSelected = false;
	$pcid = 1;
	if (isset($_GET['pc_id'])) {
		$isSelected = true;
		$pcid = $_GET['pc_id'];
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

		<script src="../js/jquery-3.2.0.min.js"></script>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<form action="" method="get">
			<select name="pc_id">
				<?php
					$selProdCat = $dbh->prepare("select * from product_categories");
					$selProdCat->execute();

					while($pc = $selProdCat->fetch()):
				?>
					<option value="<?php echo $pc['id'] ?>" <?php echo $pcid == $pc['id'] ? 'selected' : ''; ?>><?php echo $pc['category_name'] ?></option>
				<?php endwhile; ?>
			</select>
			<table class="table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Product Name</th>
						<th>Code</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$selProd = $dbh->prepare('select * from products where product_category_id = :pid');
						$selProd->execute(array( 'pid' => $pcid ));

						while($prod = $selProd->fetch()):
					?>
					<tr>
						<td><?php echo $prod['id'] ?></td>
						<td><?php echo $prod['product_name'] ?></td>
						<td><?php echo $prod['product_code'] ?></td>
					</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</form>
	</body>
	<script type="text/javascript">
		$(document).ready(function(){
			$("select[name='pc_id']").on('change', function(){
				$("form").submit();
			});
		});
	</script>
</html>
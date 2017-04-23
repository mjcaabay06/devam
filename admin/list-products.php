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
				<div class="col-sm-12">
					<div class="page-header">
						<h1>PRODUCTS</h1>
					</div>
					<form action="" method="get">
						<div class="form-group pull-left">
							<select name="pc_id" class="form-control">
								<?php
									$selProdCat = $dbh->prepare("select * from product_categories");
									$selProdCat->execute();

									while($pc = $selProdCat->fetch()):
								?>
									<option value="<?php echo $pc['id'] ?>" <?php echo $pcid == $pc['id'] ? 'selected' : ''; ?>><?php echo $pc['category_name'] ?></option>
								<?php endwhile; ?>
							</select>	
						</div>
						
						
						<div class="form-inline pull-right">
							<div class="form-group">
								<a href="add-products.php" class="btn btn-default">Add Product</a>
							</div>
							<!-- <div class="form-group">
								<a href="add-category.php" class="btn btn-default">Add Category</a>
							</div> -->
						</div>

						<div class="form-group">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>ID</th>
										<th>Product Name</th>
										<th>Description</th>
										<th>Code</th>
										<th>Added By</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$selProd = $dbh->prepare('select * from products where product_category_id = :pid');
										$selProd->execute(array( ':pid' => $pcid ));

										while($prod = $selProd->fetch()):
											$selUser = $dbh->prepare('select * from users where id = :user_id');
											$selUser->execute(array( ':user_id' => $prod['user_id'] ));
											$user = $selUser->fetch(PDO::FETCH_ASSOC);
									?>
									<tr>
										<td><?php echo $prod['id'] ?></td>
										<td><?php echo $prod['product_name'] ?></td>
										<td><?php echo $prod['description'] ?></td>
										<td><?php echo $prod['product_code'] ?></td>
										<td><?php echo $user['username'] ?></td>
										<td>
											<a href="edit-products.php?pid=<?php echo $prod['id'] ?>" class="btn btn-primary" data-id="">
												<span class="glyphicon glyphicon-pencil"></span>
											</a>
											<button type="button" class="btn btn-primary btn-del" data-id="<?php echo $prod['id'] ?>" data-type="product">
												<span class="glyphicon glyphicon-trash"></span>
											</button>
										</td>
									</tr>
									<?php endwhile; ?>
								</tbody>
							</table>
						</div>
						
					</form>
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(document).ready(function(){
			$("select[name='pc_id']").on('change', function(){
				$("form").submit();
			});

			$(".btn-del").on('click', function(){
				var r = confirm('Are you sure you want to delete the record?');
				if (r) {
					$.get("delete-record.php?rid=" + $(this).data("id") + '&type=' + $(this).data("type"))
						.done(function(){ location.reload(); });
				}
			});
		});
	</script>
</html>
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
						
						<!-- <ul class="nav navbar-nav navbar-right">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									Marc Caabay
									(<small>Admin</small>)
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<li><a href="/admin/change-password"><span class="hidden-sm"><span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;&nbsp;</span>Change Password</a></li>
									<li><a href="/logout"><span class="hidden-sm"><span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;&nbsp;</span>Sign Out</a></li>
								</ul>
							</li>
						</ul> -->
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
							<a href="list-products.php">
								<span class="glyphicon glyphicon-chevron-left"></span>
							</a>
							Add New Product
						</h3>
					</div>
					<form method="post" action="" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-3 control-label" for="product_name">Product Name</label>
							<div class="col-sm-9">
								<input id="product_name" type="text" class="form-control" name="product_name" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label" for="product_code">Product Code</label>
							<div class="col-sm-9">
								<input id="product_code" type="text" class="form-control" name="product_code" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="description">Description</label>
							<div class="col-sm-9">
                              <textarea id="description" class="form-control" name="product_code"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="product_category_id">Category</label>
							<div class="col-sm-9">
								<select id="product_category_id" name="product_category_id" class="form-control">
									<?php
										$selProdCat = $dbh->prepare("select * from product_categories");
										$selProdCat->execute();

										while($pc = $selProdCat->fetch()):
									?>
										<option value="<?php echo $pc['id'] ?>" <?php echo $pcid == $pc['id'] ? 'selected' : ''; ?>><?php echo $pc['category_name'] ?></option>
									<?php endwhile; ?>
								</select>
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
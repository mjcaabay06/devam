<?php
	session_start();
	if(!isset($_SESSION['AuthId']) || empty($_SESSION['AuthId'])){
		header("Location: login.php");
		exit;
	}else{
		include('../include/configuration.php');

		if (isset($_POST['btn-submit'])) {
			$upCat = $dbh->prepare("update product_categories set category_name = :category_name, updated_at = NOW() where id = :cid");
			$upCat->execute(array(
					':category_name' => $_REQUEST['category_name'],
					':cid' =>$_REQUEST['cid'],
				));

			header("Location: list-category.php");
		}


		if ($_GET['cid']) {
			$selCat = $dbh->prepare("select * from product_categories where id = :cid");
			$selCat->execute(array( ':cid' =>$_GET['cid'], ));
			$cat = $selCat->fetch(PDO::FETCH_ASSOC);
		}
	}
	
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
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
							<li class="act"><a href="list-category.php">Categories</a></li>
						</ul>


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
							<a href="list-category.php">
								<span class="glyphicon glyphicon-chevron-left"></span>
							</a>
							Edit Category
						</h3>
					</div>
					<form method="post" action="" class="form-horizontal">
						<input type="hidden" name="cid" value="<?php echo $_GET['cid'] ?>"/>
						<div class="form-group">
							<label class="col-sm-3 control-label" for="category_name">Category Name</label>
							<div class="col-sm-9">
								<input id="category_name" type="text" class="form-control" name="category_name" value="<?php echo $cat ? $cat['category_name'] : '' ?>" />
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
<?php
	session_start();
	if(!isset($_SESSION['AuthId']) || empty($_SESSION['AuthId'])){
		header("Location: login.php");
		exit;
	}else{
		include('../include/configuration.php');

		$isSelected = false;
		$pcid = 1;
		if (isset($_GET['pc_id'])) {
			$isSelected = true;
			$pcid = $_GET['pc_id'];
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
							<li class="act"><a href="list-farmers.php">Farmers</a></li>
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
				<div class="col-sm-12">
					<div class="page-header">
						<h1>FARMERS</h1>
					</div>
					<form action="" method="get">
						<div class="form-inline pull-right">
							<div class="form-group">
								<a href="add-farmer.php" class="btn btn-default">Add Farmer</a>
							</div>
						</div>

						<div class="form-group">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Contact Number</th>
										<th>Added By</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$selProd = $dbh->prepare('select * from farmer_infos');
										$selProd->execute();

										while($prod = $selProd->fetch()):
											$selUser = $dbh->prepare('select * from users where id = :user_id');
											$selUser->execute(array( ':user_id' => $prod['user_id'] ));
											$user = $selUser->fetch(PDO::FETCH_ASSOC);
									?>
									<tr>
										<td><?php echo $prod['id'] ?></td>
										<td><?php echo $prod['last_name'] . ', ' . $prod['first_name'] ?></td>
										<td><?php echo $prod['mobile_number'] . ' / ' . $prod['telephone_number'] ?></td>
										<td><?php echo $user['username'] ?></td>
										<td><a href="edit-farmer.php?fid=<?php echo $prod['id'] ?>" class="btn btn-primary" data-id="">
												<span class="glyphicon glyphicon-pencil"></span>
											</a>
											<button type="button" class="btn btn-primary btn-del" data-id="<?php echo $prod['id'] ?>" data-type="farmer">
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
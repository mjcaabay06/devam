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
							<li><a href="list-farmers.php">Farmers</a></li>
						</ul>
						<ul class="nav navbar-nav">
							<li class="act"><a href="list-products.php">Products</a></li>
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
											<button type="button" class="btn btn-primary btn-send" data-code="<?php echo $prod['product_code'] ?>" data-id="<?php echo $prod['id'] ?>" data-type="product">
												<span class="glyphicon glyphicon-send"></span>
												<span class="glyphicon glyphicon-refresh gly-spin hidden">
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

		<div id="modalPrice" class="modal fade" role="dialog">
			<div class="modal-dialog modal-sm">

			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Send Market Value</h4>
					</div>
					<div class="modal-body">
						<div class="col-sm-12">
							<div class="row">
								<div class="form-group" id="product_name">
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<div class="row">
											<textarea class="hidden" id="sms-content"></textarea>
											<input id="mobileno" type="text" class="form-control" placeholder="Enter Mobile Number" />
										</div>
									</div>
								</div>
							</div>
						</div>
						<div style="clear: both"></div>
					</div>
					<div class="modal-footer">
						<div class="col-sm-3 pull-right">
							<div class="row">
								<button type="button" class="btn btn-primary msg-user-btn" onclick="sendmsg();">Send</button>
							</div>
						</div>
					</div>
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

			$(".btn-send").on('click', function(){
				$(this).children("span.glyphicon-send").addClass("hidden");
				$(this).children("span.glyphicon-refresh").removeClass("hidden");
				fetchValue($(this).data('code'));
			});
		});
		function sendmsg(){
			$.ajax({
				url: "send_oneway.php",
				type: "post",
				data: {action:"sendsnglmsg", message: encodeURIComponent($("#sms-content").val()), phone: $("#mobileno").val()},
				success: function(response){
					console.log(response);//$("#sndmsg-dv").html(response);
				}
			});
		}
		function fetchValue(code) {
			var url = "https://www.quandl.com/api/v3/datasets/";
			var product_code = code;
			var fullUrl = url + product_code + '.json?' + dateFilter() + '&api_key=v_AVA5kuHqzsnG2XwsiK';

			$.get(fullUrl)
				.done(function(data){
					var hasValue = false;
					var indexVal = 0;
					for(var x = 0; x < data.dataset.column_names.length; x++) {
						var cn = data.dataset.column_names[x];
						if (cn == "Value" || cn == "Last") {
							indexVal = x;
							hasValue = true;
							break;
						}
					}
					var val = hasValue ? data.dataset.data[0][indexVal] : 0;
					$("#modalPrice #product_name").html('<h3>' + data.dataset.name + ' (' + val + ') </h3>');
					$("#sms-content").html('The amount of ' + data.dataset.name + ' as of ' + data.dataset.data[0][0] + ' is cost $' + val + '.');
					
					$(".btn-send span.glyphicon-send").removeClass("hidden");
					$(".btn-send span.glyphicon-refresh").addClass("hidden");
					
					// $("#modalPrice .modal-title").html(data.dataset.name);

					// var html = '';
					// var prod;
					// html += '<table class="table">'
					// 		+ '<thead>'
					// 		+ '<tr>'
					// 		+ '<td>Price</td>'
					// 		+ '<td>As Of</td>'
					// 		+ '</tr>'
					// 		+ '</thead>'
					// 		+ '<tbody>';

					// var hasValue = false;
					// var indexVal = 0;
					// for(var x = 0; x < data.dataset.column_names.length; x++) {
					// 	var cn = data.dataset.column_names[x];
					// 	if (cn == "Value" || cn == "Last") {
					// 		indexVal = x;
					// 		hasValue = true;
					// 		break;
					// 	}
					// }

					// if(hasValue) {
					// 	for(prod in data.dataset.data) {
					// 		html += '<tr><td>' + data.dataset.data[prod][x] + '</td><td>' + data.dataset.data[prod][0] + '</td></tr>';
					// 	}
					// 	$("#modalPrice .modal-body").html(html);
					// }


					$("#modalPrice").modal('show');


				});
		}

		function dateFilter() {
			var d = new Date();
			var m = (d.getMonth() + 1) > 9 ? (d.getMonth() + 1) : "0" + (d.getMonth() + 1);
			var y = d.getFullYear();

			var endDate = y + '-' + m + '-' + d.getDate();
			d.setMonth(d.getMonth() - 5);

			m = (d.getMonth() + 1) > 9 ? (d.getMonth() + 1) : "0" + (d.getMonth() + 1);
			y = d.getFullYear();
			var startDate = y + '-' + m + '-' + d.getDate();

			return "start_date=" + startDate + "&end_date=" + endDate + '&collapse=monthly';
		}
	</script>
</html>
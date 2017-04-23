<?php
	include('include/configuration.php');

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
		<title>DevAm</title>

		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/custom.css" rel="stylesheet">

		<script src="js/jquery-3.2.0.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/bootstrap.min.js"></script>
		

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<nav class="navbar navbar-inverse navbar-inverse-red navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						aaa
					</div>
				</div>
			</div>
		</nav>

		<div class="container main-container">
			<div class="row">
				<div class="col-sm-12">
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
						
						<div class="form-group">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>ID</th>
										<th>Product Name</th>
										<th>Description</th>
										<th>Code</th>
										<th></th>
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
										<td><?php echo $prod['description'] ?></td>
										<td><?php echo $prod['product_code'] ?></td>
										<td><button type="button" data-code="<?php echo $prod['product_code'] ?>" data-id="<?php echo $prod['id'] ?>" class="btn-modal btn btn-primary"><span class="glyphicon glyphicon-refresh gly-spin hidden"></span><span class="glyphicon glyphicon-search"></span></button></td>
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
			<div class="modal-dialog">

			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"></h4>
					</div>
					<div class="modal-body">
						
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

			$(".btn-modal").on("click", function(){
				var url = "https://www.quandl.com/api/v3/datasets/";
				var product_code = $(this).data("code");
				var fullUrl = url + product_code + '.json?' + dateFilter() + '&api_key=v_AVA5kuHqzsnG2XwsiK';
				$(this).children("span.glyphicon-search").addClass("hidden");
				$(this).children("span.glyphicon-refresh").removeClass("hidden");

				$.get(fullUrl)
					.done(function(data){
						$(".btn-modal span.glyphicon-search").removeClass("hidden");
						$(".btn-modal span.glyphicon-refresh").addClass("hidden");
						
						$("#modalPrice .modal-title").html(data.dataset.name);

						var html = '';
						var prod;
						html += '<table class="table">'
								+ '<thead>'
								+ '<tr>'
								+ '<td>Price</td>'
								+ '<td>As Of</td>'
								+ '</tr>'
								+ '</thead>'
								+ '<tbody>';

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

						if(hasValue) {
							for(prod in data.dataset.data) {
								html += '<tr><td>' + data.dataset.data[prod][x] + '</td><td>' + data.dataset.data[prod][0] + '</td></tr>';
							}
							$("#modalPrice .modal-body").html(html);
						}


						$("#modalPrice").modal('show');
					});
			});
		});

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
<?php
	include('include/configuration.php');

	$isSelected = false;
	$pcid = 0;
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
		<nav class="navbar navbar-inverse navbar-inverse-red navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<div class="pull-right">
							<a href="admin/login.php" class="" style="line-height: 45px;" />
					    		Sign In
					    	</a>
						</div>
					</div>
				</div>
			</div>
		</nav>
		<div class="container main-container">
			<div class="row">
				<div class="col-sm-12">
					<form action="index.php" method="get">
						<div class="form-inline pull-right">
							<div class="form-group">
					    		<label class="control-label" style="text-transform: none; color: black;">&nbsp;&nbsp;&nbsp;&nbsp;Search Product: </label>
					    	</div>
							<div class="form-group">
								<input type="text" class="form-control" name="query" placeholder="Name or Code" value="<?php echo $_GET['query'] ? $_GET['query'] : '' ?>" />
				    			<button type="submit" value="Search" class="btn btn-primary">
									<span class="glyphicon glyphicon-search"></span>
								</button>
				    		</div>
						</div>
						
						<div class="form-group pull-left">
							<select name="pc_id" class="form-control">
								<option value="0" <?php echo $pcid == 0 ? 'selected' : '' ?>>All Category</option>
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
										$where = '';
										$and = '';
										$query = $_GET['query'] ? " product_name LIKE '%" . $_GET['query'] . "%' " : '';

										if ($pcid != 0 || $query != '') {
											$where = ' where ';
										} else if ($pcid != 0 && $query != '') {
											$and = ' and ';
										}

										$pcQuery = $pcid == 0 ? '' : ' product_category_id = ' . $pcid;
										
										$selProd = $dbh->prepare('select * from products ' . $where . $pcQuery . $and . $query);
										$selProd->execute();

										while($prod = $selProd->fetch()):
									?>
									<tr>
										<td><?php echo $prod['id'] ?></td>
										<td><?php echo $prod['product_name'] ?></td>
										<td><?php echo $prod['description'] ?></td>
										<td><?php echo $prod['product_code'] ?></td>
										<td><button type="button" data-code="<?php echo $prod['product_code'] ?>" data-id="<?php echo $prod['id'] ?>" class="btn-modal btn btn-primary"><span class="glyphicon glyphicon-refresh gly-spin hidden"></span><span class="glyphicon glyphicon-eye-open"></span></button></td>
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
				$(this).children("span.glyphicon-eye-open").addClass("hidden");
				$(this).children("span.glyphicon-refresh").removeClass("hidden");

				$.get(fullUrl)
					.done(function(data){
						$(".btn-modal span.glyphicon-eye-open").removeClass("hidden");
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
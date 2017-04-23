<?php
	include('../include/configuration.php');

	$type = "";
	switch ($_GET['type']) {
		case 'product':
			$type = 'products';
			break;
		case 'farmer':
			$type = 'farmer_infos';
			break;
		case 'category':
			$type = 'product_categories';
			break;
	}

	$delRec = $dbh->prepare("delete from " . $type . " where id=:id");
	$delRec->execute(array( ':id' => $_GET['rid']));

	echo 'success';
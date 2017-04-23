<?php
session_start();
include("../include/configuration.php");
include("../include/general_functions.php");

if(!isset($_SESSION['AuthId']) || empty($_SESSION['AuthId'])){
	header("Location: login.php");
	exit;
}
?>
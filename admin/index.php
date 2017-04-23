<?php
include("../include/configuration.php");
session_start();

if(!isset($_SESSION['AuthId']) || empty($_SESSION['AuthId'])){
	header("Location: login.php");
	exit;
}
?>
<?php 
	require_once('./connect.php');
	session_start();

	$subcategory = $_POST['data'];
	$update = $_POST['update'];

	$sql = "UPDATE SET WHERE";
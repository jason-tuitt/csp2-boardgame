<?php 
session_start();
	$_SESSION['game_id_filter'] = 'ALL';
	$_SESSION['type_id_filter'] = 'ALL';

header('Location: ../views/catalog.php');
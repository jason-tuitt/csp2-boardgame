<?php 
	include_once "../partials/header.php"; 
	require_once('../controllers/connect.php');
	session_start();
?>

	<style type="text/css">
		#afterRegistrationContainer {
	
		}

	</style>
</head>
<body>
	<?php include_once '../partials/navbar.php'; ?>
	<?php 
		if(isset($_SESSION['user_data'])) {
			header('Location: ./catalog.php');
		}
	 ?>
	<div class="appViewBox">
	<h1>Board Game - Registration Complete</h1>

	<div id='afterRegistrationContainer'>
		<p>Registration Complete - Go to <a href="./login.php">Login</a></p>
	</div>
	<div>

<?php 
	include_once "../partials/footer.php";
?>
<?php 
	include_once "../partials/header.php"; 
	require_once('../controllers/connect.php');
	session_start();
?>

</head>
<body>
	<?php include_once '../partials/navbar.php'; ?>
	<?php include_once '../partials/header.php'; ?>
	<?php 
		if(isset($_SESSION['user_data'])) {
			header('Location: ./catalog.php');
		}
	 ?>
	<div class="appViewBox">

	<h1>Board Game - Registration Complete</h1>

	<div id='afterRegistrationContainer' style="display:flex; justify-content: center; flex-direction:column; align-items: center;">
		<div style="display: flex; justify-content: center; margin:10px 0;" >
			<p style="font-size: 24px;">Registration Complete!</p>
		</div>
		<div style="display: flex; justify-content: center; margin:10px 0;" >
	 		<a href="./login.php"><button id="returnToShopping" class="btn btn-outline-success">You may now Log In</button></a>
	 	</div>
	</div>

	</div>

<?php 
	include_once "../partials/footer.php";
?>
<?php 
	include_once '../partials/header.php';
	require_once('../controllers/connect.php');
	session_start();
?>

	<link rel='stylesheet' type='text/css' href='./login.css'>
</head>
<body>
	<?php include_once '../partials/navbar.php'; ?>
	<?php 
		if(isset($_SESSION['user_data'])) {
			header('Location: ./catalog.php');
		}
	 ?>
	 <div class="appViewBox">

		<h1>Board Game Store - Login</h1>

		<div id="loginApp">
			<div id="loginContainer">
				<div id="loginForm">
					<form method="POST" action="../controllers/authenticate.php">
						<h2>Login</h2>
						<div>
							<label>Username</label>
							<input type="text" name="inputUsername">
						</div>
						<div>
							<label>Password</label>
							<input type="password" name="inputPassword">
						</div>
						<button type="submit" class="btn btn-primary">Login</button>
					</form>
				</div>
				<div id="loginMessage">
					<?php 
					if(isset($_SESSION['login_message'])) {
						echo $_SESSION['login_message'];
						unset($_SESSION['login_message']);
					}
					 ?>
				</div>		
			</div>
			
		</div>
	</div>

<?php 
	include_once '../partials/footer.php';
?>
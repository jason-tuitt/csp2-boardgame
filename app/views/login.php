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
						<div class="form-group-login">
							<label>Username</label>
							<input class="form-control" type="text" name="inputUsername">
						</div>
						<div class="form-group-login">
							<label>Password</label>
							<input class="form-control" type="password" name="inputPassword">
						</div>
						<div id="loginMessage">
							<?php 
							if(isset($_SESSION['login_message'])) {
								echo $_SESSION['login_message'];
								unset($_SESSION['login_message']);
							}
							 ?>
						</div>
						<div class="form-group-login">
							<button type="submit" class="btn btn-outline-dark">Login</button>
							<button type="button" class="btn btn-outline-dark">Forgot Password</button>
						</div>
						<div class="form-group-login">
							<a href="./register.php"><p>No account? Register here</p></a>
						</div>	
					</form>	
				</div>		
			</div>
			
		</div>
	</div>

<?php 
	include_once '../partials/footer.php';
?>
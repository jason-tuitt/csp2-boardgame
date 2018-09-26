
<?php 
	include_once "../partials/header.php"; 
	require_once('../controllers/connect.php');
	session_start();
?>

	<link rel="stylesheet" type="text/css" href="./register.css">
</head>
<body>
	<?php include_once '../partials/navbar.php'; ?>
	<?php 
		if(isset($_SESSION['user_data'])) {
			header('Location: ./catalog.php');
		}
	 ?>
	<div class="appViewBox">
		<h1>Board Game Store - Register</h1>

		<div id='registerFormContainer'>
		<form method="POST" action="../controllers/register.php">
		  <div class="form-row">
		    <div class="form-group col-md-12">
		      <label for="inputEmail4">Username</label>
		      <input type="text" class="form-control" id="inputEmail4" placeholder="Username" name="registerUsername" required>
		    </div>
		    <div class="form-group col-md-6">
		      <label for="inputPassword4">Password</label>
		      <input type="password" class="form-control" id="inputPassword4" placeholder="Password" name="registerPassword" required>
		    </div>
		    <div class="form-group col-md-6">
		      <label for="inputPassword4">Verify Password</label>
		      <input type="password" class="form-control" id="inputPassword4" placeholder="Password" name="registerVerifyPassword" required>
		    </div>
		    <div class="form-group col-md-12">
		      <label for="inputEmail4">Email</label>
		      <input type="email" class="form-control" id="inputEmail4" placeholder="Email" name="registerEmail" required>
		    </div>
		  </div>
		  <div class="form-row">
		  <div class="form-group col-md-6">
		      <label for="inputPassword4">First Name</label>
		      <input type="text" class="form-control" id="inputPassword4" placeholder="First Name" name="registerFirstName">
		    </div>
		    <div class="form-group col-md-6">
		      <label for="inputPassword4">Last Name</label>
		      <input type="text" class="form-control" id="inputPassword4" placeholder="Last Name" name="registerLastName">
		    </div>
		  </div>  
		  <div class="form-group">
		    <label for="inputAddress">Address</label>
		    <input type="text" class="form-control" id="inputAddress" placeholder="Address" name="registerAddress">
		  </div>
		  <div class="form-row">
		    <div class="form-group col-md-6">
		      <label for="inputState">Contact Number</label>
		      <input type="text" class="form-control" id="inputContact" placeholder="Contact Number" name="registerContact">
		    </div>
		  </div>
		  <button type="submit" class="btn btn-primary">Register</button>
		</form>
		</div>
	</div>	
<?php 
	include_once "../partials/footer.php";
?>
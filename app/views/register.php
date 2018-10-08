
<?php 
	include_once "../partials/header.php"; 
	require_once('../controllers/connect.php');
	session_start();
?>

	<link rel="stylesheet" type="text/css" href="./register.css">
</head>
<body>
	<?php 
		if(isset($_SESSION['user_data'])) {
			header('Location: ./catalog.php');
		}
	 ?>
	<?php include_once '../partials/navbar.php'; ?>
	<div class="appViewBox">
		<h1>Register an Account</h1>
		<div id="registrationErrorMessage" style="display: flex; justify-content: center; color:red; font-size: 22px; margin:10px 0;">
			<p style="margin:0;">
				<?php 
				if (isset($_SESSION['register_error'])) {
					echo $_SESSION['register_error'];
					unset($_SESSION['register_error']);
				}
				?>
			</p>
				
		</div>

		<div id='registerFormContainer'>
		<form method="POST" action="../controllers/register.php">
		  <div class="form-row">
		    <div class="form-group col-md-12">
		      <label for="registerUsername">Username</label><span style="padding-left: 5px; color:red;" id="registerCheckUsername"></span> 
		      <input type="text" autocomplete="off" class="form-control" id="registerUsername" placeholder="Username" name="registerUsername" required>
		    </div>
		    <div class="form-group col-md-6">
		      <label for="registerPassword">Password</label>
		      <input type="password" autocomplete="off" class="form-control" id="registerPassword" placeholder="Password" name="registerPassword" required>
		    </div>
		    <div class="form-group col-md-6">
		      <label for="registerVerifyPassword">Verify Password </label><span style="padding-left: 5px; color:red;" id="registerCheckPassword"> </span>
		      <input type="password" class="form-control" id="registerPasswordConfirm" placeholder="Password" name="registerVerifyPassword" required>
		    </div>
		    <div class="form-group col-md-12">
		      <label for="registerEmail">Email</label><span style="padding-left: 5px; color:red;" id="registerCheckEmail"></span> 
		      <input type="email" class="form-control" id="registerEmail" placeholder="Email" name="registerEmail" required>
		    </div>
		  </div>
		  <div class="form-row">
		  <div class="form-group col-md-6">
		      <label for="registerFirstName">First Name</label>
		      <input type="text" class="form-control" id="registerFirstName" placeholder="First Name" name="registerFirstName" required>
		    </div>
		    <div class="form-group col-md-6">
		      <label for="registerLastName">Last Name</label>
		      <input type="text" class="form-control" id="registerLastName" placeholder="Last Name" name="registerLastName" required>
		    </div>
		  </div>  
<!-- 		  <div class="form-group">
		    <label for="inputAddress">Address</label>
		    <input type="text" class="form-control" id="inputAddress" placeholder="Address" name="registerAddress">
		  </div> -->
		  <div class="form-row">
		    <div class="form-group col-md-6">
		      <label for="inputState">Contact Number</label>
		      <input type="text" class="form-control" id="registerContact" placeholder="Contact Number" name="registerContact" required>
		    </div>
		  </div>
		  <div style="display: flex; justify-content: center;">
		  <button style="min-width: 250px;"type="submit" class="btn btn-outline-primary">Register</button>
		  </div>
		</form>
		</div>
	</div>	

	<script>
		const pass = document.querySelector('#registerPassword');
		const passConfirm = document.querySelector('#registerPasswordConfirm');
		const email = document.querySelector('#registerEmail');
		const user = document.querySelector('#registerUsername');
		const messBox = document.querySelector('#registerCheckPassword');
		const emailBox = document.querySelector('#registerCheckEmail');
		const userBox = document.querySelector('#registerCheckUsername');

		const confirm_password = () => {
			;
			
			if (pass.value !== passConfirm.value) {
				messBox.textContent = "Passwords Do Not Match"
			} else {
				messBox.textContent = " "
			}
		}

		const confirm_email = () => {
			if (!email.value.includes('@') || !email.value.includes('.') ) {
				emailBox.textContent = "Invalid Email Provided."
			} else {
				emailBox.textContent = " "
			}
		}

		const confirm_username = () => {
			const inputUser = user.value;

			if (inputUser.length < 4) {
				userBox.textContent = "Username is too short. Minimum of 5 characters."
				return
			} else {
				userBox.textContent = " "
			}

			$.ajax({
				url:'../controllers/check_username.php',
				type:'GET',
				data:{user:inputUser},
				success: (data) => {
					const d = JSON.parse(data);
					console.log(data)
					if (d == 0) {
						userBox.textContent = "Username already Taken."
					} else {
						userBox.textContent = " "
					}
				}
			})
		}

		const password_listener = () => {
			passConfirm.addEventListener("input", () => {
				confirm_password();
			})
		}

		const email_listener = () => {
			email.addEventListener("blur", () => {
				console.log('asdasd')
				confirm_email();
			})
		}

		const username_listener = () => {
			user.addEventListener("blur", () => {
				confirm_username();
			})
		}

		password_listener();
		email_listener();
		username_listener();
	</script>
<?php 
	include_once "../partials/footer.php";
?>
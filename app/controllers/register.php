<?php 
	require_once('./connect.php');
	session_start();

	$username = $_POST['registerUsername'];
	$password = $_POST['registerPassword'];
	$verifypassword = $_POST['registerVerifyPassword'];
	$email = $_POST['registerEmail'];
	$first_name = $_POST['registerFirstName'];
	$last_name = $_POST['registerLastName'];
	// $address = $_POST['registerAddress'];
	$contact = $_POST['registerContact'];

	$encrypted = password_hash($password, PASSWORD_BCRYPT);

	if (isset($username) && isset($password) && isset($email) && $first_name != '' && $last_name != '' && $contact != '') {
		$sql_query = "INSERT INTO users(first_name, last_name, email, contact, username, password, roles_id) values ('$first_name', '$last_name', '$email', '$contact', '$username', '$encrypted', 1)";
		if (mysqli_query($conn, $sql_query)) {
		header("Location: ../views/after_registration.php");

		} else {
			echo "Error: " . $sql_query . "<br>" . mysqli_error($conn);
			echo "error";
		}
	} else {
		$_SESSION['register_error'] = 'Insufficient information provided.';
		// echo $_SESSION['register_error'];
		header ("Location: ../views/register.php");
	}

	

	// var_dump($sql_query);
	// var_dump(mysqli_query($conn, $sql_query));

	

	
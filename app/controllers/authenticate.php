<?php 
	require_once('./connect.php');
	session_start();

$username = $_POST['inputUsername'];
$password = $_POST['inputPassword'];

	$sql = "SELECT * FROM users where username='$username'";

	// $password_input = password_hash($password, PASSWORD_BCRYPT);

	// echo "$sql";

	$result = mysqli_query($conn, $sql);


	if ( mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		if (password_verify($password, $row['password'])) {
			$_SESSION['user_data'] = $row;
			$_SESSION['cartQuantity'] = 0;
			$_SESSION['cart'] = array();
			$_SESSION['wishlist'] = array();
			$_SESSION['wishlistQuantity'] = 0;

			if ($row['roles_id'] == 2) {
				$_SESSION['admin'] = 1;
			}

			header('Location: ../views/catalog.php' );
		} else {
			$_SESSION['login_message'] = 'Incorrect Password';
			header('Location: ../views/login.php' );
		}
		// var_dump($row) ;
	} else {
		$_SESSION['login_message'] = 'Username does not exist';
		header('Location: ../views/login.php' );
	}

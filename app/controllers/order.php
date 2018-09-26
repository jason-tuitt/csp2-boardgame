<?php 
	require_once('./connect.php');
	session_start();
	require './generate_transaction_number.php';
// include './generate_transaction_number.php';

	$cart = $_SESSION['cart'];


	$payment_method = $_POST['paymentMethod'];
	$timestamp = date("Y-m-d H:i:s");
	$referenceNumber = referenceNumberGenerator();
	$status_id = 1;


	$id = $_SESSION['user_data']['id'];

	$sql = "INSERT INTO orders (order_timestamp, status_id, transaction_num, user_id, payment_method) VALUES ('$timestamp', $status_id, '$referenceNumber', $id, $payment_method)";

	$result = mysqli_query($conn, $sql);

	$orderId = mysqli_insert_id($conn);

	// $orderId
	$totalprice = 0;

	foreach($cart as $cart_item) {
		$cart_id = $cart_item['id'];
		$cart_qty = $cart_item['qty'];

		$sql_getprice = "SELECT price from items where id = $cart_id";
		$result_getprice = mysqli_query($conn, $sql_getprice);
		$row = mysqli_fetch_assoc($result_getprice);

		$itemprice = $row['price'];
		$subtotal = $row['price'] * $cart_qty;

		$totalprice = $totalprice + $subtotal;

		$sql_addToOrder = "INSERT INTO orders_items (item_id, order_id, price, quantity, subtotal) VALUES ($cart_id, $orderId, $itemprice, $cart_qty, $subtotal)";

		$result_addToOrder = mysqli_query($conn, $sql_addToOrder);
	}

	$sql_inserttotal = "UPDATE orders SET total_price = $totalprice where id = $orderId";
	$result_inserttotal = mysqli_query($conn, $sql_inserttotal);

	echo $sql_inserttotal;

	$_SESSION['cart'] = array();
	$_SESSION['cartQuantity'] = 0;


	//SEnd confirmation email to user
	//Create new gmail account for capstone 2 web app as admin account
	//Disable security feature for insecure apps
	// admin account - 

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions

$customer_email = 'jason.d.delatorre@gmail.com';
$subject = 'Bored Games - Order Confirmation';
$body = '<h3>'. $referenceNumber .'</h3>';

try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'boredgamesph.capstone@gmail.com';                 // SMTP username
    $mail->Password = 'tu!tt123';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('boredgamesph.capstone@gmail.com', 'Bored Staff');
    $mail->addAddress($customer_email);     

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body = $body;

    $mail->send();

    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}



	//Route user to confirmation page

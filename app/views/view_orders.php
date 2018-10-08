<?php 
include_once '../partials/header.php';
require_once('../controllers/connect.php');
session_start();
?>

<link rel='stylesheet' type='text/css' href='./view_orders.css'>
</head>
<body>
	<?php include_once '../partials/navbar.php'; ?>
	<?php 
	if(!isset($_SESSION['user_data'])) {
		header('Location: ./catalog.php');
	}
	?>

	<div class="appViewBox">
		<h1>View Orders</h1>
		<div style="display: flex; justify-content: center; margin:10px 0;" >
	 		<a href="./catalog.php"><button id="returnToShopping" class="btn btn-outline-success">Return to Shopping</button></a>
	 	</div>
		<div id="viewOrdersApp">
			<div id="pendingOrders" class="card card-orders">
				<div class="card-header">
					My Current Orders
				</div>
				<div class="card-body" style='display:flex; justify-content:center; flex-direction: column;'>
					<?php 
					$user_id = $_SESSION['user_data']['id']; 
					$sql_orders = "SELECT o.id, o.order_timestamp, s.status_name, o.transaction_num, p.payment_method, o.total_price from orders as o JOIN statuses as s on o.status_id = s.id JOIN payment_method as p on o.payment_method = p.id where user_id = $user_id AND s.id <> 5";

					$result_order = mysqli_query($conn, $sql_orders);


					if (mysqli_num_rows($result_order) > 0) {
						while ($ro = mysqli_fetch_assoc($result_order)) {
							$o_id = $ro['id'];

							$sql_order_item = "SELECT i.item_image, i.item_desc, i.name, i.game_types_id, i.categories_id, oi.price, oi.quantity, oi.subtotal from orders_items as oi JOIN items as i ON oi.item_id = i.id where order_id = $o_id";


							$result_order_item = mysqli_query($conn, $sql_order_item);
							echo '<div class="single-order-container">';
							echo '<h5>Reference Number: '.$ro['transaction_num'].'</h5>';
							echo '<p>Date Ordered: '.$ro['order_timestamp'].'</p>';
							echo '<table>';
								echo '<tr >';
									echo '<th></th>';
									echo '<th>Name</th>';
									echo '<th>Item Description</th>';
									echo '<th>Unit Price</th>';
									echo '<th>Quantity</th>';
									echo '<th>Subtotal</th>';
									echo '<th>Status</th>';
									echo '<th>Payment</th>';
								echo '</tr>';

							while ($roi = mysqli_fetch_assoc($result_order_item)) {
								echo '<tr>';
									echo "<td><img src='".$roi['item_image']."'></td>";
									echo "<td>".$roi['name']."</td>";
									echo "<td>".$roi['item_desc']."</td>";
									echo "<td>Php ".number_format($roi['price'], 2, '.', ',')."</td>";
									echo "<td>".$roi['quantity']."</td>";
									echo "<td>Php ". number_format($roi['subtotal'], 2, '.', ',')."</td>";
									echo "<td>".$ro['status_name']."</td>";
									echo "<td>".$ro['payment_method']."</td>";
								echo '</tr>';
							}
							echo '</table>';
							echo '<h5> Net Amount: Php '. number_format($ro['total_price'], 2, '.', ',') .'</h5>';
							echo '</div>';
						}
						
					} else {
						echo 'You have no current order.';
					}

					?>
					
				</div>
			</div>

			<div id="ordersHistory" class="card card-orders">
				<div class="card-header">
					Orders History
				</div>
				<div class="card-body" style="display:flex; justify-content: center;">
					You have no previous transactions.
				</div>
			</div>
		</div>
	</div>

</body>

<script type="text/javascript">

</script>

<?php 
include_once '../partials/footer.php';
?>
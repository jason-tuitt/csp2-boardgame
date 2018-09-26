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
		<div id="viewOrdersApp">
			<div id="pendingOrders" class="card card-orders">
				<div class="card-header">
					My Current Orders
				</div>
				<div class="card-body">
					<?php 
					$user_id = $_SESSION['user_data']['id']; 
					$sql_orders = "SELECT * from orders where user_id = $user_id AND payment_method <> 5";

					$result_order = mysqli_query($conn, $sql_orders);

					if (mysqli_num_rows($result_order) > 0) {
						while ($ro = mysqli_fetch_assoc($result_order)) {
							$o_id = $ro['id'];

							$sql_order_item = "SELECT i.item_image, i.item_desc, i.name, i.game_types_id, i.categories_id, oi.price, oi.quantity, oi.subtotal from orders_items as oi JOIN items as i ON oi.item_id = i.id where order_id = $o_id";

							$result_order_item = mysqli_query($conn, $sql_order_item);

							echo '<h4>Reference Number: '.$ro['transaction_num'].'</h4>';
							echo '<table>';
								echo '<tr >';
									echo '<th></th>';
									echo '<th>Name</th>';
									echo '<th>Item Description</th>';
									echo '<th>Unit Price</th>';
									echo '<th>Quantity</th>';
									echo '<th>Subtotal</th>';
									echo '<th>Status</th>';
								echo '</tr>';

							while ($roi = mysqli_fetch_assoc($result_order_item)) {
								echo '<tr>';
									echo "<td><img src='".$roi['item_image']."'></td>";
									echo "<td>".$roi['name']."</td>";
									echo "<td>".$roi['item_desc']."</td>";
									echo "<td>".$roi['price']."</td>";
									echo "<td>".$roi['quantity']."</td>";
									echo "<td>".$roi['subtotal']."</td>";
									echo "<td>".$ro['status_id']."</td>";
								echo '</tr>';
							}
							echo '</table>';
							echo '<h5> Total Price: '. $ro['total_price'] .'</h5>';
						}
						echo '<br>';
					} else {

					}

					?>
				</div>
			</div>
			<div id="ordersHistory" class="card card-orders">
				<div class="card-header">
					Orders History
				</div>
				<div class="card-body">
					asdfgsd
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
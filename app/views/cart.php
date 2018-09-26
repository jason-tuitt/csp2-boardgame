<?php 
	include_once '../partials/header.php';
	require_once('../controllers/connect.php');
	session_start();
?>

	<link rel='stylesheet' type='text/css' href='./cart.css'>
</head>
<body>
	<?php include_once '../partials/navbar.php'; ?>
	<?php 
		if(!isset($_SESSION['user_data'])) {
			header('Location: ./catalog.php');
		}
	 ?>

	 <div class="appViewBox">
		<h1>Board Game Store - CartPage</h1>
		<a href="./catalog.php">go to catalog</a>
		<a href="../controllers/clear_cart.php">CLEAR CART</a>

		<div id="cartApp">
			<div id="cartContainer">
				<?php 
					if(count($_SESSION['cart']) > 0) {
						$cart = $_SESSION['cart'];
						$totalprice = 0;

							echo '<table>';
							echo '<tr>';
								echo '<th>Image</th>';
								echo '<th>Name</th>';
								echo '<th>Qty</th>';
								echo '<th>Price</th>';
								echo '<th>Item Description</th>';
								echo '<th>Subtotal</th>';
								echo '<th class="td-short"></th>';
							echo '</tr>';

						foreach($cart as $cart_item) {
							$sql = "SELECT * from items where id='$cart_item[id]'";

							if ($cart_item['qty'] <= 0) {
								continue;
							}

							$result = mysqli_query($conn, $sql);
							$row = mysqli_fetch_assoc($result);

							$subtotal = $row['price'] * $cart_item['qty'];

							echo '<tr>';
								echo "<td><img src=".$row['item_image']."></td>";
								echo "<td>".$row['name']."</td>";
								echo "<td><input id='input".$row['id']."' type='number' min='1' class='cart-qty-input' value='". $cart_item['qty'] ."'></td>"; //multiple id mistake, fix this, change innerhtml to inputvalue
								echo "<td id='price".$row['id']."'>".$row['price']."</td>";
								echo "<td>".$row['item_desc']."</td>";
								echo "<td>PHP <span class='subtotal-element' id='sub".$row['id']."'>". $subtotal."</span></td>";
								echo "<td><button id=".$row['id']." class='btn btn-danger button-delete-item'>DELETE</button></td>";
								$totalprice = $totalprice + $subtotal;
							echo '</tr>';
						}
							echo '<tr>';
								echo "<td></td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td><strong>Total Price</strong></td>";
								echo "<td><strong>PHP <span id='totalPriceCart'>".$totalprice."</span></strong></td>";
							echo '</tr>';

							echo '</table>';
							echo '<a href="../views/checkout.php"><button>Checkout</button></a>';
					} else {
						echo '<p>Empty Cart</p>';
					}

				 ?>
			</div>
		</div>
		</div>


<script type="text/javascript">
	const deletebuttons = document.querySelectorAll('.button-delete-item');

	console.log(deletebuttons);

	deletebuttons.forEach(ele => {
		ele.addEventListener("click", (event)=> {
			const id = event.target.id;
			console.log(event);

			deleteItem(id);

			// const deletedQuantity = document.querySelector(`#${id}`).value;	
			const deletedQuantity = document.querySelector(`#input${id}`);
			
			const totalPriceElement = document.querySelector('#totalPriceCart');
			const totalPrice = parseInt(totalPriceElement.innerHTML);
			const subtotal = ele.parentElement.previousSibling.lastChild.innerHTML;
			const cartQuantity = document.querySelector('#cartQuantity').textContent;

			totalPriceElement.innerHTML = totalPrice - subtotal;
	
			document.querySelector('#cartQuantity').textContent = cartQuantity - deletedQuantity.value;

			ele.parentElement.parentElement.remove();

			const table_rows = document.querySelectorAll('tr')
			if (table_rows.length <= 2) {
				$('#cartContainer').empty();
				$('#cartContainer').append(`
					<p>Empty Cart</p>`)
			}
		})
	});


	const numberInputQuantity = document.querySelectorAll('.cart-qty-input');


	numberInputQuantity.forEach(ele => {
		ele.addEventListener("input", (event) => {
			const inputid = event.target.id;
			const id = inputid.replace('input', '');
			const updatedQty = event.target.value;
			
			const totalPriceElement = document.querySelector('#totalPriceCart');
			const subtotalElement = document.querySelector(`#sub${id}`);
			const unitPrice = document.querySelector(`#price${id}`);

			subtotalElement.textContent = updatedQty * unitPrice.textContent;

			const allSubtotals = document.querySelectorAll('span[id^="sub"]')

			let newTotalPrice = 0;

			allSubtotals.forEach(ele => {
				newTotalPrice += parseInt(ele.textContent);
			})

			totalPriceElement.textContent = newTotalPrice;

			// console.log(subtotalElement.textContent);

			// const subtotal = ele.parentElement.previousSibling.lastChild.innerHTML;
			// const 

			
			$.ajax({
				url: '../controllers/update_cart_quantity.php',
				data:{id: id, qty: updatedQty},
				type:'POST',
				success: (data) => {
					const dataJSON = JSON.parse(data);
					document.querySelector('#cartQuantity').textContent = dataJSON;
				}
			})
		})
	})


	const deleteItem = (id) => {
		$.ajax({
			url: '../controllers/delete_cart_item.php',
			data: {id:id},
			type:'POST',
			success: (data) => {
				// console.log(data);
			}
		}) 
	}

</script>

<?php 
	include_once '../partials/footer.php';
?>
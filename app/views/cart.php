<?php 
	include_once '../partials/header.php';
	require_once('../controllers/connect.php');
	session_start();
?>

	<link rel='stylesheet' type='text/css' href='./cart.css'>
	<link rel='stylesheet' type='text/css' href='./input_number.css'>
</head>
<body>
	<?php include_once '../partials/navbar.php'; ?>
	<?php 
		if(!isset($_SESSION['user_data'])) {
			header('Location: ./catalog.php');
		}
		$totalprice = 0;
	 ?>

	 <div class="appViewBox">
		<h1>My Cart</h1>		
		<div id="cartApp">
			<div id="cartContainer">
				<a  href="./catalog.php"><button id="returnToShopping" class="btn btn-outline-success">Return to Shopping</button></a>
				<?php 
					if(count($_SESSION['cart']) > 0) {
						$cart = $_SESSION['cart'];
						$totalprice = 0;

							echo '<table>';
							echo '<tr>';
								echo '<th>Image</th>';
								echo '<th>Name</th>';
								echo '<th id="thQuantity">Qty</th>';
								echo '<th>Price</th>';
								// echo '<th>Item Description</th>';
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
								echo "<td><img id='td-image".$row['id']."'src=".$row['item_image']."></td>";
								echo "<td>".$row['name']."</td>";
								echo "<td><span class='input-number-decrement'>–</span><input id='input".$row['id']."'class='input-number' type='number' value='". $cart_item['qty'] ."'><span class='input-number-increment'>+</span></td>";
								// echo "<td><input id='input".$row['id']."' type='number' min='1' class='cart-qty-input' value='". $cart_item['qty'] ."'></td>"; 
								//multiple id mistake, fix this, change innerhtml to inputvalue
								echo "<td>Php <span id='price".$row['id']."'>".number_format($row['price'], 2, '.',',')."</span></td>";
								// echo "<td>".$row['item_desc']."</td>";
								echo "<td>PHP <span class='subtotal-element' id='sub".$row['id']."'>". number_format($subtotal, 2, '.', ',')."</span></td>";
								echo "<td><i id=".$row['id']." class='button-delete-item fas fa-trash-alt'></i></td>";
								$totalprice = $totalprice + round($subtotal, 2);
							echo '</tr>';
						}
							echo '<tr>';
								echo "<td></td>";
								echo "<td></td>";
								// echo "<td></td>";
								echo "<td></td>";
								echo "<td><strong>Total Price</strong></td>";
								echo "<td><strong>PHP <span id='totalPriceCart'>".number_format((float)$totalprice, 2, '.', ',')."</span></strong></td>";
								echo "<td></td>";
							echo '</tr>';

							echo '</table>';
					} else {
						echo '<p style="text-align:center; margin-top:16px;">Your cart is empty.</p>';
					}

				 ?>
			</div>
			<div id="cartSummary">
				<div class="card cart-summary-card">
					<div class="card-header">
						<h4>Cart Summary</h4>
					</div>
					<div class="card-body">
						<table id="cartSummaryTable">
							<tr>
								<td>Qty </td>
								<td><span id="cartSummaryQty"><?php echo $_SESSION['cartQuantity'] ?></span></td>
								<td>Qty Cart Quantity</td>
							</tr>
							<tr>
								<td>Php </td>
								<td><span id="cartSummaryTotalPrice"><?php echo number_format((float)$totalprice, 2, '.', ',') ?></span></td>
								<td>Php Total Amount</td>
							</tr>
							<tr>
								<td>Delivery</td>
								<td>Free</td>
								<td>Shipping</td>
							</tr>
						</table>
					</div>
					<div class="card-footer">
					<?php  
						if ($_SESSION['cartQuantity'] == 0 || !isset($_SESSION['cartQuantity'])) {
							echo "<a href='../views/checkout.php'><button class='btn btn-outline-dark'>Proceed to Checkout</button></a>";
						} else {
							echo "<a href='../views/checkout.php'><button class='btn btn-outline-dark'>Proceed to Checkout</button></a>";
						}
					?>	
					</div>				
				</div>
			</div>
		</div>
		</div>

<!-- <script src="../assets/js/input_number.js"></script> -->

<script type="text/javascript">
	const deletebuttons = document.querySelectorAll('.button-delete-item');

	deletebuttons.forEach(ele => {
		ele.addEventListener("click", (event)=> {
			const id = event.target.id;
			console.log(event);

			deleteItem(id);

			// const deletedQuantity = document.querySelector(`#${id}`).value;	
			const deletedQuantity = document.querySelector(`#input${id}`);
			
			const totalPriceElement = document.querySelector('#totalPriceCart');
			const totalPrice = parseFloat(totalPriceElement.innerHTML.replace(',', ''));
			const subtotal = parseFloat(ele.parentElement.previousSibling.lastChild.innerHTML.replace(',', ''));
			const cartQuantity = document.querySelector('#cartQuantity').textContent;

			totalPriceElement.innerHTML = Number(parseFloat(totalPrice - subtotal).toFixed(2)).toLocaleString('en');
			// totalPriceElement.innerHTML = totalPrice - subtotal;

			const cartSummaryTotalPrice = document.querySelector('#cartSummaryTotalPrice')

			cartSummaryTotalPrice.innerHTML =  Number(parseFloat(totalPrice - subtotal).toFixed(2)).toLocaleString('en');
	
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


	// const numberInputQuantity = document.querySelectorAll('.cart-qty-input');
	// numberInputQuantity.forEach(ele => {
	// 	ele.addEventListener("input", (event) => {
	// 		const inputid = event.target.id;
	// 		const id = inputid.replace('input', '');
	// 		$.ajax({
	// 			url: '../controllers/update_cart_quantity.php',
	// 			data:{id: id, qty: updatedQty},
	// 			type:'POST',
	// 			success: (data) => {
	// 				const dataJSON = JSON.parse(data);
	// 				document.querySelector('#cartQuantity').textContent = dataJSON;
	// 				document.querySelector('#cartSummaryQty').textContent = dataJSON;

	// 			}
	// 		})
	// 	})
	// })

	const updateCart = (id, updatedQty) => {
	
		const totalPriceElement = document.querySelector('#totalPriceCart');
		const subtotalElement = document.querySelector(`#sub${id}`);
		const unitPrice = parseFloat(document.querySelector(`#price${id}`).innerHTML.replace(',', ''));
		
		// console.log(parseFloat(unitPrice.replace(',', '')))
		// console.log(unitPrice);

		subtotalElement.textContent = Number(parseFloat(updatedQty * unitPrice).toFixed(2)).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});

		const allSubtotals = document.querySelectorAll('span[id^="sub"]')

		let newTotalPrice = 0;

		allSubtotals.forEach(ele => {
			newTotalPrice += parseFloat(ele.textContent.replace(',', ''));
		})

		totalPriceElement.textContent = Number(parseFloat(newTotalPrice).toFixed(2)).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});

		const cartSummaryTotalPrice = document.querySelector('#cartSummaryTotalPrice')

			cartSummaryTotalPrice.innerHTML = Number(parseFloat(newTotalPrice).toFixed(2)).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});

		$.ajax({
				url: '../controllers/update_cart_quantity.php',
				data:{id: id, qty: updatedQty},
				type:'POST',
				success: (data) => {
					const dataJSON = JSON.parse(data);
					document.querySelector('#cartQuantity').textContent = dataJSON;
				}
		})
	}


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


	//For input number



	const quantityInput = document.querySelectorAll(`input[id^="input"]`);

	quantityInput.forEach((ele) => {
		const id = ele.id.replace('input', '');
		ele.previousSibling.addEventListener("click", () => decrement(id))
		ele.nextSibling.addEventListener("click", () => increment(id))
		ele.addEventListener("blur", () => qtychange(id))
	})

	const decrement = (id) => {
		const val = document.querySelector(`#input${id}`);
		if (val.value >= 2) {
			val.value--
			updateCart(id, val.value)
		}
	}
	const increment = (id) => {
		const val = document.querySelector(`#input${id}`);
		val.value++	
		updateCart(id, val.value)
	}
	const qtychange = (id) => {
		const val = document.querySelector(`#input${id}`)
		updateCart(id, val.value)
	}


	const itemImage = document.querySelectorAll('[id^="td-image"]');

	itemImage.forEach((image) => {
		image.addEventListener("click", (e) => {
			const image_id = e.target.id;
			const id = image_id.replace('td-image', '');

			window.location.href = `./product.php?id=${id}`;
		})
	})

	// (function() {
 
	//   window.inputNumber = function(el) {

	//     var min = el.attr('min') || false;
	//     var max = el.attr('max') || false;

	//     var els = {};

	//     els.dec = el.prev();
	//     els.inc = el.next();

	//     el.each(function() {
	//       init($(this));
	//     });

	//     function init(el) {

	//       els.dec.on('click', decrement);
	//       els.inc.on('click', increment);

	//       function decrement() {
	//         var value = el[0].value;
	//         value--;
	//         if(!min || value >= min) {
	//           el[0].value = value;
	//         }
	//       }

	//       function increment() {
	//         var value = el[0].value;
	//         value++;
	//         if(!max || value <= max) {
	//           el[0].value = value++;
	//         }
	//       }
	//     }
	//   }
	// })();

	// $('.input-number').each(inputNumber())
	
	// inputNumber($('.input-number'));

</script>

<?php 
	include_once '../partials/footer.php';
?>
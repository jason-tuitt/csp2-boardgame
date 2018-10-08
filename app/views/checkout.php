<?php 
include_once '../partials/header.php';
require_once('../controllers/connect.php');
session_start();
?>

<?php 
// if ($_SERVER['HTTP_REFERER'] !== 'http://localhost:8000/views/cart.php') {
// 	header('Location: ../views/cart.php');
// }
?>

<link rel='stylesheet' type='text/css' href='./checkout.css'>
<link rel='stylesheet' type='text/css' href='../assets/css/spinner.css'>
</head>
<body>
	<?php 
	if(!isset($_SESSION['user_data'])) {
		header('Location: ./catalog.php');
	}
	if($_SESSION['cartQuantity'] < 1) {
		header('Location: ./catalog.php');
	}
	?>
	<?php include_once '../partials/navbar.php'; ?>
	

	<?php 
		$id = $_SESSION['user_data']['id'];
		$sql_address = "SELECT * from addresses where user_id = $id";
		$result_address = mysqli_query($conn, $sql_address);
		if (mysqli_num_rows($result_address) < 2) {
			
			include './new_address_modal.php';
			echo "
				<script>
					function noscroll() {
					  window.scrollTo( 0, 0 );
					}
					window.addEventListener('scroll', noscroll);
				</script>
			";
		}
	?>

	<?php 
		include_once("../partials/update_address_modal.php");
	?>

	<div id="checkoutModalLoad">a</div>

	<div class="appViewBox">
		<h1>Checkout Page</h1>

		<div id="checkoutApp">
			<form>
				<div id="shippingAndPayment">
					<div id="checkoutLeft">
						<div class="form-group">
							<label class="label-address" for="shippingAddress">Shipping Address</label><input type="button" id="updateAddressShipping" class="btn btn-outline-info update-address-button" value="Update Shipping Address"></input>
							<p id="currentShipping">Please enter a shipping address.</p>
							<label class="label-address" for="billingAddress">Billing Address</label><input type="button" id="updateAddressBilling" class="btn btn-outline-info update-address-button" value="Update Billing Address"></input>
							<p id="currentBilling">Please enter a billing address.</p>
						</div>
					</div>
					<div id="checkoutRight">
						<h6>Payment Method</h6>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="payment-method" id="pm1" value="cod" checked>
							<label class="form-check-label" for="cod">
								COD
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="payment-method" id="pm2" value="paypal">
							<label class="form-check-label" for="paypal">
								Paypal
							</label>
						</div>
						<h6>Order Summary</h6>
						<div class="list-group-item">PHP <span id="totalPrice"></span></div>
						<input type="button" style="margin-top: 20px;" id="submitOrder" class="btn btn-outline-primary" value="Place your order"></input>
					</div>
				</div>
			</form>
			<div id="orderItemsCheckoutContainer">
				<table id="orderItemsCheckout">
				</table>
			</div>
		</div>
	</div>

</body>

<script type="text/javascript" src="../assets/js/get_ph_info.js"></script>
<script type="text/javascript" src="../assets/js/get_update_address.js"></script>

<script type="text/javascript">
	
	const updateButton = document.querySelectorAll('[id^="updateAddress"]');

	updateButton.forEach(ele => {
		ele.addEventListener("click", (event) => {
			// document.querySelector('#updateModal').style.display = "flex";
			// setTimeout(() => {document.querySelector('#updateModal').style.opacity = "1";}, 200)

			// const typespan = document.querySelector('span#typeAddress');
			// const modalform = document.querySelector('#submitUpdateButton');

			// if (event.target.id == "updateAddressShipping") {
			// 	typespan.textContent = "Shipping"
			// 	modalform.setAttribute("submittal", 1);
			// }
			// else {
			// 	typespan.textContent = "Billing";
			// 	modalform.setAttribute("submittal", 2);
			// }
			window.location.href = "./account.php";
		})
	})

// FUNCTIONALITY //

	const get_checkout = () => {
		$('#orderItemsCheckout').empty();
		$('#orderItemsCheckout').append(`<div class="loadermodal"><div class="loader"></div></div>`);
		$.ajax({
			url: '../controllers/checkout.php',
			data:{},
			method: 'GET',
			success: (data) => {
				const itemData = JSON.parse(data);
				let shoppingCart;

				$.ajax({
					url: '../controllers/return_shopping_cart.php',
					data:{},
					method:'GET',
					success: (data) => {
						shoppingCart = JSON.parse(data);
						$('#orderItemsCheckout').empty();

						$('#orderItemsCheckout').append(`
							<tr>
							<th></th>
							<th>Item Name</th>
							<th>Item Price</th>
							<th>Quantity</th>
							<th>Subtotal</th>
							<th>Actions</th>
							</tr>
							`)

						let totalPrice = 0;

						for(let key in shoppingCart) {
							for(let key2 in itemData) {
								if (shoppingCart[key]['id'] == itemData[key2]['id']) {
									const subTotal = parseInt(shoppingCart[key]['qty'])*parseFloat(itemData[key2]['price']);

									const displaySubtotal = Number(parseFloat(subTotal).toFixed(2)).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})

									$('#orderItemsCheckout').append(`
										<tr>
										<td><image src="${itemData[key2]['item_image']}"></td>
										<td>${itemData[key2]['name']}</td>
										<td><span>Php </span>${Number(parseFloat(itemData[key2]['price']).toFixed(2)).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
										<td id='input${shoppingCart[key]['id']}'>${shoppingCart[key]['qty']}</td>
										<td>Php <span id='sub${shoppingCart[key]['id']}'>${displaySubtotal}</span></td>
										<td><i id='${shoppingCart[key]['id']}' class='button-delete-item fas fa-trash-alt'></i></td>
										</tr>
										`)

									// <button id='${shoppingCart[key]['id']}' class='btn btn-danger button-delete-item'>DELETE</button>

									totalPrice += subTotal;
								}
							}		
						} 

						document.querySelector("#totalPrice").textContent = Number(parseFloat(totalPrice).toFixed(2)).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});

						const deleteItem = (id) => {
							$.ajax({
								url: '../controllers/delete_cart_item.php',
								data: {id:id},
								type:'POST',
								success: (data) => {
									get_checkout();
								}
							}) 
						}

						const deletebuttons = document.querySelectorAll('.button-delete-item');

						deletebuttons.forEach(ele => {
							ele.addEventListener("click", (event)=> {
								const id = event.target.id;

								deleteItem(id);

								// const deletedQuantity = document.querySelector(`#${id}`).value;	
								const deletedQuantity = document.querySelector(`#input${id}`);
								const cartQuantity = document.querySelector('#cartQuantity').textContent;

								const totalPriceElement = document.querySelector('#totalPrice');
								const totalPrice = parseInt(totalPriceElement.textContent);
								const subtotal = document.querySelector(`#sub${id}`);

								document.querySelector('#cartQuantity').textContent = cartQuantity - deletedQuantity.textContent;

								document.querySelector("#totalPrice").textContent = totalPrice - subtotal.textContent;

								ele.parentElement.parentElement.remove();

								const table_rows = document.querySelectorAll('tr')
								console.log(table_rows)
								if (table_rows.length <= 1) {
									$('#orderItemsCheckoutContainer').empty();
									$('#orderItemsCheckoutContainer').append(`
										<p style="{text-align:center;}">Empty Cart</p>`)
								}
							})
						});
						const table_rows = document.querySelectorAll('tr')
						if (table_rows.length <= 1) {
							$('#orderItemsCheckoutContainer').empty();
							$('#orderItemsCheckoutContainer').append(`
								<p style="{text-align:center;}">Your Cart is Empty.</p>`)
							$('#orderItemsCheckoutContainer').append(`
								<a href="./catalog.php"><button class="btn btn-outline-success">Return to Shopping</button></a>`)
						}
					}
				})
			}
		})
	}

	const load_address = (type) => {
		$.ajax({
			url: '../controllers/get_address.php',
			data: {data: type},
			type: 'GET',
			success: (data) => {
				const d = JSON.parse(data);
				const ele = document.querySelector(`#${type}`);
				d ? ele.textContent = `${d.house_num_others}, ${d.barangay}, ${d.province_code}, ${d.region_province}, ${d.region}` : ele.textContent = "No information Provided."
				
			}
		})
	}

	// const get_ph_info = (category = "regions", filter = "01") => {
	// 	const selectList = document.querySelector('#selectregions')
	// 	console.log(category, filter)

	// 	const empty_append_category = (category) => {
	// 		$(`#select${category}`).empty();
	// 		$(`#select${category}`).append(`<option value="null">--PLEASE SELECT--</option>`);
	// 	}

	// 	$.ajax({
	// 		url:'../controllers/get_ph_info.php',
	// 		data:{category: category, filter:filter},
	// 		type: 'GET',
	// 		success: (data) => {
	// 			const d = JSON.parse(data);
	// 			if (category == "regions") {
	// 				for(let key in d) {
	// 					$('#selectregions').append(`
	// 						<option class=${category} value="${d[key]['region_code']}">${d[key]['region']}</option>
	// 					`)
	// 				}
	// 				empty_append_category("provinces");
	// 				empty_append_category("municipalities");
	// 				empty_append_category("barangays");
	// 			}

	// 			else if (category == "provinces") {
	// 				empty_append_category(category);
	// 				for(let key in d) {
	// 					$('#selectprovinces').append(`
	// 						<option class=${category} value="${d[key]['province_code']}">${d[key]['region_province']}</option>
	// 					`)
	// 				}
	// 				empty_append_category("municipalities");
	// 				empty_append_category("barangays");
	// 			}

	// 			else if (category == "municipalities") {
	// 				empty_append_category(category);
	// 				for(let key in d) {
	// 					$('#selectmunicipalities').append(`
	// 						<option class=${category} value="${d[key]['city_municipality_code']}">${d[key]['province_code']}</option>
	// 					`)
	// 				}
	// 				empty_append_category("barangays");
	// 			}

	// 			else if (category == "barangays") {
	// 				empty_append_category(category);
	// 				for(let key in d) {
	// 					$('#selectbarangays').append(`
	// 						<option class=${category} value="${d[key]['id']}">${d[key]['barangay']}</option>
	// 					`)
	// 				}
	// 			}

	// 			document.querySelector(`select#select${category}`).addEventListener("change", (event) => {
	// 					if (category == "regions") {
	// 						get_ph_info("provinces", event.target.value);
	// 					}
	// 					else if (category == "provinces") {
	// 						get_ph_info("municipalities", event.target.value);
	// 					} 
	// 					else if (category == "municipalities") {
	// 						get_ph_info("barangays", event.target.value);
	// 					} 
	// 					else return;
	// 			})
	// 		},
	// 		error: (error) => {
	// 			console.log("error:" + error)
	// 		}
	// 	})
	// }

	// document.querySelector('#submitUpdateButton').addEventListener("click", (event) => {
	// 	const submittal = event.target.attributes.submittal.nodeValue;
	// 	const street = $('#inputstreet').val();
	// 	const region = $('#selectregions :selected').val();
	// 	const province = $('#selectprovinces :selected').val();
	// 	const municipality = $('#selectmunicipalities :selected').val();
	// 	const barangay = $('#selectbarangays :selected').val();

	// 	if (submittal && street && region && province && municipality && barangay) {
			
	// 		document.querySelector('#updateModal').style.opacity = "0";
	// 		setTimeout(() => {document.querySelector('#updateModal').style.display = "none"}, 300)

	// 		$.ajax({
	// 			url:'../controllers/update_address.php',
	// 			data: {address_type_id: submittal, house_num_others: street, region_code: region, region_province_code: province, city_municipality_code: municipality, barangay_id: barangay},
	// 			type:'POST',
	// 			success: (data) => {
	// 				console.log(data);

	// 				load_address('currentShipping');
	// 				load_address('currentBilling');
	// 				get_ph_info("regions", "01");

	// 				alert('Updated address!')
	// 			}
	// 		})

	// 		$('#inputstreet').val('');
	// 		$('#inputstreet').empty();
	// 		$('#selectregions').empty();
	// 		$('#selectprovinces').empty();
	// 		$('#selectmunicipalities').empty();
	// 		$('#selectbarangays').empty();

	// 	} else {
	// 		alert('Please complete your address.')
	// 	}
	// })

	
	document.querySelector('#submitOrder').addEventListener("click", (event) => {
		

		$('body').prepend(`<div class="loadermodal"><div class="loader"></div></div>`)
		const radioButtons = document.querySelectorAll('[name="payment-method"]');
		const checked = [...radioButtons].filter((button) => button.checked);
		const totalPriceShown = document.querySelector('#totalPrice').textContent;

		let paymentMethod = 1;

		if (checked[0].id == "pm2") {
			paymentMethod = 2;
		}
		
		$.ajax({
			url: '../controllers/order.php',
			data: {paymentMethod: paymentMethod},
			type: 'POST',
			success: (data) => {
				$('body').find('div').first().remove();
				window.location = './view_orders.php';
			}
		})
	});


	/*SCROLL LOCK ON NEW ADDRESS*/
	
	// Remove listener to disable scroll
	// window.removeEventListener('scroll', noscroll);



	$(document).ready(get_checkout);
	$(document).ready(() => load_address('currentShipping'));
	$(document).ready(() => load_address('currentBilling'));
	$(document).ready(() => get_ph_info("regions", "01"));



	
</script>

<?php 
include_once '../partials/footer.php';
?>
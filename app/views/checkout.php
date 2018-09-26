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
</head>
<body>
	<?php include_once '../partials/navbar.php'; ?>
	<?php 
	if(!isset($_SESSION['user_data'])) {
		header('Location: ./catalog.php');
	}
	?>

	<div id="updateModal" class="close-modal">
		<div id="updateForm">
			<header>
				<h2>Update <span id="typeAddress"></span> Address</h2>
				<div class="close-modal"><i class="fas fa-times close-modal"></i></div>
			</header>
			<main>
				<div class="modal-input-div">
					<label for="region">Address Number and Street</label>
					<input class="modal-only" type="text" name="street" id="inputstreet">
				</div>
				<div class="modal-input-div">
					<label for="region">Region</label>
					<select class="modal-only" name="region" id="selectregions">
					</select>
				</div>
				<div class="modal-input-div">
					<label for="province">Province</label>
					<select class="modal-only" name="province" id="selectprovinces">
						<option value="null">--PLEASE SELECT--</option>
					</select>
				</div>
				<div class="modal-input-div">
					<label for="municipality">Municipality</label>
					<select class="modal-only" name="municipality" id="selectmunicipalities">
						<option value="null">--PLEASE SELECT--</option>
					</select>
				</div>
				<div class="modal-input-div">
					<label for="barangay">Barangay</label>
					<select class="modal-only" name="barangay" id="selectbarangays">
						<option value="null">--PLEASE SELECT--</option>
					</select>
				</div>
			</main>
			<footer>
				<button type="button" class="btn btn-secondary close-modal">Close</button>
        		<button type="button" class="btn btn-primary" id="submitUpdateButton">Update Address</button>
			</footer>	
		</div>
	</div>


	<div class="appViewBox">
		<h1>Board Game Store - Checkout Page</h1>
		<a href="./catalog.php">go to catalog</a>

		<div id="checkoutApp">
			<form>
				<div id="shippingAndPayment">
					<div id="checkoutLeft">
						<div class="form-group">
							<label class="label-address" for="shippingAddress">Shipping Address</label><input type="button" id="updateAddressShipping" class="btn btn-info update-address-button" value="Edit Shipping Address"></input>
							<p id="currentShipping">shipping</p>
							<label class="label-address" for="billingAddress">Billing Address</label><input type="button" id="updateAddressBilling" class="btn btn-info update-address-button" value="Edit Billing Address"></input>
							<p id="currentBilling">billing</p>
						</div>
					</div>
					<div id="checkoutRight">
						<h4>Payment Method</h4>
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
						<h4>Order Summary</h4>
						<div class="list-group-item">PHP <span id="totalPrice"></span></div>
						<input type="button" style="{margin-top: 20px;}" id="submitOrder" class="btn btn-primary" value="PLACE ORDER NOW"></input>
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

<script type="text/javascript">

// ANIMATION/DESIGN //

	const closeModal = document.querySelectorAll(".close-modal")

	closeModal.forEach(ele => {
		ele.addEventListener("click", (e) => {
			if(event.target == event.currentTarget) {	
				document.querySelector('#updateModal').style.opacity = "0";
				setTimeout(() => {document.querySelector('#updateModal').style.display = "none"}, 300)
			}
		})
	})
	
	const updateButton = document.querySelectorAll('[id^="updateAddress"]');

	updateButton.forEach(ele => {
		ele.addEventListener("click", (event) => {
			document.querySelector('#updateModal').style.display = "flex";
			setTimeout(() => {document.querySelector('#updateModal').style.opacity = "1";}, 200)

			const typespan = document.querySelector('span#typeAddress');
			const modalform = document.querySelector('#submitUpdateButton');

			if (event.target.id == "updateAddressShipping") {
				typespan.textContent = "Shipping"
				modalform.setAttribute("submittal", 1);
			}
			else {
				typespan.textContent = "Billing";
				modalform.setAttribute("submittal", 2);
			}
		})
	})

	// const submitUpdateButton = document.querySelector('#submitUpdateButton')

	// submitUpdateButton.addEventListener("click", () => {
	// 	document.querySelector('#updateModal').style.opacity = "0";
	// 	setTimeout(() => {document.querySelector('#updateModal').style.display = "none"}, 300)
	// })

// FUNCTIONALITY //

	const get_checkout = () => {
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
									const subTotal = parseInt(shoppingCart[key]['qty'])*parseInt(itemData[key2]['price']);

									$('#orderItemsCheckout').append(`
										<tr>
										<td><image src="${itemData[key2]['item_image']}"></td>
										<td>${itemData[key2]['name']}</td>
										<td>${itemData[key2]['price']}</td>
										<td id='input${shoppingCart[key]['id']}'>${shoppingCart[key]['qty']}</td>
										<td id='sub${shoppingCart[key]['id']}'>${subTotal}</td>
										<td><button id='${shoppingCart[key]['id']}' class='btn btn-danger button-delete-item'>DELETE</button></td>
										</tr>
										`)
									totalPrice += subTotal;
								}
							}		
						} 

						document.querySelector("#totalPrice").textContent = totalPrice;

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

						const deletebuttons = document.querySelectorAll('.button-delete-item');

						deletebuttons.forEach(ele => {
							ele.addEventListener("click", (event)=> {
								const id = event.target.id;

								deleteItem(id);

								// const deletedQuantity = document.querySelector(`#${id}`).value;	
								const deletedQuantity = document.querySelector(`#input${id}`);
								const cartQuantity = document.querySelector('#cartQuantity').textContent;

								const totalPriceElement = document.querySelector('#totalPrice');
								const totalPrice = parseInt(totalPriceElement.innerHTML);
								const subtotal = document.querySelector(`#sub${id}`);

								document.querySelector('#cartQuantity').textContent = cartQuantity - deletedQuantity.innerHTML;

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
								<p style="{text-align:center;}">Empty Cart</p>`)
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

				ele.textContent = `${d.house_num_others}, ${d.barangay}, ${d.province_code}, ${d.region_province}, ${d.region}`
			}
		})
	}

	let category = "regions"
	let filter = "01"

	const get_ph_info = (category, filter) => {
		const selectList = document.querySelector('#selectregions')

		$.ajax({
			url:'../controllers/get_ph_info.php',
			data:{category: category, filter:filter},
			type: 'GET',
			success: (data) => {
				const d = JSON.parse(data);
				// console.log(data);
				if (category == "regions") {
					$('#selectregions').empty();	
					// $('#selectregions').append(`<option value="null">--PLEASE SELECT YOUR REGION--</option>`)	
					for(let key in d) {
						$('#selectregions').append(`
							<option class=${category} value="${d[key]['region_code']}">${d[key]['region']}</option>
						`)
					}
				}

				else if (category == "provinces") {
					$('#selectprovinces').empty();
					for(let key in d) {
						$('#selectprovinces').append(`
							<option class=${category} value="${d[key]['province_code']}">${d[key]['region_province']}</option>
						`)
					}
				}

				else if (category == "municipalities") {
					$('#selectmunicipalities').empty();
					for(let key in d) {
						$('#selectmunicipalities').append(`
							<option class=${category} value="${d[key]['city_municipality_code']}">${d[key]['province_code']}</option>
						`)
					}
				}

				else if (category == "barangays") {
					$('#selectbarangays').empty();
					for(let key in d) {
						$('#selectbarangays').append(`
							<option class=${category} value="${d[key]['id']}">${d[key]['barangay']}</option>
						`)
					}
				}

				document.querySelector(`select#select${category}`).addEventListener("change", (event) => {
						if (category == "regions") {
							get_ph_info("provinces", event.target.value);
							$('#selectmunicipalities').empty();
							$('#selectmunicipalities').append(`<option value="null">--PLEASE SELECT--</option>`);
							$('#selectbarangays').empty();
							$('#selectbarangays').append(`<option value="null">--PLEASE SELECT--</option>`);
						}
						else if (category == "provinces") {
							get_ph_info("municipalities", event.target.value);
							$('#selectbarangays').empty();
							$('#selectbarangays').append(`<option value="null">--PLEASE SELECT--</option>`);
						} 
						else if (category == "municipalities") {
							get_ph_info("barangays", event.target.value);
						} 
						else return;
				})
			},
			error: (error) => {
				console.log("error:" + error)
			}
		})
	}

	document.querySelector('#submitUpdateButton').addEventListener("click", (event) => {
		const submittal = event.target.attributes.submittal.nodeValue;
		const street = $('#inputstreet').val();
		const region = $('#selectregions :selected').val();
		const province = $('#selectprovinces :selected').val();
		const municipality = $('#selectmunicipalities :selected').val();
		const barangay = $('#selectbarangays :selected').val();

		if (submittal && street && region && province && municipality && barangay) {
			
			document.querySelector('#updateModal').style.opacity = "0";
			setTimeout(() => {document.querySelector('#updateModal').style.display = "none"}, 300)

			$.ajax({
				url:'../controllers/update_address.php',
				data: {address_type_id: submittal, house_num_others: street, region_code: region, region_province_code: province, city_municipality_code: municipality, barangay_id: barangay},
				type:'POST',
				success: (data) => {
					console.log(data);

					load_address('currentShipping');
					load_address('currentBilling');
					get_ph_info("regions", "01");

					alert('Updated address!')
				}
			})

			$('#inputstreet').val('');
			$('#inputstreet').empty();
			$('#selectregions').empty();
			$('#selectprovinces').empty();
			$('#selectmunicipalities').empty();
			$('#selectbarangays').empty();

		} else {
			alert('Please complete your address.')
		}
	})

	
	document.querySelector('#submitOrder').addEventListener("click", (event) => {
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
				console.log(data);
			}
		})
	});



	$(document).ready(get_checkout);
	$(document).ready(() => load_address('currentShipping'));
	$(document).ready(() => load_address('currentBilling'));
	$(document).ready(() => get_ph_info("regions", "01"));



	
</script>

<?php 
include_once '../partials/footer.php';
?>
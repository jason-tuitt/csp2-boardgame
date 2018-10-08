<?php 
	include_once '../partials/header.php';
	require_once('../controllers/connect.php');
	session_start();
?>

	<link rel='stylesheet' type='text/css' href='product.css'>
	<link rel='stylesheet' type='text/css' href='./input_number.css'>
</head>
<body>
	<?php include_once '../partials/navbar.php'; ?>
	 <div class='appViewBox'>
	 	<h1>Product Information</h1>
	 	<div id='productApp'>
	 		<?php 
		 		$id = $_GET['id'];
		 		// echo $id;

		 		$sql = "SELECT * from items where id= $id";
		 		$result = mysqli_query($conn, $sql);

		 		if(mysqli_num_rows($result) > 0) {
		 			$row = mysqli_fetch_assoc($result);

		 			echo "<div id='productContainerLeft'><img src='".$row['item_image']."' alt=''></div>";
		 			echo "<div id='productContainerRight'>
			 				<div>
					 			<h2>".$row['name']."</h2>
					 			<ul id='price-availability'>
					 				<li><i class='far fa-money-bill-alt'></i>Php ".$row['price']."</li>
					 				<li><i class='fas fa-archive'></i>In Stock</li>
					 			</ul>
					 			<ul id='age-players-averagetime'>
					 				<li><i class='far fa-calendar-alt'></i>Ages ".$row['age']." and above</li>
					 				<li><i class='fas fa-user'></i></i>Players ".$row['min_players']." - ".$row['max_players']."</li>
					 				<li><i class='fas fa-stopwatch'></i>".$row['average_length_id']." </li>
					 			</ul>
					 			<div id='itemDescDiv'>
					 				<p>".$row['item_desc']."</p>
								</div>
					 			<ul id='rating-wishlist-share'>
					 				<li><i class='far fa-star'></i>Rating: ".round($row['rating'], 2)." /10</li>
					 				<li><i class='far fa-heart'></i>Wishlist</li>
					 				<li><i class='fas fa-share'></i>Share</li>
					 			</ul>
				 			</div>
				 			<div id='productQtyField'>
								<div>
									<span class='input-number-decrement'>–</span><input id='input".$id."'class='input-number' type='number' value='1'><span class='input-number-increment'>+</span>
								</div>
								<span>Quantity</span>
							</div>
							<div id = 'productButtonField'>
								<div>";
									if(isset($_SESSION['user_data'])) {
										echo "<button onClick=addToCart(".$id.") class='btn btn-outline-dark'>Add to Cart <i class='fas fa-shopping-cart'></i></button></div>";
									} else {
										echo "<a href='./login.php'><button class='btn btn-outline-dark'>Add To Cart <i class='fas fa-shopping-cart'></i></button></a></div>";
									};
								echo "<div>
										<a  href='./catalog.php'><button id='returnToShopping' class='btn btn-outline-success'>Return to Shopping</button></a>
									</div>
								</div>
							</div>
						</div>";
		 		}
		 	?>
	 	</div>
	 </div>
	 	
<!-- 
	<script src="../assets/js/input_number.js"></script> -->
	<script>
		const addToCart = (id) => {
			const qty = document.querySelector(`#input${id}`).value;

			// console.log(qty);
			$.ajax({
				url: '../controllers/add_to_cart.php',
				data: {id: id, qty: qty},
				type: 'POST',
				success: (data) => {
					const cartQty = document.querySelector('#cartQuantity')
					cartQty.textContent = data;
				}
			})
	}

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
				// updateCart(id, val.value)
			}
		}
		const increment = (id) => {
			const val = document.querySelector(`#input${id}`);
			val.value++	
			// updateCart(id, val.value)
		}
		const qtychange = (id) => {
			const val = document.querySelector(`#input${id}`)
			// updateCart(id, val.value)
		}


	</script>

<?php 
	include_once '../partials/footer.php';
?>
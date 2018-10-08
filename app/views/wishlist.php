<?php 
	include_once '../partials/header.php';
	require_once('../controllers/connect.php');
	session_start();
?>

	<link rel='stylesheet' type='text/css' href='./wishlist.css'>
</head>
<body>
	<?php 
		if(!isset($_SESSION['user_data'])) {
			header('Location: ./catalog.php');
		}
	?>
	<?php include_once '../partials/navbar.php'; ?>
	
	<div class="appViewBox">
	 	<h1>My Bored Gamer's Wishlist</h1>
	 	<div style="display: flex; justify-content: center; margin:10px 0;" >
	 		<a href="./catalog.php"><button id="returnToShopping" class="btn btn-outline-success">Return to Shopping</button></a>
	 	</div>
	 	<div id="wishlistApp">
	 		
	 	</div>

	</div>

	<script>
		const get_wishlist = () => {
			$.ajax({
				url:'../controllers/wishlist.php',
				type:'GET',
				success: (data) => {
					const d = JSON.parse(data);

					$('#wishlistApp').empty();
					$('#wishlistApp').append(`<div class="card">
			 			<div class="card-header">
			 				<h5>My Wishlist</h5>
			 			</div>
			 			<div class="card-body">
			 				<table id="wishlistTable">
			 				</table>
			 			</div>
			 			<div class="card-footer">
			 				<a  href="./catalog.php"><button id="returnToShopping" class="btn btn-outline-success">Return to Shopping</button></a>
			 			</div>
			 		</div>
					`);
					if (d.length > 0) {
						$('#wishlistTable').empty();
						for(let item of d) {	
						$('#wishlistTable').append(`
							<tr>
								<td><img src="${item.item_image}" style="width:250px;height:250px"></td>
								<td>${item.name}</td>
								<td>Php ${Number(item.price).toLocaleString('en')}</td>
								<td><button class="btn btn-outline-danger" id="deleteWishlistItem${item.id}">Delete from Wishlist</button></td>
							</tr>`);
						}
						add_delete_wish_listener();
					} else {
						$('#wishlistTable').empty();
						$('#wishlistTable').append(`<p>You do not have any wishlist.<p>`);
					}
				}
			})
		}	

		const add_delete_wish_listener = () => {
			const deleteButton = document.querySelectorAll('[id^="deleteWishlistItem"]');
			deleteButton.forEach(button => {
				button.addEventListener("click", (event) => {
					const dom_id = event.target.id;
					const item_id = dom_id.replace(/\D/g, '');
					// console.log(item_id)
					delete_wish(item_id);
				})
			})
		}

		const delete_wish = (id) => {
			$.ajax({
				url:'../controllers/delete_wishlist.php',
				data:{id:id},
				type:'POST',
				success: (data) => {
					const d = JSON.parse(data);
					const wishlistQty = document.querySelector('#wishlistQuantity')
					wishlistQty.textContent = d;
					get_wishlist();
				}
			})
		}
		get_wishlist();

	</script>

<?php 
	include_once '../partials/footer.php';
?>
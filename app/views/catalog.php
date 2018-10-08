<?php 
	include_once '../partials/header.php';
	require_once('../controllers/connect.php');
	session_start();
	// $_SESSION['game_id_filter'] = 'ALL';
	// $_SESSION['type_id_filter'] = 'ALL';
?>

	<link rel='stylesheet' type='text/css' href='./catalog.css'>
	<link rel="stylesheet" href="../assets/css/spinner.css">
	<script type="text/javascript">	
		const adjustHeight = () => {
		let distancePX = $(window).scrollTop();
		let windowHeight = $(window).height();
		let distanceVH = 100*distancePX/windowHeight;

		const filterbar = document.querySelector('#filterdiv');
		// console.log(distanceVH);
		if (distanceVH >= 20) {
			filterbar.classList.add('filter-move-up');
		} else {
			filterbar.classList.remove('filter-move-up');
		}
	}
	</script>
</head>
<body onscroll="adjustHeight()">
	<?php include_once '../partials/navbar.php'; ?>
	
	<div class="appViewBox">
	
		<h1>Our Board Game Library</h1>

		<!-- <div class="loader"></div> -->

		<div id='catalogContainer'>
			<div id='filterbarContainer'>
				<div id="filterdiv">
				<p>Filter by Game</p>
				<ul class='list-group'>
				  <li id='categories1'class='list-group-item game-filter-list-item'>Board Games</li>
				  <li id='categories2'class='list-group-item game-filter-list-item'>Card Games</li>
				  <li id='categories3'class='list-group-item game-filter-list-item'>Special Games</li>
				</ul>
				<p>Filter by Type</p>
				<ul class='list-group'>
				  <li id='gametypes1' class='list-group-item type-filter-list-item'>Strategy</li>
				  <li id='gametypes2' class='list-group-item type-filter-list-item'>Party / Socialize</li>
				  <li id='gametypes3' class='list-group-item type-filter-list-item'>For Fun</li>
				  <li id='gametypes4' class='list-group-item type-filter-list-item'>Kids</li>
				  <li id='gametypes5' class='list-group-item type-filter-list-item'>Cooperative</li>
				  <li id='gametypes6' class='list-group-item type-filter-list-item'>Puzzle</li>
				</ul>	
	
				  <p id="clearFilter">Remove Filters</p>
		
				</div>	
			</div>

			<div id='rightSide'>
				<!-- <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
				  <div class="carousel-inner">
				    <div class="carousel-item active">
				      <img class="d-block w-100" src="../assets/image/carousel-image1.jpg" alt="First slide">
				    </div>
				    <div class="carousel-item">
				      <img class="d-block w-100" src="../assets/image/carousel-image2.jpg" alt="Second slide">
				    </div>
				    <div class="carousel-item">
				      <img class="d-block w-100" src="../assets/image/carousel-image3.jpg" alt="Third slide">
				    </div>
				  </div>
				</div>
				<h2 id="forSaleHeader">Board Games</h2> -->
				<!-- <div id="filterToolbar">
						<button id="gridButton"><i class="fas fa-th"></i></button>
						<button id="listButton"><i class="fas fa-list"></i></button>
				</div> -->
				<div id="navcenter">
				    <input type="text" id="searchBoardGame" placeholder="Search for a game!">
				    <span id="searchBoardGameIcon"><i class="fas fa-search"></i></a></span>
				  </div>
				<div id='itemsForSale'>
					
					<?php
						$sql = "SELECT id, name, price, item_image, item_desc FROM items LIMIT 25";
						$result = mysqli_query($conn, $sql);

						if (mysqli_num_rows($result) > 0) {
							while($row = mysqli_fetch_assoc($result)) {
								echo "<div class='cardContainer'>
									<div class='card' id='".$row['id']."'>
									  <img class='card-img-top' src='". $row['item_image'] ."' alt='Card image cap' id='".$row['id']."'>
									  <div class='card-body' id='".$row['id']."'>
									    <h5 class='card-title' id='".$row['id']."'>". $row['name'] ."</h5>
									    <div class='catalog-item-desc'><p>".$row['item_desc']."</p></div>
									    <h6 id='".$row['id']."'> <strong>PHP</strong> ". number_format($row['price'], 2, '.', ',') ."</h6><div class='catalog-buttons-container'>
									    ";
									    	if(isset($_SESSION['user_data'])) {
												echo "<button onClick=event.stopPropagation();addToCart(".$row['id'].") class='btn btn-outline-dark'>Add to Cart <i class='fas fa-shopping-cart'></i></button>";
											} else {
												echo "<button onClick=event.stopPropagation();location.href='./login.php' class='btn btn-outline-dark'>Add To Cart <i class='fas fa-shopping-cart'></i></button>";
											};

											echo "<button onClick=event.stopPropagation();addToWishlist(".$row['id'].")  class='btn btn-outline-danger'> Wishlist <i class='far fa-heart'></i></button></div>";
									     echo "</div>
									</div>
								</div>";  
							}
						}
					 ?>

				</div>
			</div>
		</div>
	</div>



<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

<script type="text/javascript">

	/*LI CLICK LISTENER*/

	document.querySelectorAll('.game-filter-list-item').forEach(li => {
		li.addEventListener("click", (event) => {
			const id = event.target.id;
			const cat_id = id.replace(/[^0-9]*/, '')
			filter("categories_id", cat_id);
		})
	})
	document.querySelectorAll('.type-filter-list-item').forEach(li => {
		li.addEventListener("click", (event) => {
			const id = event.target.id;
			const cat_id = id.replace(/[^0-9]*/, '')
			filter("game_types_id", cat_id);
		})
	})

	document.querySelector('#clearFilter').addEventListener("click", () => {
		filter('none')
		document.querySelectorAll('.list-group-item').forEach(li => {
			li.classList.remove('selected-filter');
		})
	});

	/*FILTER FUNCTION AJAX AND ANIMATION*/

	const filter = (filter, id=1) => {
		const f = filter == "categories_id" ? 'categories' : 'gametypes';

		const liDom = document.querySelectorAll(`[id^=${f}]`)

		liDom.forEach(li => {
			li.classList.remove('selected-filter');
			if (id == li.id.replace(/[^0-9]*/, '')) {
				li.classList.add('selected-filter');
			}
		})

		$('body').prepend(`<div class="loadermodal"><div class="loader"></div></div>`)

		setTimeout(() => $.ajax({
			url: '../controllers/filter_items.php',
			data: {filter: filter, id: id},
			type:'GET',
			success: (data) => {
				let dataParse = JSON.parse(data);

				const dataFiltered = dataParse.filter;
				const login = dataParse.login;

				$('#itemsForSale').empty();

				$('body').find('div').first().remove();

				if (dataParse.filter.length === 0) {
					$('#itemsForSale').append(
						`<p>Item not found</p>`
						);
				}
			generate_cards(dataFiltered, login);
			}
		}), 150)
	}


	const generate_cards = (dataFiltered, login) => {
		for (let key in dataFiltered) {
					$('#itemsForSale').append(`
						<div class='cardContainer'>
							<div class='card' id='${dataFiltered[key]['id']}'>
								<img class='card-img-top' src="${dataFiltered[key]['item_image']}" alt='Card image cap' id='${dataFiltered[key]['id']}'>
								<div class='card-body' id='${dataFiltered[key]['id']}'>
									<h5 class='card-title' id='${dataFiltered[key]['id']}'>${dataFiltered[key]["name"]}</h5>
									<div class='catalog-item-desc'><p>${dataFiltered[key]['item_desc']}</p></div>
									<h6 id='${dataFiltered[key]['id']}'><strong>PHP </strong>${Number(parseFloat(dataFiltered[key]["price"]).toFixed(2)).toLocaleString('en')}</h6>
									${login 
										? `<div class='catalog-buttons-container'><button onClick=event.stopPropagation();addToCart(${dataFiltered[key]['id']}) class='btn btn-outline-dark'>Add To Cart <i class='fas fa-shopping-cart'></i></button>`
										: `<div class='catalog-buttons-container'><button onClick=event.stopPropagation();location.href='./login.php' class='btn btn-outline-dark'>Add To Cart <i class='fas fa-shopping-cart'></i></button>`	
									}
									<button onClick=event.stopPropagation();addToWishlist(${dataFiltered[key]['id']})  class='btn btn-outline-danger'> Wishlist <i class='far fa-heart'></i></button></div>
								</div>
							</div>
					</div>`)
				}
		addListenerToCards();
		addGridListToCards();
	}

	const addToCart = (id) => {
		$.ajax({
			url: '../controllers/add_to_cart.php',
			data: {id: id, qty: 1},
			type: 'POST',
			success: (data) => {
				const cartQty = document.querySelector('#cartQuantity')
				cartQty.textContent = data;
				alert('Item Added!')
			}
		})
	}

	const addToWishlist = (id) => {
		$.ajax({
			url:'../controllers/add_wishlist.php',
			data:{id:id},
			type:'POST',
			success:(data) => {
				const wishlistQty = document.querySelector('#wishlistQuantity')
				wishlistQty.textContent = data;
				alert('Item Added To Wishlist!')
			}
		})
	}

	const addListenerToCards = () => {
		const cards = document.querySelectorAll('.cardContainer .card');
		// console.log(cards);

		cards.forEach(card => {
			card.addEventListener("click", (event) => {
				const card_id = event.target.id;
				console.log(card_id);
				window.location.href = `./product.php?id=${card_id}`
			})
		})
	}

	/*SEARCH BAR FILTER*/

	const searchDom = document.querySelector('#searchBoardGame');
	const searchIconDom = document.querySelector('#searchBoardGameIcon');

	searchDom.addEventListener("keypress", (event) => {
		if (event.keyCode == 13) {
			if (searchDom.value == '') {
				return
			} else {
				$('body').prepend(`<div class="loadermodal"><div class="loader"></div></div>`)
		 		 search_game();
			}
		}
	})
	searchIconDom.addEventListener("click", () => {
		if (searchDom.value == '') {
				return
			} else {
				$('body').prepend(`<div class="loadermodal"><div class="loader"></div></div>`)
				search_game();
			}
	})

	const search_game = () => {
		const filtered = searchDom.value;
			filter('none');

			setTimeout(() => $.ajax({
				  url:'../controllers/filter_word.php',
				  data:{filter: filtered},
				  type:'GET',
				  success: (data) => {
				  	// console.log(data);
				    let dataParse = JSON.parse(data);
					
					const dataFiltered = dataParse.filter;
					const login = dataParse.login;

					$('body').find('div').first().remove();
					$('#itemsForSale').empty();

					if (dataParse.filter.length === 0) {
						$('#itemsForSale').append(
							`<p>Item not found</p>`
							);
					}	
					generate_cards(dataFiltered, login);	
				  }
			}), 200)
	}

	addListenerToCards();
	

	const addGridListToCards = () => {
		const cardContainerDom = document.querySelectorAll('.cardContainer');
		const forSaleDom = document.querySelectorAll('#itemsForSale');

		document.querySelector('#gridButton').addEventListener("click", () => {
			forSaleDom.classList.remove('itemsForSale-list');
			cardContainerDom.classList.toggle('cardContainer-list')
			cardContainerDom.classList.toggle('catalog-item-desc')
		})

		document.querySelector('#listButton').addEventListener("click", () => {
			forSaleDom.classList.add('itemsForSale-list');
			cardContainerDom.classList.toggle('cardContainer-list')
			cardContainerDom.classList.toggle('catalog-item-desc')
		})


		const remove_class = (dom, c) => {
			dom.forEach(d => {
				d.classList.remove(c);
			})
		}
		const add_class = (dom, c) => {
			dom.forEach(d => {
				d.classList.add(c);
			})
		}
	}

	


</script>

<?php 
	include_once '../partials/footer.php';
?>


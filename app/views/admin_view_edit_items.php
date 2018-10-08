<?php 
include_once '../partials/header.php';
require_once('../controllers/connect.php');
session_start();
	// $_SESSION['game_id_filter'] = 'ALL';
	// $_SESSION['type_id_filter'] = 'ALL';
?>
<link rel="stylesheet" href="../assets/css/spinner.css">
<link rel="stylesheet" href="./admin_view_edit_items.css">
</head>
<body onscroll="adjustHeightModal()">
	<?php include_once '../partials/navbar.php'; ?>

	<?php include_once '../partials/admin_update_item_modal.php'; ?>
	<?php include_once '../partials/admin_add_item_modal.php'; ?>


	<div class="appViewBox">
		<h1>The Board Game Library</h1>

		<!-- <div class="loader"></div> -->

		<div id='adminItemsApp'>
			<div style="display: flex; justify-content: center; padding:20px 0;">
				<button style="text-align:center; min-width: 400px;"id="adminAddNewItem" class="btn btn-outline-success">Add New Item</button>
			</div>
			<div id="adminCompleteItems">
				
			</div>
		</div>
	</div>

	<script type="text/javascript">

		//UPDATE ITEMS DOM

		const nameModal = document.querySelector('.admin-item-input-div [name="name"]');
		const priceModal = document.querySelector('.admin-item-input-div [name="price"]');
		const urlModal = document.querySelector('.admin-item-input-div [name="url"]');
		const itemdescModal = document.querySelector('.admin-item-input-div [name="desc"]');
		const minplayerModal = document.querySelector('.admin-item-input-div [name="minplayer"]');
		const maxplayerModal = document.querySelector('.admin-item-input-div [name="maxplayer"]');
		const timeModal = document.querySelector('.admin-item-input-div [name="time"]');
		const catModal = document.querySelector('.admin-item-input-div [name="category"]');
		const gtModal = document.querySelector('.admin-item-input-div [name="gametype"]');
		const trendModal = document.querySelector('.admin-item-input-div [name="trend"]');
		const yearModal = document.querySelector('.admin-item-input-div [name="year"]');
		const ratingModal = document.querySelector('.admin-item-input-div [name="rating"]');
		const inputidModal = document.querySelector('#adminUpdateModalItemId');

		const modalDom = [inputidModal, nameModal,priceModal,urlModal,itemdescModal,minplayerModal,maxplayerModal,timeModal,catModal,gtModal,trendModal,yearModal,ratingModal]

		const modalname = ['id','name', 'price', 'item_image', 'item_desc', 'min_players','max_players', 'average_length_id', 'categories_id', 'game_types_id', 'trends_id', 'year', 'rating']

		//ADD ITEMS DOM

		const addnameModal = document.querySelector('.admin-item-input-div [name="nameadd"]');
		const addpriceModal = document.querySelector('.admin-item-input-div [name="priceadd"]');
		const addurlModal = document.querySelector('.admin-item-input-div [name="urladd"]');
		const additemdescModal = document.querySelector('.admin-item-input-div [name="descadd"]');
		const addminplayerModal = document.querySelector('.admin-item-input-div [name="minplayeradd"]');
		const addmaxplayerModal = document.querySelector('.admin-item-input-div [name="maxplayeradd"]');
		const addtimeModal = document.querySelector('.admin-item-input-div [name="timeadd"]');
		const addcatModal = document.querySelector('.admin-item-input-div [name="categoryadd"]');
		const addgtModal = document.querySelector('.admin-item-input-div [name="gametypeadd"]');
		const addtrendModal = document.querySelector('.admin-item-input-div [name="trendadd"]');
		const addyearModal = document.querySelector('.admin-item-input-div [name="yearadd"]');
		const addratingModal = document.querySelector('.admin-item-input-div [name="ratingadd"]');
		const addinputidModal = document.querySelector('#adminUpdateModalItemIdadd');

		const modalnameadd = ['name', 'price', 'item_image', 'item_desc', 'min_players','max_players', 'average_length_id', 'categories_id', 'game_types_id', 'trends_id', 'year', 'rating']

		const addmodalDom = [addnameModal,addpriceModal,addurlModal,additemdescModal,addminplayerModal,addmaxplayerModal,addtimeModal,addcatModal,addgtModal,addtrendModal,addyearModal,addratingModal]

		//Get All Items
		const admin_complete_items = () => {
			// $('#adminCompleteItems').empty();
			// $('#adminCompleteItems').append(`<div class="loadermodal"><div class="loader"></div></div>`);

			$.ajax({
				url: '../controllers/admin_view_edit_items.php',
				type:'POST',
				success: (data) => {
					let d = JSON.parse(data);
					$('#adminCompleteItems').empty();

					for(let item of d) {
						$('#adminCompleteItems').append(`
							<div class="adminItemContainer" id="adminItem${item.id}">
							<div class="adminItemContainerLeft">
							<div class="admin-admin-image">
							<img src="${item.item_image}">
							<p><strong>Image Provided</strong></p>
							</div>
							</div>
							<div class="adminItemContainerRight">
							<div class="admin-id-name-price">
							<p><strong>ID</strong>: ${item.id}</p>
							<p><strong>Name</strong>: ${item.name}</p>
							<p><strong>Price</strong>: Php ${item.price}</p>
							</div>
							<div class="admin-min-max-time">
							<p><strong>Min Players</strong>: ${item.min_players}</p>
							<p><strong>Max Players</strong>: ${item.max_players}</p>
							<p><strong>Average Time</strong>: ${item.average_length_id}</p>
							</div>

							<div class="admin-itemdesc">
							
							<p><strong>Item Description</strong>: ${item.item_desc}</p>
							</div>

							<div class="admin-cat-gt-trend">
							<p><strong>Category</strong>: ${item.category_names}</p>
							<p><strong>Type</strong>: ${item.game_type_names}</p>
							<p><strong>Trend</strong>: ${item.trend_names}</p>
							</div>
							<div class="admin-pub-rating">
							<p><strong>year</strong>: ${item.year}</p>
							<p><strong>Rating</strong>: ${item.rating}</p>
							</div>
							<div class="admin-update-button">
							<button class="btn btn-outline-primary" id="adminupdatebutton${item.id}">Update Item Information</button>
							</div>
							</div>
							</div>
							`);
					}

					const adminUpdateButton = document.querySelectorAll('[id^="adminupdatebutton"]');

					adminUpdateButton.forEach(button => {
						button.addEventListener("click", (event) => {
							const item_id = event.target.id.replace('adminupdatebutton', '');
						// console.log(item_id);

						document.querySelector('#adminUpdateModal').style.display = 'flex';
						setTimeout(() => document.querySelector('#adminUpdateModal').style.opacity = 1, 200)

						admin_single_item(item_id);
						})
					})
				}
			})
		}

		/*Add Item Button Functionality*/

		document.querySelector('#adminAddNewItem').addEventListener("click", () => {
			document.querySelector('#adminAddModal').style.display = 'flex';
			setTimeout(() => document.querySelector('#adminAddModal').style.opacity = 1, 200)
		})

		document.querySelector('#adminAddCloseModalButton').addEventListener('click', () => {
			setTimeout(() => document.querySelector('#adminAddModal').style.display = 'none', 300)

			document.querySelector('#adminAddModal').style.opacity = 0;

			addmodalDom.forEach(dom => {
				dom.value = '';

				if (!dom.getAttribute('type')) {
					dom.value = 1;
				} 
			})

		})

		document.querySelector('#adminSubmitAddItemButton').addEventListener('click', () => {
			adminSubmitAddItem();
		})

		/*Add Item Function*/

		const adminSubmitAddItem = () => {
			const newItemData = {};

			modalnameadd.forEach((form,index) => {
				if (addmodalDom[index].value) {
					newItemData[form] = addmodalDom[index].value;
				} else {
					alert('Please fill in all details.')
					continue;
				}
				
			})

			// console.log(document.querySelector('uploadImage').files);

			let file_data = $("#uploadImageAdd").prop('files')[0];
			let formData = new FormData();
		    formData.append("uploadimageadd", file_data);
		 	
			$('#adminCompleteItems').empty();
			$('#adminCompleteItems').append(`<div class="loadermodal"><div class="loader"></div></div>`);

			$.ajax({
				url:'../controllers/admin_add_item.php',
				data:{...newItemData},
				type:'POST',
				success: (data) => {
					$.ajax({
						url:'../controllers/admin_add_image.php',
						data:formData,
						type:'POST',
						contentType: false,
						processData: false, 
						success: (data) => {
							console.log(data);
							admin_complete_items();
						}
					})
					document.querySelector('#adminAddCloseModalButton').click();
				}
			})
		}

		/*Update Functions*/

		const adminSubmitUpdateItem = () => {
			const dataObject = {};
			modalDom.forEach((form, index) => {		
				const column = modalname[index];
				dataObject[column] = form.value
			})
			// console.log(dataObject);
			let file_data = $("#uploadImage").prop('files')[0];
			let formData = new FormData();
		    formData.append("uploadimage", file_data);

		    $('#adminCompleteItems').empty();
			$('#adminCompleteItems').append(`<div class="loadermodal"><div class="loader"></div></div>`);
		 	
			$.ajax({
				url:'../controllers/admin_update_item.php',
				data: {...dataObject},
				type:'POST',
				success: (data) => {
					$.ajax({
						url:'../controllers/admin_update_image.php',
						data:formData,
						type:'POST',
						contentType: false,
						processData: false, 
						success: (data) => {
							admin_complete_items();
						}
					})
					document.querySelector('#adminCloseModalButton').click();
				}
			})
		}

		const adminDeleteItemButton = () => {
			const item_id = inputidModal.value;

			$.ajax({
				url:'../controllers/admin_delete_item.php',
				data:{id: item_id},
				type:'POST',
				success: (data) => {
					console.log(data);
					admin_complete_items();
					document.querySelector('#adminCloseModalButton').click();
				}
			})
		}

		const admin_single_item = (id) => {
			$.ajax({
				url:'../controllers/admin_get_single_item.php',
				data:{id:id},
				type:'GET',
				success: (data) => {
					const d = JSON.parse(data);
				
				// console.log(d)
				inputidModal.value = d.id;
				nameModal.value = d.name;
				priceModal.value = d.price;
				urlModal.value = d.item_image;
				itemdescModal.value = d.item_desc;
				minplayerModal.value = d.min_players;
				maxplayerModal.value = d.max_players;
				timeModal.value = d.average_length_id;
				set_select_default(d.categories_id,'category');
				set_select_default(d.game_types_id,'gametype');
				set_select_default(d.trends_id,'trend');
				yearModal.value = d.year;
				ratingModal.value = d.rating;
				}
			})
		}

		const set_select_default = (data, select) => {
			let temp = data;
			let mySelect = document.querySelector(`.admin-item-input-div [name="${select}"]`);

			// console.log(mySelect);

			for(var i, j = 0; i = mySelect.options[j]; j++) {
				// console.log(j)
				if(i.value == temp) {
					mySelect.selectedIndex = j;
					break;
				}
			}
		}


		/*Update Modal Button Functionality*/

		document.querySelector('#adminCloseModalButton').addEventListener('click', () => {

			setTimeout(() => document.querySelector('#adminUpdateModal').style.display = 'none', 300)

			document.querySelector('#adminUpdateModal').style.opacity = 0;
		})

		document.querySelector('#adminSubmitUpdateItemButton').addEventListener('click', () => {
			adminSubmitUpdateItem();
		})

		document.querySelector('#adminSubmitDeleteItemButton').addEventListener('click', () => {
			adminDeleteItemButton();
		})



		/*Adjusting Modal Height*/

		const adjustHeightModal = () => {
			let distancePX = $(window).scrollTop();
			let windowHeight = $(window).height();

			const filterbar = document.querySelector('#filterdiv');

			document.querySelector('#adminUpdateModal').style.top = `${distancePX}px`;
		}

		admin_complete_items();

		


	</script>

	<?php 
	include_once '../partials/footer.php';
	?>

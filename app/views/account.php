<?php 
include_once '../partials/header.php';
require_once('../controllers/connect.php');
session_start();
?>

<link rel='stylesheet' type='text/css' href='./account.css'>
<link rel='stylesheet' type='text/css' href='../assets/css/spinner.css'>
</head>
<body>
	<?php include_once '../partials/navbar.php'; ?>
	<?php 
	if(!isset($_SESSION['user_data'])) {
		header('Location: ./register.php');
	} 
	?>
	<?php 
	include_once("../partials/update_address_modal.php");
	?>
	<div id="accountLoadModal" class="loadermodal"><div class="loader"></div></div>
	<div class="appViewBox" id="account-appViewBox">
		<div id="leftAccount">
			<div class="card" style="width: 18rem;">
				<div class="card-header">
					My Account Information
				</div>
				<ul class="list-group list-group-flush">
					<li id="getUserProfile"class="list-group-item">
						User Profile
					</li>
					<li class="list-group-item">
						<div class="left-default-edit">
							<p>Default Email</p>
							<p class="edit" id="edit-email">Edit</p>
						</div>
						<p class="account-default-info" id="accountDefaultemail">No Information</p>
					</li>
					<li class="list-group-item">
						<div class="left-default-edit">
							<p>Default Shipping</p>
							<p class="edit" id="edit-shipping">Edit</p>
						</div>
						<p class="account-default-info" id="accountDefaultshipping">No Information</p>
					</li>
					<li class="list-group-item">
						<div class="left-default-edit">
							<p>Default Billing</p>
							<p class="edit" id="edit-billing">Edit</p>
						</div>
						<p class="account-default-info" id="accountDefaultbilling">No Information</p>
					</li>
					<li class="list-group-item">
						<div class="left-default-edit">
							<p>Default Mobile Number</p>
							<p class="edit" id="edit-contact">Edit</p>
						</div>
						<p class="account-default-info" id="accountDefaultcontact">No Information</p>
					</li>
				</ul>
			</div>
		</div>
		<div id="rightAccount">

		</div>
	</div>

	<script type="text/javascript" src="../assets/js/get_ph_info.js"></script>
	<script type="text/javascript" src="../assets/js/get_update_address.js"></script>

	<script type="text/javascript">
		const lm = document.querySelector('#accountLoadModal');

		const info = [
		{'id':'username','name':'Username', type:'text'},
		{'id':'password','name':'Password', type: 'password'}, 
		{'id':'first_name','name':'First Name', type: 'text'},
		{'id':'last_name','name':'Last Name', type: 'text'},
		{'id':'email','name':'Email', type: 'email'},
		{'id':'contact','name':'Mobile No.', type: 'tel'}];

		const get_user_profile = (info, dom) => {
			const val = $.ajax({
				url:'../controllers/get_user_info.php',
				data:{data: info},
				type:'GET',
				success: (data) => {
					const d = JSON.parse(data);
					const domEle = document.querySelector(`#${dom}`);

					if(info == 'password') {
						domEle.value = '**********'
					} else {
						domEle.value = d[info];
					}

					if(info == 'email' || info == 'contact') {
						document.querySelector(`#accountDefault${info}`).textContent = d[info];
					}
				}
			})
		}

		const edit_user_profile = (id, newvalue) => {
			$('#rightAccount').empty();
			$('#rightAccount').append(`<div style="display:flex;justify-content:center;"><div class="loader"></div></div>`);
			
			setTimeout(() => $.ajax({
				url: '../controllers/update_user_info.php',
				data: {id: id, value: newvalue},
				type: 'POST',
				success: (data) => {
					// console.log(data);
					generate_user_info();

					const d  = JSON.parse(data);
					if (d == 0) {
						const errorSpan = document.querySelector(`#error${id}`)

						errorSpan.style.color = 'red';
						errorSpan.textContent = `${info.filter(e => e.id == id)[0]['name']} is already taken.`
					} else if (d == 1) {
						const errorSpan = document.querySelector(`#error${id}`)

						errorSpan.style.color = '#009933';
						errorSpan.textContent = `${info.filter(e => e.id == id)[0]['name']} successfully updated!`
					} else if (d == 3) {
						const errorSpan = document.querySelector(`#error${id}`)

						errorSpan.style.color = 'red';
						errorSpan.textContent = `${info.filter(e => e.id == id)[0]['name']} is not valid.`	
					}
				}
			}),200)
		}

		const generate_user_info = () => {

			$('#rightAccount').empty();
			$('#rightAccount').append(`<h2>User Information</h2>`);

			info.forEach(ele => {
				get_user_profile(ele.id, `accountinput${ele.id}`)
				$('#rightAccount').append(`
					<div id="formgroup${ele.id}"class="form-group account-info-subcategory">
					<label for="${ele.id}">${ele.name}</label><span id="error${ele.id}"></span>
					<div class="accountInputButton">
					<input type="text" class="form-control" id="accountinput${ele.id}" readonly>
					<button type="button" class="btn btn-info accountButton" id="editButton${ele.id}"> Edit ${ele.name}</button>
					</div>
					</div>
					`);

			})

			get_account_address('shipping');
			get_account_address('billing');

			document.querySelectorAll('.accountButton').forEach((ele) => {
				ele.addEventListener("click", () => {
					const buttonid = event.target.id;
					const id = buttonid.replace('editButton','');
					const accountInput = document.querySelector(`#accountinput${id}`)
					const newInputValue = accountInput.value;

					accountInput.readOnly = false;
					accountInput.style.pointerEvents = "auto";

					const edit = document.querySelector(`#editButton${id}`)

					if (edit.textContent == 'Save Changes') {
						edit.textContent = `Edit ${(info.filter((e) => e.id == id)[0]['name'])}`
						edit.classList.remove('btn-success');
						edit.classList.add('btn-info');
						accountInput.readOnly = true;
						accountInput.style.pointerEvents = "none"
						
						if(id == 'password') {
							edit.textContent = 'Save Changes';
						} else {
							edit_user_profile(id, newInputValue);
						}
					} else {
						edit.textContent = `Save Changes`;
						edit.classList.remove('btn-info');
						edit.classList.add('btn-success');

						if (id == 'password') {
							accountInput.readOnly = true;
							accountInput.style.pointerEvents = "none"
							edit.classList.remove('btn-success');
							edit.classList.add('btn-info');
						} else {
							accountInput.readOnly = false;
							accountInput.style.pointerEvents = "auto"	
						}		
					}
				});
			})


			$(`<div id="accountChangePassword">
				<h6>Change Password</h6>
				<label>Enter Old Password</label>
				<input class="form-control" type="password" id="inputoldpassword">
				<label>Set new password</label>
				<input class="form-control" type="password" id="inputnewpassword">
				<div>
				<label>Confirm password</label><span id="changePasswordSpan"></span>
				<div>
				<input class="form-control" type="password" id="inputconfirmnewpassword">
				<div id="changePasswordButtonContainer">
				<button type="button" class="btn btn-link" id="cancelChangepassword">Cancel</button>
				<button type="button" class="btn btn-link" id="changePasswordSubmit">Submit</button>
				</div>
				</div>`).insertAfter('#formgrouppassword')

			const changePassword = (event) => {
				document.querySelector('#accountChangePassword').classList.add('accountChangePasswordShow');
				document.querySelector('#formgroupfirst_name').classList.add('formgroupfirst_name-down');
			} 

			const oldpassword = document.querySelector('#inputoldpassword')
			const newpassword = document.querySelector('#inputnewpassword')
			const confirmnewpassword = document.querySelector('#inputconfirmnewpassword')
			const changePasswordErrorSpan = document.querySelector('#changePasswordSpan');

			document.querySelector('#editButtonpassword').addEventListener("click", () => changePassword(event))

			document.querySelector('#cancelChangepassword').addEventListener("click", (event) => {
				document.querySelector('#accountChangePassword').classList.remove('accountChangePasswordShow');
				const ebp = document.querySelector('#editButtonpassword')

				oldpassword.value = '';
				newpassword.value = '';
				confirmnewpassword.value = '';
				changePasswordErrorSpan.textContent = '';

				ebp.textContent = "Edit Password";
				ebp.classList.remove("btn-success");
				ebp.classList.add("btn-info");
			})

			document.querySelector('#changePasswordSubmit').addEventListener("click", () => {
				if (newpassword.value !== confirmnewpassword.value) {
					changePasswordErrorSpan.textContent = "Passwords Do Not Match"
				} else {
					$('body').prepend(`<div id="modalLoad"><div class="loader"></div></div>`)

					setTimeout(() => $.ajax({
						url:'../controllers/change_password.php',
						data:{oldpassword: oldpassword.value, newpassword: newpassword.value, confirmnewpassword: confirmnewpassword.value},
						type:'POST',
						success: (data) => {
							if (data == '0'){
								document.querySelector('#errorpassword').textContent = "Old password does not match."
								document.querySelector('#errorpassword').style.color="red"
							}
							if (data == '1'){
								document.querySelector('#errorpassword').textContent = "New password does not match."
								document.querySelector('#errorpassword').style.color="red";
							}
							if (data == '2'){
								document.querySelector('#errorpassword').textContent = "Password successfully changed."
								document.querySelector('#errorpassword').style.color='#009933';
							}
							document.querySelector('#cancelChangepassword').click();

							$('body').find('div').first().remove();
						}
					}), 200)
				}
			})
		}

		const get_account_address = (type) => {
			$.ajax({
				url:'../controllers/get_address.php',
				type:'GET',
				data:{data:type},
				success: (data) => {
					const d = JSON.parse(data);
					d ? document.querySelector(`#accountDefault${type}`).textContent = `${d.house_num_others}, ${d.barangay}, ${d.province_code}, ${d.region_province}, ${d.region}` : document.querySelector(`#accountDefault${type}`).textContent = 'No Information Provided';
				}, 
			})
		}

		const get_all_address = (type) => {
			$('body').prepend(`<div id="modalLoad"><div class="loader"></div></div>`)
			$.ajax({
				url: '../controllers/get_all_address.php',
				type:'GET',
				data: {data:type},
				success:(data) => {
					const d = JSON.parse(data);

					if (d) {
						$(`#listCurrent${type}`).empty()
						for(let ad of d) {
							$(`#listCurrent${type}`).append(`
								<div class="listCurrentTypeSub">
								<div class="listCurrentTypeData">${ad.house_num_others}, ${ad.barangay}, ${ad.province_code}, ${ad.region_province}, ${ad.region}</div>
								<div class="listCurrentTypeDefault">${parseInt(ad.default_add) ? `<span style="padding:0 0 0 7px;">  Current  Default</span>` : `<button class="btn btn-outline-dark" id="listCurrentTypeDefaultButton${ad.id}">Set Default<button>`}</div>
								<div class="listCurrentTypeUpdate"><button class="btn btn-outline-info" id="listCurrentTypeUpdateButton${ad.id}">Update</button></div>
								<div class="listCurrentTypeDelete">
								<button class="btn btn-outline-danger" id="listCurrentTypeDeleteButton${ad.id}">Delete</button></div>
								</div>
								`)
						}
					} else {
						$(`#listCurrent${type}`).empty(); 
						$(`#listCurrent${type}`).append(`<p style="text-align:center;">No Address Provided. Please add an address below.</p>`);
					}

					/*SET DEFAULT BUTTONS*/	
					const setDefaultButtons = document.querySelectorAll('[id^="listCurrentTypeDefaultButton"]');

					setDefaultButtons.forEach(button => button.addEventListener("click", (event) => {
						$('body').prepend(`<div id="modalLoad"><div class="loader"></div></div>`)
						const address_id = event.target.id.replace('listCurrentTypeDefaultButton', ''); 
						const parentnode_id = button.parentNode.parentNode.parentNode.id
						const type_address = parentnode_id.replace('listCurrent', '');
						
						let address_type_id = 1;
						if (type_address == "billing") address_type_id = 2;

						$.ajax({
							url:'../controllers/set_default_address.php',
							data: {address_id: address_id, address_type_id: address_type_id},
							type:'POST',
							success: (data) => {
								console.log(data);
								get_all_address(type_address);
								get_account_address(type_address);
								$('body').find('div').first().remove();
							}
						})

					}))


					/*UPDATE BUTTONS*/
					const updateButtons = document.querySelectorAll('[id^="listCurrentTypeUpdateButton"]');

					updateButtons.forEach(button => 
						button.addEventListener("click", (event) => {
							const address_id = event.target.id.replace('listCurrentTypeUpdateButton', '');
							const parentnode_id = button.parentNode.parentNode.parentNode.id
							const type_address = parentnode_id.replace('listCurrent', '');

							document.querySelector('#updateModal').style.display = "flex";
							setTimeout(() => {document.querySelector('#updateModal').style.opacity = "1";}, 200)

							get_ph_info();

							const submitUpdate = document.querySelector('#submitUpdateButton');
							const footerUpdate = submitUpdate.parentNode;	
							footerUpdate.id = `${type_address}${address_id}`;

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
						}))

					document.querySelectorAll('[id^="listCurrentTypeDeleteButton"]').forEach(button => {
						button.addEventListener("click", (event) => {
							const idToBeDeleted = event.target.id.replace(/\D/g,'');
							const parentnode_id = button.parentNode.parentNode.parentNode.id
							const type_address = parentnode_id.replace('listCurrent', '');
							$('body').prepend(`<div id="modalLoad"><div class="loader"></div></div>`)
							// let address_type_id = 1;
							// if (type_address == "billing") address_type_id = 2;
							
							$.ajax({
								url:'../controllers/delete_address.php',
								data:{id: idToBeDeleted},
								type:'POST',
								success: (data) => {
									if(data == 0) {
										alert('You cannot delete your default address.')
									} else {
										alert('Successfully deleted address.')
										get_all_address(type_address);
									}
									$('body').find('div').first().remove();
								}
							})

						})
					})
					$('body').find('div').first().remove();
				}
			})
		}

const generate_address_profile = (type) => {
	$('#rightAccount').empty();
	$('#rightAccount').append(`<h2>My <span style="text-transform:capitalize;">${type}</span> Address </h2>`);

	$('#rightAccount').append(`
		<div id="listCurrent${type}"><h3 style="margin-top:40px;font-size:25px;">Saved Addresses<h3></div>
		`)
	get_all_address(`${type}`);

	$('#rightAccount').append(`
		<div id="addAddressForm">
		<h3 style="margin:20px 0 20px 0;font-size:25px;">Add New Address</h3>
		<main>
		<div class="add-address-input-div">
		<label for="region">Address Number and Street</label>
		<input class="add-modal-only form-control" type="text" name="street" id="addinputstreet">
		</div>
		<div class="add-address-input-div">
		<label for="region">Region</label>
		<select class="add-modal-only form-control" name="region" id="addselectregions">
		</select>
		</div>
		<div class="add-address-input-div">
		<label for="province">Province</label>
		<select class="add-modal-only form-control" name="province" id="addselectprovinces">
		<option value="null">--PLEASE SELECT--</option>
		</select>
		</div>
		<div class="add-address-input-div">
		<label for="municipality">Municipality</label>
		<select class="add-modal-only form-control" name="municipality" id="addselectmunicipalities">
		<option value="null">--PLEASE SELECT--</option>
		</select>
		</div>
		<div class="add-address-input-div">
		<label for="barangay">Barangay</label>
		<select class="add-modal-only form-control" name="barangay" id="addselectbarangays">
		<option value="null">--PLEASE SELECT--</option>
		</select>
		</div>
		</main>
		<footer id="addAddressFooter">
		<button type="button" class="btn btn-outline-primary" id="submitAddAddressButton${type}" style="text-transform:capitalize;">Add New ${type} Address</button>
		</footer>	
		</div></div>`)
	get_ph_info_add();


	document.querySelector('[id^="submitAddAddressButton"]').addEventListener("click", (event) => {
		$('body').prepend(`<div id="modalLoad"><div class="loader"></div></div>`)

		const address_type = event.target.id.replace('submitAddAddressButton', '');
		let address_type_id = 1;
		if (address_type == 'billing') address_type_id = 2;

		const street = $('#addinputstreet').val();
		const region = $('#addselectregions :selected').val();
		const province = $('#addselectprovinces :selected').val();
		const municipality = $('#addselectmunicipalities :selected').val();
		const barangay = $('#addselectbarangays :selected').val();

		if (street && region && province && municipality && barangay){

			$.ajax({
				url:'../controllers/add_new_address.php',
				data: {address_type_id:address_type_id, house_num_others: street, region_code: region, region_province_code: province, city_municipality_code: municipality, barangay_id: barangay},
				type:'POST',
				success: (data) => {
							// console.log(data);

							// if (typeof(load_address) == "function") {
							// 	load_address('currentShipping');
							// 	load_address('currentBilling');
							// }

							if (typeof(get_all_address) == "function") {
								console.log(address_type);
								get_all_address(address_type);
							}

							alert('Updated address!')

							$('#addinputstreet').val('');
							$('#addinputstreet').empty();
							$('#addselectregions').empty();
							$('#addselectprovinces').empty();
							$('#addselectmunicipalities').empty();
							$('#addselectbarangays').empty();

							get_ph_info();
							$('body').find('div').first().remove();
						}
					})
		} else {
			$('body').find('div').first().remove();
			alert('Please complete your address.')
		}

	})
}

document.querySelector('#getUserProfile').addEventListener("click", generate_user_info)
document.querySelector('#edit-email').addEventListener("click", generate_user_info)
document.querySelector('#edit-contact').addEventListener("click", generate_user_info)

document.querySelector('#edit-billing').addEventListener("click", () => generate_address_profile('billing'))
document.querySelector('#edit-shipping').addEventListener("click", () => generate_address_profile('shipping'))

/**/

/**/




$(document).ready(generate_user_info());

</script>

<?php 
include_once '../partials/footer.php';
?>

	document.querySelector('#submitUpdateButton').addEventListener("click", (event) => {
		// const submittal = event.target.attributes.submittal.nodeValue;
		$('body').prepend(`<div id="modalLoad"><div class="loader"></div></div>`)

		const footer_id = document.querySelector('#submitUpdateButton').parentNode.id;
		const address_type = footer_id.replace(/[0-9]/g, '');
		
		const f = footer_id.replace('billing', '');
		const address_id =	f.replace('shipping', '');
	
		let address_type_id = 1;

		if (address_type == 'billing') {
			address_type_id = 2;
		}
		
		const street = $('#inputstreet').val();
		const region = $('#selectregions :selected').val();
		const province = $('#selectprovinces :selected').val();
		const municipality = $('#selectmunicipalities :selected').val();
		const barangay = $('#selectbarangays :selected').val();

		if (street && region && province && municipality && barangay) {
			
			document.querySelector('#updateModal').style.opacity = "0";
			setTimeout(() => {document.querySelector('#updateModal').style.display = "none"}, 300)

			$.ajax({
				url:'../controllers/update_address.php',
				data: {address_type_id:address_type_id, address_id: address_id, house_num_others: street, region_code: region, region_province_code: province, city_municipality_code: municipality, barangay_id: barangay},
				type:'POST',
				success: (data) => {
					// console.log(data);

					if (typeof(load_address) == "function") {
						load_address('currentShipping');
						load_address('currentBilling');
					}
					
					if (typeof(get_all_address) == "function") {
						get_all_address(address_type);
					}
					$('body').find('div').first().remove();
					alert('Updated address!')

					$('#inputstreet').val('');
					$('#inputstreet').empty();
					$('#selectregions').empty();
					$('#selectprovinces').empty();
					$('#selectmunicipalities').empty();
					$('#selectbarangays').empty();

					get_ph_info();
				}
			})

			

		} else {
			$('body').find('div').first().remove();
			alert('Please complete your address.')
		}
	})

	const closeModal = document.querySelectorAll(".close-modal")

	closeModal.forEach(ele => {
		ele.addEventListener("click", (e) => {
			if(event.target == event.currentTarget) {	
				document.querySelector('#updateModal').style.opacity = "0";
				setTimeout(() => {document.querySelector('#updateModal').style.display = "none"}, 300)
				$('#inputstreet').val('');
				$('#inputstreet').empty();
				$('#selectregions').empty();
				$('#selectprovinces').empty();
				$('#selectmunicipalities').empty();
				$('#selectbarangays').empty();
				get_ph_info("regions", "01");
			}
		})
	})
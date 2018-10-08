const get_ph_info = (category = "regions", filter = "01") => {
		const selectList = document.querySelector('#selectregions')
		// console.log(category, filter)

		const empty_append_category = (category) => {
			$(`#select${category}`).empty();
			$(`#select${category}`).append(`<option value="null">--PLEASE SELECT--</option>`);
		}

		$.ajax({
			url:'../controllers/get_ph_info.php',
			data:{category: category, filter:filter},
			type: 'GET',
			success: (data) => {
				const d = JSON.parse(data);
				// console.log(data);
				if (category == "regions") {
					// $('#selectregions').empty();	
					// $('#selectregions').append(`<option value="null">--PLEASE SELECT--</option>`);	
					for(let key in d) {
						$('#selectregions').append(`
							<option class=${category} value="${d[key]['region_code']}">${d[key]['region']}</option>
						`)
					}
					empty_append_category("provinces");
					empty_append_category("municipalities");
					empty_append_category("barangays");
				}

				else if (category == "provinces") {
					empty_append_category(category);
					for(let key in d) {
						$('#selectprovinces').append(`
							<option class=${category} value="${d[key]['province_code']}">${d[key]['region_province']}</option>
						`)
					}
					empty_append_category("municipalities");
					empty_append_category("barangays");
				}

				else if (category == "municipalities") {
					empty_append_category(category);
					for(let key in d) {
						$('#selectmunicipalities').append(`
							<option class=${category} value="${d[key]['city_municipality_code']}">${d[key]['province_code']}</option>
						`)
					}
					empty_append_category("barangays");
				}

				else if (category == "barangays") {
					empty_append_category(category);
					for(let key in d) {
						$('#selectbarangays').append(`
							<option class=${category} value="${d[key]['id']}">${d[key]['barangay']}</option>
						`)
					}
				}

				document.querySelector(`select#select${category}`).addEventListener("change", (event) => {
						if (category == "regions") {
							get_ph_info("provinces", event.target.value);
						}
						else if (category == "provinces") {
							get_ph_info("municipalities", event.target.value);
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

const get_ph_info_add = (category = "regions", filter = "01") => {
		const selectList = document.querySelector('#addselectregions')
		// console.log(category, filter)

		const empty_append_category = (category) => {
			$(`#addselect${category}`).empty();
			$(`#addselect${category}`).append(`<option value="null">--PLEASE SELECT--</option>`);
		}

		$.ajax({
			url:'../controllers/get_ph_info.php',
			data:{category: category, filter:filter},
			type: 'GET',
			success: (data) => {
				const d = JSON.parse(data);
				// console.log(data);
				if (category == "regions") {
					// $('#addselectregions').empty();	
					// $('#addselectregions').append(`<option value="null">--PLEASE SELECT--</option>`);	
					for(let key in d) {
						$('#addselectregions').append(`
							<option class=${category} value="${d[key]['region_code']}">${d[key]['region']}</option>
						`)
					}
					empty_append_category("provinces");
					empty_append_category("municipalities");
					empty_append_category("barangays");
				}

				else if (category == "provinces") {
					empty_append_category(category);
					for(let key in d) {
						$('#addselectprovinces').append(`
							<option class=${category} value="${d[key]['province_code']}">${d[key]['region_province']}</option>
						`)
					}
					empty_append_category("municipalities");
					empty_append_category("barangays");
				}

				else if (category == "municipalities") {
					empty_append_category(category);
					for(let key in d) {
						$('#addselectmunicipalities').append(`
							<option class=${category} value="${d[key]['city_municipality_code']}">${d[key]['province_code']}</option>
						`)
					}
					empty_append_category("barangays");
				}

				else if (category == "barangays") {
					empty_append_category(category);
					for(let key in d) {
						$('#addselectbarangays').append(`
							<option class=${category} value="${d[key]['id']}">${d[key]['barangay']}</option>
						`)
					}
				}

				document.querySelector(`select#addselect${category}`).addEventListener("change", (event) => {
						if (category == "regions") {
							console.log(event.target.value)
							get_ph_info_add("provinces", event.target.value);
						}
						else if (category == "provinces") {
							console.log(event.target.value)
							get_ph_info_add("municipalities", event.target.value);

						} 
						else if (category == "municipalities") {
							console.log(event.target.value)
							get_ph_info_add("barangays", event.target.value);
						} 
						else return;
				})
			},
			error: (error) => {
				console.log("error:" + error)
			}
		})
	}





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
	// 				// console.log(data);

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
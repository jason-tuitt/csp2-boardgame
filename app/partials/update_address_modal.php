<link rel="stylesheet" href="../views/checkout.css">

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
						<option value="null"></option>
					</select>
				</div>
				<div class="modal-input-div">
					<label for="municipality">Municipality</label>
					<select class="modal-only" name="municipality" id="selectmunicipalities">
						<option value="null"></option>
					</select>
				</div>
				<div class="modal-input-div">
					<label for="barangay">Barangay</label>
					<select class="modal-only" name="barangay" id="selectbarangays">
						<option value="null"></option>
					</select>
				</div>
			</main>
			<footer>
				<button type="button" class="btn btn-secondary close-modal">Close</button>
        		<button type="button" class="btn btn-primary" id="submitUpdateButton">Update Address</button>
			</footer>	
		</div>
	</div>
<link rel="stylesheet" href="../partials/admin_modal.css">
<?php require_once('../controllers/connect.php'); ?>

<div id="adminAddModal">
		<div id="adminAddModalForm">
			<header>
				<h2>Add Item Information</h2>
				<input id="adminAddModalItemId" type="text" hidden>
			</header>
			<main>
				<div class="admin-item-input-div">
					<label for="name">Name</label>
					<input class="form-control" type="text" name="nameadd">
					<label for="price">Price</label>
					<input class="form-control" type="number" name="priceadd">
				</div>
		<!-- 		<div class="admin-item-input-div">
					
				</div> -->
				<div class="admin-item-input-div admin-item-input-div-long">
					<label for="url">Image URL</label>
					<input class="form-control" type="text" name="urladd" required>
					<label for="upload">Upload Image</label>
					<div class="upload-image-container">
						<input type="file" id="uploadImageAdd" name="uploadadd">
						<img id="showUploadImageAdd" style="width:250px;height:250px;" src="../assets/image/default.png">
					</div>
				</div>
				<div class="admin-item-input-div admin-item-input-div-long">
					<label for="desc">Item Description</label>
					<input class="form-control" type="text" name="descadd" required>
				</div>
				<div class="admin-item-input-div">
					<label for="minplayer">Min Players</label>
					<input class="form-control" type="number" name="minplayeradd" required>
					<label for="maxplayer">Max Players</label>
					<input class="form-control" type="number" name="maxplayeradd" required>
					<label for="time">Average Time (Mins.)</label>
					<input class="form-control" type="number" name="timeadd" required>
				</div>
				<!-- <div class="admin-item-input-div">
					
				</div> -->
				<div class="admin-item-input-div">
					<label for="category">Category</label>
					<select class="modal-only form-control" name="categoryadd" required>
						<?php 
							$sql = "SELECT * from categories";
							$result = mysqli_query($conn, $sql);

							while($row = mysqli_fetch_assoc($result)) {
								echo "<option class='form-control adminModalOption' value='".$row['id']."' id='categoryid".$row['id']."'>".$row['category_names']."</option>";
							}
						?>
					</select>
		<!-- 		</div>
				<div class="admin-item-input-div"> -->
					<label for="gametype">Type</label>
					<select class="modal-only form-control" name="gametypeadd" required>
						<?php 
							$sql = "SELECT * from game_types";
							$result = mysqli_query($conn, $sql);

							while($row = mysqli_fetch_assoc($result)) {
								echo "<option class='form-control adminModalOption' value='".$row['id']."' id='gametypeid".$row['id']."'>".$row['game_type_names']."</option>";
							}
						?>
					</select>
			<!-- 	</div>
				<div class="admin-item-input-div"> -->
					<label for="trend">Trend</label>
					<select class="modal-only form-control" name="trendadd" required>
						<?php 
							$sql = "SELECT * from trends";
							$result = mysqli_query($conn, $sql);

							while($row = mysqli_fetch_assoc($result)) {
								echo "<option class='form-control adminModalOption' value='".$row['id']."' id='trendid".$row['id']."'>".$row['trend_names']."</option>";
							}
						?>
					</select>
				</div>
				<div class="admin-item-input-div">
					<label for="year">Year</label>
					<input class="form-control" type="text" name="yearadd" required>
					<label for="rating">Rating</label>
					<input class="form-control" type="number" name="ratingadd" required>
				</div>
			</main>
			<footer>
				<button type="button" class="btn btn-secondary" id="adminAddCloseModalButton">Close</button>
        		<button type="button" class="btn btn-primary" id="adminSubmitAddItemButton">Add Item Information</button>
			</footer>	
		</div>
	</div>

		<script type="text/javascript">
		document.querySelector('#uploadImageAdd').onchange = function () {
			var reader = new FileReader();

			reader.onload = function (e) {
				document.querySelector('#showUploadImageAdd').style.height = '250px';
				document.querySelector('#showUploadImageAdd').style.width = '250px';
				document.querySelector('#showUploadImageAdd').src = e.target.result;
			}
			reader.readAsDataURL(this.files[0])
		}
	</script>
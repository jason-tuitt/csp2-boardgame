<?php 
	include_once "./partials/header.php";
	include_once "./partials/navbar.php";
?>

	<link rel="stylesheet" type="text/css" href="./assets/css/landing.css">
</head>
<body>

	<div class="appViewBox" id="landingAppViewBox" style="margin-top: 80px;">
		<div id="landingPage" style="width: 100%; min-height: 120vh">
			<div class="landing">
				<p style="color:#eaeaea; margin-bottom: 8px; font-size: 28px; font-family: 'Raleway', sans-serif">It's your turn</p>
				<a href="./views/catalog.php"><button class="btn btn-dark">Find the perfect board game for you.</button></a>
			</div>
		</div>
	
	<h1 style="padding: 20px 0 0 0; margin-bottom: 0;">The Bored Gamer</h1>
	<p style="text-align:center; font-size: 20px; font-family: 'Titillium Web', sans-serif;">Your go to place for all your board game needs.</p>
	</div>

	<script>
		document.querySelector('#navleft a').setAttribute('href', '#');
	</script>

<?php 
	include_once "./partials/footer.php";
?>

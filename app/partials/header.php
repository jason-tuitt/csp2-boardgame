
<!DOCTYPE html>
<html>
<head>
	<title>Board Game Store</title>

	<link rel="stylesheet" type="text/css" href="../assets/css/style.css">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<link href="https://fonts.googleapis.com/css?family=Cabin|Josefin+Sans|Raleway|Source+Sans+Pro|Titillium+Web" rel="stylesheet">

	<!-- JQEUERY -->
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

	<style type="text/css">
		html {
			background-color: #00000008;
		}

		.appViewBox {
			background-color: #00000008;
			min-height: 90vh;
			padding-bottom: 30px;
			/*width:80%;*/
			/*margin: 0 auto;*/
			margin-top: 150px;
			margin-bottom: 10px;
		}

	/*	@media only screen and (min-width: 1200px) {
			.appViewBox {
				width: 80% !important;
				margin: 0 auto;
				padding:5px;
			}
		}*/

		.appViewBox > h1 {
			text-align: center;
			display: flex;
			padding: 0 1vw;
		}

		.appViewBox h1:before {
			margin-right: 20px;
		}

		.appViewBox h1:before,
		.appViewBox h1:after {
		  color:#544c4c;
		  content:'';
		  flex:1;
		  border-bottom:groove 2px;
		  margin:auto 0.25em;
		  box-shadow: 0 -1px ;/* ou 0 1px si border-style:ridge */
		}

		body,h3 {
			font-family: 'Raleway', sans-serif;
		}

		h1,h2,h4, label {
			font-family: 'Cabin', sans-serif;
			/*font-family: 'Titillium Web', sans-serif;*/
		}

		h5,h6 {
			font-family: 'Titillium Web', sans-serif;
		}

		li, p, span {
			font-family: 'Source Sans Pro', sans-serif;
			/*font-family: 'Josefin Sans', sans-serif;*/
		}
		
		

		@media only screen and (min-width: 600px) {
			div[id$="App"] {
				width:100vw;
				margin: 0 auto;
			}
		}

		@media only screen and (min-width: 1600px) {
			div[id$="App"] {
				width:80vw;
				margin: 0 auto;
			}
		}
		
	</style>

	<!-- BOOTRSTAP CSS -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!-- JQUERY - BOOTSTRAP -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

	<!-- FONT AWESOME -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">



<?php 
include_once '../partials/header.php';
require_once('../controllers/connect.php');
session_start();
?>

<link rel='stylesheet' type='text/css' href=''>
</head>
<body>
	<?php include_once '../partials/navbar.php'; ?>
	<?php 
	if(!isset($_SESSION['user_data'])) {
		header('Location: ./catalog.php');
	}
	?>

</body>

<script type="text/javascript">

</script>

<?php 
include_once '../partials/footer.php';
?>
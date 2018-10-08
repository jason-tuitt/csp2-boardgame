<link rel="stylesheet" href="./checkout.css">

<style>
	#redirectToAddAddressModal {
		display: flex;
		width:100vw;
		height:100vh;
		background-color:rgba(0,0,0,.5);
		position: absolute;
		top:0;
		left: 0;
		z-index: 10000;
		display: flex;
		justify-content: center;
		align-items: center;
		transition: opacity 0.3s linear;
		opacity: 1;
	}

	#redirectToAddAddress {
		display: flex;
		background-color: white;
		box-shadow: 0 4px 7px 2px;  
		width:50vw;
		padding: 25px;
		justify-content: center;
		flex-direction: column;
		align-content: center;
		align-items: center;
		margin-bottom: 300px;
	}
	

</style>


<div id="redirectToAddAddressModal">
	<div id="redirectToAddAddress">
		<p>You have not provided a shipping and a billing address. Please update your account profile to proceed with checkout.</p>
		<a href="./account.php"><button class="btn btn-outline-dark">Go to my Account</button></a>
	</div>
</div>
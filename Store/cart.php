<?php session_start();
if (isset($_SESSION["s_loggedin"]) && $_SESSION["s_loggedin"] === true) {
  $login_status = $_SESSION["s_loggedin"];
  $username = $_SESSION["s_username"];
  $s_id = $_SESSION["s_id"];
  
} else {
  header("location: login.php");
  exit;
} ?>
<!DOCTYPE html>
<html>

<head>
	<title>Shopping Cart UI</title>
	<link rel="stylesheet" type="text/css" href="assets/css/cartStyle.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,900" rel="stylesheet">
</head>

<body>
	<div class="CartContainer">
		<div class="Header">
			<a href="index.php">
				<h3 class="Heading">Home</h3>
			</a>

			<h5 class="Action">Remove all</h5>
		</div>

		<div class="Cart-Items">
			<div class="image-box">
				<img src="images/apple.png" style={{ height="120px" }} />
			</div>
			<div class="about">
				<h1 class="title">Apple Juice</h1>
				<h3 class="subtitle">250ml</h3>
				<img src="images/veg.png" style={{ height="30px" }} />
			</div>
			<div class="counter">
				<div class="btn">+</div>
				<div class="count">2</div>
				<div class="btn">-</div>
			</div>
			<div class="prices">
				<div class="amount">$2.99</div>
				<div class="save"><u>Save for later</u></div>
				<div class="remove"><u>Remove</u></div>
			</div>
		</div>

		<div class="Cart-Items pad">
			<div class="image-box">
				<img src="images/grapes.png" style={{ height="120px" }} />
			</div>
			<div class="about">
				<h1 class="title">Grapes Juice</h1>
				<h3 class="subtitle">250ml</h3>
				<img src="images/veg.png" style={{ height="30px" }} />
			</div>
			<div class="counter">
				<div class="btn">+</div>
				<div class="count">1</div>
				<div class="btn">-</div>
			</div>
			<div class="prices">
				<div class="amount">$3.19</div>
				<div class="save"><u>Save for later</u></div>
				<div class="remove"><u>Remove</u></div>
			</div>
		</div>
		<hr>
		<div class="checkout">
			<div class="total">
				<div>
					<!-- <div class="Subtotal">Sub-Total</div> -->
					<div class="items">Amount</div>
				</div>
				<input id="order_value" type="number">
				<!-- <div >$6.18</div> -->
			</div>
			<button class="button" onclick="return call()">Check Discount</button>
			<p id="disc"></p>
			<button class="button" onclick="return placeOrder()">Checkout</button>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<script>
		var s_id = <?php echo $s_id; ?>;
		function call() {
			var order_value = document.getElementById("order_value").value
			$.ajax({
				url: '/../../reward_system/ajax_bill.php',
				type: 'get',
				data: {
					order_value: order_value,
					s_id: s_id,
					option: 1
				},
				// dataType: 'JSON',
				success: function (response) {
					var fp = (Number(order_value) -parseInt(response.replace(/[^0-9]/g, "")));
					document.getElementById("disc").innerHTML = "Discount: " + response + ", Final Price: "+fp;
				}
			});
		}
		function placeOrder(){
			var order_value = document.getElementById("order_value").value
			$.ajax({
				url: '/../../reward_system/ajax_bill.php',
				type: 'get',
				data: {
					order_value: order_value,
					s_id: s_id,
					option: 2
				},
				// dataType: 'JSON',
				success: function (response) {
					alert(response);
				}
			});
		}
	</script>
</body>

</html>
<?php session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
	$login_status = $_SESSION["loggedin"];
	$username = $_SESSION["username"];

} else {
	header("location: login.php");
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="assets/css/style.css">

	<title>Reward System Dashboard</title>
	<link rel="stylesheet" href="assets/css/form.css">
</head>

<body>
	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="index.php" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">Rewardify</span>
		</a>
		<ul class="side-menu top">
			<li class=" <?php if ($menu == "home") {
				echo "active";
			} ?>">
				<a href="index.php">
					<i class='bx bxs-home'></i>
					<span class="text">Home</span>
				</a>
			</li>

			<li class=" <?php if ($menu == "RewardSchemes") {
				echo "active";
			} ?>">
				<a href="reward_scheme.php">
					<i class='bx bxs-checkbox-checked'></i>
					<span class="text">Reward Schemes</span>
				</a>
			</li>
			<!-- <li class=" <?php if ($menu == "NewReward") {
				echo "active";
			} ?>">
				<a href="new_reward.php">
					<i class='bx bxs-message-square-add'></i>
					<span class="text">Add Reward Scheme</span>
				</a>
			</li> -->
			<!-- <li class=" <?php if ($menu == "GiftReward") {
				echo "active";
			} ?>">
				<a href="gift_reward.php">
					<i class='bx bxs-gift'></i>
					<span class="text">Gift Reward Points</span>
				</a>
			</li> -->
			<li class=" <?php if ($menu == "Spins") {
				echo "active";
			} ?>">
				<a href="spin.php">
					<i class='bx bxs-bolt-circle'></i>
					<span class="text">Spins</span>
				</a>
			</li>
			<li class=" <?php if ($menu == "NewRewardLog") {
				echo "active";
			} ?>">
				<a href="reward_list_log.php">
					<i class='bx bxs-archive-in'></i>
					<span class="text">Reward Update Log</span>
				</a>
			</li>
			<li class=" <?php if ($menu == "RewardLog") {
				echo "active";
			} ?>">
				<a href="reward_log.php">
					<i class='bx bxs-archive'></i>
					<span class="text">Received Log</span>
				</a>
			</li>
			<li class=" <?php if ($menu == "ReedemLog") {
				echo "active";
			} ?>">
				<a href="reedem_log.php">
					<i class='bx bxs-archive'></i>
					<span class="text">Reedem Log</span>
				</a>
			</li>
			<li class=" <?php if ($menu == "Users") {
				echo "active";
			} ?>">
				<a href="users.php">
					<i class='bx bxs-group'></i>
					<span class="text">Users</span>
				</a>
			</li>
			<li class=" <?php if ($menu == "Settings") {
				echo "active";
			} ?>">
				<a href="settings.php">
					<i class='bx bxs-cog'></i>
					<span class="text">Settings</span>
				</a>
			</li>

		</ul>
		<ul class="side-menu">
			<li>
				<a href="logout.php" class="logout">
					<i class='bx bxs-log-out-circle'></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu'></i>
			<!-- <a href="#" class="nav-link">Categories</a> -->
			<form action="#">
				<div class="form-input">
					<!-- <input type="search" placeholder="Search..."> -->
					<button type="submit" class=""><i class='bx'></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>

			<a href="#" class="profile">
				<?php echo $username; ?>
			</a>
		</nav>
		<!-- NAVBAR -->
		<main>
			<script>
				if (localStorage.getItem('dark')) {
					document.body.classList.add('dark');
					const switchm = document.getElementById('switch-mode');
					switchm.checked = true
				}
			</script>
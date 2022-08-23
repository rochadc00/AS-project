<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<div id="navbar" class="sticky">
    <a id="gamebet" href="home"><span>Gamebet</span><img src="images/GameBetLogo-square-white.png" style="width: 45px;"></a>
    <a href="wallet">Wallet</a>
    <a href="points">Points</a>
    <a href="friends">Friends</a>
    <a href="profile">Profile</a>
    <a href="stats">Stats</a>
    <a href="settings">Settings</a>
    <a href="faq">FAQ</a>
    <a href="login?submit=logout">Logout</a>
    <div style="
			display: flex;
			align-items: center;
			position: absolute;
			right: 10px;">
		<a href="deposit">
		<div class="balance-box">
			<div>
				<div id="navbar-money"><?php echo apiFetch("http://".$_SERVER['SERVER_NAME']."/api/users?keys=money&id=".$_SESSION["userId"])["data"][0]["money"]; ?> €</div>
			</div>
			<div>
				<div></div>
				<div></div>
			</div>
		</div>
		</a>
		<a href="points">
		<div class="balance-box">
			<div>
				<div id="navbar-points"><?php echo apiFetch("http://".$_SERVER['SERVER_NAME']."/api/users?keys=points&id=".$_SESSION["userId"])["data"][0]["points"]; ?></div>
				<img style="width: 19px;
					filter: invert(1);
					margin-left: 5px;
					opacity: 0.4;"
				src="/images/gp-logo.png">
			</div>
			<div>
				<div></div>
				<div></div>
			</div>
		</div>
		</a>
		<a style="position: relative;" href="tickets">
			<img id="ticketNavbarImg" src="/images/ticket.png">
			<div class="ticketNavbar-counter">
				<div>
					<?php 
						require $_SERVER['DOCUMENT_ROOT'].'/php/connect.php';
					
						$query = "SELECT id FROM RegisteredTickets WHERE userId=".$_SESSION["userId"];
						$result = mysqli_query($conn, $query);
						echo mysqli_num_rows($result);
					?>
				</div>
			</div>
		</a>
		<a id="username" style="font-size: 16px;"><?php echo $_SESSION["userUsername"] ?></a>
		<div class="burger-menu">
			<div></div>
			<div></div>
			<div></div>
		</div>
  	</div>
</div>

<div style="display:none" class="side-navbar side-navbar-hidden">
	<div>
		<div><a href="home">Home</a></div>
		<div><a href="wallet">Wallet</a></div>
		<div><a href="points">Points</a></div>
		<div><a href="home">Friends</a></div>
		<div><a href="home">Profile</a></div>
		<div><a href="home">Stats</a></div>
		<div><a href="home">Settings</a></div>
		<div><a href="faq">FAQ</a></div>
		<div><a href="login?submit=logout">Logout</a></div>
	</div>
</div>
<script type="text/javascript" src="js/navbar.js"></script>

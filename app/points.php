<?php 
	require $_SERVER['DOCUMENT_ROOT'].'/php/check-session.php'; 
	require $_SERVER['DOCUMENT_ROOT'].'/php/functions.php';
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/navbar.css"/>
  <link rel="stylesheet" href="css/points.css"/>
  <link rel="stylesheet" href="css/essentials.css"/>
  <link rel="icon" href="/images/GameBetLogo-square.png">
  <title>Points - Gamebet</title>
</head>

<body>
	<script>
		const userSession = <?php echo json_encode($_SESSION); ?>;
	</script>
	
  <?php include "templates/navbar.php"?>
   
 	<div class="points-container">
 		<div>
 			<div>
	 			<div>Points</div>
	 			<div>
	 				<div>Balance:</div>
	 				<div>
	 					<div><?php echo apiFetch("http://".$_SERVER['SERVER_NAME']."/api/users?keys=points&id=".$_SESSION["userId"])["data"][0]["points"]; ?></div>
	 					<div><img src="/images/gp-logo.png"></div>
	 				</div>
	 			</div>
	 			<div class="daily-rewards">
	 				<div>
	 					<div>
	 						<div class="absolute-centered">Claimed</div>
	 					</div>
	 					 <div>
	 						<div class="absolute-centered">Claimed</div>
	 					</div>
	 					<div>
	 						<div class="absolute-centered">Claimed</div>
	 					</div>
	 				</div>
	 				<div>
	 				 	<div>
	 						<div class="absolute-centered">Claimed</div>
	 					</div>
	 					 <div>
	 						<div class="absolute-centered">Claimed</div>
	 					</div>
	 					<div>
	 						<div class="absolute-centered">Claimed</div>
	 					</div>
	 				</div>
	 				<div>Daily Rewards</div>
	 			</div>
	 		</div>
 			</div>
 		<div>
 			<div>
 				<div>Store</div>
 				<div>
	 				<div class="store-items">
		 				<div>
	 						<div>
	 							<div>Microsoft Store</div>
	 							<div>20€</div>
	 						</div>
	 						<div>
	 							<div>10000</div>
	 							<div><img src="/images/gp-logo.png"></div>
	 						</div>
	 					</div>
	 				</div>
	 				<div class="store-items">
		 				<div>
	 						<div>
	 							<div>Microsoft Store</div>
	 							<div>20€</div>
	 						</div>
	 						<div>
	 							<div>10000</div>
	 							<div><img src="/images/gp-logo.png"></div>
	 						</div>
	 					</div>
	 				</div>
	 				<div class="store-items">
		 				<div>
	 						<div>
	 							<div>Microsoft Store</div>
	 							<div>20€</div>
	 						</div>
	 						<div>
	 							<div>10000</div>
	 							<div><img src="/images/gp-logo.png"></div>
	 						</div>
	 					</div>
	 				</div>
	 				<div class="store-items">
		 				<div>
	 						<div>
	 							<div>Microsoft Store</div>
	 							<div>20€</div>
	 						</div>
	 						<div>
	 							<div>10000</div>
	 							<div><img src="/images/gp-logo.png"></div>
	 						</div>
	 					</div>
	 				</div>
	 				<div class="store-items">
		 				<div>
	 						<div>
	 							<div>Microsoft Store</div>
	 							<div>20€</div>
	 						</div>
	 						<div>
	 							<div>10000</div>
	 							<div><img src="/images/gp-logo.png"></div>
	 						</div>
	 					</div>
	 				</div>
	 				<div class="store-items">
		 				<div>
	 						<div>
	 							<div>Microsoft Store</div>
	 							<div>20€</div>
	 						</div>
	 						<div>
	 							<div>10000</div>
	 							<div><img src="/images/gp-logo.png"></div>
	 						</div>
	 					</div>
	 				</div>
 				</div>
 			</div>
 		</div>
 	</div>
 
	<script>
		if (window.innerWidth < 1050)
			document.body.style.height = document.body.scrollHeight+"px";
		else
			document.body.style.height = window.innerHeight+"px";
		
		window.onresize = () => {
			if (window.innerWidth < 1050)
				document.body.style.height = document.body.scrollHeight+"px";
			else
				document.body.style.height = window.innerHeight+"px";
		}
	</script>

  <script type="text/javascript" src="js/home.js"></script>
</body>
</html>

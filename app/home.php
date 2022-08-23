<?php 
	require $_SERVER['DOCUMENT_ROOT'].'/php/check-session.php'; 
	require $_SERVER['DOCUMENT_ROOT'].'/php/functions.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/home.css"/>
	<link rel="stylesheet" href="css/navbar.css"/> 
	<link rel="stylesheet" href="css/essentials.css"/>
	<link rel="stylesheet" href="css/ticket.css"/>
	<!--Importing icons-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
	<link rel="icon" href="/images/GameBetLogo-square.png">
	<title>Games - Gamebet</title>
</head>

<body>

<script> 
	const userSession = <?php echo json_encode($_SESSION); ?>;
	let userFavoriteGames = <?php echo json_encode(apiFetch("http://".$_SERVER['SERVER_NAME']."/api/users?keys=favoriteGames&id=".$_SESSION["userId"])["data"][0]["favoriteGames"]); ?>;
</script>

<?php include "templates/navbar.php"?>

<div style="position: relative;
				height: 70px;">
	<div style="position: absolute;
					left: 20px;
					top: 0;
					bottom: 0;
					margin: auto;
					height: fit-content;
					padding-top: 10px;">
		<div id="n-games" style="display: flex;
					align-items: center;
					font-size: 25px;
					color: var(--font-light-gray);
					font-weight: bold;">Games</div>
	</div>
	<div style="position: absolute;
				right: 20px;
				display: flex;
				align-items: center;
				margin: auto 15px;
				column-gap: 10px;
				top: 0;
				bottom: 0;">
		<div style="max-width: 300px;
						height: 35px;">
		  <div class="input-icons">
		      <i style="opacity: 0.5;" class="fa fa-search icon"></i>
		      <input class="input-field"
		             type="text"
		             placeholder="Game...">
			</div>
		</div>

		<input style="width: 35px;" type="image" src="/images/sort.png">
		<input id="favorites-filter" style="width: 25px;" type="image" src="/images/star.png">	
	</div>
</div>

<hr size="4" width="96%" color="#f50083"> 

<?php include("templates/loading.php"); ?>
<div style="display: none;" class="games-list">
	
</div>

<div class="ticket-button">
	<img src="images/cart.png">
	<div>
    	<div class="absolute-centered"></div>
  	</div>
</div>

<script type="text/javascript" src="vendor/swiped-events/swiped-events.min.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/home.js"></script>
<script type="text/javascript" src="js/ticket.js"></script>

</body>
</html>

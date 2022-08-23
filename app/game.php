<?php 
	require $_SERVER['DOCUMENT_ROOT'].'/php/check-session.php'; 
	require $_SERVER['DOCUMENT_ROOT'].'/php/functions.php';
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/game.css"/>
  <link rel="stylesheet" href="css/essentials.css"/>
  <link rel="stylesheet" href="css/navbar.css"/>
  <link rel="stylesheet" href="css/stream.css"/> 
  <link rel="stylesheet" href="css/ticket.css"/>
  <!--Importing icons-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
  <link rel="icon" href="/images/GameBetLogo-square.png">
  <title>Gamebet</title>
</head>

<body>
<script>
	const userSession = <?php echo json_encode($_SESSION); ?>;
	const userBets = <?php echo json_encode(apiFetch("http://".$_SERVER['SERVER_NAME']."/api/tickets?keys=bets&userId=".$_SESSION["userId"])["data"]); ?>;
</script>

<?php include "templates/navbar.php"?>

<div style="position: relative;
				height: 70px;">
  <div>
    <div style="position: absolute;
					left: 20px;
					top: 0;
					bottom: 0;
					margin: auto;
					height: fit-content;
					padding-top: 10px;">
      <div style="display: flex;
          align-items: baseline;
          column-gap: 5px;"><a href="home">home/</a><div style="display: flex; align-items: center; column-gap: 10px;"><b id="game-name" style="font-size: 25px; color: var(--font-gray)">Game</b><img style="width: 24px; cursor: pointer;" src="/images/star.png"></div></div>
      <div id="n-events" style="color:#f50083;font-weight: bold;">0 events</div>
    </div>
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
		      <i style="margin-left: 10px;opacity: 0.5;" class="fa fa-search icon"></i>
		      <input class="input-field"
		             type="text"
		             placeholder="Streamer...">
			</div>
		</div>

		<input style="width: 35px;" type="image" src="/images/sort.png">
	</div>
</div>

<hr size="4" width="96%" color="#f50083"> 

<?php include("templates/loading.php"); ?>
<div style="display:none;" id="streams"></div>

<div class="ticket-button">
	<img src="images/cart.png">
  <div>
    <div class="absolute-centered"></div>
  </div>
</div>

<script type="text/javascript" src="vendor/swiped-events/swiped-events.min.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/game.js"></script>
<script type="text/javascript" src="js/stream.js"></script>
<script type="text/javascript" src="js/ticket.js"></script>

</body>
</html>

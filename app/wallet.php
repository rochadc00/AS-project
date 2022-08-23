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
  <link rel="stylesheet" href="css/wallet.css"/>
  <link rel="stylesheet" href="css/essentials.css"/>
  <link rel="icon" href="/images/GameBetLogo-square.png">
  <title>Wallet - Gamebet</title>
</head>

<body>
	<script>
		const userSession = <?php echo json_encode($_SESSION); ?>;
	</script>
	
  <?php include "templates/navbar.php"?>
   
  <div class="absolute-centered">
    <div class="title">
      <h1>Wallet</h1>
    </div>
  

  
    <div class="middle-buttons">
      <div>
        <div>
          <div><?php echo apiFetch("http://".$_SERVER['SERVER_NAME']."/api/users?keys=money&id=".$_SESSION["userId"])["data"][0]["money"]; ?>€</div>
          <a href="deposit"><button type="button">Deposit</button></a>
          <a href="withdraw"><button type="button">Withdraw</button></a>
        </div>
        <div> 
          <div><?php echo apiFetch("http://".$_SERVER['SERVER_NAME']."/api/users?keys=points&id=".$_SESSION["userId"])["data"][0]["points"]; ?> <img src="/images/gp-logo.png" 
            style="width: 42px; filter: invert(27%) sepia(33%) 
            saturate(811%) hue-rotate(86deg) brightness(88%) contrast(87%);"></div>
          <a href="points"><button type="button">Win GameBet Points</button></a>
        </div>
      </div>
    </div> 

    <hr id="line">

    <div class="bottom-buttons">
      <a href="balance"><button type="button">Balance History</button></a>
      <a href="account"><button type="button">My Account</button></a>
      <a href="bets"><button type="button">Bets</button></a>
      <a href="#">
        <button type="button">Invite Friend</button>
        <div><button type="button">+ 10€</button></div>
      </a>
    </div>
  </div>

  <script type="text/javascript" src="js/home.js"></script>
</body>
</html>

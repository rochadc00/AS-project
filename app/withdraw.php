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
  <link rel="stylesheet" href="css/withdraw.css"/>
  <link rel="stylesheet" href="css/essentials.css"/>
  <link rel="icon" href="/images/GameBetLogo-square.png">
  <title>Withdraw - Gamebet</title>
</head>

<body>
<script>
		const userSession = <?php echo json_encode($_SESSION); ?>;
	</script>
	
  <?php include "templates/navbar.php"?>

<div class="absolute-centered">
  <div class="title">
    <h1>Withdrawal</h1>
  </div>

  <div class="image">
    <img src="images/money_guy.png"> 
  </div>

  <div class="input-field">
      <input type="text" placeholder="Valor a retirar (€)">
  </div>

  <div class="withdraw-money">
    <button type="button">Start Withdrawing Money</button>
  </div>
</div>


  <script type="text/javascript" src="js/withdraw.js"></script>
</body>
</html>
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
  <link rel="stylesheet" href="css/deposit.css"/>
  <link rel="stylesheet" href="css/essentials.css"/>
  <link rel="icon" href="/images/GameBetLogo-square.png">
  <title>Deposit - Gamebet</title>
</head>

<body>
	<script>
		const userSession = <?php echo json_encode($_SESSION); ?>;
	</script>
	
  <?php include "templates/navbar.php"?>


  <div class="absolute-centered">
    <div class="title">
      <h1>Deposit</h1>
    </div>

    <div class="deposit-values">
      <div>
        <button type="button">10€</button>
        <button type="button">20€</button>
      </div>
      <div>
        <button type="button">50€</button>
        <button type="button">100€</button>
      </div>
      <div>
        <button type="button">200€</button>
        <button type="button">500€</button>
      </div>
    </div>

    <div class="input-field">
      <input type="text" placeholder="Outro Valor (min. 5€)">
    </div>

    <div class="image">
      <img src="images/pagamento-mb.png">
      <img src="images/pagamento-mbway.png">
      <img src="images/pagamento-visa.png">
      <img src="images/pagamento-mastercard.png">
    </div>

    <div class="pay">
      <button type="button" id="pay">Pay Now</button>
    </div>
  </div>

	<script type="text/javascript" src="js/functions.js"></script>
  <script type="text/javascript" src="js/deposit.js"></script>
</body>
</html>




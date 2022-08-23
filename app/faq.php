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
  <link rel="stylesheet" href="css/faq.css"/>
  <link rel="stylesheet" href="css/essentials.css"/>
  <link rel="icon" href="/images/GameBetLogo-square.png">
  <title>FAQ - Gamebet</title>
</head>

<body>
	<script>
		const userSession = <?php echo json_encode($_SESSION); ?>;
	</script>
	
  <?php include "templates/navbar.php"?>


  <div class="absolute-centered">
  <main>
        <h1 class="faq-heading">FAQ</h1>
        <section class="faq-container">
            <div class="faq-one">
                <h1 class="faq-page">O que é a Gamebet</h1>
                <div class="faq-body">
                    <p>A Gamebet é uma plataforma de apostas em jogos digitais feita no âmbito da unidade curricular de Análise de Sistemas na Universidade de Aveiro. 
                       Esta plataforma foi desenvolvida por Diogo Correia, Diana Rocha, Gonçalo Maranhão e Gil Fernandes. 
                    </p>
                </div>
            </div>
            <hr class="hr-line">
            <div class="faq-two">
                <h1 class="faq-page">Que funcionalidades estão presentes</h1>
                <div class="faq-body">
                    <p>De momento, a Gamebet encontra-se em estado de desenvolvimento e, como tal, ainda não tem muitas funcionalidades desenvolvidas.
                       A Gamebet dispõe de uma base de dados, com valores (dinheiro e pontos) gerados aleatoriamente, para já.
                       É possível manipular esses valores, de forma persistente, através de apostas a partir da home, acedendo à página "Wallet" é possível depositar (deposit) ou retirar (withdraw) dinheiro da conta. 
                       Estas ações são apenas, para já, para efeitos de simulação, visto que não há comunicação com entidades bancárias.</p>
                </div>
            </div>
            <hr class="hr-line">
            <div class="faq-three">
                <h1 class="faq-page">Funcionalidades futuras</h1>
                <div class="faq-body">
                    <p>A Gamebet tem a ambição de oferecer uma plataforma onde se possa apostar dinheiro ou pontos, dependendo da possibilidade (idade) e vontade dos utilizadores.
                       Para além de um sistema de apostas tradicional com dinheiro ou pontos, contará com um algoritmo robusto de apostas em tempo real, registo com verificação recorrendo a inteligência artifical,
                       diferenciação de serviços tendo em conta o utilizador (menores de idade, maiores de idade e streamers),
                       oferecer parceria a streamers interessados na plataforma, entre outras funcionalidades futuras. 
                    </p>
                </div>
            </div>
            <hr class="hr-line">
            <div class="faq-four">
                <h1 class="faq-page">Compatibilidade</h1>
                <div class="faq-body">
                    <p>A Gamebet conta desde já com compatibilidade para dispositivos de qualquer dimensão de ecrã compreendidos entre os smartphones e desktops/laptops.
                        O seu acesso é feito através de um browser.
                    </p>
                </div>
            </div>
            <hr class="hr-line">
            <div class="faq-five">
                <h1 class="faq-page">A quem se destina</h1>
                <div class="faq-body">
                    <p>A Gamebet pode ser usada por qualquer pessoa a partir dos 16 anos de idade. DIferentes idades estarão limitadas ao uso de funcionalidades especifícas.</p>
        </section>
    </main>
</div>

<script type="text/javascript" src="js/faq.js"></script>

</body>
</html>
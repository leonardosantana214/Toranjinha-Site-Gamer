<?php
session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION['email'])) {
	header("location: process.php");
	exit();
}
?>
<!DOCTYPE html>

<html lang="pt-br">


<head>

	<meta charset="UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Toranja - Jogos</title>

	<link rel="stylesheet" href="styleJogos.css">
	<style>
		@font-face {
			font-family: 'Pixeboy-z8XGD';
			src: url('css/pixeboy-font/Pixeboy-z8XGD.ttf');
		}

		* {
			margin: auto;
			font-family: 'Pixeboy-z8XGD';
		}



		/* Estilos para o header */
		header {
			background-color: rgba(255, 255, 255, 0.599);
			color: black;
			padding: 20px;
			text-align: center;
			font-size: 30px;
		}


		/* Estilos para o main */
		main {
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			align-items: center;
			padding: 20px;
		}

		/* Estilos para as divs dos jogos */
		.jogo {
			width: 300px;
			height: 300px;
			margin: 20px;
			border-radius: 10px;
			overflow: hidden;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
			transition: transform 0.3s ease-in-out;
		}

		/* Estilos para o hover das divs dos jogos */
		.jogo:hover {
			transform: scale(1.05);
		}

		/* Estilos para as imagens dos jogos */
		.jogo img {
			width: 100%;
			height: 100%;
			object-fit: cover;
		}
	</style>
</head>

<body>
	<header>
		<nav>
			<ul>
				<li><a href="meu primeiro site.php">Inicio</a></li>
				<img class="imagem" src="Frutas/Logo.png" alt="">
				<li><a href="https://www.instagram.com/kinesprice/">Instagram</a></li>
				<li>
					<?php
					if (isset($_SESSION['nome']) && !empty($_SESSION['nome'])) {
						echo '<a href="#about">' . $_SESSION['nome'] . '</a>';
					} else {
						echo '<a href="LoginToranjão.php">Login</a>';
					}
					?>
				</li>

				<li><a><button type="submit" id="modoEscuroBtn" class="lua" onclick="troca()"><img
								src="https://64.media.tumblr.com/ed7868e316b410275de826d78c08dfee/tumblr_p3fs1eHdCS1wvcbfqo1_1280.gif"
								style="width: 30px; height: 30px;" id="photo-dark" title="deixa escuro"
								alt="modo-escuro"></i></button></a></li>
			</ul>
		</nav>
	</header>
	<p>

		Aqui e a parte de jogos, se voce quiser aprender a desenvolver se divertindo no <br> <span>toranjinha
			games</span>

	</p> <br>

	<main>

		<div class="jogo">
			<a href="https://flexboxfroggy.com/"><img src="assets/3318923-flexbox-froggy.png"></a>
			<h2>FlexBox Froggy</h2>
			<p>Descrição do Jogo 1</p>
		</div>
		<div class="jogo">
			<a href="Hardware/Atividade/Binary Game.html"><img src="assets/Captura de tela 2023-04-28 134515.png"></a>
			<h2>Jogo 2</h2>
			<p>Descrição do Jogo 2</p>
		</div>
		<div class="jogo">
			<a href="https://cssbattle.dev/"><img src="assets/BIu19jPP_400x400.png"></a>
			<h2>Jogo 3</h2>
			<p>Descrição do Jogo 3</p>
		</div>
		<div class="jogo">
			<a href="https://flukeout.github.io/"><img src="assets/maxresdefault.jpg"></a>
			<h2>Jogo 4</h2>
			<p>Descrição do Jogo 4</p>
		</div>
	</main>
	<script>
		const modoEscuroBtn = document.getElementById('modoEscuroBtn');
		const body = document.body;

		modoEscuroBtn.addEventListener('click', () => {
			body.classList.toggle('modo-escuro');
		});

	</script>
</body>

</html>
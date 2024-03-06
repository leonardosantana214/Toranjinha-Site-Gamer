<!DOCTYPE html>
<html lang="pt-br">
<?php
session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION['email'])) {
  header("location: process.php");
  exit();
}
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Vendas - Toranjinha</title>
  <link rel="shortcut icon" href="Frutas/istockphoto-1243077910-170667a.jpg" type="image/x-icon">
  <link rel="stylesheet" href="styleRevoluction.css">
</head>
<style>
  @font-face {
    font-family: 'Pixeboy-z8XGD';
    src: url('css/pixeboy-font/Pixeboy-z8XGD.ttf');
  }

  * {
    margin: auto;
    font-family: 'Pixeboy-z8XGD';
  }

  body {
    background-image: url(https://i.redd.it/6u69qrpuzrga1.gif);
    background-size: cover;
    color: var(--texto-claro);
    transition: 3s;
    zoom: 125%;
  }

  a button {
    background-color: transparent;
  }

  /* Estilos para o modo escuro */
  body.modo-escuro {
    background-image: url('https://i.redd.it/cxhfjeq9abcb1.gif');
    background-size: cover;
    color: var(--texto-escuro);
    transition: 3s;
  }

  .products {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
  }

  .product {
    width: 100%;
    transition: 1s;
    border: orangered solid 1px;
    background-color: #000000a6;
    padding: 5px;
  }

  /* Adicionando alguns estilos para ajustar o layout em telas menores */
  @media (max-width: 768px) {
    .products {
      grid-template-columns: 1fr;
    }

    .product {
      width: 100%;
    }
  }
</style>

<body>
  <header>
    <nav>
      <ul>
        <li><a href="meu primeiro site.php">Inicio</a></li>
        <img class="imagem" src="Frutas/Logo.png" alt="">
        <li><a href="TELA DE JOGOS.php">Jogos</a></li>
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
        <li>
          <a>
            <button type="submit" id="modoEscuroBtn" class="lua" onclick="troca()">
              <img
                src="https://64.media.tumblr.com/ed7868e316b410275de826d78c08dfee/tumblr_p3fs1eHdCS1wvcbfqo1_1280.gif"
                style="width: 30px; height: 30px;" id="photo-dark" title="deixa escuro" alt="modo-escuro">
            </button>
          </a>
        </li>
      </ul>
    </nav>
  </header>
  <main>
    <h1>Os Melhores Mundos do PalPreto</h1>
    <p>Viva em Mundos Desafiadores e Magicos</p>
    <div class="products">
      <?php
      $usuario = 'root';
      $senha = '';
      $database = 'toranja';
      $host = 'localhost';

      $mysqli = new mysqli($host, $usuario, $senha, $database);
      if ($mysqli->connect_error) {
        die('Falha ao conectar o banco de dados' . $mysqli->connect_error);
      }

      $result = $mysqli->query("SELECT * FROM produtos");

      if ($result) {
        while ($row = $result->fetch_assoc()) {
          echo '<div class="product">';
          echo '<a href="Descricao.php?id=' . $row['id'] . '">';
          echo '<img src="' . $row['imagem'] . '" alt="' . $row['nome'] . '">';
          echo '<h2>' . $row['nome'] . '</h2>';
          echo '<p>' . $row['descricao'] . '</p>';
          echo '<button>Comprar</button>';
          echo '</a>';
          echo '</div>';
        }
        $result->free();
      }
      ?>
    </div>
  </main>
  <br><br><br><br><br>
  <footer>
    <p>Cabos de Vassoura &copy; 2023</p>
  </footer>
  <script>
    const modoEscuroBtn = document.getElementById('modoEscuroBtn');
    const body = document.body;

    modoEscuroBtn.addEventListener('click', () => {
      body.classList.toggle('modo-escuro');
    })
  </script>
</body>

</html>
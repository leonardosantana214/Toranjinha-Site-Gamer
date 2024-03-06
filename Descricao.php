<?php
session_start();
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('conexao.php'); // Inclua a conexão com o banco de dados

$usuario = 'root';
$senha = '';
$database = 'toranja';
$host = 'localhost';

$mysqli = new mysqli($host, $usuario, $senha, $database);
if ($mysqli->connect_error) {
    die('Falha ao conectar o banco de dados: ' . $mysqli->connect_error);
}

if (isset($_POST['adicionar_carrinho'])) {
    // Verificar se a sessão está definida
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: LoginToranjão.php");
        exit();
    }

    $produto_id = $_POST['produto_id'];
    $quantidade = $_POST['quantidade'];
    $usuario_id = $_SESSION['usuario_id'];

    // Buscar informações do produto no banco de dados
    $query_produto = "SELECT * FROM produtos WHERE id = '$produto_id'";
    $result_produto = $mysqli->query($query_produto);

    if ($result_produto->num_rows > 0) {
        $produto = $result_produto->fetch_assoc();
        $preco = $produto['preco'];

        // Inserir no carrinho
        $sql = "INSERT INTO carrinho (usuario_id, produto_id, quantidade, preco) VALUES ('$usuario_id', '$produto_id', '$quantidade', '$preco')";
        $mysqli->query($sql);
    }
}

// Consultar 3 produtos aleatórios da loja
$sqlRandomProducts = "SELECT id, nome, imagem1, preco FROM produtos ORDER BY RAND() LIMIT 3";
$resultRandomProducts = $mysqli->query($sqlRandomProducts);

// Array para armazenar os resultados dos produtos aleatórios
$randomProducts = array();

while ($row = $resultRandomProducts->fetch_assoc()) {
    $randomProducts[] = $row;
}

// Verificar se o ID do produto está definido na URL
$idProduto = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Consultar os detalhes do produto específico
if ($idProduto > 0) {
    $sqlProdutoEspecifico = "SELECT * FROM produtos WHERE id = $idProduto";
    $resultProdutoEspecifico = $mysqli->query($sqlProdutoEspecifico);

    // Array para armazenar os resultados do produto específico
    $productData = array();

    if ($resultProdutoEspecifico) {
        // Verificar se a consulta foi bem-sucedida
        if ($resultProdutoEspecifico->num_rows > 0) {
            // Armazenar os resultados em um array associativo
            $productData = $resultProdutoEspecifico->fetch_assoc();
        }
    } else {
        // Adicionar uma mensagem de erro ao log ou exibir na tela
        echo "Erro na consulta SQL: " . $mysqli->error;
    }
} else {
    echo "ID do produto não especificado.";
}

// Fechar a conexão com o banco de dados
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $productData['nome'] ?> - Toranjinha
    </title>
    <link rel="shortcut icon" href="Frutas/istockphoto-1243077910-170667a.jpg" type="image/x-icon">
    <link rel="stylesheet" href="styleDescription.css">
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
            background-size: cover;
            background-repeat: no-repeat;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.9)), url('https://wallpapercave.com/wp/wp12850254.gif');
            background-color: black;
            margin: 0;
            zoom: 125%;
        }

        .alert {
            padding: 20px;
            background-color: #f44336;
            color: white;
            margin: 0;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 20px;
            line-height: 10px;
            cursor: pointer;
        }

        .closebtn:hover {
            color: black;
        }

        .product-details {
            position: relative;
            top: -430px;
            padding: 20px;
            left: 330px;
            width: 310px;
            background-color: #33333360;
        }

        .product-price {
            color: white;
        }

        .btn-Link {
            font-family: 'Pixeboy-z8XGD';
            font-size: large;
            width: 150px;
            height: 50px;
            color: white;
            text-transform: uppercase;
            background-color: rgba(255, 166, 0, 0.182);
            border-top: 1px orange;
            padding: 10px;
            border-left: 1px orange;
            border-color: rgba(255, 166, 0, 0.525);
            border-right: 4px solid orangered;
            border-bottom: 6px solid orangered;
            transition: 1s;
            box-shadow: -3px 0 0 0 black, 3px 0 0 0 black, 0 -3px 0 0 black, 0 3px 0 0 black;
            margin-top: 30px;
        }

        .btn-Link:active {
            background-color: rgb(173, 114, 3);
            transform: translateY(3px);
            width: 148px;
            border-right: 4px orangered;

            border-bottom: 5px solid orangered;
        }

        .btn-Link:hover {
            background-color: rgba(255, 166, 0, 0.604);
            transition: 1s;
            border-top: 1px rgba(255, 68, 0, 0.612);
            border-left: 1px rgba(255, 68, 0, 0.474);
            border-color: rgba(255, 68, 0, 0.582);
            border-right: 6px solid rgba(255, 68, 0, 0.712);
            border-bottom: 8px solid rgba(255, 68, 0, 0.59);
        }

        label {
            color: white;
        }

        section::before {
            content: '';
            position: absolute;
            width: 100%;
            left: 0;
            margin: 0;
            top: -60px;
            height: 60px;
            background: linear-gradient(to top, rgba(128, 0, 128, 0.479), transparent);
        }

        section {
            position: relative;
            content: "";
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.9)), url('https://wallpapercave.com/wp/wp12850254.gif');
            background-size: cover;
            background-repeat: no-repeat;
            width: 2080px;
            height: 560px;
            margin-top: 50px;
            background-color: #000;
            z-index: 99999;
            box-shadow: 0 0 50px purple;
        }

        .random-products {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            position: relative;
            top: -300px;
            color: white;


        }

        .random-products a {
            text-decoration: none;
            color: white;
        }

        .random-product {
            text-align: center;
            width: 120px;
            /* Ajuste a largura conforme necessário */
            margin-top: 10px;
            /* Ajuste a margem superior conforme necessário */
            border: solid 1px gray;
            padding: 25px;
            transition: 1s;
            height: 160px;
        }

        .random-product img {
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
            /* Adiciona espaço entre a imagem e o texto */
        }

        .random-product s {
            font-weight: 200;
            font-size: x-small;
        }

        .random-product:hover {
            transition: 1s;
            transform: translateY(-10px);
        }

        hr {
            width: 40%;
            position: relative;
            top: -400px;

        }


        .imgSmall {
            max-width: 80% !important;
            flex-direction: column;
            display: flex;
        }


        .Quant-Label {
            position: relative;
            top: 35px;
        }

        #resultado {
            color: white;
            margin-top: 20px;
        }

        #freteInput {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div id="myAlert" class="alert">
        <span class="closebtn" onclick="closeAlert()">&times;</span>
        <strong>Alerta:</strong> Aproveite a promocao ;-;
    </div>


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
            </ul>
        </nav>
    </header>

    <main>
        <?php
        if (!empty($productData)) {
            // Se $productData é um array associativo
            echo '<div id="Imgbig">';
            // Exibir as imagens dos produtos
            echo '<img src="' . $productData['imagem1'] . '" style="width: 400px; heigth: 400px;" alt="Imagem do Produto" class="product-images" id="imagem1">';
            echo '</div>';
            echo '<div id="ImgSmall">';
            echo '<img src="' . $productData['imagem2'] . '" alt="1 Produto" class="imgSmall" onclick="trocarComImagemPrincipal(this)">';
            echo '<img src="' . $productData['imagem3'] . '" alt="Imagem do Produto" class="imgSmall" onclick="trocarComImagemPrincipal(this)">';
            echo '<img src="' . $productData['imagem4'] . '" alt="Imagem do Produto" class="imgSmall" onclick="trocarComImagemPrincipal(this)"> ';
            echo '</div>';
            echo '<br>';
            echo '<section>';
            echo '<div class="product-details">';
            echo '<p class="product-description">' . $productData['nome'] . '</p>';
            echo '<p class="product-price">R$ ' . number_format($productData['preco'], 2, ',', '.') . '</p>';
            echo '<form method="post" action="carrinho.php">';
            echo '<div id="quantidade-input">';
            echo '<input type="hidden" name="produto_id" value="' . $productData['id'] . '">';
            echo '<label class="Quant-Label" for="quantidade">Quantidade:</label>';
            echo '<input type="number" id="quantidade" name="quantidade" min="1" max="10" value="1">';
            echo '<input type="submit" name="adicionar_carrinho" class="btn-Link" value="Carrinho">';
            echo '</div>';
            echo '</form>';
            echo '<div id="freteInput">';
            echo '<form action="#">';
            echo '<label class="Frete-Label" for="cep">CEP de entrega:</label>';
            echo '<input type="text" id="cep" name="cep" minlength="8" maxlength="8" placeholder="Digite seu CEP" required>';
            echo '<button onclick="calcularFrete()" type="button" class="btn-Link btn-Calcular" style="padding:0; margin:0;">Calcular Frete</button>';
            echo '<p class="value"><div id="resultado"></div></p>';
            echo '</form>';
            echo '</div>';
            echo '<h2 style="color:orangered;">Descricao</h2>';
            echo '<p style="color:white;">' . $productData['descricao'] . '</p>';
            echo '</div>';
            echo '<br><br><br>';
            echo '<hr style=" color: #33333360;">';
        } else {
            echo "Nenhum Produto Encontrado!";
        }

        echo '<p class="product-description" style="position:relative; top:-400px;">Produtos Recomendados</p>';
        if (!empty($randomProducts)) {
            echo '<div class="random-products">';
            foreach ($randomProducts as $randomProduct) {
                echo '<a href="descricao.php?id=' . $randomProduct['id'] . '" class="random-product">';
                echo '<img src="' . $randomProduct['imagem1'] . '" style="width: 100px; height: 100px;" alt="Imagem do Produto" id="imagem1">';
                echo '<p>' . $randomProduct['nome'] . '</p>';
                echo '<s>frete gratis</s>';
                echo '<p>R$ ' . number_format($randomProduct['preco'], 2, ',', '.') . '</p>';
                echo '</a>';
            }
            echo '</div>';
        } else {
            echo '<p>Nenhum produto aleatório encontrado.</p>';
        }
        echo '</section>';
        ?>

    </main>
</body>
<script src="JavadaDescrição.js"></script>

</html>
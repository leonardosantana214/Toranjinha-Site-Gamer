<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('conexao.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Operações de Login
    if (isset($_POST['email']) && isset($_POST['senha'])) {
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM usuarios WHERE email = '$email'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código: " . $mysqli->error);
        $quantidade = $sql_query->num_rows;
        if ($quantidade == 1) {
            $usuario = $sql_query->fetch_assoc();
        
            if (password_verify($senha, $usuario['senha'])) {
                // Iniciar a sessão e armazenar informações relevantes
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['nome'] = $usuario['nome'];
                $_SESSION['image'] = $usuario['image'];
        
                // Redirecionar para a página home
                header("location: meu_primeiro_site.php");
                exit();
            } else {
                // Defina a mensagem de erro para senha incorreta
                $_SESSION['error_message'] = "Senha incorreta";
                header('Location: LoginToranjão.php');
                exit();
            }
        } else {
            // Defina a mensagem de erro para email não encontrado
            $_SESSION['error_message'] = "E-mail não encontrado";
            header('Location: LoginToranjão.php');
            exit();
        }
        
    }
}
// Verifique se existe uma mensagem de erro
if (isset($_SESSION['error_message'])) {
    echo '<span class="span" style="color: red;">' . $_SESSION['error_message'] . '</span>';
    // Limpe a mensagem de erro da sessão após exibi-la
    unset($_SESSION['error_message']);
}
// Operações de Cadastro
if (isset($_POST['nomeCadastro']) && isset($_POST['emailCadastro']) && isset($_POST['senhaCadastro']) && isset($_POST['CPF'])) {
    $nomeCadastro = $mysqli->real_escape_string($_POST["nomeCadastro"]);
    $emailCadastro = $mysqli->real_escape_string($_POST["emailCadastro"]);
    $senhaCadastro = password_hash($mysqli->real_escape_string($_POST["senhaCadastro"]), PASSWORD_BCRYPT);
    $cpfCadastro = $mysqli->real_escape_string($_POST["CPF"]);

    // Verifica se o e-mail já está cadastrado
    $sqlVerificaEmail = "SELECT * FROM usuarios WHERE email = '$emailCadastro'";
    $result = $mysqli->query($sqlVerificaEmail);
    if ($result->num_rows > 0) {
        echo 'E-mail já cadastrado';
    } else {
        // Inserção no banco de dados
        // Inserção no banco de dados
        $sqlCadastro = "INSERT INTO usuarios (nome, email, senha, cpf) VALUES ('$nomeCadastro', '$emailCadastro', '$senhaCadastro', '$cpfCadastro')";
        if ($mysqli->query($sqlCadastro)) {
            // Redirecionar para a página de sucesso
            header("Location: LoginToranjão.php");
            exit(); // Certifique-se de sair após o redirecionamento
        } else {
            // Se houver um erro no SQL, exiba uma mensagem de erro
            die("Erro ao cadastrar usuário: " . $mysqli->error);
        }

    }
}

?>

<!DOCTYPE html>
<html lang="pt-Br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styleLogin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Login - Toranjinha</title>
    <script src="LoginToranja.js">
    </script>
</head>

<body class="body">
    <div class="container">
        <div class="card-container">
            <div class="card">
                <!-- LOGIN -->
                <div class="login-form">
                    <div class="header">Login</div>
                    <div class="content">
                        <form action="process.php" method="post">
                            <!-- Campos do formulário de login -->
                            <label for="email">E-Mail</label>
                            <input type="email" name="email" id="email" placeholder="Coloque o seu E-mail"
                                class="input">
                            <br><br>
                            <label for="senha">Senha</label>
                            <input type="password" name="senha" id="senha" class="input"
                                placeholder="Coloque sua Senha">
                            <br><br>
                            <button class="custom-btn btn-6"><span>LOGIN</span></button>
                        </form>

                    </div>
                    <button class="btn btn-rotate" id="btn-login">Faça o cadastro</button>
                </div>
                <!-- CADASTRO -->
                <div class="signup-form">
                    <div class="header">CADASTRO</div>
                    <div class="content">
                        <!-- Formulário de cadastro -->
                        <form action="LoginToranjão.php" method="post">
                            <!-- Campos do formulário de cadastro -->
                            <label for="nome">Nome</label>
                            <!-- Altere name="nome" para name="nomeCadastro" -->
                            <input type="text" name="nomeCadastro" placeholder="Coloque seu nome" class="input"><br>

                            <br>
                            <label for="emailCadastro">E-Mail</label>
                            <!-- Altere name="emailCadastro" para name="emailCadastro" -->
                            <input type="email" name="emailCadastro" id="emailCadastro"
                                placeholder="Coloque o seu E-mail" class="input"><br>

                            <br><br>
                            <label for="senhaCadastro">Senha</label>
                            <!-- Altere name="senhaCadastro" para name="senhaCadastro" -->
                            <input type="password" name="senhaCadastro" id="senhaCadastro" class="input"
                                placeholder="Coloque sua Senha" minlength="4"><br>
                            <span id="error-message" style="color: red;"></span>
                            <br>
                            &nbsp;&nbsp;&nbsp;&nbsp;<label for="CPF">CPF</label>
                            <!-- Altere name="CPF" para name="CPF" -->
                            <input oninput="mascara(this)" type="text" name="CPF" placeholder="xxx.xxx.xxx-xx"
                                class="input CPF" maxlength="11" minlength="11" id="CPF"> <br>
                            <button type="submit" class="btn btn-rotate btn-7">Salvar</button>
                        </form>


                    </div>
                    <button class="btn btn-rotate btn-7" id="btn-signup">Faça Login</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 

include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $nome = $data['nome'];
    $espec = $data['espec'];
    $CRM = $data['crm'];
    $usuario = $data['usuario'];
    $senha = $data['senha'];

    if (!empty($nome) && !empty($espec) && !empty($CRM) && !empty($usuario) && !empty($senha)) {
        $sql = "INSERT INTO tbmedico (nome, especialidade, CRM, usuario, senha) VALUES ('$nome', '$espec', '$CRM', '$usuario', '$senha')";

        if ($conect->query($sql) === TRUE) {
            echo json_encode(["message" => "Médico inserido com sucesso!", "status" => "success"]);
        } else {
            echo json_encode(["message" => "Erro ao inserir o médico: " . $conect->error, "status" => "error"]);
        }
        } else {
            echo json_encode(["message" => "Por favor, preencha todos os campos corretamente.", "status" => "error"]);
        }
} else {
    echo json_encode(["message" => "Método HTTP inválido. Use POST.", "status" => "error"]);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir médico</title>
</head>
<body>
    <h2>Inserir médico</h2>

    <form method="POST">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="espec">Especialidade:</label><br>
        <input type="text" id="espec" name="espec" required><br><br>

        <label for="coren">CRM:</label><br>
        <input type="text" id="crm" name="crm" required><br><br>

        <label for="usuario">Usuário:</label><br>
        <input type="text" id="usuario" name="usuario" required><br><br>

        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" name="senha" required><br><br>

        <input type="submit" value="Confirmar">
    </form>

    <br><a href="login.php">Desconectar</a>
</body>
</html>

<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $nome = $data['nome'];
    $corem = $data['coren'];
    $usuario = $data['usuario'];
    $senha = $data['senha'];
    if (!empty($nome) && !empty($corem) && !empty($usuario) && !empty($senha)) {
        $sql = "INSERT INTO tbenfermeiro (nome, COREN, usuario, senha) VALUES ('$nome', '$corem', '$usuario', '$senha')";
        if ($conect->query($sql) === TRUE) {
            echo json_encode(["message" => "Enfermeiro inserido com sucesso!", "status" => "success"]);
        } else {
            echo json_encode(["message" => "Erro ao inserir o enfermeiro: " . $conect->error, "status" => "error"]);
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
    <title>Inserir Enfermeiro</title>
    <script>
        function enviarFormulario() {
            const nome = document.getElementById('nome').value;
            const coren = document.getElementById('coren').value;
            const usuario = document.getElementById('usuario').value;
            const senha = document.getElementById('senha').value;

            const dados = {
                nome: nome,
                coren: coren,
                usuario: usuario,
                senha: senha
            };

            fetch('inserirenfermeiro.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dados)
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao enviar dados!');
            });
        }
    </script>
</head>
<body>
    <h2>Inserir Enfermeiro</h2>
    <form onsubmit="event.preventDefault(); enviarFormulario();">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="coren">COREN:</label><br>
        <input type="text" id="coren" name="coren" required><br><br>

        <label for="usuario">Usuário:</label><br>
        <input type="text" id="usuario" name="usuario" required><br><br>

        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" name="senha" required><br><br>

        <input type="submit" value="Confirmar">
    </form>
</body>
</html>


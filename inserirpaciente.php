<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $nome = $data['nome'];
    $leito = $data['leito'];
    $dataNasc = $data['dataNasc'];
    if (!empty($nome) && !empty($dataNasc)) {
        $sql = "INSERT INTO tbpaciente (nome, leito, dataNascimento) VALUES ('$nome', '$leito', '$dataNasc')";

        if ($conect->query($sql) === TRUE) {
            echo json_encode(["message" => "Paciente inserido com sucesso!", "status" => "success"]);
        } else {
            echo json_encode(["message" => "Erro ao inserir o paciente: " . $conect->error, "status" => "error"]);
        }
    } else {
        echo json_encode(["message" => "Por favor, preencha todos os campos corretamente.", "status" => "error"]);
    }
} else {
    echo json_encode(["message" => "Método HTTP inválido. Use POST.", "status" => "error"]);
}
?>

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir paciente</title>
    <script>
        function enviarFormulario() {
            const nome = document.getElementById('nome').value;
            const leito = document.getElementById('leito').value;
            const dataNasc = document.getElementById('dataNasc').value;

            const dados = {
                nome: nome,
                leito: leito,
                dataNasc: dataNasc
            };

            fetch('inserirpaciente.php', {
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
    <h2>Inserir paciente</h2>
    <form method="POST">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="leito">Leito:</label><br>
        <input type="number" id="leito" name="leito"><br><br>

        <label for="dataNasc">Data de Nascimento:</label><br>
        <input type="text" id="dataNasc" name="dataNasc" required><br><br>

        <input type="submit" value="Confirmar">
    </form>
</body>
</html>

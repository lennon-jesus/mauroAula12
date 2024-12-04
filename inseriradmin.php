<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include('conexao.php');

$inputData = json_decode(file_get_contents('php://input'), true);

$nomePac = $inputData['nomePac'];
$nomeMed = $inputData['nomeMed'];
$dataAdmin = isset($inputData['dataAdmin']) ? $inputData['dataAdmin'] : null;
$dose = $inputData['dose'];

if (!empty($nomePac) && !empty($nomeMed) && !empty($dose)) {

    $sql = "INSERT INTO tbadministracao (id, nomePaciente, nomeMedicamento, dataAdmin, dose, dataRegistro) VALUES (NULL, '$nomePac', '$nomeMed', '$dataAdmin', '$dose', CURRENT_TIMESTAMP)";
    if ($conect->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Administração inserida com sucesso!"]);
        } else {
        echo json_encode(["status" => "error", "message" => "Erro ao inserir administração: " . $conect->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Por favor, preencha todos os campos corretamente."]);
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Administração</title>
    <script>
        function inserirAdmin() {
            const nomePac = document.getElementById('nomePac').value;
            const nomeMed = document.getElementById('nomeMed').value;
            const dataAdmin = document.getElementById('dataAdmin').value;
            const dose = document.getElementById('dose').value;

            const dados = {
                nomePac: nomePac,
                nomeMed: nomeMed,
                dataAdmin: dataAdmin,
                dose: dose
            };

            fetch('inseriradmin.php', {
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
                alert('Erro ao inserir administração');
            });
        }
    </script>
</head>
<body>
    <h2>Inserir Administração</h2>

    <label for="nomePac">Nome do Paciente:</label><br>
    <input type="text" id="nomePac" required><br><br>

    <label for="nomeMed">Nome do Medicamento:</label><br>
    <input type="text" id="nomeMed" required><br><br>

    <label for="dataAdmin">Data de Administração:</label><br>
    <input type="text" id="dataAdmin"><br><br>

    <label for="dose">Dose:</label><br>
    <input type="text" id="dose" required><br><br>

    <button onclick="inserirAdmin()">Confirmar</button>
</body>
</html>

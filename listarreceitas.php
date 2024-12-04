<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include('conexao.php');

$sql = "SELECT id, nomePaciente, nomeMedicamento, dataAdmin, dose FROM tbreceita";
$result = $conect->query($sql);

if (!$result) {
    echo json_encode(["message" => "Erro na consulta SQL: " . $conect->error, "status" => "error"]);
    die();
}

if ($result->num_rows > 0) {
    $receitas = [];

    while ($row = $result->fetch_assoc()) {
        $receitas[] = [
            'id' => $row['id'],
            'nomePaciente' => $row['nomePaciente'],
            'nomeMedicamento' => $row['nomeMedicamento'],
            'dataAdmin' => $row['dataAdmin'],
            'dose' => $row['dose']
        ];
    }

    echo json_encode(["status" => "success", "data" => $receitas]);
} else {
    echo json_encode(["status" => "success", "message" => "Não há receitas cadastradas.", "data" => []]);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Receitas</title>
    <script>
        function carregarReceitas() {
            fetch('listarreceitas.php')
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        let tabela = "<table border='1'><thead><tr><th>ID Receita</th><th>Paciente</th><th>Medicamento</th><th>Data Admin.</th><th>Dose</th></tr></thead><tbody>";

                        data.data.forEach(receita => {
                            tabela += `<tr>
                                            <td>${receita.id}</td>
                                            <td>${receita.nomePaciente}</td>
                                            <td>${receita.nomeMedicamento}</td>
                                            <td>${receita.dataAdmin}</td>
                                            <td>${receita.dose}</td>
                                        </tr>`;
                        });

                        tabela += "</tbody></table>";
                        document.getElementById('receitas').innerHTML = tabela;
                    } else {
                        document.getElementById('receitas').innerHTML = data.message;
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    document.getElementById('receitas').innerHTML = 'Erro ao carregar receitas';
                });
        }

        window.onload = carregarReceitas;
    </script>
</head>
<body>
    <h2>Lista de Receitas</h2>
    <div id="receitas"></div>
</body>
</html>


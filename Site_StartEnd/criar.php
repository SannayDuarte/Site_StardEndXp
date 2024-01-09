 <?php
session_start();
include_once("conexao.php");

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$id_criador = 1; // Substitua isso pela lógica real para obter o ID do usuário autenticado

// Verifica se o usuário está autenticado

// Verifica se o usuário está autenticado
$tipo_usuario = isset($_SESSION['tipo_usuario']) ? $_SESSION['tipo_usuario'] : null;

// Obtém o ID do professor autenticado
$id_prof = isset($_SESSION['id_prof']) ? $_SESSION['id_prof'] : null;



// Obtém o ID do professor autenticado
$id_prof = isset($_SESSION['id_prof']) ? $_SESSION['id_prof'] : null;


if (isset($_POST['search'])) {
    $search = '%' . $_POST['search'] . '%';
    $consulta = "SELECT * FROM equipes WHERE nome_equipe LIKE :search";
    $resultado = $conn->prepare($consulta);
    $resultado->bindParam(':search', $search, PDO::PARAM_STR);
    $resultado->execute();
} else {
    // Se a barra de pesquisa não foi utilizada, mostra todas as equipes
    $consulta = "SELECT * FROM equipes";
    $resultado = $conn->query($consulta) or die($conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipes Existentes</title>
    <link rel="stylesheet" href="criar.css">
    <!-- Adiciona jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Adiciona script JavaScript para atualização em tempo real -->
    <script>
        $(document).ready(function () {
            // Adiciona um ouvinte de eventos à barra de pesquisa
            $('#search').on('input', function () {
                // Obtém o valor atual da barra de pesquisa
                var searchTerm = $(this).val();

                // Envia uma solicitação AJAX para obter os resultados da pesquisa
                $.ajax({
                    type: 'POST',
                    url: 'criarequipe.php',
                    data: {search: searchTerm},
                    success: function (response) {
                        // Atualiza a tabela de resultados
                        $('#resultTable').html(response);
                    }
                });
            });
        });
    </script>
</head>
<body>
    
<form class="eq-ex">
<h1>Equipes já existentes</h1>

<form method="POST">
    <input type="text" name="search" id="search" placeholder="Pesquisar por nome da equipe">
</form>

<table border="1" id="resultTable">
    <tr>
        <th>Nome</th>
        <th>Foto</th> <!-- Adicionado -->
    </tr>
    <?php
    while ($dado = $resultado->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
            <td><a href='equipes/<?php echo $dado["nome_equipe"] . ".php"; ?>'><?php echo $dado["nome_equipe"]; ?></a></td>
            <td>
                <?php
                if ($dado['foto_equipe'] !== null) {
                    echo "<img src='{$dado['foto_equipe']}' alt='Foto da Equipe' style='width: 100px; height: auto;'>";
                } else {
                    echo "Sem foto";
                }
                ?>
            </td>
        </tr>
    <?php } ?>

</table>

<?php
if ($tipo_usuario && $tipo_usuario == 'professor') {
    ?>
    <form method="POST" id="formEquipe">
        <a href="criaequipe.php">Crie sua equipe!</a>
    <?php } else {
        echo "Para criar equipes consulte seu professor!";
    }
    ?>

</form>
</body>
</html>

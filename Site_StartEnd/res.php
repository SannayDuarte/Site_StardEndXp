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


$consulta = "SELECT * FROM equipes";
$resultado = $conn->query($consulta) or die($conn->error);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criação de Equipes</title>
</head>
<body>

<h1>Equipes já existentes</h1>
<table border="1">
    <tr>
        <th>Nome</th>
    </tr>
    <?php while ($dado = $resultado->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
            <td><a href='equipes/<?php echo $dado["nome_equipe"] . ".php"; ?>'><?php echo $dado["nome_equipe"]; ?></a></td>
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

</body>
</html>

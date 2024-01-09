<?php
session_start();
include_once("/xampp/htdocs/teste/conexao.php");

$id_prof = isset($_SESSION['id_prof']) ? $_SESSION['id_prof'] : null;

if (!isset($_SESSION['tipo_usuario'])) {
    echo "Você não está autenticado.";
    exit();
}

$tipo_usuario = $_SESSION['tipo_usuario'];

if ($tipo_usuario !== 'professor') {
    echo "Você não tem permissão para acessar esta página, consulte seu professor!";
    exit();
}

$email_prof = isset($_SESSION['email_prof']) ? $_SESSION['email_prof'] : null;
$email_prof = $_SESSION['email'];

$query_info_equipe = "SELECT * FROM equipes WHERE email_prof = :email_prof";
$stmt_info_equipe = $conn->prepare($query_info_equipe);
$stmt_info_equipe->bindParam(':email_prof', $email_prof, PDO::PARAM_STR);
$stmt_info_equipe->execute();

if ($stmt_info_equipe->rowCount() > 0) {
    $info_equipe = $stmt_info_equipe->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send'])) {
        $nome_equipe = $info_equipe['nome_equipe']; // Use o nome da equipe do banco de dados

        $sobre_equipe = $_POST['sobre_equipe'];
        $sobre_projeto = $_POST['sobre_projeto'];

        $query_update_equipe = "
            UPDATE equipes
            SET nome_equipe = :nome_equipe, sobre_equipe = :sobre_equipe, sobre_projeto = :sobre_projeto
            WHERE email_prof = :email_prof
        ";

        $stmt_update_equipe = $conn->prepare($query_update_equipe);
        $stmt_update_equipe->bindParam(':nome_equipe', $nome_equipe, PDO::PARAM_STR);
        $stmt_update_equipe->bindParam(':sobre_equipe', $sobre_equipe, PDO::PARAM_STR);
        $stmt_update_equipe->bindParam(':sobre_projeto', $sobre_projeto, PDO::PARAM_STR);
        $stmt_update_equipe->bindParam(':email_prof', $email_prof, PDO::PARAM_STR);

        if ($stmt_update_equipe->execute()) {
            // Atualize o nome da equipe, se necessário
            $nome_equipe = $_POST['nome_equipe'];

            // Redirecione para a página atualizada da equipe
            header("Location: /teste/equipes/{$info_equipe['nome_equipe']}.php");
            exit();
        } else {
            echo "Erro ao atualizar as informações: " . $stmt_update_equipe->errorInfo()[2];
        }
    }
} else {
    echo "Equipe não encontrada ou você não tem permissão para editar.";
    ?>
    <script>
        setTimeout(function(){
            window.history.back();
        }, 1000);
    </script>
    <?php
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Equipe</title>
</head>
<body>

<label>Nome equipe</label> <br>
<span id="equipe"><?php echo $info_equipe['nome_equipe']; ?></span><br><br>

<h1 style="display: flex;">
    &nbsp;
    <span id="apresenta">Apresentação do projeto</span>
    <span id="detalhes_projeto" style="display: none;">Projeto detalhado</span>
    <span id="membros_equipe" style="display: none;">Membros da equipe</span>
</h1>


<form method="POST" id="formCadastro" action="">

    <input type="radio" name="projeto" id="projeto1" value="1" onchange="Sobre();">
    Apresentação
    <input type="radio" name="projeto" id="projeto2" value="2" onchange="Projeto();">
    Projeto
    <input type="radio" name="projeto" id="projeto3" value="3" onchange="Membros();">
    Membros
    <br><br>

    <div id="erro"></div>

    <div id="area_sobre">
    
        <label>Sobre a equipe</label> <br>
        <input type="text" name="sobre_equipe" id="sobre_equipe" required placeholder="Informe sobre a equipe" value="<?php echo $info_equipe['sobre_equipe']; ?>"><br><br>

        <label>Sobre o projeto</label> <br>
        <input type="text" name="sobre_projeto" id="sobre_projeto" required placeholder="Informe sobre o projeto" value="<?php echo $info_equipe['sobre_projeto']; ?>"><br><br>
    </div>

    <div id="area_projeto" style="display: none;">
        
    </div>

    <div id="area_membros" style="display: none;">
        
    </div>

    <!-- Adicione as outras seções conforme necessário -->

    <script>
        function Sobre() {
            document.getElementById("apresenta").style.display = 'block';
            document.getElementById("detalhes_projeto").style.display = 'none';
            document.getElementById("membros_equipe").style.display = 'none';
            document.getElementById("area_projeto").style.display = 'none';
            document.getElementById("area_membros").style.display = 'none';
            document.getElementById("area_detalhes").style.display = 'none';
            document.getElementById("area_sobre").style.display = 'block';
        }
        function Projeto() {
            document.getElementById("area_projeto").style.display = 'block';
            document.getElementById("detalhes_projeto").style.display = 'block';
            document.getElementById("membros_equipe").style.display = 'none';
            document.getElementById("apresenta").style.display = 'none';
            document.getElementById("area_membros").style.display = 'none';
            document.getElementById("area_detalhes").style.display = 'none';
            document.getElementById("area_sobre").style.display = 'none';
        }
        function Membros() {
            document.getElementById("area_membros").style.display = 'block';
            document.getElementById("membros_equipe").style.display = 'block';
            document.getElementById("detalhes_projeto").style.display = 'none';
            document.getElementById("apresenta").style.display = 'none';
            document.getElementById("area_projeto").style.display = 'none';
            document.getElementById("area_detalhes").style.display = 'none';
            document.getElementById("area_sobre").style.display = 'none';
        }
    </script>

    <input type="submit" name="send" value="Salvar alterações" id="submitForm">
</form>

</body>
</html>

<?php
session_start();
include_once("conexao.php");

// Obtém o ID do professor autenticado
$id_prof = isset($_SESSION['id_prof']) ? $_SESSION['id_prof'] : null;

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

// Verifica se o usuário está autenticado
if (!isset($_SESSION['tipo_usuario'])) {
    echo "Você não está autenticado.";
    exit();
}

$tipo_usuario = $_SESSION['tipo_usuario'];

//$email_prof = ($_SESSION['email']);
//var_dump($email_prof);

if ($tipo_usuario !== 'professor') {
    echo "Você não tem permissão para acessar esta página, consulte seu professor!";
    exit();
}

// Verifica se o email do professor está na sessão
$email_prof = isset($_SESSION['email_prof']) ? $_SESSION['email_prof'] : null;

//Salvar email no banco de dados
$email_prof = ($_SESSION['email']);

////var_dump($email_prof);

if (!empty($dados['send'])) {
    if (empty($dados['equipe'])) {
        header("Location: invalidocadal.php");
        exit();
    } else {
        // Verifica se o email do professor está disponível
        if ($email_prof !== null) {
            $query_equipe_nome = "SELECT id FROM equipes WHERE (nome_equipe=:eqnome) LIMIT 1";
            $result_equipe_nome = $conn->prepare($query_equipe_nome);
            $result_equipe_nome->bindParam(':eqnome', $dados['equipe'], PDO::PARAM_STR);
            $result_equipe_nome->execute();

            if ($result_equipe_nome && $result_equipe_nome->rowCount() != 0) {
                echo "Equipe já existente, volte e crie uma nova!";
                exit();
            } else {
                if (!empty($_FILES['foto_equipe']['name'])) {
                    // Diretório onde as fotos da equipe serão armazenadas
                    $upload_dir = 'foto_equipe/';
                
                    // Verifica se o diretório existe e cria se não existir
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0777, true); // Ajuste as permissões conforme necessário
                    }
                
                    // Obtém a extensão do arquivo
                    $file_extension = pathinfo($_FILES['foto_equipe']['name'], PATHINFO_EXTENSION);
                
                    // Nome do arquivo único para evitar sobrescrita
                    $foto_equipe_path = $upload_dir . uniqid('equipe_', true) . '.' . $file_extension;
                
                    // Move o arquivo para o diretório de uploads
                    if (!move_uploaded_file($_FILES['foto_equipe']['tmp_name'], $foto_equipe_path)) {
                        echo "Erro ao fazer o upload do arquivo.";
                        exit();
                    }
                
                    
                    $foto_equipe_path_db = 'foto_equipe/' . basename($foto_equipe_path);
                } else {
                    $foto_equipe_path_db = null; //se não houver upload
                }
               
                $query_equipe = "INSERT INTO equipes (nome_equipe, participantes, email_prof, sobre_equipe, sobre_projeto, resumo, demonstracao, final, detalhes, referencia, foto_equipe)
                 VALUES (:eqnome, 0, :email_prof, :sobre_equipe, :sobre_projeto, :resumo, :demonstra, :final, :detalhes, :referencia, :foto_equipe)";

                $cad_equipe = $conn->prepare($query_equipe);
                $cad_equipe->bindParam(':eqnome', $dados['equipe']);
                $cad_equipe->bindParam(':email_prof', $email_prof);
                $cad_equipe->bindParam(':sobre_equipe', $dados['sobre_equipe']);
                $cad_equipe->bindParam(':sobre_projeto', $dados['sobre_projeto']);
                $cad_equipe->bindParam(':resumo', $dados['resumo']);
                $cad_equipe->bindParam(':demonstra', $dados['demonstra']);
                $cad_equipe->bindParam(':final', $dados['final']);
                $cad_equipe->bindParam(':detalhes', $dados['detalhes']);
                $cad_equipe->bindParam(':referencia', $dados['referencia']);
                $cad_equipe->bindParam(':foto_equipe', $foto_equipe_path, PDO::PARAM_STR);

                $cad_equipe->execute();

                if ($cad_equipe->rowCount() > 0) {
                    $nome_equipe = $dados['equipe'];

                    if (!is_dir('equipes')) {
                        mkdir('equipes');
                    }
    
                    // Criação da página da equipe
                    $pagina_equipe = fopen("equipes/$nome_equipe.php", "w");
    
                    // Escreve as informações da equipe na página
                    fwrite($pagina_equipe, "<!DOCTYPE html>\n");
                    fwrite($pagina_equipe, "<html lang='pt-br'>\n");
                    fwrite($pagina_equipe, "<head>\n");
                    fwrite($pagina_equipe, "<link rel='stylesheet' href='style.css'>\n");
                    fwrite($pagina_equipe, "<meta charset='UTF-8'>\n");
                    fwrite($pagina_equipe, "<meta name='viewport' content='width=device-width, initial-scale=1.0'>\n");
                    fwrite($pagina_equipe, "<title>$nome_equipe</title>\n");
                    fwrite($pagina_equipe, "</head>\n");
                    
    
                    // Consulta SQL para obter informações da equipe
                    $query_info_equipe = "SELECT * FROM equipes WHERE nome_equipe = :nome_equipe";
                    $stmt_info_equipe = $conn->prepare($query_info_equipe);
                    $stmt_info_equipe->bindParam(':nome_equipe', $nome_equipe, PDO::PARAM_STR);
                    $stmt_info_equipe->execute();
                    $info_equipe = $stmt_info_equipe->fetch(PDO::FETCH_ASSOC);
    
                    // Verifica se a equipe existe
                    if (!$info_equipe) {
                        echo "Equipe não encontrada.";
                        exit();
                    }

                    // Escreve as informações na página
                    $pagina_equipe = fopen("equipes/{$info_equipe['nome_equipe']}.php", "w");

// Escreve o início do arquivo PHP
fwrite($pagina_equipe, "<?php\n");
fwrite($pagina_equipe, "include_once(\"/xampp/htdocs/teste/conexao.php\");\n");
fwrite($pagina_equipe, "\$query_info_equipe = \"SELECT * FROM equipes WHERE nome_equipe = '{$info_equipe['nome_equipe']}'\";\n");
fwrite($pagina_equipe, "\$stmt_info_equipe = \$conn->prepare(\$query_info_equipe);\n");
fwrite($pagina_equipe, "\$stmt_info_equipe->execute();\n");
fwrite($pagina_equipe, "\$info_equipe = \$stmt_info_equipe->fetch(PDO::FETCH_ASSOC);\n");
fwrite($pagina_equipe, "?>\n");

// Escreve o início do HTML
fwrite($pagina_equipe, "<!DOCTYPE html>\n");
fwrite($pagina_equipe, "<html lang='pt-br'>\n");
fwrite($pagina_equipe, "<head>\n");
fwrite($pagina_equipe, "<link rel='stylesheet' href='style.css'>\n");
fwrite($pagina_equipe, "<meta charset='UTF-8'>\n");
fwrite($pagina_equipe, "<meta name='viewport' content='width=device-width, initial-scale=1.0'>\n");
fwrite($pagina_equipe, "<title>{$info_equipe['nome_equipe']}</title>\n");
fwrite($pagina_equipe, "</head>\n");

// Escreve o início do corpo do HTML
fwrite($pagina_equipe, "<body>\n");

fwrite($pagina_equipe, "<img src='/teste/{$info_equipe['foto_equipe']}' alt='Foto da Equipe'>\n");

// Adiciona o cabeçalho da página
fwrite($pagina_equipe, "<h1>{$info_equipe['nome_equipe']}</h1>\n");
fwrite($pagina_equipe, "<p>Sobre a equipe: <br><br> {$info_equipe['sobre_equipe']}</p>\n");
fwrite($pagina_equipe, "<p>Sobre o projeto: <br><br> {$info_equipe['sobre_projeto']}</p>\n");
fwrite($pagina_equipe, "<p>Resumo do projeto: <br><br> {$info_equipe['resumo']}</p>\n");
fwrite($pagina_equipe, "<p>Demonstração do projeto: <br><br> {$info_equipe['demonstracao']}</p>\n");
fwrite($pagina_equipe, "<p>Projeto final: <br><br> {$info_equipe['final']}</p>\n");
fwrite($pagina_equipe, "<p>Detalhes do projeto: <br><br> {$info_equipe['detalhes']}</p>\n");
fwrite($pagina_equipe, "<p>Referências utilizadas: <br><br> {$info_equipe['referencia']}</p>\n");


// Escreve o fim do corpo e do HTML
fwrite($pagina_equipe, "</body>\n");
fwrite($pagina_equipe, "</html>\n");

// Fecha o arquivo
fclose($pagina_equipe);
                    header("Location: equipes/$nome_equipe.php");
                    exit();
                } 
                else {
                    echo "Erro ao criar a equipe. Tente novamente.";
                }
            }
        } else {
            echo "Erro: Email do professor não encontrado na sessão.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criação de Equipes</title>
</head>
<body>

<?php
if ($tipo_usuario && $tipo_usuario == 'professor') {
    ?>
    <h1 style="display: flex;">
        &nbsp;
        <span id="apresenta">Apresentação do projeto</span>
        <span id="detalhes" style="display: none;">Projeto detalhado</span>
        <span id="mebros" style="display: none;">Membros da equipe</span>
    </h1>

    <form method="POST" id="formCadastro" action="" enctype="multipart/form-data">
        <input type="radio" name="projeto" id="projeto1" value="1" onchange="Sobre();">
        Apresentação
        <input type="radio" name="projeto" id="projeto2" value="2" onchange="Projeto();">
        Projeto
        <input type="radio" name="projeto" id="projeto3" value="3" onchange="Membros();">
        Membros
        <br><br>

        <div id="erro"></div>

        <div id="sobre">

            <div id="cad" style="display: none;">
                <label>Usuário já cadastrado!</label>
            </div>

            <label>Nome equipe</label> <br>
            <input type="text" name="equipe" id="equipe" required placeholder="Nome da equipe"><br><br>

            <label>Foto da equipe</label> <br>
            <input type="file" name="foto_equipe" accept="image/*"> <br><br>

            <label>Sobre a equipe</label> <br>
            <input type="text" name="sobre_equipe" id="sobre_equipe" required placeholder="Informe sobre a equipe"><br><br>

            <label>Sobre o projeto</label> <br>
            <input type="text" name="sobre_projeto" id="sobre_projeto" required placeholder="Informe sobre o projeto"><br><br>

        </div>

        <div id="resumo" style="display: none;">
            <label>Resumo do projeto</label> <br><br>
            <input type="text" name="resumo" id="resumo" required placeholder="Faça um resumo do projeto"><br><br>

            <label>Demonstração do projeto</label> <br><br>
            <input type="text" name="demonstra" id="demonstra" required placeholder="Link da demonstração"><br><br>

            <label>Projeto final</label> <br><br>
            <input type="text" name="final" id="final" required placeholder="Link do projeto final"><br><br>

            <label>Detalhes do projeto</label> <br><br>
            <input type="text" name="detalhes" id="detalhes" required placeholder="Detalhes do projeto"><br><br>

            <label>Referências utilizadas</label> <br><br>
            <input type="text" name="referencia" id="referencia" required placeholder="Digite suas referências"><br><br>

        </div>

        <div id="membros" style="display: none;">

        </div>

        <!-- FUNÇÕES DO BOTÃO -->
        <script>
            function Sobre() {

                // Nome
                document.getElementById("apresenta").style.display = 'block';
                document.getElementById("detalhes").style.display = 'none';
                document.getElementById("mebros").style.display = 'none';
                // Form
                document.getElementById("sobre").style.display = 'block';
                document.getElementById("resumo").style.display = 'none';
                document.getElementById("membros").style.display = 'none';
                // Botão cad
                document.getElementById("submitForm").style.display = 'block';

            }
            function Projeto() {

                // Nome
                document.getElementById("detalhes").style.display = 'block';
                document.getElementById("apresenta").style.display = 'none';
                document.getElementById("mebros").style.display = 'none';
                // Form
                document.getElementById("resumo").style.display = 'block';
                document.getElementById("sobre").style.display = 'none';
                document.getElementById("membros").style.display = 'none';
                // Botão cad
                document.getElementById("submitForm").style.display = 'block';

            }
            function Membros() {

                // Nome
                document.getElementById("mebros").style.display = 'block';
                document.getElementById("apresenta").style.display = 'none';
                document.getElementById("detalhes").style.display = 'none';
                // Form
                document.getElementById("membros").style.display = 'block';
                document.getElementById("sobre").style.display = 'none';
                document.getElementById("resumo").style.display = 'none';
                // Botão cad
                document.getElementById("submitForm").style.display = 'block';

            }
        </script>
        <!-- FUNÇÕES DO BOTÃO -->

        <input type="submit" name="send" value="Criar" id="submitForm"> 
    </form>
    <?php
} else {
    echo "Você não tem permissão para acessar esta página, consulte seu professor!.";
}
?>

</body>
</html>
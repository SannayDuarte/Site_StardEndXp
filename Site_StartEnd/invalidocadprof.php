 <?php
include_once("conexao.php");

//FUNÇÕES DO CADASTRO

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    


    if(!empty($dados['SendCad'])) {
       // var_dump($dados);

        //TIPO ALUNO
        
            if(empty($dados['profnome']) || empty($dados['profcpf']) || empty($dados['profemail']) || empty($dados['profsenha'])){
             
              header("Location: invalidocadprof.php");
              exit();
            
            }
            else{

             $query_usuario_email = "SELECT id FROM professor WHERE (email=:profemail) LIMIT 1";
             $result_email = $conn->prepare($query_usuario_email);
             $result_email->bindParam(':profemail', $dados['profemail'], PDO::PARAM_STR);
             $result_email->execute();

            }
             if(($result_email) AND ($result_email->rowCount() != 0)){

            header("Location: usuariocad.php");
              exit();
              
             }else{
             $query_usuario_cpf = "SELECT id FROM professor WHERE (cpf=:profcpf) LIMIT 1";
             $result_cpf = $conn->prepare($query_usuario_cpf);
             $result_cpf->bindParam(':profcpf', $dados['profcpf'], PDO::PARAM_STR);
             $result_cpf->execute();
             }

            if(($result_cpf) AND ($result_cpf->rowCount() != 0)){
              header("Location: usuariocad.php");
              exit();
              
            }else{
             
            
        $query_pessoa = "INSERT INTO professor( nome, cpf, email, senha) VALUES (:profnome, :profcpf, :profemail, :senha)";
        $cad_pessoa = $conn->prepare($query_pessoa);
        $cad_pessoa->bindParam(':profnome', $dados['profnome']);
        $cad_pessoa->bindParam(':profcpf', $dados['profcpf']);
        $cad_pessoa->bindParam(':profemail', $dados['profemail']);
        $senha_cript = password_hash($dados['profsenha'], PASSWORD_DEFAULT);
        $cad_pessoa->bindParam(':senha', $senha_cript, PDO::PARAM_STR);
             
              } 
              $cad_pessoa->execute();

        if($cad_pessoa->rowCount()){
          echo  "<script>alert('Email enviado com Sucesso, abra seu email para verificar sua conta!');</script>";
          //header("Location: index.php"); //ÁREA DE CONFIRMAÇÃO
    }else{
      header("Location: invalidocadprof.php");
    }
            
        }
      
        ?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro inválido</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="css/invalid.css">

    
</head>
<body>
<!--CONTEUDO-->
<form class="Cadastro" method="POST" id="formCadastro" action="">
  <h2>Preencha todos os dados corretamente</h2> 
  <div class="container" id="cads">
      <div class="nomes ">
          <div class="dados mb-6">
            <label>Nome</label>
            <input type="text" name="profnome" id="profnome" placeholder="Nome completo" ><br><br>
          </div>
          <div class="dados mb-6">
            <label>Cpf</label>
            <input type="text" name="profcpf" id="profcpf"  placeholder="CPF" ><br><br>
          </div>
          <div class="dados mb-6">
            <label>E-mail</label>
            <input type="text" name="profemail" placeholder="EMAIL" ><br><br>
          </div>
          <div class="dados mb-6">
            <label>Senha</label>
            <input type="password" name="profsenha" placeholder="Digite sua senha" ><br><br>
          </div>
          
          <input class="btnn btn-primary" type="submit" name="SendCad" value="Cadastrar"> <br><br>

          <script src="https://cdn.jsdelivr.net/npm/js-brasil/js-brasil.js"></script>
  <script>
    $("#alcpf").on("blur", function(){
        let cpf_value = $(this).val();
      
        if(jsbrasil.validateBr.cpf(cpf_value)) {
        } else {
          alert("CPF inválido")
        }
    });
    $("#profcpf").on("blur", function(){
        let cpf_value = $(this).val();
      
        if(jsbrasil.validateBr.cpf(cpf_value)) {
        } else {
          alert("CPF inválido")
        }
    });
  
    $("#cnpj").on("blur", function(){
        let cnpj_value = $(this).val();
      
        if(jsbrasil.validateBr.cnpj(cnpj_value)) {
            
        } else {
            alert("CNPJ inválido");
        }
    });
  </script>
      </div>
  </div>
</div>

</form>
<!--CONTEUDO-->
</body>
</html>
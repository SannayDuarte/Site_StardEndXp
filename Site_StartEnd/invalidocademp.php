?php
include_once("conexao.php");

//FUNÇÕES DO CADASTRO

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    


    if(!empty($dados['SendCad'])) {
       // var_dump($dados);

        //TIPO ALUNO
        
            if(empty($dados['emp']) || empty($dados['cnpj']) || empty($dados['empemail']) || empty($dados['empsenha'])){
             
              header("Location: invalidocademp.php");
              exit();
            
            }
            else{

             $query_usuario_email = "SELECT id FROM empresa WHERE (email=:empemail) LIMIT 1";
             $result_email = $conn->prepare($query_usuario_email);
             $result_email->bindParam(':empemail', $dados['empemail'], PDO::PARAM_STR);
             $result_email->execute();

            }
             if(($result_email) AND ($result_email->rowCount() != 0)){

            header("Location: usuariocad.php");
              exit();
              
             }else{
             $query_usuario_cpf = "SELECT id FROM empresa WHERE (cnpj=:cnpj) LIMIT 1";
             $result_cpf = $conn->prepare($query_usuario_cpf);
             $result_cpf->bindParam(':cnpj', $dados['cnpj'], PDO::PARAM_STR);
             $result_cpf->execute();
             }

            if(($result_cpf) AND ($result_cpf->rowCount() != 0)){
              header("Location: usuariocad.php");
              exit();
              
            }else{
             
            
        $query_pessoa = "INSERT INTO empresa( emp, cnpj, email, senha) VALUES (:emp, :cnpj, :empemail, :senha)";
        $cad_pessoa = $conn->prepare($query_pessoa);
        $cad_pessoa->bindParam(':emp', $dados['emp']);
        $cad_pessoa->bindParam(':cnpj', $dados['cnpj']);
        $cad_pessoa->bindParam(':empemail', $dados['empemail']);
        $senha_cript = password_hash($dados['empsenha'], PASSWORD_DEFAULT);
        $cad_pessoa->bindParam(':senha', $senha_cript, PDO::PARAM_STR);
             
              } 
              $cad_pessoa->execute();

        if($cad_pessoa->rowCount()){
          echo  "<script>alert('Email enviado com Sucesso, abra seu email para verificar sua conta!');</script>";
          //header("Location: index.php"); //ÁREA DE CONFIRMAÇÃO
    }else{
      header("Location: invalidocademp.php");
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
            <input type="text" name="emp" id="emp" placeholder="Nome completo"><br><br>
          </div>
          <div class="dados mb-6">
            <label>Cpf</label>
            <input type="text" name="cnpj" id="cnpj"  placeholder="CNPJ"><br><br>
          </div>
          <div class="dados mb-6">
            <label>E-mail</label>
            <input  type="text" name="empemail" placeholder="EMAIL" ><br><br>
          </div>
          <div class="dados mb-6">
            <label>Senha</label>
            <input type="password" name="empsenha" placeholder="Digite sua senha"><br><br>
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
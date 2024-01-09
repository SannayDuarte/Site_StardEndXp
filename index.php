<?php
include_once("conexao.php");

//FUNÇÕES DO CADASTRO

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    


    if(!empty($dados['SendCad'])) {
       // var_dump($dados);

        //TIPO ALUNO
        if($dados['tipo_pessoa'] == 1){
            if(empty($dados['alnome']) || empty($dados['alcpf']) || empty($dados['alemail']) || empty($dados['alsenha'])){
             
              header("Location: invalidocadal.php");
              exit();
            
            }
            else{

             $query_usuario_email = "SELECT id_al FROM aluno WHERE (email=:alemail) LIMIT 1";
             $result_email = $conn->prepare($query_usuario_email);
             $result_email->bindParam(':alemail', $dados['alemail'], PDO::PARAM_STR);
             $result_email->execute();


             if(($result_email) AND ($result_email->rowCount() != 0)){
              header("Location: usuariocad.php");
              exit();

              
              
             }else{
             $query_usuario_cpf = "SELECT id_al FROM aluno WHERE (cpf=:alcpf) LIMIT 1";
             $result_cpf = $conn->prepare($query_usuario_cpf);
             $result_cpf->bindParam(':alcpf', $dados['alcpf'], PDO::PARAM_STR);
             $result_cpf->execute();
             }

            if(($result_cpf) AND ($result_cpf->rowCount() != 0)){
              header("Location: usuariocad.php");
              exit();
              
            }else{
             
            
        $query_pessoa = "INSERT INTO aluno(tipo_pessoa, nome, cpf, email, senha) VALUES (:tipo_pessoa, :alnome, :alcpf, :alemail, :senha)";
        $cad_pessoa = $conn->prepare($query_pessoa);
        $cad_pessoa->bindParam(':tipo_pessoa', $dados['tipo_pessoa']);
        $cad_pessoa->bindParam(':alnome', $dados['alnome']);
        $cad_pessoa->bindParam(':alcpf', $dados['alcpf']);
        $cad_pessoa->bindParam(':alemail', $dados['alemail']);
        $senha_cript = password_hash($dados['alsenha'], PASSWORD_DEFAULT);
        $cad_pessoa->bindParam(':senha', $senha_cript, PDO::PARAM_STR);
             
              } 
            }
        }
        
        //TIPO ALUNO
        if($dados['tipo_pessoa'] == 2){
           // echo "Prof";
           
           if(empty($dados['profnome']) || empty($dados['profcpf']) || empty($dados['profemail']) || empty($dados['profsenha'])){
             
            header("Location: invalidocadprof.php");
            exit();
          }
          else{

            $query_usuario_email_prof = "SELECT id_prof FROM professor WHERE (email=:profemail) LIMIT 1";
            $result_email_prof = $conn->prepare($query_usuario_email_prof);
            $result_email_prof->bindParam(':profemail', $dados['profemail'], PDO::PARAM_STR);
            $result_email_prof->execute();

            if(($result_email_prof) AND ($result_email_prof->rowCount() != 0)){
              header("Location: usuariocad.php");
              exit();
              
             
             }else{
              $query_usuario_cpf_prof = "SELECT id_prof FROM professor WHERE (cpf=:profcpf) LIMIT 1";
              $result_cpf_prof = $conn->prepare($query_usuario_cpf_prof);
              $result_cpf_prof->bindParam(':profcpf', $dados['profcpf'], PDO::PARAM_STR);
              $result_cpf_prof->execute();
              }
 
             if(($result_cpf_prof) AND ($result_cpf_prof->rowCount() != 0)){
              header("Location: usuariocad.php");
              exit();
              
 
             }else{

        $query_pessoa = "INSERT INTO professor(tipo_pessoa, nome, cpf, email, senha) VALUES (:tipo_pessoa, :profnome, :profcpf, :profemail, :senha)";
        $cad_pessoa = $conn->prepare($query_pessoa);
        $cad_pessoa->bindParam(':tipo_pessoa', $dados['tipo_pessoa']);
        $cad_pessoa->bindParam(':profnome', $dados['profnome']);
        $cad_pessoa->bindParam(':profcpf', $dados['profcpf']);
        $cad_pessoa->bindParam(':profemail', $dados['profemail']);
        $senha_cript = password_hash($dados['profsenha'], PASSWORD_DEFAULT);
        $cad_pessoa->bindParam(':senha', $senha_cript, PDO::PARAM_STR);
        }
      }

    }
        if($dados['tipo_pessoa'] == 3){
            //echo "Emp";
            if(empty($dados['emp']) || empty($dados['cnpj']) || empty($dados['empemail']) || empty($dados['empsenha'])){
             
              header("Location: invalidocademp.php");
              exit();
            }
            else{

              $query_usuario_email_emp = "SELECT id_emp FROM empresa WHERE (email=:empemail) LIMIT 1";
              $result_email_emp = $conn->prepare($query_usuario_email_emp);
              $result_email_emp->bindParam(':empemail', $dados['empemail'], PDO::PARAM_STR);
              $result_email_emp->execute();
  
              if(($result_email_emp) AND ($result_email_emp->rowCount() != 0)){
                header("Location: usuariocad.php");
                exit();
                
               
               }else{
                $query_usuario_cnpj = "SELECT id_emp FROM empresa WHERE (cnpj=:cnpj) LIMIT 1";
                $result_cnpj = $conn->prepare($query_usuario_cnpj);
                $result_cnpj->bindParam(':cnpj', $dados['cnpj'], PDO::PARAM_STR);
                $result_cnpj->execute();
                }
   
               if(($result_cnpj) AND ($result_cnpj->rowCount() != 0)){
                header("Location: usuariocad.php");
                exit();
                
   
               }else{

        $query_pessoa = "INSERT INTO empresa(tipo_pessoa, emp, cnpj, email, senha) VALUES (:tipo_pessoa, :emp, :cnpj, :empemail, :senha)";
        $cad_pessoa = $conn->prepare($query_pessoa);
        $cad_pessoa->bindParam(':tipo_pessoa', $dados['tipo_pessoa'], PDO::PARAM_STR);
        $cad_pessoa->bindParam(':emp', $dados['emp'], PDO::PARAM_STR);
        $cad_pessoa->bindParam(':cnpj', $dados['cnpj'], PDO::PARAM_STR);
        $cad_pessoa->bindParam(':empemail', $dados['empemail']);
        $senha_cript = password_hash($dados['empsenha'], PASSWORD_DEFAULT);
        $cad_pessoa->bindParam(':senha', $senha_cript, PDO::PARAM_STR);
        }
      }
        }
        $cad_pessoa->execute();

        if($cad_pessoa->rowCount()){
          echo  "<script>alert('Email enviado com Sucesso, abra seu email para verificar sua conta!');</script>";
    }else{
      echo  "<script>alert('Sua conta não foi cadastrada, verifique os campos novamente!');</script>";
    }

}
 //FUNÇÕES DO CADASTRO
  
    ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagina Inicial</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <link rel="icon" type="imagem/png" href="IMG/icon-nav.png" />

  <meta name="description" content="Stard_End" />
  <meta name="copyright" content="© 2020 - 2023 Stard_End - All Rights Reserved." />
  <meta name="author" content="Stard_End" />

  <meta property="og:title" content="Stard_End" />
  <meta property="og:site_name" content="Stard_End" />
  <meta property="og:description" content="Stard_End" />
  <meta property="og:type" content="website" />
  <meta property="og:image" content="/img/photo-intro.jpg" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <script defer src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Open+Sans&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://use.typekit.net/rrg4put.css" />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-9ZW2LKR6BL"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="css/style.css">
</head>

<body id="to-top" class="noselect">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon btn-dark"></span>
      </button>
      <img src="img/A.start.png" id="logo" />
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto navbar-links">
          <li class="nav-card-item">
            <a class="login nav-link" id="links" onclick="abrirModal()">Entrar</a>
          </li>
          <li class="nav-item" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <a class="login nav-link text-white">Cadastrar</a>
          </li>
          <!--
          <li class="nav-card-item">
            <a class="login nav-link" href="projet.html">Projetos</a>
          </li>
        -->
          <li class="nav-card-item">
            <a class="nav-link js-scroll-trigger noselect" onclick="toAbout()">Sobre</a>
          </li>
          <li class="nav-card-item">
            <a class="nav-link js-scroll-trigger noselect" onclick="toBio()">Jogo</a>
          </li>
          <li class="nav-card-item">
            <a class="nav-link js-scroll-trigger noselect" onclick="toAgenda()">Agenda</a>
          </li>


          <!--Login-->
          <div id="modal-login" class="modal-container">
            <div class="acessar">
              <button class="fechar">X</button>
              <h4 class="subtitulo">Acessar a Conta</h4>
              <form id="login">
                <!-- ... (conteúdo do formulário de login) -->
                <span id="msgAlertErrorLogin"></span>
                <span><br></span>
                <label for="email" class="form-label">EMAIL</label>
                <input type="text" class="form-control" name="email" id="email" placeholder="Digite seu email">

                <div class="my-3">
                  <label for="senha" class="form-label">SENHA</label>
                  <input type="password" class="form-control" name="senha" id="senha" autocomplete=​"off"
                    placeholder="Digite sua senha">
                  <button type="submit" class="btn btn-dark">Entrar</button>
                </div>
                <a href="ajuda.html" class="tx">Esqueceu a senha.</a>
              </form>
            </div>
          </div>
          <script>
            // Script para abrir o modal de login
            function abrirModal() {
              const modal = document.getElementById("modal-login")
              modal.classList.add("mostrar")

              modal.addEventListener("click", (e) => {
                if (e.target.id == "modal-login" || e.target.className == "fechar") {
                  modal.classList.remove("mostrar");
                }
              });
            }
          </script>
          <!--Login-->

          <!--Cadastro-->
          <div class="cadastr-form col -1 d-flex align-items-end pb-2">
            <!-- Modal de Cadastro -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <!-- ... (conteúdo do modal de cadastro) -->
              <div class="modal-dialog">
                <div class="modal-content p-4">
                  <!--1 modal pra cadastro-->
                  <div class="cadastro">
                    <div class="menu">
                      <section class="centro">
                        <label for="niveldeacesso"><input type="radio" value="1">
                          <a class="Single tit-cadas" target="1">Cadastro Aluno</a>
                        </label>
                        <br /><br />
                        <label for="niveldeacesso"><input type="radio" value="2"> <a class="Single tit-cadas"
                            target="2">Cadastro Professor</a>
                        </label>
                        <br /><br />
                        <label for="niveldeacesso"><input type="radio" value="3"> <a class="Single tit-cadas"
                            target="3">Cadastro Empresa</a>
                        </label>
                        <br />
                      </section>
                    </div>

                    <!--Cadastro Aluno-->
                    <section class="target_box" style="color: aliceblue;">
                      <div id="div1" class="target">
                        <h4>Cadastro Aluno</h4><br>
                        <form class="row g-3" id="alForm">
                          <div class="mb-6">
                            <label for="alnome" class="form-label">Nome e Sobrenome</label>
                            <input type="text" class="form-control" name="alnome" id="alnome" aria-describedby="nome"
                              placeholder="Escreva seu Nome Completo">
                          </div>
                          <div class="mb-6">
                            <label for="alnasc" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" autocomplete="off" id="alnasc" nome="alnasc"
                              aria-describedby="nasc">
                          </div>
                          <div class="mb-6">
                            <label for="alcpf" class="form-label">Cpf</label>
                            <input type="text" class="form-control" id="alcpf" nome="alcpf" aria-describedby="cpf"
                              placeholder="Escreva seu Cpf">
                          </div>
                          <div class="mb-6">
                            <label for="alescola" class="form-label">Escola</label>
                            <input type="text" class="form-control" id="alescola" name="alescola"
                              aria-describedby="emailHelp" placeholder="Escreva o nome da sua escola." />
                          </div>
                          <div class="mb-6">
                            <label for="altel" class="form-label">Celular com DDD</label>
                            <input type="tel" class="form-control" id="altel" name="altel" aria-describedby="tel"
                              placeholder="exemplo: (00) 00000-0000">
                          </div>
                          <fieldset class="row mb-3">
                            <div class="col-sm-10">
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="gridRadios" id="dRadios1"
                                  value="option1" checked>
                                <label class="form-check-label" for="dRadios1">
                                  Feminino
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="gridRadios" id="dRadios2"
                                  value="option2">
                                <label class="form-check-label" for="dRadios2">
                                  Masculino
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="gridRadios" id="dRadios3"
                                  value="option3">
                                <label class="form-check-label" for="dRadios3">
                                  Nao Declarar
                                </label>
                              </div>
                            </div>
                          </fieldset>
                          <div class="mb-6">
                            <label for="alcep" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="alcep" name="alcep" aria-describedby="cep"
                              placeholder="digite o CEP">
                          </div>
                          <div class="mb-6">
                            <label for="alestado" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="alestado" name="alestado"
                              aria-describedby="Estado" placeholder="digite o nome do seu estado">
                          </div>
                          <div class="mb-6 ">
                            <label for="alcidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="alcidade" name="alcidade"
                              aria-describedby="Cidade" placeholder="digite o nome da sua cidade">
                          </div>
                          <div class="mb-6">
                            <label for="alemail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="alemail" name="alemail"
                              aria-describedby="emailHelp" placeholder="Escreva seu email." />
                          </div>
                          <div class="mb-6">
                            <label for="alsenha" class="form-label">Defina sua senha</label>
                            <input type="password" class="form-control" id="alsenha" name="alsenha" autocomplete=​"off"
                              placeholder="Minimo 8 caracteres, com letras e numeros.">
                            <input type="checkbox" class="form-check-input" id="Check1">
                            <label class="form-check-label" for="Check1">Lembrar-me</label>
                          </div>
                          <input type="submit" value="CADASTRAR">

                        </form>
                      </div>
                    </section>
                    <!--Cadastro Aluno-->
                    <!--Cadastro Professor-->
                    <section class="target_box" style="color: aliceblue;">
                      <div id="div2" class="target">
                        <h4>Cadastro Professor</h4><br>
                        <form class="row g-3" id="cad-usuario-form">
                          <div class="mb-6">
                            <label for="profnome" class="form-label">Nome e Sobrenome</label>
                            <input type="text" class="form-control" id="profnome" aria-describedby="nome"
                              placeholder="Escreva seu Nome Completo">
                          </div>
                          <div class="mb-6">
                            <label for="profnasc" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" id="profnasc" aria-describedby="nasc" required>
                          </div>
                          <div class="mb-6">
                            <label for="profcpf" class="form-label">Cpf ou Cnpj</label>
                            <input type="text" class="form-control" id="profcpf" aria-describedby="cpf"
                              placeholder="Escreva seu Cpf ou Cnpj" required>
                          </div>
                          <div class="mb-6">
                            <label for="profescola" class="form-label">Escola</label>
                            <input type="email" class="form-control" id="profescola" aria-describedby="emailHelp"
                              placeholder="Escreva o nome da escola em que voce ensina" />
                          </div>
                          <div class="mb-6">
                            <label for="proftel" class="form-label">Celular com DDD</label>
                            <input type="tel" class="form-control" id="proftel" aria-describedby="tel"
                              placeholder="exemplo: (00) 00000-0000" required>
                          </div>
                          <fieldset class="row mb-3">
                            <div class="col-sm-10">
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="profidRadios" id="profidRadios1"
                                  value="option1" checked>
                                <label class="form-check-label" for="profidRadios1">
                                  Feminino
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="profidRadios" id="profidRadios2"
                                  value="option2">
                                <label class="form-check-label" for="profidRadios2">
                                  Masculino
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="profidRadios" id="profidRadios3"
                                  value="option3">
                                <label class="form-check-label" for="profidRadios3">
                                  Nao Declarar
                                </label>
                              </div>
                            </div>
                          </fieldset>
                          <div class="mb-6">
                            <label for="profcep" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="profcep" aria-describedby="cep"
                              placeholder="digite o CEP">
                          </div>
                          <div class="mb-6">
                            <label for="profestado" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="profestado" aria-describedby="Estado"
                              placeholder="digite o nome do seu estado">
                          </div>
                          <div class="mb-6 ">
                            <label for="profcidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="profcidade" aria-describedby="Cidade"
                              placeholder="digite o nome da sua cidade">
                          </div>
                          <div class="mb-6">
                            <label for="profemail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="profemail" aria-describedby="emailHelp"
                              placeholder="Escreva seu email." />
                          </div>
                          <div class="mb-6">
                            <label for="profpassword" class="form-label">Defina sua senha</label>
                            <input type="password" class="form-control" id="profpassword" autocomplete=​"off"
                              placeholder="Minimo 8 caracteres, com letras e numeros.">
                            <input type="checkbox" class="form-check-input" id="prof Check1">
                            <label class="form-check-label" for="Check1">Lembrar-me</label>
                          </div>
                          <button class="btn btn-dark" type="submit"><a href="#">Finalizar Cadastro</a></button>

                        </form>
                      </div>
                    </section>
                    <!--Cadastro Professor-->
                    <!--Cadastro Empresa-->
                    <section class="target_box" style="color: aliceblue;">
                      <div id="div3" class="target">
                        <h4>Cadastro Empresa</h4><br>
                        <form class="row g-3">
                          <div class="mb-6">
                            <label for="emprnome" class="form-label">Nome e Sobrenome</label>
                            <input type="text" class="form-control" id="emprnome" aria-describedby="nome"
                              placeholder="Escreva seu Nome Completo" required>
                          </div>
                          <div class="mb-6">
                            <label for="alnasc" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" id="emprnasc" aria-describedby="nasc" required>
                          </div>
                          <div class="mb-6">
                            <label for="alcpf" class="form-label">Cpf ou Cnpj</label>
                            <input type="text" class="form-control" id="emprcpf" aria-describedby="cpf"
                              placeholder="Escreva seu Cpf ou Cnpj" required>
                          </div>
                          <div class="mb-6">
                            <label for="alescola" class="form-label">Escola</label>
                            <input type="email" class="form-control" id="emprescola" aria-describedby="emailHelp"
                              placeholder="Escreva o nome da sua empresa." />
                          </div>
                          <div class="mb-6">
                            <label for="altel" class="form-label">Celular com DDD</label>
                            <input type="tel" class="form-control" id="emprtel" aria-describedby="tel"
                              placeholder="exemplo: (00) 00000-0000" required>
                          </div>
                          <fieldset class="row mb-3">
                            <div class="col-sm-10">
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="emprdRadios" id="emprdRadios1"
                                  value="option1" checked>
                                <label class="form-check-label" for="emprdRadios1">
                                  Feminino
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="emprdRadios" id="emprdRadios2"
                                  value="option2">
                                <label class="form-check-label" for="emprdRadios2">
                                  Masculino
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="emprdRadios" id="emprdRadios3"
                                  value="option3">
                                <label class="form-check-label" for="emprdRadios3">
                                  Nao Declarar
                                </label>
                              </div>
                            </div>
                          </fieldset>
                          <div class="mb-6">
                            <label for="alcep" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="emprcep" aria-describedby="cep"
                              placeholder="digite o CEP">
                          </div>
                          <div class="mb-6">
                            <label for="alestado" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="emprestado" aria-describedby="Estado"
                              placeholder="digite o nome do seu estado">
                          </div>
                          <div class="mb-6 ">
                            <label for="alcidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="emprcidade" aria-describedby="Cidade"
                              placeholder="digite o nome da sua cidade">
                          </div>
                          <div class="mb-6">
                            <label for="alemail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="empremail" aria-describedby="emailHelp"
                              placeholder="Escreva seu email." />
                          </div>
                          <div class="mb-6">
                            <label for="alpassword" class="form-label">Defina sua senha</label>
                            <input type="password" class="form-control" id="emprpassword" autocomplete=​"off"
                              placeholder="Minimo 8 caracteres, com letras e numeros.">
                            <input type="checkbox" class="form-check-input" id="empr Check1">
                            <label class="form-check-label" for="Check1">Lembrar-me</label>
                          </div>
                          <button class="btn btn-dark" type="submit"><a href="#">Finalizar Cadastro</a></button>
                        </form>
                      </div>
                    </section>
                    <!--Cadastro Empresa-->
                  </div>
                  <!--1 modal pra cadastro-->
                </div>
              </div>
            </div>
          </div>
          <!--Cadastro-->

        </ul>
      </div>
      <div class="scroll-progress-track">
        <div id="progress-bar" class="scroll-progress-thumb"></div>
      </div>
    </div>
  </nav>
  <!-- Navbar -->

  <div class="page-content">
    <!-- Conteudo -->
    <main>
      <!-- Intro -->
      <section id="intro">
        <div class="intro container" data-aos="fade-down" data-aos-duration="1000">
          <div class="text">
            <h1>
              <h1 class="intro-animation">
                <span class="green my-name">Stard_End</span>
              </h1>
              <br />
            </h1>
            <p>
              Seja bem-vindo (a) a esta emocionante aventura! <br>
              Estamos muito satisfeitos por ter você entre nós<br>
              e mal podemos esperar para compartilharmos<br>
              momentos inesquecíveis.<br>
              Nossa maior preocupação é te proporcionar uma<br>
              experiência maravilhosa, repleta não apenas de<br>
              conhecimento enriquecedor, mas também de<br>
              muitas interatividades.<br>
              Conheça o Trilha do Aprendiz, site que conecta<br>
              jovens ao mercado de trabalho.
            </p>
            <div class="intro-btns">
              <a href="https://trilhadoaprendiz.com/" target="_blank"
                class="button btn-contact contact-btn hb-fill-right-bg noselect" onclick="toContact()">
                <i class="fa-regular fa-envelope fa-lg"></i>
                <span>Trilha_do_Aprendiz</span>
              </a>
            </div>
          </div>
          <div class="img-astro">
            <img src="img/astrou.png" onContextMenu="return false;" loading="lazy" class="astrounaut pulsate-bck"
              alt="intro-image" />
          </div>
        </div>
      </section>
      <svg width="100%" height="100%" id="svg" viewBox="0 0 1440 400" xmlns="http://www.w3.org/2000/svg"
        class="transition duration-300 ease-in-out delay-150">
        <style>
          .path-0 {
            animation: pathAnim-0 4s;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
          }

          @keyframes pathAnim-0 {
            0% {
              d: path("M 0,400 C 0,400 0,200 0,200 C 62.43333333333334,168.3025641025641 124.86666666666667,136.6051282051282 219,129 C 313.1333333333333,121.3948717948718 438.9666666666666,137.88205128205126 522,143 C 605.0333333333334,148.11794871794874 645.2666666666668,141.86666666666665 718,158 C 790.7333333333332,174.13333333333335 895.9666666666667,212.65128205128207 974,232 C 1052.0333333333333,251.34871794871793 1102.8666666666666,251.52820512820512 1176,243 C 1249.1333333333334,234.47179487179488 1344.5666666666666,217.23589743589744 1440,200 C 1440,200 1440,400 1440,400 Z"
                );
            }

            25% {
              d: path("M 0,400 C 0,400 0,200 0,200 C 70.93846153846152,195.9897435897436 141.87692307692305,191.9794871794872 233,204 C 324.12307692307695,216.0205128205128 435.4307692307692,244.07179487179485 515,256 C 594.5692307692308,267.92820512820515 642.4,263.73333333333335 713,261 C 783.6,258.26666666666665 876.9692307692308,256.99487179487176 956,252 C 1035.0307692307692,247.00512820512822 1099.7230769230769,238.2871794871795 1178,229 C 1256.2769230769231,219.7128205128205 1348.1384615384616,209.85641025641024 1440,200 C 1440,200 1440,400 1440,400 Z"
                );
            }

            50% {
              d: path("M 0,400 C 0,400 0,200 0,200 C 79.91025641025641,201.23076923076923 159.82051282051282,202.46153846153848 249,214 C 338.1794871794872,225.53846153846152 436.6282051282052,247.38461538461536 516,262 C 595.3717948717948,276.61538461538464 655.6666666666667,284 722,263 C 788.3333333333333,242.00000000000003 860.7051282051282,192.6153846153846 948,171 C 1035.2948717948718,149.3846153846154 1137.5128205128203,155.53846153846152 1222,165 C 1306.4871794871797,174.46153846153848 1373.2435897435898,187.23076923076923 1440,200 C 1440,200 1440,400 1440,400 Z"
                );
            }

            75% {
              d: path("M 0,400 C 0,400 0,200 0,200 C 60.45384615384617,191.85897435897436 120.90769230769234,183.71794871794873 202,180 C 283.09230769230766,176.28205128205127 384.8230769230769,176.9871794871795 481,186 C 577.1769230769231,195.0128205128205 667.8,212.33333333333331 757,221 C 846.2,229.66666666666669 933.9769230769232,229.67948717948718 997,234 C 1060.0230769230768,238.32051282051282 1098.2923076923075,246.94871794871796 1168,242 C 1237.7076923076925,237.05128205128204 1338.8538461538462,218.52564102564102 1440,200 C 1440,200 1440,400 1440,400 Z"
                );
            }

            100% {
              d: path("M 0,400 C 0,400 0,200 0,200 C 62.43333333333334,168.3025641025641 124.86666666666667,136.6051282051282 219,129 C 313.1333333333333,121.3948717948718 438.9666666666666,137.88205128205126 522,143 C 605.0333333333334,148.11794871794874 645.2666666666668,141.86666666666665 718,158 C 790.7333333333332,174.13333333333335 895.9666666666667,212.65128205128207 974,232 C 1052.0333333333333,251.34871794871793 1102.8666666666666,251.52820512820512 1176,243 C 1249.1333333333334,234.47179487179488 1344.5666666666666,217.23589743589744 1440,200 C 1440,200 1440,400 1440,400 Z"
                );
            }
          }
        </style>
        <path
          d="M 0,400 C 0,400 0,200 0,200 C 62.43333333333334,168.3025641025641 124.86666666666667,136.6051282051282 219,129 C 313.1333333333333,121.3948717948718 438.9666666666666,137.88205128205126 522,143 C 605.0333333333334,148.11794871794874 645.2666666666668,141.86666666666665 718,158 C 790.7333333333332,174.13333333333335 895.9666666666667,212.65128205128207 974,232 C 1052.0333333333333,251.34871794871793 1102.8666666666666,251.52820512820512 1176,243 C 1249.1333333333334,234.47179487179488 1344.5666666666666,217.23589743589744 1440,200 C 1440,200 1440,400 1440,400 Z"
          stroke="none" stroke-width="0" fill="#222222ff"
          class="transition-all duration-300 ease-in-out delay-150 path-0" transform="rotate(-180 720 200)"></path>
      </svg>
      <!-- Intro -->

      <!-- Sobre -->
      <section id="about">
        <div class="about container" data-aos="fade-up" data-aos-duration="1000">
          <h6 class="section-title">Sobre</h6>
          <div class="about-wrapper">
            <div class="left">
              <div>
                <h2>
                  <span class="green counter">600</span><span class="green">+</span>
                  <p>Jovens Alcancados</p>
                </h2>
              </div>
              <div>
                <h2>
                  <span class="green">01º</span><span class="green">Lugar no</span>
                  <p>Prêmio SEBRAE de Educação Empreendedora do Amazonas</p>
                </h2>
              </div>
            </div>
            <div class="right">
              <h2>
                O que é o <span class="green">Start_End?</span>
              </h2>
              <p>
                É uma maratona itinerante de inovação realizada em ciclos e desenvolvida em escolas públicas e privadas,
                para jovens de 14 a 24 anos. Estartamos a nossa jornada com os jovens, visando despertá-los e fazer
                compreender a importância da ciência agregada a tecnologia, a evolução e seu impacto no mercado de
                trabalho, gerando novas profissões, produtos e / ou serviços.
              </p>
              <p>
                Profissões – Desenvolvimento de alunos por meio de mini cursos e workshop, orientando os jovens a se
                capacitarem para o mercado de trabalho.
                Produtos – Recrutamento e seleção gamificado para jovens em fase acadêmica, onde somos orientados por
                dados e resultados, usando metodologia própria contemplada com o 1º lugar no Prêmio SEBRAE de Educação
                Empreendedora do Amazonas, evento de educação empreendedora, inovação e novas profissões, desenvolvido
                para jovens.
                Serviços – Organização e realização de Ideathons, Inovathons e Hackatons
              </p>
            </div>
          </div>
        </div>
        <div class="container" data-aos="fade-up" data-aos-duration="1000">
          <h6 class="section-title">Integrantes</h6>
          <div class="milestones">
            <div class="timeline">
              <ul>
                <!-- Lider -->
                <li>
                  <div class="timeline-content">
                    <h3 class="date">Lider</h3>
                    <h2 class="title education">Erick Matos</h2>
                    <h3 class="sub-title school">Fundador do Start_End</h3>
                    <p class="description">
                      Administrador, Especialista em Comércio Exterior e Tecnólogo em Logística Empresarial, Consultor
                      de
                      Negócios onde inspira clientes nas áreas de gestão, tecnologia e inovação.
                    </p>
                  </div>
                </li>

                <!-- Vice-Lider -->
                <li>
                  <div class="timeline-content">
                    <h3 class="date">Vice-Lider</h3>
                    <h2 class="title education">Helen Araujo</h2>
                    <h3 class="sub-title school">Advogada e Empreendedora</h3>
                    <p class="description">
                      Cofundadora da Trilha do Aprendiz startup que aborda a lei da Aprendizagem, ECA, LGPD. Atuo com
                      assessoria jurídica para empresas e pessoas que buscam segurança nos processos frente ao novo
                      mercado
                      digital na advogacia.
                    </p>
                  </div>
                </li>

                <!-- FrontEnd-Ilustradora -->
                <li>
                  <div class="timeline-content">
                    <h3 class="date">FrontEnd-Ilustradora</h3>
                    <h2 class="title education">Sannay Duarte</h2>
                    <h3 class="sub-title school">Desenvolvedora Front End</h3>
                    <p class="description">
                      Entusiasta de game, e artes digitais, apaixonada pelo impacto posito real que pequenas mudanças
                      podem
                      causar na vida de pessoas.
                    </p>
                  </div>
                </li>

                <!-- Back-end -->
                <li>
                  <div class="timeline-content">
                    <h3 class="date">Back-end</h3>
                    <h2 class="title education">Cristophe Damião</h2>
                    <h3 class="sub-title school">Desenvolvedor Back-End</h3>
                    <p class="description">
                      Entusiasta de tecnologia, sempre em busca de aprender algo novo. Aceita desafios para aprender
                      soluções.
                    </p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>
      <svg width="100%" height="100%" id="svg" viewBox="0 0 1440 400" xmlns="http://www.w3.org/2000/svg"
        class="transition duration-300 ease-in-out delay-150">
        <style>
          .path-0 {
            animation: pathAnim-0 4s;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
          }

          @keyframes pathAnim-0 {
            0% {
              d: path("M 0,400 C 0,400 0,200 0,200 C 75.28461538461539,167.45897435897436 150.56923076923078,134.91794871794872 239,134 C 327.4307692307692,133.08205128205128 429.0076923076923,163.7871794871795 513,172 C 596.9923076923077,180.2128205128205 663.4000000000001,165.93333333333337 741,183 C 818.5999999999999,200.06666666666663 907.3923076923077,248.47948717948714 977,269 C 1046.6076923076923,289.52051282051286 1097.0307692307692,282.14871794871794 1171,266 C 1244.9692307692308,249.85128205128206 1342.4846153846154,224.92564102564103 1440,200 C 1440,200 1440,400 1440,400 Z"
                );
            }

            25% {
              d: path("M 0,400 C 0,400 0,200 0,200 C 62.7923076923077,160.5179487179487 125.5846153846154,121.03589743589743 199,126 C 272.4153846153846,130.96410256410257 356.45384615384614,180.37435897435896 443,215 C 529.5461538461539,249.62564102564104 618.6000000000001,269.4666666666667 713,246 C 807.3999999999999,222.53333333333333 907.1461538461538,155.75897435897434 987,144 C 1066.8538461538462,132.24102564102566 1126.8153846153846,175.4974358974359 1199,194 C 1271.1846153846154,212.5025641025641 1355.5923076923077,206.25128205128203 1440,200 C 1440,200 1440,400 1440,400 Z"
                );
            }

            50% {
              d: path("M 0,400 C 0,400 0,200 0,200 C 76.36666666666665,193.56923076923078 152.7333333333333,187.13846153846154 230,176 C 307.2666666666667,164.86153846153846 385.4333333333334,149.0153846153846 470,151 C 554.5666666666666,152.9846153846154 645.5333333333333,172.80000000000004 720,174 C 794.4666666666667,175.19999999999996 852.4333333333333,157.7846153846154 922,150 C 991.5666666666667,142.2153846153846 1072.7333333333333,144.06153846153848 1161,154 C 1249.2666666666667,163.93846153846152 1344.6333333333332,181.96923076923076 1440,200 C 1440,200 1440,400 1440,400 Z"
                );
            }

            75% {
              d: path("M 0,400 C 0,400 0,200 0,200 C 65.16666666666669,221.14102564102564 130.33333333333337,242.28205128205127 223,244 C 315.66666666666663,245.71794871794873 435.83333333333326,228.01282051282053 521,214 C 606.1666666666667,199.98717948717947 656.3333333333334,189.66666666666666 728,206 C 799.6666666666666,222.33333333333334 892.8333333333333,265.3205128205128 974,265 C 1055.1666666666667,264.6794871794872 1124.3333333333335,221.05128205128204 1200,203 C 1275.6666666666665,184.94871794871796 1357.8333333333333,192.47435897435898 1440,200 C 1440,200 1440,400 1440,400 Z"
                );
            }

            100% {
              d: path("M 0,400 C 0,400 0,200 0,200 C 75.28461538461539,167.45897435897436 150.56923076923078,134.91794871794872 239,134 C 327.4307692307692,133.08205128205128 429.0076923076923,163.7871794871795 513,172 C 596.9923076923077,180.2128205128205 663.4000000000001,165.93333333333337 741,183 C 818.5999999999999,200.06666666666663 907.3923076923077,248.47948717948714 977,269 C 1046.6076923076923,289.52051282051286 1097.0307692307692,282.14871794871794 1171,266 C 1244.9692307692308,249.85128205128206 1342.4846153846154,224.92564102564103 1440,200 C 1440,200 1440,400 1440,400 Z"
                );
            }
          }
        </style>
        <path
          d="M 0,400 C 0,400 0,200 0,200 C 75.28461538461539,167.45897435897436 150.56923076923078,134.91794871794872 239,134 C 327.4307692307692,133.08205128205128 429.0076923076923,163.7871794871795 513,172 C 596.9923076923077,180.2128205128205 663.4000000000001,165.93333333333337 741,183 C 818.5999999999999,200.06666666666663 907.3923076923077,248.47948717948714 977,269 C 1046.6076923076923,289.52051282051286 1097.0307692307692,282.14871794871794 1171,266 C 1244.9692307692308,249.85128205128206 1342.4846153846154,224.92564102564103 1440,200 C 1440,200 1440,400 1440,400 Z"
          stroke="none" stroke-width="0" fill="#222222ff"
          class="transition-all duration-300 ease-in-out delay-150 path-0" transform="rotate(-180 720 200)"></path>
      </svg>
      <!-- Sobre-->

      <!-- Jogo -->
      <section id="bio">
        <div class="bio container" data-aos="fade-up" data-aos-duration="1000">
          <div class="img">
            <img loading="lazy" class="bio-img" src="/Site_StartEnd/img/y.m.png" alt="photo-bio" />
            <img loading="lazy" class="bio-img" src="/Site_StartEnd/img/y.me.png" alt="photo-bio" />
          </div>
          <div class="text">
            <h6 class="section-title">Jogo</h6>
            <h2>
              <span class="green">Trilha do Aprendiz<br /></span> Uma Aventura Espacial em Pixel Art!
            </h2>
            <p>
              Bem-vindo a NASA, aventureiro! Prepare-se para uma emocionante jornada em Trilha do Aprendiz,
              um jogo de aventura em pixel art que vai desafiar sua destreza e habilidades estratégicas, que
              mostra um pouco da beleza de Manaus, a capital do Amazonas!
            </p>
            <p>
              A história se aprofunda conforme nosso herói se aventura de Startend até Marte, onde uma missão
              especial o aguarda: realizar o plantio desses recursos para garantir um futuro sustentável para
              o planeta vermelho e o planeta azul. Com uma jogabilidade cativante e envolvente, Trilha do Aprendiz
              é ideal para adolescentes que buscam emoção, desafios intelectuais e diversão sem fim. Prepare-se
              para embarcar nessa jornada emocionante, enfrentar desafios, desvendar segredos e se tornar um
              verdadeiro mestre das trilhas interplanetárias em Trilha do Aprendiz!
            </p>
            <br><br><br>
            <div class="jogo-link">
              <h4>
                Junte-se ao nosso corajoso carinha e embarque nessa aventura espacial inesquecível hoje mesmo!
              </h4>
              <br>
              <div class="custom-btn btn-12">
                <span>
                  <a href="https://www.mediafire.com/file/l6tv2vwl9pgz11r/Trilha_do_Aprendiz.rar/file">
                    Aproveite
                  </a>
                </span>
                <span>Baixar Jogo</span>
              </div>
              <h5 class="instrucoes">
                É necessário descompactar o arquivo para executar ele em seu computador, após isso entre na
                pasta DemoTrilha do Aprendiz e coloque as configurações:<br>
                Screen Resolution = 1760x990 e clique em Windowed, de player.
              </h5>
            </div>
          </div>
        </div>
      </section>
      <svg width="100%" height="100%" id="svg" viewBox="0 0 1440 400" xmlns="http://www.w3.org/2000/svg"
        class="transition duration-300 ease-in-out delay-150">
        <style>
          .path-0 {
            animation: pathAnim-0 4s;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
          }

          @keyframes pathAnim-0 {
            0% {
              d: path("M 0,500 C 0,500 0,250 0,250 C 53.5,275.4589743589744 107,300.9179487179487 202,290 C 297,279.0820512820513 433.5,231.7871794871795 519,219 C 604.5,206.2128205128205 638.9999999999999,227.93333333333334 710,242 C 781.0000000000001,256.06666666666666 888.5,262.4794871794872 968,272 C 1047.5,281.5205128205128 1099,294.14871794871794 1173,291 C 1247,287.85128205128206 1343.5,268.925641025641 1440,250 C 1440,250 1440,500 1440,500 Z"
                );
            }

            25% {
              d: path("M 0,500 C 0,500 0,250 0,250 C 77.53846153846152,284.94615384615383 155.07692307692304,319.8923076923077 236,310 C 316.92307692307696,300.1076923076923 401.2307692307693,245.3769230769231 486,248 C 570.7692307692307,250.6230769230769 656.0000000000002,310.6 738,328 C 819.9999999999998,345.4 898.7692307692305,320.22307692307686 971,304 C 1043.2307692307695,287.77692307692314 1108.923076923077,280.5076923076923 1186,273 C 1263.076923076923,265.4923076923077 1351.5384615384614,257.74615384615385 1440,250 C 1440,250 1440,500 1440,500 Z"
                );
            }

            50% {
              d: path("M 0,500 C 0,500 0,250 0,250 C 77.8153846153846,299.1128205128205 155.6307692307692,348.22564102564104 236,343 C 316.3692307692308,337.77435897435896 399.29230769230776,278.21025641025636 475,277 C 550.7076923076922,275.78974358974364 619.2,332.93333333333334 702,310 C 784.8,287.06666666666666 881.9076923076923,184.0564102564103 964,184 C 1046.0923076923077,183.9435897435897 1113.1692307692308,286.8410256410257 1190,315 C 1266.8307692307692,343.1589743589743 1353.4153846153845,296.57948717948716 1440,250 C 1440,250 1440,500 1440,500 Z"
                );
            }

            75% {
              d: path("M 0,500 C 0,500 0,250 0,250 C 81.18717948717949,259.9846153846154 162.37435897435898,269.96923076923076 235,286 C 307.625641025641,302.03076923076924 371.68974358974356,324.1076923076924 455,326 C 538.3102564102564,327.8923076923076 640.8666666666667,309.6 725,267 C 809.1333333333333,224.4 874.8435897435897,157.4923076923077 948,162 C 1021.1564102564103,166.5076923076923 1101.7589743589745,242.43076923076922 1185,269 C 1268.2410256410255,295.5692307692308 1354.1205128205129,272.7846153846154 1440,250 C 1440,250 1440,500 1440,500 Z"
                );
            }

            100% {
              d: path("M 0,500 C 0,500 0,250 0,250 C 53.5,275.4589743589744 107,300.9179487179487 202,290 C 297,279.0820512820513 433.5,231.7871794871795 519,219 C 604.5,206.2128205128205 638.9999999999999,227.93333333333334 710,242 C 781.0000000000001,256.06666666666666 888.5,262.4794871794872 968,272 C 1047.5,281.5205128205128 1099,294.14871794871794 1173,291 C 1247,287.85128205128206 1343.5,268.925641025641 1440,250 C 1440,250 1440,500 1440,500 Z"
                );
            }
          }
        </style>
        <path
          d="M 0,500 C 0,500 0,250 0,250 C 53.5,275.4589743589744 107,300.9179487179487 202,290 C 297,279.0820512820513 433.5,231.7871794871795 519,219 C 604.5,206.2128205128205 638.9999999999999,227.93333333333334 710,242 C 781.0000000000001,256.06666666666666 888.5,262.4794871794872 968,272 C 1047.5,281.5205128205128 1099,294.14871794871794 1173,291 C 1247,287.85128205128206 1343.5,268.925641025641 1440,250 C 1440,250 1440,500 1440,500 Z"
          stroke="none" stroke-width="0" fill="#222222ff"
          class="transition-all duration-300 ease-in-out delay-150 path-0"></path>
      </svg>
      <!-- Jogo -->

      <!-- Equipes -->
      <section class="section-eqp" id="equipe">
        <div class="Eventos container" data-aos="fade-up" data-aos-duration="1000">
          <h6 class="section-title">Equipes</h6>
          <h3 class="skill-label">Equipes</h3>
          <div class="container-eqp">
            <div class="carousel">
              <input class="in-eqp" type="radio" name="slides" checked="checked" id="slide-1">
              <input class="in-eqp" type="radio" name="slides" id="slide-2">
              <input class="in-eqp" type="radio" name="slides" id="slide-3">
              <input class="in-eqp" type="radio" name="slides" id="slide-4">
              <input class="in-eqp" type="radio" name="slides" id="slide-5">
              <input class="in-eqp" type="radio" name="slides" id="slide-6">
              <ul class="carousel__slides">
                <li class="carousel__slide">
                  <figure>
                    <div>
                      <img class="img-eqp" src="img/Em Breve.png" alt="">
                    </div>
                    <figcaption>
                      Participantes da Equipe.
                      Cidade/Estado.
                      <span class="credit">Instagram da Equipe.</span>
                    </figcaption>
                  </figure>
                </li>
                <li class="carousel__slide">
                  <figure>
                    <div>
                      <img class="img-eqp" src="img/Em Breve.png" alt="">
                    </div>
                    <figcaption>
                      Participantes da Equipe.
                      Cidade/Estado.
                      <span class="credit">Instagram da Equipe.</span>
                    </figcaption>
                  </figure>
                </li>
                <li class="carousel__slide">
                  <figure>
                    <div>
                      <img class="img-eqp" src="img/Em Breve.png" alt="">
                    </div>
                    <figcaption>
                      Participantes da Equipe.
                      Cidade/Estado.
                      <span class="credit">Instagram da Equipe.</span>
                    </figcaption>
                  </figure>
                </li>
                <li class="carousel__slide">
                  <figure>
                    <div>
                      <img class="img-eqp" src="img/Em Breve.png" alt="">
                    </div>
                    <figcaption>
                      Participantes da Equipe.
                      Cidade/Estado.
                      <span class="credit">Instagram da Equipe.</span>
                    </figcaption>
                  </figure>
                </li>
                <!-- Repita o bloco de li e figure conforme necessário para cada equipe -->
              </ul>
              <ul class="carousel__thumbnails">
                <li>
                  <label for="slide-1"><img class="img-eqp" src="img/Em Breve.png" alt=""></label>
                </li>
                <li>
                  <label for="slide-2"><img class="img-eqp" src="img/Em Breve.png" alt=""></label>
                </li>
                <li>
                  <label for="slide-3"><img class="img-eqp" src="img/Em Breve.png" alt=""></label>
                </li>
                <li>
                  <label for="slide-4"><img class="img-eqp" src="img/Em Breve.png" alt=""></label>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>
      <svg width="100%" height="100%" id="svg" viewBox="0 0 1440 400" xmlns="http://www.w3.org/2000/svg"
        class="transition duration-300 ease-in-out delay-150">
        <style>
          .path-0 {
            animation: pathAnim-0 4s;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
          }

          @keyframes pathAnim-0 {
            0% {
              d: path("M 0,400 C 0,400 0,200 0,200 C 75.28461538461539,167.45897435897436 150.56923076923078,134.91794871794872 239,134 C 327.4307692307692,133.08205128205128 429.0076923076923,163.7871794871795 513,172 C 596.9923076923077,180.2128205128205 663.4000000000001,165.93333333333337 741,183 C 818.5999999999999,200.06666666666663 907.3923076923077,248.47948717948714 977,269 C 1046.6076923076923,289.52051282051286 1097.0307692307692,282.14871794871794 1171,266 C 1244.9692307692308,249.85128205128206 1342.4846153846154,224.92564102564103 1440,200 C 1440,200 1440,400 1440,400 Z"
                );
            }

            25% {
              d: path("M 0,400 C 0,400 0,200 0,200 C 62.7923076923077,160.5179487179487 125.5846153846154,121.03589743589743 199,126 C 272.4153846153846,130.96410256410257 356.45384615384614,180.37435897435896 443,215 C 529.5461538461539,249.62564102564104 618.6000000000001,269.4666666666667 713,246 C 807.3999999999999,222.53333333333333 907.1461538461538,155.75897435897434 987,144 C 1066.8538461538462,132.24102564102566 1126.8153846153846,175.4974358974359 1199,194 C 1271.1846153846154,212.5025641025641 1355.5923076923077,206.25128205128203 1440,200 C 1440,200 1440,400 1440,400 Z"
                );
            }

            50% {
              d: path("M 0,400 C 0,400 0,200 0,200 C 76.36666666666665,193.56923076923078 152.7333333333333,187.13846153846154 230,176 C 307.2666666666667,164.86153846153846 385.4333333333334,149.0153846153846 470,151 C 554.5666666666666,152.9846153846154 645.5333333333333,172.80000000000004 720,174 C 794.4666666666667,175.19999999999996 852.4333333333333,157.7846153846154 922,150 C 991.5666666666667,142.2153846153846 1072.7333333333333,144.06153846153848 1161,154 C 1249.2666666666667,163.93846153846152 1344.6333333333332,181.96923076923076 1440,200 C 1440,200 1440,400 1440,400 Z"
                );
            }

            75% {
              d: path("M 0,400 C 0,400 0,200 0,200 C 65.16666666666669,221.14102564102564 130.33333333333337,242.28205128205127 223,244 C 315.66666666666663,245.71794871794873 435.83333333333326,228.01282051282053 521,214 C 606.1666666666667,199.98717948717947 656.3333333333334,189.66666666666666 728,206 C 799.6666666666666,222.33333333333334 892.8333333333333,265.3205128205128 974,265 C 1055.1666666666667,264.6794871794872 1124.3333333333335,221.05128205128204 1200,203 C 1275.6666666666665,184.94871794871796 1357.8333333333333,192.47435897435898 1440,200 C 1440,200 1440,400 1440,400 Z"
                );
            }

            100% {
              d: path("M 0,400 C 0,400 0,200 0,200 C 75.28461538461539,167.45897435897436 150.56923076923078,134.91794871794872 239,134 C 327.4307692307692,133.08205128205128 429.0076923076923,163.7871794871795 513,172 C 596.9923076923077,180.2128205128205 663.4000000000001,165.93333333333337 741,183 C 818.5999999999999,200.06666666666663 907.3923076923077,248.47948717948714 977,269 C 1046.6076923076923,289.52051282051286 1097.0307692307692,282.14871794871794 1171,266 C 1244.9692307692308,249.85128205128206 1342.4846153846154,224.92564102564103 1440,200 C 1440,200 1440,400 1440,400 Z"
                );
            }
          }
        </style>
        <path
          d="M 0,400 C 0,400 0,200 0,200 C 75.28461538461539,167.45897435897436 150.56923076923078,134.91794871794872 239,134 C 327.4307692307692,133.08205128205128 429.0076923076923,163.7871794871795 513,172 C 596.9923076923077,180.2128205128205 663.4000000000001,165.93333333333337 741,183 C 818.5999999999999,200.06666666666663 907.3923076923077,248.47948717948714 977,269 C 1046.6076923076923,289.52051282051286 1097.0307692307692,282.14871794871794 1171,266 C 1244.9692307692308,249.85128205128206 1342.4846153846154,224.92564102564103 1440,200 C 1440,200 1440,400 1440,400 Z"
          stroke="none" stroke-width="0" fill="#222222ff"
          class="transition-all duration-300 ease-in-out delay-150 path-0" transform="rotate(-180 720 200)"></path>
      </svg>
      <!-- Equipes -->

      <!-- Agenda -->
      <section id="agenda">
        <div class="Agenda container" data-aos="fade-up" data-aos-duration="1000">
          <h6 class="section-title text-ag">Eventos_e_Equipes</h6>
          <h4 class="text-ag">Nosso próximo evento acontecerá em 24/04/2024</h4>
          <h5 class="text-ag">Acompanhe nossa contagem regressiva.</h5>
          <h6 class="text-ag">Aguarde, em breve divulgaremos o nosso próximo evento.</h6>
          <!-- Countdown start -->
          <div id="countdown_dashboard">
            <div class="dashp">
              <div class="day">
                <span class="dashtitle">Dias</span>
                <p id="days"></p>
              </div>
              <div class="hr">
                <span class="dashtitle">Horas</span>
                <p id="hours"></p>
              </div>
              <div class="min">
                <span class="dashtitle">Minutos</span>
                <p id="minutes"></p>
              </div>
              <div class="seg">
                <span class="dashtitle">Segundos</span>
                <p id="seconds"></p>
              </div>
            </div>
          </div>
          <!-- Countdown end -->
          <script type="text/javascript">
            function countdown() {
              var now = new Date();
              // Altere a data do seu evento aqui
              var eventDate = new Date("04 24, 2024 09:00:00");
              var currentTime = now.getTime();
              var eventTime = eventDate.getTime();
              var remTime = eventTime - currentTime;
              // Calculando o dia, hora, minuto e segundo
              var d = Math.floor(remTime / (1000 * 60 * 60 * 24));
              var h = Math.floor((remTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
              var m = Math.floor((remTime % (1000 * 60 * 60)) / (1000 * 60));
              var s = Math.floor((remTime % (1000 * 60)) / 1000);
              document.getElementById("days").textContent = d;
              document.getElementById("days").innerText = d;
              document.getElementById("hours").textContent = h;
              document.getElementById("minutes").textContent = m;
              document.getElementById("seconds").textContent = s;
              setTimeout(countdown, 1000);

              // Verifica se acabou o período do evento
              if (remTime < 0) {
                clearInterval(countdown);
                document.getElementById("days").innerHTML = " ";
                document.getElementById("hours").innerHTML = " ";
                document.getElementById("minutes").innerHTML = " ";
                document.getElementById("seconds").innerHTML = "<small>FIM</small>";
              }
            }
            countdown();
          </script>
          <!-- Countdown end -->
        </div>
      </section>
      <svg width="100%" height="100%" id="svg" viewBox="0 0 1440 400" xmlns="http://www.w3.org/2000/svg"
        class="transition duration-300 ease-in-out delay-150">
        <style>
          .path-0 {
            animation: pathAnim-0 4s;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
          }

          @keyframes pathAnim-0 {
            0% {
              d: path("M 0,500 C 0,500 0,250 0,250 C 53.5,275.4589743589744 107,300.9179487179487 202,290 C 297,279.0820512820513 433.5,231.7871794871795 519,219 C 604.5,206.2128205128205 638.9999999999999,227.93333333333334 710,242 C 781.0000000000001,256.06666666666666 888.5,262.4794871794872 968,272 C 1047.5,281.5205128205128 1099,294.14871794871794 1173,291 C 1247,287.85128205128206 1343.5,268.925641025641 1440,250 C 1440,250 1440,500 1440,500 Z"
                );
            }

            25% {
              d: path("M 0,500 C 0,500 0,250 0,250 C 77.53846153846152,284.94615384615383 155.07692307692304,319.8923076923077 236,310 C 316.92307692307696,300.1076923076923 401.2307692307693,245.3769230769231 486,248 C 570.7692307692307,250.6230769230769 656.0000000000002,310.6 738,328 C 819.9999999999998,345.4 898.7692307692305,320.22307692307686 971,304 C 1043.2307692307695,287.77692307692314 1108.923076923077,280.5076923076923 1186,273 C 1263.076923076923,265.4923076923077 1351.5384615384614,257.74615384615385 1440,250 C 1440,250 1440,500 1440,500 Z"
                );
            }

            50% {
              d: path("M 0,500 C 0,500 0,250 0,250 C 77.8153846153846,299.1128205128205 155.6307692307692,348.22564102564104 236,343 C 316.3692307692308,337.77435897435896 399.29230769230776,278.21025641025636 475,277 C 550.7076923076922,275.78974358974364 619.2,332.93333333333334 702,310 C 784.8,287.06666666666666 881.9076923076923,184.0564102564103 964,184 C 1046.0923076923077,183.9435897435897 1113.1692307692308,286.8410256410257 1190,315 C 1266.8307692307692,343.1589743589743 1353.4153846153845,296.57948717948716 1440,250 C 1440,250 1440,500 1440,500 Z"
                );
            }

            75% {
              d: path("M 0,500 C 0,500 0,250 0,250 C 81.18717948717949,259.9846153846154 162.37435897435898,269.96923076923076 235,286 C 307.625641025641,302.03076923076924 371.68974358974356,324.1076923076924 455,326 C 538.3102564102564,327.8923076923076 640.8666666666667,309.6 725,267 C 809.1333333333333,224.4 874.8435897435897,157.4923076923077 948,162 C 1021.1564102564103,166.5076923076923 1101.7589743589745,242.43076923076922 1185,269 C 1268.2410256410255,295.5692307692308 1354.1205128205129,272.7846153846154 1440,250 C 1440,250 1440,500 1440,500 Z"
                );
            }

            100% {
              d: path("M 0,500 C 0,500 0,250 0,250 C 53.5,275.4589743589744 107,300.9179487179487 202,290 C 297,279.0820512820513 433.5,231.7871794871795 519,219 C 604.5,206.2128205128205 638.9999999999999,227.93333333333334 710,242 C 781.0000000000001,256.06666666666666 888.5,262.4794871794872 968,272 C 1047.5,281.5205128205128 1099,294.14871794871794 1173,291 C 1247,287.85128205128206 1343.5,268.925641025641 1440,250 C 1440,250 1440,500 1440,500 Z"
                );
            }
          }
        </style>
        <path
          d="M 0,500 C 0,500 0,250 0,250 C 53.5,275.4589743589744 107,300.9179487179487 202,290 C 297,279.0820512820513 433.5,231.7871794871795 519,219 C 604.5,206.2128205128205 638.9999999999999,227.93333333333334 710,242 C 781.0000000000001,256.06666666666666 888.5,262.4794871794872 968,272 C 1047.5,281.5205128205128 1099,294.14871794871794 1173,291 C 1247,287.85128205128206 1343.5,268.925641025641 1440,250 C 1440,250 1440,500 1440,500 Z"
          stroke="none" stroke-width="0" fill="#222222ff"
          class="transition-all duration-300 ease-in-out delay-150 path-0"></path>
      </svg>
      <!--Agenda-->
    </main>
    <!-- Conteudo -->

    <!-- Footer -->
    <footer>
      <div class="main">
        <div class="col1">
          <h3 class="heading">Redirecionamento</h3>
          <div class="footer-nav">
            <ul>
              <li>
                <a href="index.html">
                  Início
                </a>
              </li>
              <li>
                <a href="https://www.instagram.com/startendexp/">
                  Entre em Contato
                </a>
              </li>
            </ul>
          </div>
        </div>

        <div class="col3">
          <h3 class="heading">Redes Sociais</h3>
          <div class="social social-media-set">
            <a title="LinkedIn" href="https://www.linkedin.com/in/start-end-experience-a540b2266/?originalSubdomain=br"
              class="social-icon" target="_blank">
              <div class="img linkedin"></div>
            </a>
            <a title="Twitter" href="https://www.instagram.com/startendexp?igshid=OGQ5ZDc2ODk2ZA==" class="social-icon"
              target="_blank">
              <div class="img twitter"></div>
            </a>
            <a title="Facebook" href="#" class="social-icon" target="_blank">
              <div class="img facebook"></div>
            </a>
          </div>
        </div>
      </div>

      <div class="footer-rights">
        <hr />
        <div class="container">
          <div class="copyright">
            <p>
              Copyright &copy; 2020-2023 | Todos os direitos reservados. Feito com
              <span id="heart-icon">&#10084;</span> por
              <a href="" title="Official Website" target="_blank">Sannay_Duarte - Cristophe_Damião</a>
            </p>
          </div>
        </div>
      </div>
    </footer>
    <!-- Footer -->
  </div>


  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="js/tilt.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"
    target="_blank"></script>
  <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
  <script src="https://kit.fontawesome.com/0a73ff5289.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
  <script src="./js/counter.min.js"></script>
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <script src="https://unpkg.co/gsap@3/dist/gsap.min.js"></script>
  <script src="https://unpkg.com/gsap@3/dist/Draggable.min.js"></script>
  <script src="js/main.js"></script>
  <script>
    AOS.init();
  </script>
  <!-- Snow Flakes in December -->
  <script src="https://unpkg.com/magic-snowflakes/dist/snowflakes.min.js"></script>
  <script>
    const d = new Date();
    let month = d.getMonth();
    if (month == 11) {
      var snowflakes = new Snowflakes({ count: 20 });
    } else {
      null;
    }
  </script>
</body>

</html>
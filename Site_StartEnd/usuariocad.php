<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro inválido</title>
    <link rel="stylesheet" href="css/invalid.css">
</head>
<body>
  
    
<!--CONTEUDO-->
<form class="Cadastro" id="login-usuario-form">
  <h2>Este usuário já está cadastrado faça o login!</h2> 
  <span id="msgAlertErrorLogin"></span>
  <span><br></span>
  <div class="container" id="cads">
      <div class="nomes ">
          <div class="dados mb-6">
            <label for="email" class="form-label">EMAIL</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Digite seu email"> <br><br>
          </div>
          <div class="dados mb-6">
            <label for="senha" class="form-label">SENHA</label>
            <input type="password" class="form-control" name="senha" id="senha" placeholder="Digite sua senha">
            <input type="submit" id="login-usuario-bnt" class="btn btn-dark" value="Acessar"><br><br>
          </div>
          <a href="https://www.instagram.com/direct/t/17852131451757062" class="tx">Esqueceu a senha.</a>
      </div>
  </div>
</div>
</form>
<!--CONTEUDO-->

<script src="js/custom.js"></script>

</body>
</html>
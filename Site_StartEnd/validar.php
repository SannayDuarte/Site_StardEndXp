<?php
session_start();
include_once "conexao.php";

$retorna = array();

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if(empty($dados['email'])){
    $retorna = ['erro'=> true, 'msg' => "Erro: Necessário preencher os campos"];
} elseif(empty($dados['senha'])){
    $retorna = ['erro'=> true, 'msg' => "Erro: Necessário preencher os campos"];
}else{
   $query_aluno = "(
    SELECT 'aluno' as tipo_pessoa, id_al, nome, email, senha
    FROM aluno
    WHERE email = :email
    LIMIT 1
) UNION (
    SELECT 'professor' as tipo_pessoa, id_prof, nome, email, senha
    FROM professor
    WHERE email = :email
    LIMIT 1
) UNION (
    SELECT 'empresa' as tipo_pessoa, id_emp, emp, email, senha
    FROM empresa
    WHERE email = :email
    LIMIT 1
)";
    $result_aluno = $conn->prepare($query_aluno);
    $result_aluno->bindParam(":email", $dados['email'], PDO::PARAM_STR);
    $result_aluno->execute();

    {


    if(($result_aluno) and ($result_aluno->rowCount() != 0)){
        
        unset($_SESSION['nome'] );
        unset($_SESSION['email'] );
        unset($_SESSION['senha'] );
       $row_aluno = $result_aluno->fetch(PDO::FETCH_ASSOC);
       if(password_verify($dados['senha'], $row_aluno['senha'])){
        $_SESSION['nome'] = $row_aluno['nome'];
        $_SESSION['email'] = $row_aluno['email'];
        $_SESSION['senha'] = $row_aluno['senha'];
        $retorna = ['erro'=> false, 'dados' => $row_aluno];
    }else{
        $retorna = ['erro'=> true, 'msg' => "Usuário ou senha inválida!"];
        
        unset($_SESSION['nome'] );
        unset($_SESSION['email'] );
        unset($_SESSION['senha'] );
    }
}else{
    $retorna = ['erro'=> true, 'msg' => "Usuário ou senha inválida!"];
    
        unset($_SESSION['nome'] );
        unset($_SESSION['email'] );
        unset($_SESSION['senha'] );
}


    
}
}

echo json_encode($retorna);

function logout(){
    session_start();
    session_unset();
    session_destroy();
    header("Location: index.php");
}
const loginForm = document.getElementById("login-usuario-form");
const msgAlertErrorLogin = document.getElementById("msgAlertErrorLogin");

loginForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    if(document.getElementById("email").value === ""){
        msgAlertErrorLogin.innerHTML = "Erro: Necessário preencher os campos";
    }else if(document.getElementById("senha").value === ""){
        msgAlertErrorLogin.innerHTML = "Erro: Necessário preencher os campos";
    }else{
        const dadosForm = new FormData(loginForm);

       const dados = await fetch("validar.php",{
            method: "POST",
            body: dadosForm

        });

       const resposta = await dados.json();
       console.log(resposta);

       if(resposta['erro']){
            msgAlertErrorLogin.innerHTML = resposta['msg']
       }else{
        loginForm.reset();
        window.location.href  = "logado.php";

       }
    }
    
});






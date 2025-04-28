<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
    <div id="page-content">
    <div class="container-fluid text-center my-5">
        <img src="img/teste.webp" class="rounded-circle img-fluid" style="width: 200px; height: 200px; object-fit: cover;" alt="Imagem redonda">
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <h1><center>Bem Vindo</center></h1>
        </div>  
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col md-5 mx-auto justify-content-center"><center>
                <form id="loginForm">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control col-3" style="border-color:black;" id="email" name="email" required><br>
                    </div>
                    <div class="form-group">
                        <label for="senha">Password</label>
                        <input type="password" class="form-control col-3" style="border-color:black" id="senha" name="senha" required><br>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-dark">Entrar</button>
                        <a href="register.php" class="btn btn-outline-secondary ml-2">Criar Conta</a>
                    </div>
                </form>
                <div id="loginMessage" class="mt-3"></div>
            </center></div>
        </div>
    </div>
</div>

<!-- Adicione esses scripts no final do body -->
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>
<script>
    // Configuração do Firebase
    const firebaseConfig = {
        apiKey: "AIzaSyAGHrCKcMcOZlGcArEyCmOW4lFCnvnoNZE",
        authDomain: "testepi-e8900.firebaseapp.com",
        projectId: "testepi-e8900",
        storageBucket: "testepi-e8900.firebasestorage.app",
        messagingSenderId: "194879621285",
        appId: "1:194879621285:web:f4c7b841a57bb8a6cce54c"
    };

    // Inicializa o Firebase
    firebase.initializeApp(firebaseConfig);
    const auth = firebase.auth();

    // Função para login
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = document.getElementById('email').value;
        const senha = document.getElementById('senha').value;
        const messageDiv = document.getElementById('loginMessage');

        // Mostra loading no botão
        const btn = e.target.querySelector('button');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Entrando...';
        btn.disabled = true;

        auth.signInWithEmailAndPassword(email, senha)
            .then((userCredential) => {
                // Login bem-sucedido
                window.location.href = 'adm.php';
            })
            .catch((error) => {
                // Tratamento de erros
                let errorMessage;
                switch(error.code) {
                    case 'auth/invalid-email':
                        errorMessage = "E-mail inválido";
                        break;
                    case 'auth/user-disabled':
                        errorMessage = "Usuário desativado";
                        break;
                    case 'auth/user-not-found':
                    case 'auth/wrong-password':
                        errorMessage = "E-mail ou senha incorretos";
                        break;
                    default:
                        errorMessage = "Erro ao fazer login";
                }
                
                messageDiv.innerHTML = `<div class="alert alert-danger">${errorMessage}</div>`;
                btn.innerHTML = 'Entrar';
                btn.disabled = false;
            });
    });

    // Verifica se o usuário já está logado
auth.onAuthStateChanged((user) => {
    if (user) {
        // Verifica se o e-mail foi verificado (opcional)
        if (user.emailVerified) {
            window.location.href = 'adm.php';
        } else {
            // Se quiser exigir verificação por e-mail
            console.log('E-mail não verificado');
            // Ou redirecione para uma página de aviso:
            // window.location.href = 'verify-email.php';
        }
    }
    // Se não houver usuário, permanece na página de login
});
</script>
</body>
</html>
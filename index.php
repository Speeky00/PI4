<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
    <div id="page-content" class="container py-5">
        <div class="text-center mb-4">
            <img src="img/teste.webp" class="rounded-circle img-fluid" style="width: 200px; height: 200px; object-fit: cover;" alt="Imagem redonda">
            <h1 class="mt-4">Bem-vindo</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-4">
                <form id="loginForm">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" class="form-control" id="senha" required>
                    </div>
                    <button type="submit" class="btn btn-dark btn-block">Entrar</button>
                    <a href="register.php" class="btn btn-outline-secondary btn-block mt-2">Criar Conta</a>
                </form>
                <div id="loginMessage" class="mt-3"></div>
            </div>
        </div>
    </div>

    <!-- Firebase Scripts -->
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>

    <script>
        // Configuração do Firebase corrigida
        const firebaseConfig = {
            apiKey: "AIzaSyAGHrCKcMcOZlGcArEyCmOW4lFCnvnoNZE",
            authDomain: "testepi-e8900.firebaseapp.com",
            projectId: "testepi-e8900",
            storageBucket: "testepi-e8900.appspot.com", // Corrigido aqui
            messagingSenderId: "194879621285",
            appId: "1:194879621285:web:f4c7b841a57bb8a6cce54c"
        };

        firebase.initializeApp(firebaseConfig);
        const auth = firebase.auth();

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const senha = document.getElementById('senha').value;
            const messageDiv = document.getElementById('loginMessage');
            const btn = e.target.querySelector('button');

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Entrando...';

            auth.signInWithEmailAndPassword(email, senha)
                .then(() => {
                    window.location.href = 'adm.php';
                })
                .catch((error) => {
                    let errorMessage;
                    switch(error.code) {
                        case 'auth/invalid-email':
                            errorMessage = "E-mail inválido.";
                            break;
                        case 'auth/user-disabled':
                            errorMessage = "Usuário desativado.";
                            break;
                        case 'auth/user-not-found':
                        case 'auth/wrong-password':
                            errorMessage = "E-mail ou senha incorretos.";
                            break;
                        default:
                            errorMessage = "Erro ao fazer login.";
                    }

                    messageDiv.innerHTML = `<div class="alert alert-danger">${errorMessage}</div>`;
                    btn.disabled = false;
                    btn.innerHTML = 'Entrar';
                });
        });

        auth.onAuthStateChanged((user) => {
            if (user) {
                window.location.href = 'adm.php';
            }
        });
    </script>
</body>
</html>

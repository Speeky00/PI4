<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container py-5">
        <div class="text-center mb-4">
            <img src="img/teste.webp" class="rounded-circle" style="width: 200px; height: 200px; object-fit: cover;">
            <h1 class="mt-3">Criar Nova Conta</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-5">
                <form id="registerForm">
                    <div class="form-group">
                        <label for="regEmail">Email</label>
                        <input type="email" class="form-control" id="regEmail" required>
                    </div>
                    <div class="form-group">
                        <label for="regPassword">Senha (mínimo 6 caracteres)</label>
                        <input type="password" class="form-control" id="regPassword" minlength="6" required>
                    </div>
                    <div class="form-group">
                        <label for="regConfirmPassword">Confirmar Senha</label>
                        <input type="password" class="form-control" id="regConfirmPassword" minlength="6" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
                    <a href="index.php" class="btn btn-outline-secondary btn-block mt-2">Voltar para Login</a>
                </form>
                <div id="registerMessage" class="mt-3"></div>
            </div>
        </div>
    </div>

    <!-- Firebase Scripts -->
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>
    <script>
        // Firebase config corrigido
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

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = document.getElementById('regEmail').value;
            const password = document.getElementById('regPassword').value;
            const confirmPassword = document.getElementById('regConfirmPassword').value;
            const messageDiv = document.getElementById('registerMessage');
            const btn = e.target.querySelector('button');

            if (password !== confirmPassword) {
                messageDiv.innerHTML = '<div class="alert alert-danger">As senhas não coincidem.</div>';
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Cadastrando...';

            auth.createUserWithEmailAndPassword(email, password)
                .then((userCredential) => {
                    userCredential.user.sendEmailVerification()
                        .then(() => {
                            setTimeout(() => {
                                window.location.href = 'index.php';
                            }, 3000);
                        })
                        .catch((err) => {
                            messageDiv.innerHTML = `<div class="alert alert-warning">Conta criada, mas falha ao enviar verificação por e-mail: ${err.message}</div>`;
                        });
                })
                .catch((error) => {
                    let errorMessage;
                    switch(error.code) {
                        case 'auth/email-already-in-use':
                            errorMessage = "Este e-mail já está em uso.";
                            break;
                        case 'auth/invalid-email':
                            errorMessage = "E-mail inválido.";
                            break;
                        case 'auth/weak-password':
                            errorMessage = "Senha muito fraca (mínimo 6 caracteres).";
                            break;
                        default:
                            errorMessage = "Erro ao cadastrar: " + error.message;
                    }

                    messageDiv.innerHTML = `<div class="alert alert-danger">${errorMessage}</div>`;
                    btn.disabled = false;
                    btn.innerHTML = 'Cadastrar';
                });
        });
    </script>
</body>
</html>

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
    <div id="page-content">
        <div class="container-fluid text-center my-5">
            <img src="img/teste.webp" class="rounded-circle img-fluid" style="width: 200px; height: 200px; object-fit: cover;" alt="Imagem redonda">
        </div>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <h1><center>Criar Nova Conta</center></h1>
            </div>  
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col md-5 mx-auto justify-content-center"><center>
                    <form id="registerForm">
                        <div class="form-group">
                            <label for="regEmail">Email</label>
                            <input type="email" class="form-control col-3" style="border-color:black;" id="regEmail" required><br>
                        </div>
                        <div class="form-group">
                            <label for="regPassword">Senha (mínimo 6 caracteres)</label>
                            <input type="password" class="form-control col-3" style="border-color:black" id="regPassword" minlength="6" required><br>
                        </div>
                        <div class="form-group">
                            <label for="regConfirmPassword">Confirmar Senha</label>
                            <input type="password" class="form-control col-3" style="border-color:black" id="regConfirmPassword" minlength="6" required><br>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                            <a href="index.php" class="btn btn-outline-secondary ml-2">Voltar para Login</a>
                        </div>
                    </form>
                    <div id="registerMessage" class="mt-3"></div>
                </center></div>
            </div>
        </div>
    </div>

    <!-- Firebase e scripts -->
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>
    <script>
        // Configuração do Firebase (mesma do login)
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

        // Função para cadastro
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('regEmail').value;
            const password = document.getElementById('regPassword').value;
            const confirmPassword = document.getElementById('regConfirmPassword').value;
            const messageDiv = document.getElementById('registerMessage');
            
            // Validação básica
            if (password !== confirmPassword) {
                messageDiv.innerHTML = '<div class="alert alert-danger">As senhas não coincidem</div>';
                return;
            }
            
            if (password.length < 6) {
                messageDiv.innerHTML = '<div class="alert alert-danger">A senha deve ter no mínimo 6 caracteres</div>';
                return;
            }

            // Mostra loading no botão
            const btn = e.target.querySelector('button');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cadastrando...';
            btn.disabled = true;

            auth.createUserWithEmailAndPassword(email, password)
                .then((userCredential) => {
                    // Cadastro bem-sucedido
                    messageDiv.innerHTML = '<div class="alert alert-success">Conta criada com sucesso! Redirecionando...</div>';
                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 1500);
                })
                .catch((error) => {
                    // Tratamento de erros
                    let errorMessage;
                    switch(error.code) {
                        case 'auth/email-already-in-use':
                            errorMessage = "Este e-mail já está em uso";
                            break;
                        case 'auth/invalid-email':
                            errorMessage = "E-mail inválido";
                            break;
                        case 'auth/weak-password':
                            errorMessage = "Senha muito fraca (mínimo 6 caracteres)";
                            break;
                        default:
                            errorMessage = "Erro ao cadastrar: " + error.message;
                    }
                    
                    messageDiv.innerHTML = `<div class="alert alert-danger">${errorMessage}</div>`;
                    btn.innerHTML = 'Cadastrar';
                    btn.disabled = false;
                });
        });
    </script>
</body>
</html>
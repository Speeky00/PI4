<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Novo Sensor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
    <div class="container">
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="adm.php"><i class="fas fa-arrow-left"></i> Voltar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fas fa-plus-circle"></i> Cadastrar Novo Sensor</h5>
                </div>
                <div class="card-body">
                    <form id="formNovoSensor">
                        <div class="form-group">
                            <label for="nomeSensor">Nome do Sensor</label>
                            <input type="text" class="form-control" id="nomeSensor" required placeholder="Ex: Sensor de Umidade">
                        </div>
                        <div class="form-group">
                            <label for="localizacao">Localização</label>
                            <input type="text" class="form-control" id="localizacao" required placeholder="Ex: Sala de Servidores">
                        </div>
                        <div class="form-group">
                            <label for="intervaloLeitura">Intervalo de Leitura (minutos)</label>
                            <input type="number" class="form-control" id="intervaloLeitura" value="5" min="1">
                        </div>
                        <div class="form-group">
                            <label for="limiteAlerta">Limite para Alerta</label>
                            <input type="text" class="form-control" id="limiteAlerta" placeholder="Ex: 70%">
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cadastrar Sensor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>
<script>
    const firebaseConfig = {
        apiKey: "AIzaSyAGHrCKcMcOZlGcArEyCmOW4lFCnvnoNZE",
        authDomain: "testepi-e8900.firebaseapp.com",
        databaseURL: "https://testepi-e8900-default-rtdb.firebaseio.com",
        projectId: "testepi-e8900",
        storageBucket: "testepi-e8900.appspot.com",
        messagingSenderId: "194879621285",
        appId: "1:194879621285:web:f4c7b841a57bb8a6cce54c"
    };

    firebase.initializeApp(firebaseConfig);

    firebase.auth().onAuthStateChanged(user => {
        if (!user) {
            alert('Você precisa estar logado.');
            window.location.href = 'login.php';
        }
    });

    document.getElementById('formNovoSensor').addEventListener('submit', function(e) {
        e.preventDefault();

        const user = firebase.auth().currentUser;

        if(user){
            const sensorData = {
                nome: document.getElementById('nomeSensor').value,
                localizacao: document.getElementById('localizacao').value,
                intervaloLeitura: document.getElementById('intervaloLeitura').value,
                limiteAlerta: document.getElementById('limiteAlerta').value,
                dataCadastro: new Date().toISOString(),
                status: "ativo"
            };

            firebase.database().ref(`sensores/${user.uid}`).push(sensorData)
                .then(() => {
                    alert('Sensor cadastrado com sucesso!');
                    window.location.href = 'adm.php';
                })
                .catch((error) => {
                    alert('Erro ao cadastrar sensor: ' + error.message);
                });
        }else{
            alert('Erro de autenticação.');
            window.location.href = 'login.php';
        }
    });
</script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</body>
</html>
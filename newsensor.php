<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página de monitoramento de sensores">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">    <title>Monitoramento de Sensores</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div id="page content"> 
        <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="img/teste.webp" style="width: 80px" alt="img-aleatoria">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarcontent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="img/teste.webp" style="width: 40px" alt="foto do usuario" class="mr-2 rounded-circle">
                                <span>Menu</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="adm.php"><i class="fas fa-microchip mr-2"></i>Sensores</a>
                                <a class="dropdown-item" href="perfil.php"><i class="fas fa-user mr-2"></i>Perfil</a>
                                <a class="dropdown-item" href="config.php"><i class="fas fa-cog mr-2"></i>Configurações</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="index.php"><i class="fas fa-sign-out-alt mr-2"></i>Sair</a>
                            </div>
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
                            <h2 class="h5 mb-0"><i class="fas fa-plus-circle mr-2"></i>Cadastrar Novo Sensor</h2>
                        </div>
                        <div class="card-body">
                            <form id="formNovoSensor">
                                <div class="form-section">
                                    <h3 class="h5 text-primary mb-3"><i class="fas fa-info-circle mr-2"></i>Informações Básicas</h3>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nomeSensor" class="form-label required-field">Nome do Sensor</label>
                                            <input type="text" class="form-control" id="nomeSensor" required placeholder="Ex: Sensor de Umidade 01">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="localizacao" class="form-label required-field">Localização</label>
                                            <input type="text" class="form-control" id="localizacao" required placeholder="Ex: Sala de Servidores">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-section">
                                    <h3 class="h5 text-primary mb-3"><i class="fas fa-cog mr-2"></i>Configurações</h3>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="intervaloLeitura" class="form-label">Intervalo de Leitura (minutos)</label>
                                            <input type="number" class="form-control" id="intervaloLeitura" value="5" min="1">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="limiteAlerta" class="form-label">Limite para Alerta</label>
                                            <input type="text" class="form-control" id="limiteAlerta" placeholder="Ex: 70% para umidade">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-4">
                                    <a href="adm.php" class="btn btn-outline-secondary">
                                        <i class="fas fa-times mr-2"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save mr-2"></i>Cadastrar Sensor
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>
<script>
  // Sua configuração do Firebase
  const firebaseConfig = {
    apiKey: "AIzaSyAGHrCKcMcOZlGcArEyCmOW4lFCnvnoNZE",
    authDomain: "testepi-e8900.firebaseapp.com",
    databaseURL: "https://testepi-e8900-default-rtdb.firebaseio.com",
    projectId: "testepi-e8900",
    storageBucket: "testepi-e8900.firebasestorage.app",
    messagingSenderId: "194879621285",
    appId: "1:194879621285:web:f4c7b841a57bb8a6cce54c"
  };

  // Inicializa o Firebase
  firebase.initializeApp(firebaseConfig);
  const database = firebase.database();

  // Função para cadastrar sensor
  document.getElementById('formNovoSensor').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Coleta os dados do formulário
    const sensorData = {
      nome: document.getElementById('nomeSensor').value,
      localizacao: document.getElementById('localizacao').value,
      intervaloLeitura: document.getElementById('intervaloLeitura').value,
      limiteAlerta: document.getElementById('limiteAlerta').value,
      dataCadastro: new Date().toISOString() // Adicionei timestamp para registro
    };

    // Envia para o Firebase
    database.ref('sensores').push(sensorData)
      .then(() => {
        alert('Sensor cadastrado com sucesso!');
        window.location.href = 'adm.php';
      })
      .catch((error) => {
        console.error('Erro ao cadastrar:', error);
        alert('Erro ao cadastrar sensor: ' + error.message);
      });
  });
</script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
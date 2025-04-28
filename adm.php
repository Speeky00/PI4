<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página de monitoramento de sensores">
    <title>Página Inicial</title>
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
                    <h1 class="navbar-text mx-auto d-none d-md-block">Bem vindo, Fulano</h1>
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
        <div class="text-center mb-4">
    <a href="newsensor.php" class="btn btn-primary">
        <i class="fas fa-plus mr-2"></i>Novo Sensor
    </a>
</div>
<div class="row" id="sensores-container">
    <!-- Os sensores serão carregados aqui dinamicamente -->
</div>

<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>
<script>
  // Configuração do Firebase (use a mesma do seu cadastro)
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
  

  // Referência para a lista de sensores
  const sensoresRef = database.ref('sensores');

  // Função para carregar e exibir os sensores
  function carregarSensores() {
    sensoresRef.on('value', (snapshot) => {
      const sensores = snapshot.val();
      const container = document.getElementById('sensores-container');
      container.innerHTML = ''; // Limpa o container
      
      if (sensores) {
        // Para cada sensor, cria um card
        Object.keys(sensores).forEach((sensorId, index) => {
          const sensor = sensores[sensorId];
          const sensorNum = (index + 1).toString().padStart(3, '0');
          
          // Cria o HTML do card do sensor
          const cardHTML = `
    <div class="col-lg-3 col-md-6 mb-4" data-sensor-id="${sensorId}">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Sensor #${sensorNum}</h5>
                <div class="card-text">
                    <p class="mb-1"><strong>Nome:</strong> ${sensor.nome || '--'}</p>
                    <p class="mb-1">
                        <strong>Status:</strong> 
                        <span class="badge ${sensor.status === 'inativo' ? 'badge-danger' : 'badge-success'}">
                            ${sensor.status === 'inativo' ? 'Inativo' : 'Ativo'}
                        </span>
                    </p>
                    <p class="mb-1"><strong>Intervalo:</strong> ${sensor.intervaloLeitura || '--'} min</p>
                    <p class="mb-3"><strong>Localização:</strong> ${sensor.localizacao || '--'}</p>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top-0">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-outline-secondary btn-sm mx-1" 
                            onclick="toggleStatus('${sensorId}', '${sensor.status || 'ativo'}')">
                        <i class="fas fa-power-off"></i>
                    </button>
                    <button class="btn btn-outline-warning btn-sm mx-1" 
                            onclick="editarSensor('${sensorId}')">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-outline-danger btn-sm mx-1" 
                            onclick="excluirSensor('${sensorId}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
`;
          
          // Adiciona o card ao container
          container.innerHTML += cardHTML;
        });
      } else {
        container.innerHTML = '<div class="col-12 text-center"><p>Nenhum sensor cadastrado ainda.</p></div>';
      }
    });
  }

  // Funções para editar e excluir (implemente conforme necessário)
  function editarSensor(sensorId) {
    window.location.href = `editsensor.php?id=${sensorId}`;
}

  function excluirSensor(sensorId) {
    if (confirm("Tem certeza que deseja excluir este sensor?")) {
      database.ref('sensores/' + sensorId).remove()
        .then(() => {
          alert("Sensor excluído com sucesso!");
        })
        .catch((error) => {
          alert("Erro ao excluir sensor: " + error.message);
        });
    }
  }
  function toggleStatus(sensorId, currentStatus) {
    const newStatus = currentStatus === 'ativo' ? 'inativo' : 'ativo';
    
    database.ref('sensores/' + sensorId).update({
        status: newStatus,
        ultimaAtualizacao: new Date().toISOString()
    })
    .then(() => {
        // Atualiza visualmente sem recarregar
        const badge = document.querySelector(`[data-sensor-id="${sensorId}"] .badge`);
        if (badge) {
            badge.textContent = newStatus === 'ativo' ? 'Ativo' : 'Inativo';
            badge.classList.toggle('badge-success', newStatus === 'ativo');
            badge.classList.toggle('badge-danger', newStatus !== 'ativo');
        }
    })
    .catch((error) => {
        console.error("Erro ao alterar status:", error);
        alert("Erro ao alterar status do sensor");
    });
}

  // Carrega os sensores quando a página é aberta
  window.addEventListener('DOMContentLoaded', carregarSensores);
</script>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
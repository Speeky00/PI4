<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background: #f7f7f9; }
        .profile-pic { width: 150px; height: 150px; object-fit: cover; border: 4px solid #fff; box-shadow: 0 2px 8px #0001; }
        .sensor-status { width: 12px; height: 12px; border-radius: 50%; display: inline-block; margin-right: 6px; }
        .sensor-status.active { background: #28a745; }
        .sensor-status.inactive { background: #dc3545; }
    </style>
</head>
<body>
    <!-- Navbar (igual ao restante do site) -->
    <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-toggle="dropdown">
                            <img id="navProfilePic" src="" style="width: 40px; height: 40px; object-fit: cover; display: none;" class="mr-2 rounded-circle" alt="Foto do usuário">
                            <span>Menu</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="adm.php"><i class="fas fa-microchip mr-2"></i>Sensores</a>
                            <a class="dropdown-item active" href="perfil.php"><i class="fas fa-user mr-2"></i>Perfil</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="#" id="logoutBtn"><i class="fas fa-sign-out-alt mr-2"></i>Sair</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <div class="row">
            <!-- Coluna da esquerda: perfil -->
            <div class="col-md-4 text-center mb-4">
                <img id="profilePic" src="" class="rounded-circle profile-pic mb-2" alt="Imagem de perfil">
                <h3 id="userName" class="mt-2">Carregando...</h3>
                <p id="userEmail">Email: carregando...</p>
                <p id="userSince" class="text-muted" style="font-size:0.95em;">Cadastrado em: ...</p>
            </div>
            <!-- Coluna da direita: sensores -->
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-microchip mr-2"></i>Meus Sensores</h4>
                    </div>
                    <div class="card-body">
                        <p>Você tem <span id="sensorCount">0</span> sensores cadastrados:</p>
                        <ul id="sensorList"><li>Carregando...</li></ul>
                        <a href="adm.php" class="btn btn-outline-primary btn-sm mt-2"><i class="fas fa-arrow-left"></i> Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>
    <script>
        // Configuração Firebase
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
        const auth = firebase.auth();
        const database = firebase.database();

        // Atualiza o perfil do usuário
        function updateProfileInfo(user) {
            const imgUrl = user.photoURL
                ? user.photoURL
                : "https://ui-avatars.com/api/?name=" + encodeURIComponent(user.displayName || user.email);
            document.getElementById('profilePic').src = imgUrl;
            const navPic = document.getElementById('navProfilePic');
            navPic.src = imgUrl;
            navPic.style.display = "inline-block";
            document.getElementById('userName').textContent = user.displayName || user.email.split('@')[0];
            document.getElementById('userEmail').textContent = `Email: ${user.email}`;
            const creationDate = new Date(user.metadata.creationTime);
            document.getElementById('userSince').textContent = `Cadastrado em: ${creationDate.toLocaleDateString('pt-BR')}`;
        }

        // Lista só sensores do usuário logado
        function setupSensorsListener(user) {
            const sensorsRef = database.ref('sensores/' + user.uid);
            sensorsRef.on('value', (snapshot) => {
                const sensors = snapshot.val() || {};
                const count = Object.keys(sensors).length;
                document.getElementById('sensorCount').textContent = count;
                const sensorList = document.getElementById('sensorList');
                sensorList.innerHTML = '';
                if (count === 0) {
                    sensorList.innerHTML = '<li>Nenhum sensor cadastrado</li>';
                    return;
                }
                Object.entries(sensors).forEach(([id, sensor]) => {
                    const li = document.createElement('li');
                    li.innerHTML = `
                        <span class="sensor-status ${sensor.status === 'ativo' ? 'active' : 'inactive'}"></span>
                        <strong>${sensor.nome || 'Sensor sem nome'}:</strong> 
                        ${sensor.status === 'ativo' ? 'Ativo' : 'Inativo'} |
                        Local: ${sensor.localizacao || 'Não informado'} |
                        Intervalo: ${sensor.intervaloLeitura || 'N/A'} min
                    `;
                    sensorList.appendChild(li);
                });
            }, (error) => {
                document.getElementById('sensorList').innerHTML = '<li>Erro ao carregar sensores</li>';
            });
        }

        // Autenticação
        auth.onAuthStateChanged((user) => {
            if (user) {
                updateProfileInfo(user);
                setupSensorsListener(user);
            } else {
                window.location.href = 'index.php';
            }
        });

        // Logout
        document.getElementById('logoutBtn').addEventListener('click', function(e) {
            e.preventDefault();
            auth.signOut().then(() => window.location.href = 'index.php');
        });
    </script>
</body>
</html>

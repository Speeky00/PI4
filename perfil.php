<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página de perfil do usuário">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .profile-pic-container {
            position: relative;
            display: inline-block;
        }
        .profile-pic-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0,0,0,0.5);
            color: white;
            padding: 5px;
            text-align: center;
            opacity: 0;
            transition: opacity 0.3s;
            border-bottom-left-radius: 50%;
            border-bottom-right-radius: 50%;
        }
        .profile-pic-container:hover .profile-pic-overlay {
            opacity: 1;
        }
        .upload-progress {
            height: 5px;
            margin-top: 10px;
        }
        .card-header h4 {
            margin-bottom: 0;
        }
        .sensor-status {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }
        .sensor-status.active {
            background-color: #28a745;
        }
        .sensor-status.inactive {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div id="page-content"> 
        <!-- Navbar (mantido igual) -->
        <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="img/teste.webp" style="width: 80px" alt="Logo do Sistema">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarcontent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img id="navProfilePic" src="img/placeholder-user.png" style="width: 40px; height: 40px; object-fit: cover;" alt="foto do usuario" class="mr-2 rounded-circle">
                                <span>Menu</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="adm.php"><i class="fas fa-microchip mr-2"></i>Sensores</a>
                                <a class="dropdown-item" href="perfil.php"><i class="fas fa-user mr-2"></i>Perfil</a>
                                <a class="dropdown-item" href="config.php"><i class="fas fa-cog mr-2"></i>Configurações</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#" id="logoutBtn"><i class="fas fa-sign-out-alt mr-2"></i>Sair</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Conteúdo do Perfil do Usuário -->
        <main class="container py-5">
            <div class="row">
                <!-- Foto de perfil (mantido igual) -->
                <div class="col-md-4 text-center">
                    <div class="profile-pic-container">
                        <img id="profilePic" src="img/placeholder-user.png" class="rounded-circle img-fluid" style="width: 150px; height: 150px; object-fit: cover;" alt="Imagem de perfil">
                        <div class="profile-pic-overlay">Alterar Foto</div>
                    </div>
                    <h3 id="userName" class="mt-3">Carregando...</h3>
                    <p id="userEmail">Email: carregando...</p>
                    <p id="userSince">Cadastrado em: carregando...</p>

                    <!-- Formulário para upload de foto (mantido igual) -->
                    <form id="uploadForm" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="uploadProfilePic" class="btn btn-primary">
                                <i class="fas fa-camera mr-2"></i>Alterar Foto
                            </label>
                            <input type="file" class="form-control-file" id="uploadProfilePic" name="profileImage" style="display:none;" accept="image/*">
                            <div class="upload-progress d-none" id="uploadProgress">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="text-muted">Enviando...</small>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success d-none" id="submitUpload">Enviar</button>
                    </form>
                </div>

                <!-- Informações do usuário -->
                <div class="col-md-8">
                    <!-- Primeiro card (mantido igual) -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-primary text-white">
                            <h4><i class="fas fa-user-circle mr-2"></i>Informações do Usuário</h4>
                        </div>
                        <div class="card-body">
                            <h5><i class="fas fa-cogs mr-2"></i>Preferências</h5>
                            <ul>
                                <li><strong>Frequência de alertas:</strong> A cada 5 minutos</li>
                                <li><strong>Notificações por e-mail:</strong> Ativadas</li>
                                <li><strong>Unidade de Medição:</strong> % de umidade</li>
                            </ul>

                            <h5 class="mt-4"><i class="fas fa-bell mr-2"></i>Alertas Recentes</h5>
                            <ul>
                                <li>Sensor de Umidade 01: Alerta em 75% (23/04/2025)</li>
                                <li>Sensor de Temperatura 02: Alerta em 30ºC (22/04/2025)</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Card de Sensores (atualizado para sincronização) -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-primary text-white">
                            <h4><i class="fas fa-microchip mr-2"></i>Sensores Cadastrados</h4>
                        </div>
                        <div class="card-body">
                            <p>Você tem <span id="sensorCount">0</span> sensores cadastrados. Confira o status abaixo:</p>
                            <ul id="sensorList">
                                <li>Carregando sensores...</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Terceiro card (mantido igual) -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-primary text-white">
                            <h4><i class="fas fa-lock mr-2"></i>Segurança da Conta</h4>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-warning" data-toggle="modal" data-target="#changePasswordModal"><i class="fas fa-key mr-2"></i>Alterar Senha</button>
                        </div>
                    </div>

                    <!-- Modal para alteração de senha (mantido igual) -->
                    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="changePasswordModalLabel">Alterar Senha</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="changePasswordForm">
                                        <div class="form-group">
                                            <label for="newPassword">Nova Senha</label>
                                            <input type="password" class="form-control" id="newPassword" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="confirmNewPassword">Confirmar Nova Senha</label>
                                            <input type="password" class="form-control" id="confirmNewPassword" required>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>

    <script>
    // Configuração do Firebase (mantida igual)
    const firebaseConfig = {
        apiKey: "AIzaSyAGHrCKcMcOZlGcArEyCmOW4lFCnvnoNZE",
        authDomain: "testepi-e8900.firebaseapp.com",
        databaseURL: "https://testepi-e8900-default-rtdb.firebaseio.com",
        projectId: "testepi-e8900",
        storageBucket: "testepi-e8900.appspot.com",
        messagingSenderId: "194879621285",
        appId: "1:194879621285:web:f4c7b841a57bb8a6cce54c"
    };

    // Inicializa o Firebase
    firebase.initializeApp(firebaseConfig);
    const auth = firebase.auth();
    const database = firebase.database();

    // Monitora estado de autenticação
    auth.onAuthStateChanged((user) => {
        if (user) {
            // Atualiza informações básicas do usuário
            document.getElementById('userName').textContent = user.displayName || user.email.split('@')[0];
            document.getElementById('userEmail').textContent = `Email: ${user.email}`;
            
            const creationDate = new Date(user.metadata.creationTime);
            document.getElementById('userSince').textContent = `Cadastrado em: ${creationDate.toLocaleDateString('pt-BR')}`;
            
            // Carrega foto de perfil
            loadProfilePicture(user.uid);
            
            // Configura listener para TODOS os sensores (sem filtro por userId)
            setupSensorsListener();
        } else {
            window.location.href = 'index.php';
        }
    });

    // Função para configurar o listener dos sensores
    function setupSensorsListener() {
        // Referência para TODOS os sensores (não filtramos por userId)
        const sensorsRef = database.ref('sensores');
        
        // Listener para mudanças em tempo real
        sensorsRef.on('value', (snapshot) => {
            const sensors = snapshot.val() || {};
            const count = Object.keys(sensors).length;
            
            // Atualiza contagem
            document.getElementById('sensorCount').textContent = count;
            
            // Atualiza lista
            const sensorList = document.getElementById('sensorList');
            sensorList.innerHTML = '';
            
            if (count === 0) {
                sensorList.innerHTML = '<li>Nenhum sensor cadastrado</li>';
                return;
            }
            
            // Adiciona cada sensor à lista
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
            console.error("Erro ao carregar sensores:", error);
            document.getElementById('sensorList').innerHTML = '<li>Erro ao carregar sensores</li>';
        });
    }

    // Função para carregar foto de perfil
    function loadProfilePicture(userId) {
        fetch(`img/profile_${userId}.jpg?${new Date().getTime()}`)
            .then(response => {
                const profilePic = document.getElementById('profilePic');
                const navProfilePic = document.getElementById('navProfilePic');
                
                if (response.ok) {
                    profilePic.src = `img/profile_${userId}.jpg?${new Date().getTime()}`;
                    navProfilePic.src = `img/profile_${userId}.jpg?${new Date().getTime()}`;
                } else {
                    profilePic.src = "img/placeholder-user.png";
                    navProfilePic.src = "img/placeholder-user.png";
                }
            })
            .catch(() => {
                document.getElementById('profilePic').src = "img/placeholder-user.png";
                document.getElementById('navProfilePic').src = "img/placeholder-user.png";
            });
    }

    // Configura o evento de clique para o botão de logout
    document.getElementById('logoutBtn').addEventListener('click', function(e) {
        e.preventDefault(); // Impede o comportamento padrão do link
        
        // Faz o logout no Firebase
        auth.signOut().then(() => {
            // Redireciona para a página de login após logout
            window.location.href = 'index.php';
        }).catch((error) => {
            console.error("Erro ao fazer logout:", error);
            alert("Ocorreu um erro ao tentar sair. Por favor, tente novamente.");
        });
    });
</script>
</body>
</html>
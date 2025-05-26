<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoramento de Sensores</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <h1 class="navbar-text mx-auto d-none d-md-block" id="bemVindo">Bem vindo</h1>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-toggle="dropdown">
                            <img id="userPhoto" src="" style="width: 40px; display: none;" class="mr-2 rounded-circle" alt="Foto do usuário">
                            <span>Menu</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="adm.php"><i class="fas fa-microchip"></i> Sensores</a>
                            <a class="dropdown-item" href="perfil.php"><i class="fas fa-user"></i> Perfil</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Sair</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <div class="text-center mb-4">
            <a href="newsensor.php" class="btn btn-primary"><i class="fas fa-plus"></i> Novo Sensor</a>
        </div>
        <div class="row" id="sensores-container"></div>
    </main>

    <!-- Firebase e dependências -->
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
            if (user) {
                document.getElementById('bemVindo').innerText = `Bem vindo, ${user.email}`;
                const img = document.getElementById('userPhoto');
                if (user.photoURL) {
                    img.src = user.photoURL;
                } else {
                    img.src = "https://ui-avatars.com/api/?name=" + encodeURIComponent(user.email);
                }
                img.style.display = "inline-block";

                const sensoresRef = firebase.database().ref(`sensores/${user.uid}`);
                sensoresRef.on('value', snapshot => {
                    const sensores = snapshot.val();
                    const container = document.getElementById('sensores-container');
                    container.innerHTML = '';

                    if (sensores) {
                        Object.keys(sensores).forEach((id, index) => {
                            const s = sensores[id];
                            container.innerHTML += `
                                <div class="col-lg-3 col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">${s.nome || '--'}</h5>
                                            <p><strong>Status:</strong> <span class="badge badge-${s.status==='inativo'?'danger':'success'}">${s.status||'Ativo'}</span></p>
                                            <p><strong>Localização:</strong> ${s.localizacao||'--'}</p>
                                            <p><strong>Umidade:</strong> ${typeof s.umidade !== "undefined" ? s.umidade + '%' : '--'}</p>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button class="btn btn-sm btn-secondary" onclick="toggleStatus('${user.uid}','${id}','${s.status}')"><i class="fas fa-power-off"></i></button>
                                            <button class="btn btn-sm btn-warning" onclick="editarSensor('${id}')"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-danger" onclick="excluirSensor('${user.uid}','${id}')"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>`;
                        });
                    } else {
                        container.innerHTML = '<div class="col text-center">Nenhum sensor cadastrado ainda.</div>';
                    }
                });
            } else {
                window.location.href = 'index.php';
            }
        });

        function logout(){ firebase.auth().signOut().then(()=>window.location='index.php'); }
        function editarSensor(id){ window.location=`editsensor.php?id=${id}`; }
        function excluirSensor(uid,id){ firebase.database().ref(`sensores/${uid}/${id}`).remove(); }
        function toggleStatus(uid,id,status){
            const novoStatus=status==='ativo'?'inativo':'ativo';
            firebase.database().ref(`sensores/${uid}/${id}`).update({status:novoStatus});
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>

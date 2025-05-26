<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Sensor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fas fa-edit"></i> Editar Sensor</h5>
                </div>
                <div class="card-body">
                    <form id="formEditarSensor">
                        <input type="hidden" id="sensorId" value="<?= htmlspecialchars($_GET['id'] ?? '') ?>">
                        <div class="form-group">
                            <label for="editNomeSensor">Nome do Sensor</label>
                            <input type="text" class="form-control" id="editNomeSensor" required>
                        </div>
                        <div class="form-group">
                            <label for="editLocalizacao">Localização</label>
                            <input type="text" class="form-control" id="editLocalizacao" required>
                        </div>
                        <div class="form-group">
                            <label for="editStatus">Status</label>
                            <select class="form-control" id="editStatus">
                                <option value="ativo">Ativo</option>
                                <option value="inativo">Inativo</option>
                            </select>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Salvar</button>
                            <a href="adm.php" class="btn btn-secondary ml-2"><i class="fas fa-times"></i> Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
        alert('Faça login para acessar esta página.');
        window.location.href = 'login.php';
        return;
    }

    const uid = user.uid;
    const sensorId = document.getElementById('sensorId').value;

    if (!sensorId) {
        alert('Sensor não especificado!');
        window.location.href = 'adm.php';
        return;
    }

    const sensorRef = firebase.database().ref(`sensores/${uid}/${sensorId}`);

    sensorRef.once('value').then(snapshot => {
        const sensor = snapshot.val();
        if (sensor) {
            document.getElementById('editNomeSensor').value = sensor.nome || '';
            document.getElementById('editLocalizacao').value = sensor.localizacao || '';
            document.getElementById('editStatus').value = sensor.status || 'ativo';
        } else {
            alert('Sensor não encontrado!');
            window.location.href = 'adm.php';
        }
    });

    document.getElementById('formEditarSensor').addEventListener('submit', e => {
        e.preventDefault();

        const dadosAtualizados = {
            nome: document.getElementById('editNomeSensor').value,
            localizacao: document.getElementById('editLocalizacao').value,
            status: document.getElementById('editStatus').value,
            ultimaAtualizacao: new Date().toISOString()
        };

        sensorRef.update(dadosAtualizados).then(() => {
            alert('Sensor atualizado com sucesso!');
            window.location.href = 'adm.php';
        }).catch(err => alert('Erro: ' + err.message));
    });
});
</script>

</body>
</html>

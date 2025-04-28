<?php
// Verifica se o ID do sensor foi passado
$sensorId = $_GET['id'] ?? null;
if (!$sensorId) {
    header('Location: adm.php');
    exit;
}
?>

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
                        <h2 class="h5 mb-0"><i class="fas fa-edit mr-2"></i>Editar Sensor</h2>
                    </div>
                    <div class="card-body">
                        <form id="formEditarSensor">
                            <input type="hidden" id="sensorId" value="<?= htmlspecialchars($sensorId) ?>">
                            
                            <div class="form-section">
                                <h3 class="h5 text-primary mb-3"><i class="fas fa-info-circle mr-2"></i>Informações Básicas</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="editNomeSensor" class="form-label">Nome do Sensor</label>
                                        <input type="text" class="form-control" id="editNomeSensor" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="editLocalizacao" class="form-label">Localização</label>
                                        <input type="text" class="form-control" id="editLocalizacao" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <h3 class="h5 text-primary mb-3"><i class="fas fa-cog mr-2"></i>Configurações</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="editIntervaloLeitura" class="form-label">Intervalo de Leitura (minutos)</label>
                                        <input type="number" class="form-control" id="editIntervaloLeitura" min="1">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="editLimiteAlerta" class="form-label">Limite para Alerta</label>
                                        <input type="text" class="form-control" id="editLimiteAlerta">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="editStatus" class="form-label">Status</label>
                                        <select class="form-control" id="editStatus" required>
                                            <option value="ativo">Ativo</option>
                                            <option value="inativo">Inativo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <a href="adm.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-times mr-2"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-2"></i>Salvar Alterações
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Firebase e scripts -->
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>
    <script>
        // Configuração do Firebase (use a mesma do seu projeto)
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

        // Quando o DOM estiver carregado
        document.addEventListener('DOMContentLoaded', function() {
            const sensorId = document.getElementById('sensorId').value;
            
            // Carrega os dados do sensor
            database.ref('sensores/' + sensorId).once('value')
                .then((snapshot) => {
                    const sensor = snapshot.val();
                    if (sensor) {
                        document.getElementById('editNomeSensor').value = sensor.nome || '';
                        document.getElementById('editLocalizacao').value = sensor.localizacao || '';
                        document.getElementById('editIntervaloLeitura').value = sensor.intervaloLeitura || '5';
                        document.getElementById('editLimiteAlerta').value = sensor.limiteAlerta || '';
                    } else {
                        alert('Sensor não encontrado!');
                        window.location.href = 'adm.php';
                    }
                })
                .catch((error) => {
                    console.error('Erro ao carregar sensor:', error);
                    alert('Erro ao carregar dados do sensor');
                });

            // Formulário de edição
            document.getElementById('formEditarSensor').addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Coleta os dados do formulário
                const sensorData = {
                    nome: document.getElementById('editNomeSensor').value,
                    localizacao: document.getElementById('editLocalizacao').value,
                    intervaloLeitura: document.getElementById('editIntervaloLeitura').value,
                    limiteAlerta: document.getElementById('editLimiteAlerta').value,
                    status: document.getElementById('editStatus').value, // Novo campo
                    ultimaAtualizacao: new Date().toISOString()
                };

                // Atualiza no Firebase
                database.ref('sensores/' + sensorId).update(sensorData)
                    .then(() => {
                        alert('Sensor atualizado com sucesso!');
                        window.location.href = 'adm.php';
                    })
                    .catch((error) => {
                        console.error('Erro ao atualizar sensor:', error);
                        alert('Erro ao atualizar sensor: ' + error.message);
                    });
            });
        });
    </script>
</body>
</html>
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
                    <h1 class="navbar-text mx-auto d-none d-md-block">Bem vindo, Fulano</h1>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="img/teste.webp" style="width: 40px" alt="foto do usuario" class="mr-2 rounded-circle">
                                <span>Menu</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
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
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Sensor #001</h5>
                            <div class="card-text">
                                <p class="mb-1"><strong>Status:</strong>Ativo</p>
                                <p class="mb-1"><strong>Umidade:</strong>65%</p>
                                <p class="mb-3"><strong>localização:</strong>Sala 1</p>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-outline-warning btn-sm mx-1">Editar</button>
                                <button class="btn btn-outline-danger btn-sm mx-1">Apagar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Sensor #002</h5>
                            <div class="card-text">
                                <p class="mb-1"><strong>Status:</strong>Inativo</p>
                                <p class="mb-1"><strong>Umidade:</strong>--</p>
                                <p class="mb-3"><strong>localização:</strong>Sala 2</p>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-outline-warning btn-sm mx-1">Editar</button>
                                <button class="btn btn-outline-danger btn-sm mx-1">Apagar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Sensor #003</h5>
                            <div class="card-text">
                                <p class="mb-1"><strong>Status:</strong>Ativo</p>
                                <p class="mb-1"><strong>Umidade:</strong>72%</p>
                                <p class="mb-3"><strong>localização:</strong>Corredor</p>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-outline-warning btn-sm mx-1">Editar</button>
                                <button class="btn btn-outline-danger btn-sm mx-1">Apagar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
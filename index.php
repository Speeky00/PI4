<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
    <div id="page-content">
        <div class="container-fluid text-center my-5">
            <img src="img/teste.webp" class="rounded-circle img-fluid" style="width: 200px; height: 200px; object-fit: cover;" alt="Imagem redonda">
        </div>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <h1><center>Bem Vindo</center></h1>
            </div>  
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col md-5 mx-auto justify-content-center"><center>
                    <form action="adm.php" method="POST">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control col-3" style="border-color:black;" id="email" name="email"><br>
                        </div>
                        <div class="form-group">
                            <label for="senha">Password</label>
                             <input type= "password" class="form-control col-3" style="border-color:black" id="senha" name="senha"><br>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-dark">Entrar</button>
                        </div>
                    </form>
                </center></div>
            </div>
        </div>
    </div>
</body>
</html>
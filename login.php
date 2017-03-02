<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Iniciar Sesión Ventor</title>
    <link rel="icon" type="image/png" href="images/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="images/favicon-16x16.png" sizes="16x16">
    <link rel="stylesheet" href="css/united.min.css">
    <link rel="stylesheet" href="css/sweetalert.css">

    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
        <div class="card card-container">
<!--            <div class="titulo">Iniciar Sesión</div>-->
            <img id="profile-img" class="profile-img-card" src="images/logo.png" />
            <p id="profile-name" class="profile-name-card">VENTOR</p>
            <form class="form-signin">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" id="tbUsuario" class="form-control" placeholder="Usuario" required autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" id="tbClave" class="form-control" placeholder="Contraseña" required>
                    </div>
                </div>
                <button class="btn btn-primary btn-block btn-signin" type="button" id="btnIniciar">Iniciar Sesión</button>
            </form>
        </div>
    </div>

    <script src="js/jquery-1.12.0.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script src="js/bootbox.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/waitme.min.js"></script>

    <script src="js/login.js"></script>
</body>
</html>
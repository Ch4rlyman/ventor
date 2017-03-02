<?php
    include_once("validar.php");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php include_once ("sis_css.php") ?>
        <title>VENTOR</title>
    </head>

    <body>
        <?php include_once ("sis_menu.php") ?>

        <div class="container-fluid" style="padding: 80px 18px 0 18px;">

            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="glyphicon glyphicon-usd"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Venta Diaria</span>
                            <span class="info-box-cantidad">12</span>
                            <span class="info-box-number"><b class="soles">95.60</b></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="glyphicon glyphicon-calendar"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Venta del Mes</span>
                            <span class="info-box-cantidad">421</span>
                            <span class="info-box-number"><b class="soles">7,245.30</b></span>
                        </div>
                    </div>
                </div>

                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="glyphicon glyphicon-tag"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Productos</span>
                            <span class="info-box-number">760</span>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="glyphicon glyphicon-user"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Clientes</span>
                            <span class="info-box-number">2,000</span>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
        </div>

        <?php include_once "sis_js.php" ?>

        <script src="js/index.js"></script>
    </body>
</html>

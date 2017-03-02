<nav class="navbar navbar-default  navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php" style="text-transform: uppercase"><?php echo $_SESSION["cfg"]["nombre"]; ?></a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
            <ul class="nav navbar-nav">
                <li class="active"><a href="vender.php">Vender</a></li>
                <?php if ($_SESSION["tipo"]=="ADMIN"){ ?>
                    <li><a href="alertas.php">Alertas</a></li>
                    <li><a href="ventas.php">Ventas</a></li>
                    <li><a href="compras.php">Compras</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Maestras <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="marcas.php">Marcas</a></li>
                            <li><a href="categorias.php">Categorias</a></li>
                            <li><a href="productos.php">Productos</a></li>
                            <li class="divider"></li>
                            <li><a href="clientes.php">Clientes</a></li>
                            <li><a href="proveedores.php">Proveedores</a></li>
                            <li class="divider"></li>
                            <li><a href="usuarios.php">Usuarios</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Reportes <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="productos.html">Ventas</a></li>
                            <li><a href="#">Compras</a></li>
                            <li><a href="#">Mejores Clientes</a></li>
                            <li><a href="#">Mejores Vendedores</a></li>
                            <li><a href="#">Productos más vendidos</a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <span class="glyphicon glyphicon-user" style="margin-right: 8px"></span>
                        <span id="lblUsuario"> <?php echo $_SESSION["nombre"] ?> </span>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <?php if ($_SESSION["tipo"]=="ADMIN"){ ?>
                        <li><a data-toggle="modal" data-target="#vConfig"><span class="glyphicon glyphicon-cog"></span> Configuración</a></li>
                        <li class="divider"></li>
                        <?php } ?>
                        <li><a id="btnCambiarClave" data-toggle="modal" data-target="#vClave"><span class="glyphicon glyphicon-lock"></span> Cambiar Contraseña</a></li>
                        <li><a id="btnCerrarSesion"><span class="glyphicon glyphicon-off"></span> Cerrar Sesión</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div id="vConfig" class="modal fade" data-keyboard="true" data-backdrop="false" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Configuración</h4>
            </div>
            <div class="modal-body">
                <form id="fConfig" class="form-horizontal" data-toggle="validator">
                    <div class="form-group">
                        <label for="tbRazon" class="col-sm-4 control-label">Razón Social</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="tbRazon" name="razon_social" maxlength="200" value="<?php echo $_SESSION["cfg"]["razon_social"]; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tbNombre" class="col-sm-4 control-label">Nombre Comercial</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="tbNombre" name="nombre" required="true" maxlength="200" value="<?php echo $_SESSION["cfg"]["nombre"]; ?>" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tbRuc" class="col-sm-4 control-label">R.U.C.</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="tbRuc" name="ruc" required="true" maxlength="11" style="width: 130px;" value="<?php echo $_SESSION["cfg"]["ruc"]; ?>" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tbRep" class="col-sm-4 control-label">Representante</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="tbRepresentante" name="representante" maxlength="40" value="<?php echo $_SESSION["cfg"]["representante"]; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tbCorreo" class="col-sm-4 control-label">Correo</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="tbCorreo" name="correo"  maxlength="40" value="<?php echo $_SESSION["cfg"]["correo"]; ?>" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tbIgv" class="col-sm-4 control-label">I.G.V.</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control text-center" id="tbIgv" name="igv" required="true" maxlength="2" style="width: 65px; display: inline-block"  value="<?php echo $_SESSION["cfg"]["igv"]; ?>" /> %
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-6 text-left">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                    <div class="col-xs-6">
                        <button type="button" id="btnGuardarConfig" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="vClave" class="modal fade" data-keyboard="true" data-backdrop="false" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cambiar Contraseña</h4>
            </div>
            <div class="modal-body">
                <form id="f_cambiarClave" class="form-horizontal">
                    <div class="form-group">
                        <label for="tbUsuario" class="col-sm-4 control-label">Usuario</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="tbUsuario" name="usuario" readonly="readonly" value="<?php echo $_SESSION['usuario'] ; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tbClaveActual" class="col-sm-4 control-label">Contraseña Actual</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="tbClaveActual" name="claveactual" required="true" maxlength="40" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tbClaveNueva" class="col-sm-4 control-label">Nueva Contraseña </label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="tbClaveNueva" name="clavenueva" required="true" maxlength="40" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tbClaveRepetida" class="col-sm-4 control-label" style="font-size: .9em">Repetir Contraseña</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="tbClaveRepetida" required="true" maxlength="40" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-6 text-left">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                    <div class="col-xs-6">
                        <button type="button" id="btnGuardarClave" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
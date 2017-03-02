<?php
    include_once("validar.php");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php include_once ("sis_css.php") ?>
        <title>Usuarios</title>
    </head>

    <body>
        <?php include_once ("sis_menu.php") ?>

        <div class="container-fluid">
            <div class="well well-sm tituloPag">Usuarios</div>
            <table id="dtUsuario" class="table table-condensed table-hover" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div id="mUsuario" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="fUsuario" class="form-horizontal">
                            <div class="form-group">
                                <label for="tbNombreUsuario" class="col-sm-3 control-label">Nombre</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="tbNombreUsuario" name="nombre" maxlength="150" required>
                                    <input type="hidden" class="form-control" id="tbId" name="id">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tbUsuarioUsuario" class="col-sm-3 control-label">Usuario</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="tbUsuarioUsuario" name="usuario" maxlength="20" required data-remote="">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tbClave" class="col-sm-3 control-label">Clave</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="tbClave" name="clave">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cbTipo" class="col-sm-3 control-label">Tipo</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="cbTipo" name="tipo">
                                        <option value="ADMIN">ADMIN</option>
                                        <option value="VENTAS">VENTAS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="chbEstado" class="col-sm-3 control-label">Estado</label>
                                <div class="col-sm-9">
                                    <div class="checkbox">
                                        <label> <input type="checkbox" id="chbEstado" name="estado" checked="checked" value="1"> Activo</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-xs-6 text-left">
                                <button type="reset" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            </div>
                            <div class="col-xs-6">
                                <button type="button" id="btnGuardarUsuario" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $dataTable = true; include_once "sis_js.php" ?>

        <script src="js/usuarios.js"></script>
    </body>
</html>

<?php
    include_once("validar.php");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php include_once ("sis_css.php") ?>
        <title>Proveedors</title>
    </head>

    <body>
        <?php include_once ("sis_menu.php") ?>

        <div class="container-fluid">
            <div class="well well-sm tituloPag">Proveedores</div>
            <table id="dtProveedor" class="table table-condensed table-hover" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Razon Social</th>
                    <th>RUC</th>
                    <th>Representante</th>
                    <th>Telefono</th>
                    <th>Dirección</th>
                    <th>Correo</th>
                    <th>Web</th>
                    <th></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>

        </div>

        <div id="mProveedor" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="fProveedor" class="form-horizontal" data-toggle="validator">
                            <div class="form-group">
                                <label for="tbRucPro" class="col-sm-3 control-label">RUC</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="tbRucPro" name="ruc" maxlength="11" style="width: 45%" data-minlength="11" data-minlength-error="El RUC debe tener 11 digitos" required data-remote="">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tbRazonSocial" class="col-sm-3 control-label">Nombre</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="tbRazonSocial" name="razon_social" maxlength="250" required >
                                    <input type="hidden" class="form-control" id="tbId" name="id">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tbRepresentantePro" class="col-sm-3 control-label">Representante</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="tbRepresentantePro" name="representante" maxlength="200" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tbTelefonoPro" class="col-sm-3 control-label">Teléfono</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="tbTelefonoPro" name="telefono" maxlength="50" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tbDireccionPro" class="col-sm-3 control-label">Dirección</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="tbDireccionPro" name="direccion" maxlength="200" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tbCorreoPro" class="col-sm-3 control-label">Correo</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="tbCorreoPro" name="correo" maxlength="200" >
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tbWebPro" class="col-sm-3 control-label">Web</label>
                                <div class="col-sm-9">
                                    <input type="url" class="form-control" id="tbWebPro" name="web" maxlength="200" >
                                    <div class="help-block with-errors"></div>
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
                                <button type="button" id="btnGuardarProveedor" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $dataTable = true; include_once "sis_js.php" ?>

        <script src="js/proveedores.js"></script>
    </body>
</html>

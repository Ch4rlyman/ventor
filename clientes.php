<?php
    include_once("validar.php");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php include_once ("sis_css.php") ?>
        <title>Clientes</title>
    </head>

    <body>
        <?php include_once ("sis_menu.php") ?>

        <div class="container-fluid">
            <div class="well well-sm tituloPag">Clientes</div>
            <table id="dtCliente" class="table table-condensed table-hover" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>RUC</th>
                    <th>Sexo</th>
                    <th>Telefono</th>
                    <th>Dirección</th>
                    <th>Correo</th>
                    <th>nombres</th>
                    <th>paterno</th>
                    <th>materno</th>
                    <th>Correo</th>
                    <th></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>

        </div>

        <div id="mCliente" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <style>
                            @media (min-width: 768px) {
                                #mCliente .form-group{
                                    margin-left: 0;
                                    margin-right: 0;
                                }
                            }
                        </style>
                        <form id="fCliente" class="form-horizontal" data-toggle="validator">
                            <section id="sPersona">
                                <div class="form-group">
                                    <label for="tbDniCli" class="col-sm-2 control-label">DNI</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="tbDniCli" name="dni" maxlength="8" required data-minlength="8" data-minlength-error="El DNI debe tener 8 digitos">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tbNombreCli" class="col-sm-2 control-label">Nombres</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="tbNombresCli" name="nombres" maxlength="100" required >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="fila">
                                    <label for="tbPaternoCli" class="col-sm-2 control-label">Apellidos</label>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <input type="text" id="tbPaternoCli" name="paterno" class="form-control" placeholder="Paterno" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <input type="text" id="tbMaternoCli" name="materno" class="form-control" placeholder="Materno" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="rbSexo" class="col-sm-2 control-label">Sexo</label>
                                    <div class="col-sm-10">
                                        <label class="radio-inline" for="rbMasculinoCli">
                                            <input type="radio" id="rbMasculinoCli" name="sexo" value="M" checked="checked"> Masculino
                                        </label>
                                        <label class="radio-inline" for="rbFemeninoCli">
                                            <input type="radio" id="rbFemeninoCli" name="sexo" value="F"> Femenino
                                        </label>
                                    </div>
                                </div>
                            </section>
                            <section id="sEmpresa">
                                <div class="form-group">
                                    <label for="tbRucCli" class="col-sm-2 control-label">RUC</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="tbRucCli" name="ruc" maxlength="11" required data-minlength="11" data-minlength-error="El RUC debe tener 11 digitos">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tbRazonSocCli" class="col-sm-2 control-label">Razón Social</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="tbRazonSocCli" name="razon_social" maxlength="250" required >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </section>
                            <div class="form-group">
                                <label for="tbDireccionCli" class="col-sm-2 control-label">Teléfono</label>
                                <div class="col-sm-5">
                                    <input type="text" id="tbTelefonoCli" name="telefono" class="form-control">
                                    <input type="hidden" class="form-control" id="tbId" name="id">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tbDireccionCli" class="col-sm-2 control-label">Dirección</label>
                                <div class="col-sm-10">
                                    <input type="text" id="tbDireccionCli" name="direccion" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tbDCorreoCli" class="col-sm-2 control-label">Correo</label>
                                <div class="col-sm-10">
                                    <input type="email" id="tbCorreoCli" name="correo" class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-xs-6 text-left">
                                <button type="reset" class="btn btn-default" data-dismiss="modal" tabindex="-1">Cancelar</button>
                            </div>
                            <div class="col-xs-6">
                                <button type="button" id="btnGuardarCliente" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $dataTable = true; include_once "sis_js.php" ?>

        <script src="js/clientes.js"></script>
    </body>
</html>

<?php
    include_once("validar.php");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php include_once ("sis_css.php") ?>
        <title>Marcas</title>
    </head>

    <body>
        <?php include_once ("sis_menu.php") ?>

        <div class="container-fluid">
            <div class="well well-sm tituloPag">Marcas</div>

            <table id="dtMarca" class="table table-condensed table-hover" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Marca</th>
                    <th>Abreviatura</th>
                    <th></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div id="mMarcas" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Marcas</h4>
                    </div>
                    <div class="modal-body">
                        <form id="fMarca" class="form-horizontal"  data-toggle="validator">
                            <div class="form-group">
                                <label for="tbNombreMarca" class="col-sm-3 control-label">Nombre</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="tbNombreMarca" name="nombre" maxlength="200" required data-remote="">
                                    <input type="hidden" class="form-control" id="tbId" name="id">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tbAbreviatura" class="col-sm-3 control-label">Abreviatura</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="tbAbreviatura" name="abreviatura" data-remote="">
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
                                <button type="button" id="btnGuardarMarca" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $dataTable = true; include_once "sis_js.php" ?>

        <script src="js/marcas.js"></script>
    </body>
</html>

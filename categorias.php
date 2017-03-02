<?php include_once("validar.php"); ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php include_once ("sis_css.php") ?>
        <title>Categorias</title>
    </head>

    <body>
        <?php include_once ("sis_menu.php") ?>

        <div class="container-fluid">
            <div class="well well-sm tituloPag">Categorías</div>
            <table id="dtCategoria" class="table table-condensed table-hover" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Marca</th>
                        <th>Descripción</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div id="mCategoria" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="fCategoria" class="form-horizontal" >
                            <div class="form-group">
                                <label for="tbNombreCategoria" class="col-sm-3 control-label">Nombre</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="tbNombreCategoria" name="nombre" maxlength="200" required>
                                    <input type="hidden" class="form-control" id="tbId" name="id">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tbDescripcion" class="col-sm-3 control-label">Descripción</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="tbDescripcion" name="descripcion">
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
                                <button type="button" id="btnGuardarCategoria" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $dataTable = true; include_once "sis_js.php" ?>

        <script src="js/categorias.js"></script>
    </body>
</html>

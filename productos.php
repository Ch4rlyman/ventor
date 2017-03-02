<?php
    include_once("validar.php");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php include_once ("sis_css.php") ?>
        <title>Productos</title>
    </head>

    <body>
        <?php include_once ("sis_menu.php") ?>

        <div class="container-fluid">
            <div class="well well-sm tituloPag">Productos</div>

            <table id="dtProducto" class="table table-condensed table-hover" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Max Desc</th>
                    <th>Stock</th>
                    <th>Stock Min.</th>
                    <th>unidad_id</th>
                    <th>Unid Med</th>
                    <th>marca_id</th>
                    <th>Marca</th>
                    <th>categoria_id</th>
                    <th>Categoria</th>
                    <th></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>

        </div>

        <div id="mProducto" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="fProducto" class="form-horizontal" data-toggle="validator">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="tbCodigoPro">Código Barras</label>
                                <div class="col-md-9">
                                    <input  type="text" class="form-control" id="tbCodigoPro" name="codigo" style="width: 165px">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="tbNombrePro">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="tbNombrePro" name="nombre" required>
                                    <input type="hidden" id="tbId" name="id">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="tbStockMinPro">Stock Mín</label>
                                <div class="col-md-4">
                                    <input  type="text" class="form-control" id="tbStockMinPro" name="stock_min" pattern="^[1-9][0-9]*$" data-pattern-error="Debe ser mayor a cero" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <label class="col-md-2 control-label" for="tbStockPro">Stock</label>
                                <div class="col-md-3">
                                    <input  type="text" class="form-control" id="tbStockPro" readonly tabindex="-1">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="cbUnidadPro">Unidad Medida</label>
                                <div class="col-md-9">
                                    <select id="cbUnidadPro" name="unidad_medida_id" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="tbMarcaPro">Marca</label>
                                <div class="col-md-9">
                                    <input  type="text" class="form-control" id="tbMarcaPro" required>
                                    <input type="hidden" id="tbhMarcaPro" name="marca_id">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="tbCategoriaPro">Categoria</label>
                                <div class="col-md-9">
                                    <input  type="text" class="form-control" id="tbCategoriaPro" required>
                                    <input type="hidden" id="tbhCategoriaPro" name="categoria_id">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="tbPrecioPro">Precio</label>
                                <div class="col-md-4">
                                    <input  type="text" min="0" value="0" class="form-control" id="tbPrecioPro" name="precio" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <label class="col-md-2 control-label" for="tbMaxDescuentoPro">Max. Desc</label>
                                <div class="col-md-3">
                                    <input  type="text" min="0" value="0" class="form-control" id="tbMaxDescuentoPro" name="max_descuento" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="tbDescripcionPro">Descripción</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="tbDescripcionPro" name="descripcion"></textarea>
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
                                <button type="button" id="btnGuardarProducto" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $dataTable = true; include_once "sis_js.php" ?>

        <script src="js/productos.js"></script>
    </body>
</html>

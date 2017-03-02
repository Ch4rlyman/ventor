<?php
    include_once("validar.php");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php include_once ("sis_css.php") ?>
        <link rel="stylesheet" href="css/bootstrap-datepicker3.min.css">
        <title>Compras</title>
    </head>

    <body>
        <?php include_once ("sis_menu.php") ?>

        <div class="container-fluid">
            <div class="well well-sm tituloPag">Compras</div>
            <table id="dtCompra" class="table table-condensed table-hover" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Cod Prod</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Proveedor</th>
                    <th>Fecha</th>
                    <th>producto_id</th>
                    <th>proveedor_id</th>
                    <th></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>

        </div>

        <div id="mCompra" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="fCompra" data-toggle="validator"> 
                            <div class="form-group">
                                <label for="tbProducto_com" class="control-label">Producto</label>
                                <input  type="text" class="form-control" id="tbProducto_com" required>
                                <input type="hidden" id="tbhProducto_com" name="producto_id">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="tbCantidad_com">Cantidad</label>
                                        <input type="text" class="form-control" id="tbCantidad_com" name="cantidad" required pattern="^[1-9][0-9]*$" data-pattern-error="Debe ser mayor a cero" >
                                        <input type="hidden" id="tbId" name="id">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="tbPrecio_com">Precio</label>
                                        <input type="text" class="form-control" id="tbPrecio_com" name="precio" required min="0" value="0">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tbProveedor_com" class="control-label">Proveedor</label>
                                <input  type="text" class="form-control" id="tbProveedor_com" required>
                                <input type="hidden" id="tbhProveedor_com" name="proveedor_id">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label for="tbFecha_com" class="control-label">Fecha</label>
                                <!--<input  type="text" class="form-control" id="tbFecha_com" style="width: 120px;">-->

                                <div class="input-group date" style="width: 160px;">
                                    <input type="text" class="form-control" id="tbFecha_com">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
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
        <script src="js/bootstrap-datepicker.min.js"></script>
        <script src="js/bootstrap-datepicker.es.min.js"></script>

        <script src="js/compras.js"></script>
    </body>
</html>

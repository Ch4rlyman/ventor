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
            
            <div class="row">
                <div class="col-md-7">
                    <table id="dtCompra" class="table table-condensed table-hover" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Tipo Documento</th>
                            <th>Proveedor</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>id_td</th>
                            <th>id_p</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-md-5">
                    <table id="dtCompraDetalle" class="table table-condensed table-hover" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Cantidad</th>
                            <th>producto_id</th>
                            <!--<th>Cod Prod</th>-->
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Sub Total</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="mCompra" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="fCompra" data-toggle="validator">                            
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="cbTipoDocumento_com">Tipo Documento</label>                                        
                                        <select class="form-control" id="cbTipoDocumento_com" name="tipo_documento_id">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-2">
                                    <div class="form-group">
                                        <label for="tbSerie_com">Serie</label>
                                        <input type="text" class="form-control" id="tbSerie_com" name="serie">                                        
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-3">
                                    <div class="form-group">
                                        <label for="tbNumero_com">Número</label>
                                        <input type="text" class="form-control" id="tbNumero_com" name="numero">                                        
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="tbFecha_com" class="control-label">Fecha</label>
                                        <input type="text" class="form-control" id="tbFecha_com" name="fecha">                           
                                    </div>
                                </div>
                            </div>                                                        
                            <div class="form-group">
                                <label for="tbProveedor_com" class="control-label">Proveedor</label>
                                <input  type="text" class="form-control" id="tbProveedor_com" required data-toggle="context" data-target="#menuc_proveedor">                                
                                <input type="hidden" id="tbhProveedor_com" name="proveedor_id">
                                <div class="help-block with-errors"></div>

                                <div id="menuc_proveedor">
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a tabindex="-1" href="" id="mcNuevoProveedor">Nuevo</a></li>
                                        <li><a tabindex="-1" href="" id="mcEditarProveedor">Editar</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="well text-center" style="font-size: 0.85em; padding: 7px 4px 5px 4px; margin: 6px 0 0 0">
                                <button id="btnAgregarProducto" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#mProducto" style="padding: 2px 5px; margin-bottom: 6px">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar Producto
                                </button> 
                                
                                <div class="table-responsive">
                                    <table id="tDetalle" class="table table-condensed table-bordered table-hover" width="100%" cellspacing="0" style="background-color: #FFF; margin-bottom: 0">
                                        <thead>
                                            <tr>
                                                <th style="width: 40px; text-align: center">Cant</th>
                                                <th style="text-align: center">Producto</th>
                                                <th style="text-align: center">Precio</th>
                                                <th style="text-align: center">Sub Total</th>
                                                <th style="width: 40px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>                                            
                                        </tbody>
                                        <tfoot>
                                            <tr style='font-weight: bold'>
                                                <td colspan="2"></td>
                                                <td style="text-align: center">TOTAL</td>
                                                <td style="text-align: right" id='totalCompra'>0.00</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
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
        
        <div id="mProducto" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Agregar Producto</h4>
                    </div>
                    <div class="modal-body">
                        <form id="fProducto" data-toggle="validator">
                            <div class="form-group">
                                <label for="tbProducto_com" class="control-label">Producto</label>
                                <input  type="text" class="form-control" id="tbProducto_com" required  data-toggle="context" data-target="#menuc_producto">
                                <input type="hidden" id="tbhProducto_com" name="producto_id">
                                <div class="help-block with-errors"></div>

                                <div id="menuc_producto">
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a tabindex="-1" href="" id="mcNuevoProducto">Nuevo</a></li>
                                        <li><a tabindex="-1" href="" id="mcEditarProducto">Editar</a></li>
                                    </ul>
                                </div>
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
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-xs-6 text-left">
                                <button type="reset" class="btn btn-default" data-dismiss="modal" tabindex="-1">Cancelar</button>
                            </div>
                            <div class="col-xs-6">
                                <button type="button" id="btnAgregarProductoDetalle" class="btn btn-success">Agregar Producto</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $dataTable = true; include_once "sis_js.php" ?>
        <script src="js/bootstrap-datepicker.min.js"></script>
        <script src="js/bootstrap-datepicker.es.min.js"></script>
        <script src="js/bootstrap-contextmenu.js"></script>

        <script src="js/compras.js"></script>
    </body>
</html>

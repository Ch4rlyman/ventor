$(function () { 
    $("#tbPrecio_com").TouchSpin({
        verticalbuttons: true,
        min: 0,
        max: 99999,
        step: .1,
        decimals: 2,
        prefix: "S/"
    });
    
    $('#tbFecha_com').datepicker({
        todayBtn: "linked",
        language: "es",
        autoclose: true,
        todayHighlight: true
    });
    
    var mCom = $("#mCompra");
    var fCom = $("#fCompra");

    var dtCom = $('#dtCompra').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [ [15, 25, 50, 100, -1], [15, 25, 50, 100, "Todo"] ],
        ajax:{
            url :"funciones/admin_compra.php?f=1",
            type: "post"
        },
        "dom": "<'row text-sm'<'col-xs-6'B><'col-xs-6 text-right'f>>t<'row text-sm'<'col-xs-6 col-sm-4'<'#tbR'>i><'col-xs-6 col-sm-4 text-center'l><'col-xs-12 col-sm-4 text-right'p>>",
        buttons: [
            {
                text: "<span class='glyphicon glyphicon-plus'></span> Agregar",
                className: "btn-sm",
                action: function ( e, dt, node, config ) {
                    $("#tbId").val(0);
                    
                    $("#tbProducto_com").prop("readonly",false);
                    $("#tbCantidad_com").prop("disabled",false)
                    
                    $("#tbCantidad_com").TouchSpin({ verticalbuttons: true, max: 99999 });
                    
                    mCom.find(".modal-title").html("Nueva Compra");
                    mCom.modal('show');
                }
            }
        ],
        columnDefs: [{
            targets: -1,
            data: null,
            defaultContent: "<span class='glyphicon glyphicon-pencil dt-btn dt-btn-editar'></span> &nbsp;<span class='glyphicon glyphicon-trash dt-btn dt-btn-eliminar'></span>",
            className: "text-center",
            responsivePriority: -1,
            width: "40px",
        }],
        columns: [
            { "data": "id", "visible": false},
            { "data": "codigo" },
            { "data": "nombre" },
            { "data": "cantidad" },
            { "data": "precio" },
            { "data": "razon_social" },
            { "data": "fecha" },
            { "data": "producto_id", "visible": false},
            { "data": "proveedor_id", "visible": false},
            { "data": null, "orderable": false}
        ],
        order: [[0, "desc"]]
    });

    $("#tbR").css("display","inline").html('<button type="button" class="btn btn-default btn-sm btn-refrescar" ><span class="glyphicon glyphicon-refresh" id="btnRefrescar"></span>');

    $("#tbR").on('click', '.btn-refrescar', function () {
        dtCom.ajax.reload(null, false);
    });

    dtCom.on('click', '.dt-btn-editar', function () {
        var fila = dtCom.row($(this).parents('tr')).data();

        $("#tbCantidad_com").TouchSpin("destroy");

        $("#tbId").val(fila.id);
        $("#tbProducto_com").val(fila.nombre).prop("readonly",true);
        $("#tbhProducto_com").val(fila.producto_id);
        
        $("#tbCantidad_com").val(fila.cantidad).prop("disabled",true);
        $("#tbPrecio_com").val(fila.precio);
        
        $("#tbProveedor_com").val(fila.razon_social);
        $("#tbhProveedor_com").val(fila.proveedor_id);
        
        mCom.find(".modal-title").html("Editar Compra");
        mCom.modal('show');
    });
   /*
    $("#btnGuardarMarca").on("click",function(){
        con = $("#fCompra").parents(".modal-content");

        errores = $("#fCompra").validator('validate').has('.has-error').length;

        if (!errores) {
            con.waitMe({ text : 'Guardando...' });

            var data = fCom.serializeArray();
            data.push({name: 'f', value: $("#tbId").val()==0 ? 2 :3 });

            $.post("funciones/admin_marca.php", data, function(d) {
                if (!d.success) {
                    swal({title: d.msg, type: "error"});
                }
                else {
                    toastr["success"](d.msg);
                    mCom.modal('hide');
                    dtCom.ajax.reload();
                }
                con.waitMe('hide');
            },'json');
        }
    });
    */

    dtCom.on('click', '.dt-btn-eliminar', function () {
        contenedorTabla = $('#dtCompra').parents(".dataTables_wrapper");

        var da = dtCom.row($(this).parents('tr')).data();
        bootbox.confirm("¿Seguro que desea eliminar el registro de <b>" + da.nombre + "</b>?", function(rpta){
            if(rpta){
                var delStock = 0;
                bootbox.confirm("¿También quiere eliminar el Stock(<b>" + da.cantidad + "</b>) ingresado del Producto?", function(rpta2){
                    if(rpta2){
                        delStock = 1;
                    }
                    
                    contenedorTabla.waitMe({ text: 'Eliminando...' });
                    $.post("funciones/admin_compra.php", {"f": 4, id: da.id , es: delStock}, function(d){
                        if(!d.success){
                            toastr["error"](d.msg);
                        }else{
                            toastr["success"](d.msg);
                            dtCom.ajax.reload();
                        }
                        contenedorTabla.waitMe('hide');
                    },"json");
                });
            }
        });
    });

    mCom.on('shown.bs.modal', function (e) {
        $("#tbProducto_com").focus();
    })
    mCom.on('hidden.bs.modal', function (e) {
        $('#fCompra')[0].reset();
        con = $("#dtCompra").parents(".modal-content");
        con.waitMe('hide');
    })
    
});
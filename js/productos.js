$(function () {
    $("#tbStockMinPro").TouchSpin({ verticalbuttons: true, max: 99999 });

    $("#tbPrecioPro,#tbMaxDescuentoPro").TouchSpin({
        verticalbuttons: true,
        min: 0,
        max: 99999,
        step: .1,
        decimals: 2,
        prefix: "S/"
    });

    $('#tbMarcaPro').typeahead({
        ajax: 'funciones/admin_marca.php?f=10',
        displayField: 'nombre',
        onSelect:  function(o) { $("#tbhMarcaPro").val(o.value);}
    }).on("keyup", function(){
        if($(this).val()=="")
            $("#tbhMarcaPro").val("");
    });

    $('#tbCategoriaPro').typeahead({
        ajax: 'funciones/admin_categoria.php?f=10',
        displayField: 'nombre',
        onSelect:  function(o) { $("#tbhCategoriaPro").val(o.value);}
    }).on("keyup", function(){
        if($(this).val()=="")
            $("#tbhCategoriaPro").val("");
    });

    var mPro = $("#mProducto");
    var fPro = $("#fProducto");
    var idUnidadActual = 0;

    var dtPro = $('#dtProducto').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [ [15, 25, 50, 100, -1], [15, 25, 50, 100, "Todo"] ],
        ajax:{
            url :"funciones/admin_producto.php?f=1",
            type: "post"
        },
        "dom": "<'row text-sm'<'col-xs-6'B><'col-xs-6 text-right'f>>t<'row text-sm'<'col-xs-6 col-sm-4'<'#tbR'>i><'col-xs-6 col-sm-4 text-center'l><'col-xs-12 col-sm-4 text-right'p>>",
        buttons: [
            {
                text: "<span class='glyphicon glyphicon-plus'></span> Agregar",
                className: "btn-sm",
                action: function ( e, dt, node, config ) {
                    $("#tbCodigoPro").attr("data-remote","funciones/admin_producto.php?f=20");
                    $("#tbNombrePro").attr("data-remote","funciones/admin_producto.php?f=21");
                    $("#tbId").val(0);
                    idUnidadActual = 0;
                    mPro.find(".modal-title").html("Nuevo Producto");
                    mPro.modal('show');
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
            { "data": "id", visible: false},
            { "data": "codigo", className:"hidden-xs" },
            { "data": "nombre" },
            { "data": "descripcion", className:"hidden-xs" },
            { "data": "precio", className:"text-right"},
            { "data": "max_descuento", className:"hidden-xs hidden-sm" },
            { "data": "stock", className:"text-center"},
            { "data": "stock_min", className:"text-center hidden-xs hidden-sm" },
            { "data": "unidad_medida_id", visible: false },
            { "data": "unidad", className:"hidden-xs hidden-sm" },
            { "data": "marca_id", visible: false },
            { "data": "marca", className:"hidden-xs hidden-sm" },
            { "data": "categoria_id", visible: false },
            { "data": "categoria", className:"hidden-xs hidden-sm" },
            { "data": null, "orderable": false}
        ],
        order: [[0, "desc"]]
    });

    $("#tbR").css("display","inline").html('<button type="button" class="btn btn-default btn-sm btn-refrescar" ><span class="glyphicon glyphicon-refresh" id="btnRefrescar"></span>');

    $("#tbR").on('click', '.btn-refrescar', function () {
        dtPro.ajax.reload(null, false);
    });

    dtPro.on('click', '.dt-btn-editar', function () {
        var fila = dtPro.row($(this).parents('tr')).data();
        $("#tbCodigoPro").attr("data-remote","funciones/admin_producto.php?f=20&id=" + fila.id);
        $("#tbNombrePro").attr("data-remote","funciones/admin_producto.php?f=21&id=" + fila.id);

        mPro.find(".modal-title").html("Editar Producto");

        $("#tbId").val(fila.id);
        $("#tbCodigoPro").val(fila.codigo);
        $("#tbNombrePro").val(fila.nombre);
        $("#tbDescripcionPro").val(fila.descripcion);
        $("#tbPrecioPro").val(fila.precio);
        $("#tbMaxDescuentoPro").val(fila.max_descuento);
        $("#tbStockPro").val(fila.stock);
        $("#tbStockMinPro").val(fila.stock_min);
        idUnidadActual = fila.unidad_medida_id;
        $("#tbhMarcaPro").val(fila.marca_id);
        $("#tbMarcaPro").val(fila.marca);
        $("#tbhCategoriaPro").val(fila.categoria_id);
        $("#tbCategoriaPro").val(fila.categoria);

        mPro.modal('show');
    });


    $("#btnGuardarProducto").on("click",function(){
        con = $("#fProducto").parents(".modal-content");

        errores = $("#fProducto").validator('validate').has('.has-error').length;

        if (!errores) {
            con.waitMe({ text : 'Guardando...' });

            var data = fPro.serializeArray();
            data.push({name: 'f', value: $("#tbId").val()==0 ? 2 :3 });

            $.post("funciones/admin_producto.php", data, function(d) {
                if (!d.success) {
                    swal({title: d.msg, type: "error"});
                }
                else {
                    toastr["success"](d.msg);
                    mPro.modal('hide');
                    dtPro.ajax.reload();
                }
                con.waitMe('hide');
            },'json');
        }
    });


    dtPro.on('click', '.dt-btn-eliminar', function () {
        contenedorTabla = $('#dtProducto').parents(".dataTables_wrapper");

        var da = dtPro.row($(this).parents('tr')).data();
        bootbox.confirm("¿Seguro que desea eliminar el producto: <b>" + da.nombre + "</b>?", function(rpta){
            if(rpta){
                contenedorTabla.waitMe({ text: 'Eliminando...' });
                $.post("funciones/admin_producto.php", {"f": 4, id: da.id }, function(d){
                    if(!d.success){
                        toastr["error"](d.msg);
                    }else{
                        toastr["success"](d.msg);
                        dtPro.ajax.reload();
                    }
                    contenedorTabla.waitMe('hide');
                },"json");
            }
        });
    });

    mPro.on('shown.bs.modal', function (e) {
        $("#tbCodigoPro").focus();
        $("#cbUnidadPro").load("funciones/admin_unidadmedida.php?f=10", function(){
            $("#cbUnidadPro").val(idUnidadActual);
        });
    })
    mPro.on('hidden.bs.modal', function (e) {
        $('#fProducto')[0].reset();
        con = $("#fProducto").parents(".modal-content");
        con.waitMe('hide');
        fPro.validator('destroy');
    })

});
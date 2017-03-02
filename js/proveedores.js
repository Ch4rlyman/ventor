$(function () {
    var mPro = $("#mProveedor");
    var fPro = $("#fProveedor");

    var dtPro = $('#dtProveedor').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [ [15, 25, 50, 100, -1], [15, 25, 50, 100, "Todo"] ],
        ajax:{
            url :"funciones/admin_proveedor.php?f=1",
            type: "post"
        },
        "dom": "<'row text-sm'<'col-xs-6'B><'col-xs-6 text-right'f>>t<'row text-sm'<'col-xs-6 col-sm-4'<'#tbR'>i><'col-xs-6 col-sm-4 text-center'l><'col-xs-12 col-sm-4 text-right'p>>",
        buttons: [
            {
                text: "<span class='glyphicon glyphicon-plus'></span> Agregar",
                className: "btn-sm",
                action: function ( e, dt, node, config ) {
                    $("#tbRucPro").attr("data-remote","funciones/admin_proveedor.php?f=20");
                    $("#tbId").val(0);
                    mPro.find(".modal-title").html("Nuevo Proveedor");
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
            { "data": "id", "visible": false},
            { "data": "razon_social" },
            { "data": "ruc" },
            { "data": "representante", className:"hidden-xs" },
            { "data": "telefono", className:"hidden-xs"},
            { "data": "direccion", className:"hidden-xs hidden-sm" },
            { "data": "correo", className:"hidden-xs hidden-sm" },
            { "data": "web", className:"hidden-xs hidden-sm" ,
                "render": function (data, type, full, meta) {
                    url = full.web== null || full.web=="" ? "" : ' <a href="'+ full.web +'" target="_blank"><span class="glyphicon glyphicon-globe"></span></a>';
                    return full.web + url;
                }
            },
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
        $("#tbRucPro").attr("data-remote","funciones/admin_proveedor.php?f=20&id=" + fila.id);

        mPro.find(".modal-title").html("Editar Proveedor");

        $("#tbId").val(fila.id);
        $("#tbRazonSocial").val(fila.razon_social);
        $("#tbRucPro").val(fila.ruc);
        $("#tbRepresentantePro").val(fila.representante);
        $("#tbTelefonoPro").val(fila.telefono);
        $("#tbDireccionPro").val(fila.direccion);
        $("#tbCorreoPro").val(fila.correo);
        $("#tbWebPro").val(fila.web);

        mPro.modal('show');
    });

    $("#btnGuardarProveedor").on("click",function(){
        con = $("#fProveedor").parents(".modal-content");

        //fPro.validator("validate");
        errores = $("#fProveedor").validator('validate').has('.has-error').length;

        if (!errores) {
            con.waitMe({ text : 'Guardando...' });

            var data = fPro.serializeArray();
            data.push({name: 'f', value: $("#tbId").val()==0 ? 2 :3 });

            $.post("funciones/admin_proveedor.php", data, function(d) {
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
        contenedorTabla = $('#dtProveedor').parents(".dataTables_wrapper");

        var da = dtPro.row($(this).parents('tr')).data();
        bootbox.confirm("¿Seguro que desea eliminar el proveedor: <b>" + da.razon_social + "</b>?", function(rpta){
            if(rpta){
                contenedorTabla.waitMe({ text: 'Eliminando...' });
                $.post("funciones/admin_proveedor.php", {"f": 4, id: da.id }, function(d){
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
        $("#tbRucPro").focus();
    })
    mPro.on('hidden.bs.modal', function (e) {
        $('#fProveedor')[0].reset();
        con = $("#fProveedor").parents(".modal-content");
        con.waitMe('hide');
        fPro.validator('destroy');
    })

});
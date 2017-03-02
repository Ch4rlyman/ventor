$(function () {
    var mUsu = $("#mUsuario");
    var fUsu = $("#fUsuario");

    var dtUsu = $('#dtUsuario').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [ [15, 25, 50, 100, -1], [15, 25, 50, 100, "Todo"] ],
        ajax:{
            url :"funciones/admin_usuario.php?f=11",
            type: "post"
        },
        "dom": "<'row text-sm'<'col-xs-6'B><'col-xs-6 text-right'f>>t<'row text-sm'<'col-xs-6 col-sm-4'<'#tbR'>i><'col-xs-6 col-sm-4 text-center'l><'col-xs-12 col-sm-4 text-right'p>>",
        buttons: [
            {
                text: "<span class='glyphicon glyphicon-plus'></span> Agregar",
                className: "btn-sm",
                action: function ( e, dt, node, config ) {
                    $("#tbUsuarioUsuario").attr("data-remote","funciones/admin_usuario.php?f=20");
                    $("#tbId").val(0);
                    mUsu.find(".modal-title").html("Nuevo Usuario");
                    mUsu.modal('show');
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
        },{
            "render": function ( data, type, row ) {
                return data==1?"<span class='label label-success'>Activo</span>":"<span class='label label-default'>Inactivo</span>";
            },
            targets: 4
        }],
        columns: [
            { "data": "id", "visible": false},
            { "data": "nombre" },
            { "data": "usuario" },
            { "data": "tipo" },
            { "data": "estado" },
            { "data": null, "orderable": false}
        ],
        order: [[0, "desc"]]
    });

    $("#tbR").css("display","inline").html('<button type="button" class="btn btn-default btn-sm btn-refrescar" ><span class="glyphicon glyphicon-refresh" id="btnRefrescar"></span>');

    $("#tbR").on('click', '.btn-refrescar', function () {
        dtUsu.ajax.reload(null, false);
    });

    dtUsu.on('click', '.dt-btn-editar', function () {
        var fila = dtUsu.row($(this).parents('tr')).data();
        $("#tbUsuarioUsuario").attr("data-remote","funciones/admin_usuario.php?f=20&id=" + fila.id);

        mUsu.find(".modal-title").html("Editar Usuario");

        $("#tbId").val(fila.id);
        $("#tbNombreUsuario").val(fila.nombre);
        $("#tbUsuarioUsuario").val(fila.usuario);
        $("#tbClave").val("");

        $("#cbTipo").val(fila.tipo);
        // $('#cbTipo option:selected').attr("selected",null);
        // $("#cbTipo option[value='"+ fila.tipo +"']").prop("selected", true);
        $("#chbEstado").prop('checked', fila.estado);

        mUsu.modal('show');
    });

    $("#btnGuardarUsuario").on("click",function(){
        con = $("#fUsuario").parents(".modal-content");

        fUsu.validator("validate");
        errores = $("#fUsuario").validator('validate').has('.has-error').length;

        if (!errores) {
            con.waitMe({ text : 'Guardando...' });

            var data = fUsu.serializeArray();
            data.push({name: 'f', value: $("#tbId").val()==0 ? 12 :13 });

            $.post("funciones/admin_usuario.php", data, function(d) {
                if (!d.success) {
                    swal({title: d.msg, type: "error"});
                }
                else {
                    toastr["success"](d.msg);
                    mUsu.modal('hide');
                    dtUsu.ajax.reload();
                }
                con.waitMe('hide');
            },'json');
        }
    });


    dtUsu.on('click', '.dt-btn-eliminar', function () {
        contenedorTabla = $('#dtUsuario').parents(".dataTables_wrapper");

        var da = dtUsu.row($(this).parents('tr')).data();
        bootbox.confirm("¿Seguro que desea eliminar el usuario: <b>" + da.nombre + "(" + da.usuario +  ")" + "</b>?", function(rpta){
            if(rpta){
                contenedorTabla.waitMe({ text: 'Eliminando...' });
                $.post("funciones/admin_usuario.php", {"f": 14, id: da.id }, function(d){
                    if(!d.success){
                        toastr["error"](d.msg);
                    }else{
                        toastr["success"](d.msg);
                        dtUsu.ajax.reload();
                    }
                    contenedorTabla.waitMe('hide');
                },"json");
            }
        });
    });

    mUsu.on('shown.bs.modal', function (e) {
        $("#tbNombreUsuario").focus();
    })
    mUsu.on('hidden.bs.modal', function (e) {
        $('#fUsuario')[0].reset();
        con = $("#fUsuario").parents(".modal-content");
        con.waitMe('hide');
        fUsu.validator('destroy');
    })

});
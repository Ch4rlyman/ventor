$(function () {
    var mCli = $("#mCliente");
    var fCli = $("#fCliente");

    var dtCli = $('#dtCliente').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [ [15, 25, 50, 100, -1], [15, 25, 50, 100, "Todo"] ],
        ajax:{
            url :"funciones/admin_cliente.php?f=1",
            type: "post"
        },
        "dom": "<'row text-sm'<'col-xs-6'B><'col-xs-6 text-right'f>>t<'row text-sm'<'col-xs-6 col-sm-4'<'#tbR'>i><'col-xs-6 col-sm-4 text-center'l><'col-xs-12 col-sm-4 text-right'p>>",
        buttons: [
            {
                text: "<span class='glyphicon glyphicon-plus'></span> Persona",
                className: "btn-sm",
                action: function ( e, dt, node, config ) {
                    $("#tbDniCli").attr("data-remote","funciones/admin_cliente.php?f=20");
                    $("#tbId").val(0);
                    $("#sPersona").show();
                    $("#sEmpresa").hide();
                    mCli.find(".modal-title").html("Nuevo Cliente");
                    mCli.modal('show');
                }
            },
            {
                text: "<span class='glyphicon glyphicon-plus'></span> Empresa",
                className: "btn-sm",
                action: function ( e, dt, node, config ) {
                    $("#tbDniCli").attr("data-remote","funciones/admin_cliente.php?f=20");
                    $("#tbId").val(0);
                    $("#sPersona").hide();
                    $("#sEmpresa").show();
                    mCli.find(".modal-title").html("Nueva Empresa");
                    mCli.modal('show');
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
            { "data": "nombre"},
            { "data": "dni" },
            { "data": "ruc" },
            { "data": "sexo", className:"hidden-xs" },
            { "data": "telefono", className:"hidden-xs"},
            { "data": "direccion", className:"hidden-xs hidden-sm" },
            { "data": "correo", className:"hidden-xs hidden-sm" },
            { "data": "nombres", "visible": false},
            { "data": "paterno", "visible": false },
            { "data": "materno", "visible": false },
            { "data": "razon_social", "visible": false },
            { "data": null, "orderable": false}
        ],
        order: [[0, "desc"]]
    });

    $("#tbR").css("display","inline").html('<button type="button" class="btn btn-default btn-sm btn-refrescar" ><span class="glyphicon glyphicon-refresh" id="btnRefrescar"></span>');

    $("#tbR").on('click', '.btn-refrescar', function () {
        dtCli.ajax.reload(null, false);
    });

    dtCli.on('click', '.dt-btn-editar', function () {
        var fila = dtCli.row($(this).parents('tr')).data();
        $("#tbDniPro").attr("data-remote","funciones/admin_cliente.php?f=20&id=" + fila.id);

        if(fila.dni != ""){
            mCli.find(".modal-title").html("Editar Cliente");
            $("#sPersona").show();
            $("#sEmpresa").hide();

            $("#tbDniCli").val(fila.dni);
            $("#tbNombresCli").val(fila.nombres);
            $("#tbPaternoCli").val(fila.paterno);
            $("#tbMaternoCli").val(fila.materno);

            if(fila.razon_social == "M")
                $("#rbMasculinoCli").prop("checked", true);
            else
                $("#rbFemeninoCli").prop("checked", true);
        }else{
            mCli.find(".modal-title").html("Editar Empresa");
            $("#sPersona").hide();
            $("#sEmpresa").show();

            $("#tbRucCli").val(fila.ruc);
            $("#tbRazonSocCli").val(fila.razon_social);
        }
        $("#tbId").val(fila.id);

        $("#tbTelefonoCli").val(fila.telefono);
        $("#tbDireccionCli").val(fila.direccion);
        $("#tbCorreoCli").val(fila.correo);

        $("#tbRucCli").val(fila.ruc);
        $("#tbRazonSocialCli").val(fila.razon_cliente);

        mCli.modal('show');
    });

    $("#btnGuardarCliente").on("click",function(){

        con = $("#fCliente").parents(".modal-content");

        errores = $("#fCliente").validator('validate').has('.has-error').length;

        if (errores>0) {
            con.waitMe({ text : 'Guardando...' });

            var data = fCli.serializeArray();
            data.push({name: 'f', value: $("#tbId").val()==0 ? 2 :3 });

            $.post("funciones/admin_cliente.php", data, function(d) {
                if (!d.success) {
                    swal({title: d.msg, type: "error"});
                }
                else {
                    toastr["success"](d.msg);
                    mCli.modal('hide');
                    dtCli.ajax.reload();
                }
                con.waitMe('hide');
            },'json');
        }
    });

    dtCli.on('click', '.dt-btn-eliminar', function () {
        contenedorTabla = $('#dtCliente').parents(".dataTables_wrapper");

        var da = dtCli.row($(this).parents('tr')).data();
        bootbox.confirm("¿Seguro que desea eliminar el cliente: <b>" + da.nombre + "</b>?", function(rpta){
            if(rpta){
                contenedorTabla.waitMe({ text: 'Eliminando...' });
                $.post("funciones/admin_cliente.php", {"f": 4, id: da.id }, function(d){
                    if(!d.success){
                        toastr["error"](d.msg);
                    }else{
                        toastr["success"](d.msg);
                        dtCli.ajax.reload();
                    }
                    contenedorTabla.waitMe('hide');
                },"json");
            }
        });
    });

    mCli.on('shown.bs.modal', function (e) {
        cliente = mCli.find(".modal-title").html();
        cliente.toLowerCase().indexOf("cliente") > 0 ? $("#tbDniCli").focus() : $("#tbRucCli").focus();
    })
    mCli.on('hidden.bs.modal', function (e) {
        $('#fCliente')[0].reset();
        con = $("#fCliente").parents(".modal-content");
        con.waitMe('hide');
    })

});
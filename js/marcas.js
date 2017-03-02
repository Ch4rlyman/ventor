$(function () {
    var mMar = $("#mMarcas");
    var fMar = $("#fMarca");

    var dtMar = $('#dtMarca').DataTable({
        select: "single",
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [ [15, 25, 50, 100, -1], [15, 25, 50, 100, "Todo"] ],
        ajax:{
            url :"funciones/admin_marca.php?f=1",
            type: "post"
        },
        "dom": "<'row text-sm'<'col-xs-6'B><'col-xs-6 text-right'f>>t<'row text-sm'<'col-xs-6 col-sm-4'<'#tbR'>i><'col-xs-6 col-sm-4 text-center'l><'col-xs-12 col-sm-4 text-right'p>>",
        buttons: [
            {
                text: "<span class='glyphicon glyphicon-plus'></span> Agregar",
                className: "btn-sm",
                action: function ( e, dt, node, config ) {
                    $("#tbNombreMarca").attr("data-remote",'funciones/admin_marca.php?f=20');
                    $("#tbAbreviatura").attr("data-remote",'funciones/admin_marca.php?f=21');

                    $("#tbId").val(0);
                    mMar.find(".modal-title").html("Nueva Marca");
                    mMar.modal('show');
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
            { "data": "nombre" },
            { "data": "abreviatura" },
            { "data": null, "orderable": false}
        ],
        order: [[0, "desc"]]
    });

    $("#tbR").css("display","inline").html('<button type="button" class="btn btn-default btn-sm btn-refrescar" ><span class="glyphicon glyphicon-refresh" id="btnRefrescar"></span>');

    $("#tbR").on('click', '.btn-refrescar', function () {
        dtMar.ajax.reload(null, false);
    });

    dtMar.on('click', '.dt-btn-editar', function () {
        var fila = dtMar.row($(this).parents('tr')).data();

        $("#tbNombreMarca").attr("data-remote",'funciones/admin_marca.php?f=20&id=' + fila.id);
        $("#tbAbreviatura").attr("data-remote",'funciones/admin_marca.php?f=21&id=' + fila.id);

        mMar.find(".modal-title").html("Editar Marca");

        $("#tbId").val(fila.id);
        $("#tbNombreMarca").val(fila.nombre);
        $("#tbAbreviatura").val(fila.abreviatura);

        mMar.modal('show');
    });

    $("#btnGuardarMarca").on("click",function(){
        con = $("#fMarca").parents(".modal-content");

        errores = $("#fMarca").validator('validate').has('.has-error').length;

        if (!errores) {
            con.waitMe({ text : 'Guardando...' });

            var data = fMar.serializeArray();
            data.push({name: 'f', value: $("#tbId").val()==0 ? 2 :3 });

            $.post("funciones/admin_marca.php", data, function(d) {
                if (!d.success) {
                    swal({title: d.msg, type: "error"});
                }
                else {
                    toastr["success"](d.msg);
                    mMar.modal('hide');
                    dtMar.ajax.reload();
                }
                con.waitMe('hide');
            },'json');
        }
    });


    dtMar.on('click', '.dt-btn-eliminar', function () {
        contenedorTabla = $('#dtMarca').parents(".dataTables_wrapper");

        var da = dtMar.row($(this).parents('tr')).data();
        bootbox.confirm("¿Seguro que desea eliminar el registro de <b>" + da.nombre + "</b>?", function(rpta){
            if(rpta){
                contenedorTabla.waitMe({ text: 'Eliminando...' });
                $.post("funciones/admin_marca.php", {"f": 4, id: da.id }, function(d){
                    if(!d.success){
                        toastr["error"](d.msg);
                    }else{
                        toastr["success"](d.msg);
                        dtMar.ajax.reload();
                    }
                    contenedorTabla.waitMe('hide');
                },"json");
            }
        });
    });

    mMar.on('shown.bs.modal', function (e) {
        $("#tbNombreMarca").focus();
    })
    mMar.on('hidden.bs.modal', function (e) {
        $('#fMarca')[0].reset();
        con = $("#fMarca").parents(".modal-content");
        con.waitMe('hide');
    })

});
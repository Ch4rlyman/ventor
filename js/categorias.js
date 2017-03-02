$(function () {
    var mCat = $("#mCategoria");
    var fCat = $("#fCategoria");

    var dtCat = $('#dtCategoria').DataTable({
        // select: "single",
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [ [15, 25, 50, 100, -1], [15, 25, 50, 100, "Todo"] ],
        ajax:{
            url :"funciones/admin_categoria.php?f=1",
            type: "post"
        },
        "dom": "<'row text-sm'<'col-xs-6'B><'col-xs-6 text-right'f>>t<'row text-sm'<'col-xs-6 col-sm-4'<'#tbR'>i><'col-xs-6 col-sm-4 text-center'l><'col-xs-12 col-sm-4 text-right'p>>",
        buttons: [
            {
                text: "<span class='glyphicon glyphicon-plus'></span> Agregar",
                className: "btn-sm",
                action: function ( e, dt, node, config ) {
                    $("#tbId").val(0);
                    mCat.find(".modal-title").html("Nueva Categoria");
                    mCat.modal('show');
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
        },],
        columns: [
            { "data": "id", "visible": false},
            { "data": "nombre" },
            { "data": "descripcion" },
            { "data": null, "orderable": false}
        ],
        order: [[0, "desc"]]
    });

    $("#tbR").css("display","inline").html('<button type="button" class="btn btn-default btn-sm btn-refrescar" ><span class="glyphicon glyphicon-refresh" id="btnRefrescar"></span>');

    $("#tbR").on('click', '.btn-refrescar', function () {
        dtCat.ajax.reload(null, false);
    });

    dtCat.on('click', '.dt-btn-editar', function () {
        console.log("editar")
        var fila = dtCat.row($(this).parents('tr')).data();

        mCat.find(".modal-title").html("Editar Categoria");

        $("#tbId").val(fila.id);
        $("#tbNombreCategoria").val(fila.nombre);
        $("#tbDescripcion").val(fila.descripcion);

        mCat.modal('show');
    });

    $("#btnGuardarCategoria").on("click",function(){
        con = $("#fCategoria").parents(".modal-content");
        con.waitMe({ text : 'Guardando...' });

        var data = fCat.serializeArray();
        data.push({name: 'f', value: $("#tbId").val()==0 ? 2 :3 });

        $.post("funciones/admin_categoria.php", data, function(d) {
            if (!d.success) {
                swal({title: d.msg, type: "error"});
            }
            else {
                toastr["success"](d.msg);
                mCat.modal('hide');
                dtCat.ajax.reload();
            }
            con.waitMe('hide');
        },'json');
    });


    dtCat.on('click', '.dt-btn-eliminar', function () {
        contenedorTabla = $('#dtCategoria').parents(".dataTables_wrapper");

        var da = dtCat.row($(this).parents('tr')).data();
        bootbox.confirm("¿Seguro que desea eliminar el registro : <b>" + da.nombre + "</b>?", function(rpta){
            if(rpta){
                contenedorTabla.waitMe({ text: 'Eliminando...' });
                $.post("funciones/admin_categoria.php", {"f": 4, id: da.id }, function(d){
                    if(!d.success){
                        toastr["error"](d.msg);
                    }else{
                        toastr["success"](d.msg);
                        dtCat.ajax.reload();
                    }
                    contenedorTabla.waitMe('hide');
                },"json");
            }
        });
    });

    mCat.on('shown.bs.modal', function (e) {
        $("#tbNombreCategoria").focus();
    })
    mCat.on('hidden.bs.modal', function (e) {
        $('#fCategoria')[0].reset();
        con = $("#fCategoria").parents(".modal-content");
        con.waitMe('hide');
    })

});
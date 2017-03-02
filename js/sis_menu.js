$(function () {
    bootbox.setLocale("es");
    toastr.options = {
        "closeButton": false,
        "positionClass": "toast-top-center",
        "showEasing": "linear",
        "hideEasing": "linear",
        "showMethod": "slideDown",
    };

    //----------------------------------------

    vCon = $('#vConfig');

    vCon.on('shown.bs.modal', function (e) {
        $('#tbRazon').focus();
    });

    vCon.on('hidden.bs.modal', function (e) {
        $('#fConfig').trigger("reset");
        $('#fConfig .form-group').removeClass('has-error');
    });

    $("#btnGuardarConfig").on("click",function(){
        //$("#fConfig").validator('validate');
        nroErrores = $("#fConfig").validator('validate').has('.has-error').length;

        if (nroErrores) {
            toastr["error"]("Verifique su Formulario");
        } else {
            var data = $("#fConfig").serializeArray();
            data.push({name: 'f', value: 2});

            $.post("funciones/admin_configuracion.php", data, function(d) {
                vCon.waitMe('hide');
                if (d.success) {
                    vCon.modal('hide');
                    swal({title: d.msg, type: "success",},function(){
                            location.reload();
                        }
                    );
                }else {
                    swal({title: d.msg, type: "error"});
                }
            },'json');
        }
    });

    // ----------------- Ventana Cambiar Clave ---------------------

    vCla = $('#vClave');

    vCla.on('shown.bs.modal', function (e) {
        $('#tbClaveActual').focus();
    });

    vCla.on('hidden.bs.modal', function (e) {
        $('#f_cambiarClave').trigger("reset");
        $('#f_cambiarClave .form-group').removeClass('has-error');
    });

    $("#btnGuardarClave").on("click",function(){
        $('#f_cambiarClave .form-group').removeClass('has-error');

        if($.trim($('#tbClaveActual').val())==""){
            $('#tbClaveActual').parent().parent().addClass('has-error');
            swal({
                    title: "Ingrese la clave actual.",
                    type: "error",
                },function(){
                    setTimeout(function(){ $("#tbClaveActual").focus(); }, 200);
                }
            );
            return;
        }
        else if($.trim($('#tbClaveNueva').val())==""){
            $('#tbClaveNueva').parent().parent().addClass('has-error');
            swal({title: "Ingrese la nueva contraseña", type: "error"},
                function(){
                    setTimeout(function(){ $("#tbClaveNueva").focus(); }, 200);
                }
            );
            return;
        }
        else if($.trim($('#tbClaveActual').val())==$.trim($('#tbClaveNueva').val())){
            $('#tbClaveNueva').parent().parent().addClass('has-error');
            swal({title: "La Contraseña Actual y la nueva Contraseña son iguales. Deben ser diferentes", type: "error"},
                function(){
                    setTimeout(function(){ $("#tbClaveNueva").select(); }, 200);
                }
            );
            return;
        }
        else if($.trim($('#tbClaveRepetida').val())==""){
            $('#tbClaveRepetida').parent().parent().addClass('has-error');
            swal({title: "Ingrese la contraseña repetida", type: "error"},
                function(){
                    setTimeout(function(){ $("#tbClaveRepetida").focus(); }, 200);
                }
            );
            return;
        }
        else if($.trim($('#tbClaveNueva').val())!=$.trim($('#tbClaveRepetida').val())){
            $('#tbClaveRepetida').parent().parent().addClass('has-error');
            swal({title: "Las nuevas claves no son iguales", type: "error"},
                function(){
                    setTimeout(function(){ $("#tbClaveRepetida").select(); }, 200);
                }
            );
            return;
        }

        vCla.waitMe();

        var data = $("#f_cambiarClave").serializeArray();
        data.push({name: 'f', value: 2});

        $.post("funciones/admin_usuario.php", data, function(d) {
            if (d.success) {
                vCla.modal('hide');
                swal({title: d.msg, type: "success"});
            }else {
                swal({title: d.msg, type: "error"});
            }
            vCla.waitMe('hide');
        },'json');
    });


    $("#btnCerrarSesion").on("click",function(){
        swal({
            title: "Seguro que desea Cerrar Sesión?",
            type: "error",
            showCancelButton: true,
        },function(){
            document.location = 'logout.php';
        });
    });
});
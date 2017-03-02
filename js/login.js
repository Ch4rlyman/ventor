$(document).ready(function(){
    NOMBRESISTEMA ="Ventor";

    $('#tbUsuario').focus();

    $('#btnIniciar').click(function(){
        $('.input-group').removeClass('has-error');

        if($.trim($('#tbUsuario').val())==""){
            $('#tbUsuario').parent().addClass('has-error');
            bootbox.alert('El nombre de usuario no puede quedar vacío', function(){
                setTimeout(function(){ $("#tbUsuario").focus(); }, 200);
            });
            return;
        }
        else if($.trim($('#tbClave').val())==""){
            $('#tbClave').parent().addClass('has-error');

            bootbox.alert('La Contraseña no puede quedar vacía', function(){
                setTimeout(function(){ $("#tbClave").focus(); }, 200);
            });
            return;
        }

        $(".card-container").waitMe();

        $.post('funciones/admin_usuario.php', {
            f:1,
            usuario:$('#tbUsuario').val(),
            clave:$('#tbClave').val()
            },function(data){
                if(data.indexOf('Error') == -1){
                    document.location = 'index.php';
                }
                else{
                    $(".card-container").waitMe('hide');

                    bootbox.alert(data.toString(), function(){
                        setTimeout(function(){ $('#tbClave').select(); }, 200);
                        return;
                    })
                }
            });
    });

    $('#tbClave').keypress(function(e){
        if (e.keyCode == 13) {
            $('#btnIniciar').click();
            return true;
        }
    });
});
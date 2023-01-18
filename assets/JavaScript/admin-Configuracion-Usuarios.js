$(document).ready(function(){
    $('#txt-password').val("");
    $('#txt-rep-password').val("");

    $('body').on('click','#btn-agregar-usuario',function(){
        $('#modal-agregar-usuario').modal();
    });

    $('body').on('click','#btn-modificar-usuario',function(){
        $("#txt_nombre_M").val("");
        $("#txt_apellido_paterno_M").val("");
        $("#txt_apellido_materno_M").val("");
        $("#txt_tel_Rec_M").val("");
        $("#txt_tel_Casa_M").val("");
        $("#txt_tel_Cel_M").val("");
        $("#txt_email_M").val("");
        $("#txt_calle_M").val("");
        $("#txt_nInterior_M").val("");
        $("#txt_nExterior_M").val("");
        $('#modal-modificar-usuario').modal();
    });

    $('#sel-estadoId').change(function(){
        recargaListaMunicipios();
    });
    $('#sel_estadoId_M').change(function(){
        recargaListaMunicipios_M();
    });

    $('#sel-roleId').change(function(){
        generaClaves();
    });
});

function agregar_usuarios(){
    var usuarioId = document.getElementById('txt-UsuarioId').value;
    Swal.fire({
        title: '¡¡¡ Agregando un usuario !!!',
        text: "¿Los datos son correctos?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, agregalo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'success',
                title: '¡¡¡ El usuario ha sido agregado exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
              }),
            $.ajax({
                type:"POST",
                url: $base_url+"Configuracion_Controller/agregarUsuarios",
                data:{
                    'usuarioId':usuarioId,
                    'nombre':$('#txt-nombre').val(),
                    'apellidoP':$('#txt-apellido-paterno').val(),
                    'apellidoM':$('#txt-apellido-materno').val(),
                    'fechaN':$('#date').val(),
                    'sexoId':$('#txt-sexoId').val(),
                    'tel_rec':$('#txt-tel-Rec').val(),
                    'tel_casa':$('#txt-tel-Casa').val(),
                    'tel_cel':$('#txt-tel-Cel').val(),
                    'email':$('#txt-email').val(),
                    'calle':$('#txt-calle').val(),
                    'nInt':$('#txt-nInterior').val(),
                    'nExt':$('#txt-nExterior').val(),
                    'estadoId':$('#sel-estadoId').val(),
                    'municipioId':$('#sel-municipioId').val(),
                    'roleId':$('#sel-roleId').val(),
                    'usuario':$('#txt-usuario').val(),
                    'contrasenia':$('#txt-contrasenia').val()
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        ImprimirReporteCredenciales();
                        //location.href=$base_url+"Configuracion_Controller/ConfiguracionUsuarios/"+usuarioId;
                    },100)
                },
                error: function (xhr, message , code){
                    console.log(this);
                }
            });
        }
    })
}

function ModificarUsuarioModal(element){
    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdUsuarioId = $(etiquetaTR).children('td#UsuarioId').text();
    //alert(tdUsuarioId);
    $.ajax({
        type:"POST",
        url:$base_url+"Configuracion_Controller/getUsuarioByUsuarioId",
        data:{
            usuarioId:tdUsuarioId
        },
        success: function(data){
            var datosModalUsuario=JSON.parse(data);                                                //Debo convertir a JSON
            
            document.formModificarUsuario.sel_estadoId_M.value=datosModalUsuario[0]['EstadoId'];
            $.ajax({
                type:"POST",
                url:$base_url+"Configuracion_Controller/getAllCatMunicipiosByEstadoId",
                data:{
                    estadoId:$('#sel_estadoId_M').val()
                },
                success: function(data){
                    var datosMunicipio=JSON.parse(data);                                                //Debo convertir a JSON
                    //console.log(datosMunicipio);
                    $('#sel_municipioId_M').append("<option value=''>Seleccione una opción</option>");
                    for(var i=0;i<datosMunicipio.length;i++){
                        $('#sel_municipioId_M').append("<option value='"+datosMunicipio[i]['MunicipioId']+"'>"+datosMunicipio[i]['Municipio_Municipio']+"</option>");
                    }
                    
                },
                error: function (request, status, error){
                    console.log(request.responseText);
                }
            });
            document.formModificarUsuario.sel_municipioId_M.value=datosModalUsuario[0]['MunicipioId'];
            
            
            
            //console.log(datosModalUsuario);
            
            document.formModificarUsuario.txt_usuarioModificarId.value=datosModalUsuario[0]['UsuarioId'];
            document.formModificarUsuario.txt_nombre_M.value=datosModalUsuario[0]['Persona_Nombre'];
            document.formModificarUsuario.txt_apellido_paterno_M.value=datosModalUsuario[0]['Persona_ApellidoPaterno'];
            document.formModificarUsuario.txt_apellido_materno_M.value=datosModalUsuario[0]['Persona_ApellidoMaterno'];
            document.formModificarUsuario.date_M.value=datosModalUsuario[0]['Persona_FechaNacimiento'];
            document.formModificarUsuario.txt_sexoId_M.value=datosModalUsuario[0]['SexoId'];
            document.formModificarUsuario.txt_tel_Rec_M.value=datosModalUsuario[0]['Contacto_TelRecados'];
            document.formModificarUsuario.txt_tel_Casa_M.value=datosModalUsuario[0]['Contacto_TelCasa'];
            document.formModificarUsuario.txt_tel_Cel_M.value=datosModalUsuario[0]['Contacto_TelCelular'];
            document.formModificarUsuario.txt_email_M.value=datosModalUsuario[0]['Contacto_Email'];
            document.formModificarUsuario.txt_calle_M.value=datosModalUsuario[0]['Direccion_Calle'];
            document.formModificarUsuario.txt_nInterior_M.value=datosModalUsuario[0]['Direccion_NumeroInterior'];
            document.formModificarUsuario.txt_nExterior_M.value=datosModalUsuario[0]['Direccion_NumeroExterior'];
            document.formModificarUsuario.sel_roleId_M.value=datosModalUsuario[0]['RoleId'];

            //document.formModificarUsuario..value=datosModalUsuario[0][''];

            
        },
        error: function (request, status, error){
            console.log(request.responseText);
        }
    });
    
}

function recargaListaMunicipios(){
    //alert($('#sel-estadoId').val());
    $('#sel-municipioId').empty();
    $.ajax({
        type:"POST",
        url:$base_url+"Configuracion_Controller/getAllCatMunicipiosByEstadoId",
        data:{
            estadoId:$('#sel-estadoId').val()
        },
        success: function(data){
            var datosMunicipio=JSON.parse(data);                                                //Debo convertir a JSON
            //console.log(datosMunicipio);
            $('#sel-municipioId').append("<option value=''>Seleccione una opción</option>");
            for(var i=0;i<datosMunicipio.length;i++){
                $('#sel-municipioId').append("<option value='"+datosMunicipio[i]['MunicipioId']+"'>"+datosMunicipio[i]['Municipio_Municipio']+"</option>");
            }
            
        },
        error: function (request, status, error){
            console.log(request.responseText);
        }
    });
}

function recargaListaMunicipios_M(){
    //alert($('#sel-estadoId').val());
    $('#sel_municipioId_M').empty();
    $.ajax({
        type:"POST",
        url:$base_url+"Configuracion_Controller/getAllCatMunicipiosByEstadoId",
        data:{
            estadoId:$('#sel_estadoId_M').val()
        },
        success: function(data){
            var datosMunicipio=JSON.parse(data);                                                //Debo convertir a JSON
            //console.log(datosMunicipio);
            $('#sel_municipioId_M').append("<option value=''>Seleccione una opción</option>");
            for(var i=0;i<datosMunicipio.length;i++){
                $('#sel_municipioId_M').append("<option value='"+datosMunicipio[i]['MunicipioId']+"'>"+datosMunicipio[i]['Municipio_Municipio']+"</option>");
            }
            
        },
        error: function (request, status, error){
            console.log(request.responseText);
        }
    });
}

function generaClaves(){
    var nombre=$('#txt-nombre').val();
    var apellidoP=$('#txt-apellido-paterno').val();
    var apellidoM=$('#txt-apellido-materno').val();
    
    var num=N_aleatorio(1000,9999);
    //alert("Nombre:"+ nombre.substr(0,3)+apellidoP.substr(0,3)+apellidoM.substr(0,3)+"@"+num);
    var user=((nombre.substr(0,3)+apellidoP.substr(0,3)+apellidoM.substr(0,3)+"@"+num).toUpperCase());
    $('#txt-usuario').val(user);

    var letra=L_aleatorio();
    var num=N_aleatorio(1000,9999);
    //alert("Contraseña:"+apellidoP.substr(0,3)+apellidoM.substr(0,3)+ nombre.substr(0,3)+"@"+num+"_"+letra);
    var password=((apellidoP.substr(0,3)+apellidoM.substr(0,3)+ nombre.substr(0,3)+"@"+num+"_"+letra).toUpperCase());
    $('#txt-contrasenia').val(password);
    
}

function N_aleatorio(minimo,maximo){
    return Math.round(Math.random() * (maximo - minimo) + minimo);
}

function L_aleatorio(){
    var cadena='ABCDEFGHIJKLMNÑOPQRSTUVWXYZ';
    var posicion=N_aleatorio(0,27);
    return cadena.substring((posicion-1),posicion);
}

function limpiarCredenciales(){
    $('#txt-password').val("");
    $('#txt-rep-password').val("");
};

function guardarCredenciales(){
    var userId=$('#txt-usuarioId').val();
    var user=$('#txt-user').val();
    var password=$('#txt-password').val();
    var passwordR=$('#txt-rep-password').val();
    
    if(user!="" && password!="" && passwordR!=""){
        if(password == passwordR){
            $.ajax({
                type:"POST",
                url: $base_url+"Configuracion_Controller/updateCredenciales",
                data:{
                    usuarioId: userId,
                    password: password
                },
                complete: function(){
                    location.href=$base_url;
                },
                success: function (dataResponse){
                    location.href=$base_url;
                },
                error: function (request, status, error){
                    alert(request.responseText);
                }
            });
        }else{
            alert("¡¡¡ Las contraseñas no concuerdan !!!");
        }
    }else{
        alert("¡¡¡ Favor de revisar los campos !!!");
    }
    location.href=$base_url;
}

function Eliminar_usuario(element){
    var UsuarioIdGlobal = document.getElementById('UsuarioIdGlobal').value;

    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdId = $(etiquetaTR).children('td#UsuarioId').text();
    var tdUsuario = $(etiquetaTR).children('td#Nombre').text();

    Swal.fire({
        title: '¿Deseas eliminar al usuario '+tdUsuario+'?',
        text: "¿No podrás revertir el proceso?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, borrarlo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'success',
                title: '¡¡¡ El usuario ha sido eliminado exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
              }),
          $.ajax({
            type: "POST",
            url: $base_url+"Configuracion_Controller/eliminarUsuarios",
            data: {
                UsuarioIdGlobal:UsuarioIdGlobal,
                UsuarioId: tdId 
            },
            success: function (dataResponse){
                //console.log(dataResponse);
                setTimeout(function(){
                    location.href=$base_url+"Configuracion_Controller/ConfiguracionUsuarios/?UsuarioId="+window.btoa(UsuarioIdGlobal);
                },100)
            },
            error:function (xhr,message, code){
                console.log(this);
                Swal.fire({
                    icon: 'Error',
                    title: 'Oops...',
                    text: '¡Algo salio mal!'
                  })
            }
        });
        }
      })
}

function modificar_usuarios(){
    var usuarioId = document.getElementById('txt-UsuarioId-M').value;

    Swal.fire({
        title: 'Actualización de datos',
        text: "¿Los datos son correctos?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, modificar!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'success',
                title: '¡¡¡ El usuario ha sido modificado exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
             }),
            $.ajax({
                type:"POST",
                url: $base_url+"Configuracion_Controller/modificarUsuarios",
                data:{
                    'usuarioId':usuarioId,
                    'usuarioModificarId':$('#txt_usuarioModificarId').val(),
                    'nombre':$('#txt_nombre_M').val(),
                    'apellidoP':$('#txt_apellido_paterno_M').val(),
                    'apellidoM':$('#txt_apellido_materno_M').val(),
                    'fechaN':$('#date_M').val(),
                    'sexoId':$('#txt_sexoId_M').val(),
                    'tel_rec':$('#txt_tel_Rec_M').val(),
                    'tel_casa':$('#txt_tel_Casa_M').val(),
                    'tel_cel':$('#txt_tel_Cel_M').val(),
                    'email':$('#txt_email_M').val(),
                    'calle':$('#txt_calle_M').val(),
                    'nInt':$('#txt_nInterior_M').val(),
                    'nExt':$('#txt_nExterior_M').val(),
                    'estadoId':$('#sel_estadoId_M').val(),
                    'municipioId':$('#sel_municipioId_M').val(),
                    'roleId':$('#sel_roleId_M').val()
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Configuracion_Controller/ConfiguracionUsuarios/?UsuarioId="+window.btoa(usuarioId);
                    },100)
                },
                error: function (xhr, message , code){
                    console.log(this);
                }
            });
        }
    })
}

function ImprimirReporteCredenciales(){
    var campos={
        'usuario':$('#txt-usuario').val(),
        'contrasenia':$('#txt-contrasenia').val()
    }
    //console.log(campos);
    $('#iframe_ModalCredenciales').attr('src',$base_url+"Reporte_Controller/ReporteImprimeCredenciales/?datos="+JSON.stringify(campos));
    $('#ModalImprimeCredenciales').modal('show');
}

function redireccionarPorCredencialesAcceso(){
    var usuarioId = document.getElementById('txt-UsuarioId').value;
    location.href=$base_url+"Configuracion_Controller/ConfiguracionUsuarios/?UsuarioId="+window.btoa(usuarioId);
}




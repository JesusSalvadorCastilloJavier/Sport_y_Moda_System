$(document).ready(function(){

    $('body').on('click','#btn-agregar-proveedor',function(){
        $('#modal-agregar-proveedor').modal();
    });

    $('body').on('click','#btn-modificar-proveedor',function(){
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
        $('#modal-modificar-proveedor').modal();
    });

    $('#sel-estadoId').change(function(){
        recargaListaMunicipios();
    });
    $('#sel_estadoId_M').change(function(){
        recargaListaMunicipios_M();
    });

});

function agregar_proveedor(){
    var usuarioId = document.getElementById('txt-UsuarioId').value;
    Swal.fire({
        title: '¡¡¡ Agregando un proveedor !!!',
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
                title: '¡¡¡ El proveedor ha sido agregado exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
              }),
            $.ajax({
                type:"POST",
                url: $base_url+"Configuracion_Controller/agregarProveedor",
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
                    'municipioId':$('#sel-municipioId').val()
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Configuracion_Controller/ConfiguracionProveedores/?UsuarioId="+window.btoa(usuarioId);
                    },100)
                },
                error: function (xhr, message , code){
                    console.log(this);
                }
            });
        }
    });
}

function ModificarProveedorModal(element){
    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdProveedorId = $(etiquetaTR).children('td#ProveedorId').text();
    //alert(tdUsuarioId);
    $.ajax({
        type:"POST",
        url:$base_url+"Configuracion_Controller/getProveedorByProveedorId",
        data:{
            proveedorId:tdProveedorId
        },
        success: function(data){
            var datosModalProveedor=JSON.parse(data);                                                //Debo convertir a JSON
            //console.log(datosModalProveedor);
            document.formModificarProveedor.sel_estadoId_M.value=datosModalProveedor[0]['EstadoId'];
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
            document.formModificarProveedor.sel_municipioId_M.value=datosModalProveedor[0]['EstadosMunicipiosId'];

            document.formModificarProveedor.txt_proveedorModificarId.value=datosModalProveedor[0]['ProveedorId'];
            document.formModificarProveedor.txt_nombre_M.value=datosModalProveedor[0]['Persona_Nombre'];
            document.formModificarProveedor.txt_apellido_paterno_M.value=datosModalProveedor[0]['Persona_ApellidoPaterno'];
            document.formModificarProveedor.txt_apellido_materno_M.value=datosModalProveedor[0]['Persona_ApellidoMaterno'];
            document.formModificarProveedor.date_M.value=datosModalProveedor[0]['Persona_FechaNacimiento'];
            document.formModificarProveedor.txt_sexoId_M.value=datosModalProveedor[0]['SexoId'];
            document.formModificarProveedor.txt_tel_Rec_M.value=datosModalProveedor[0]['Contacto_TelRecados'];
            document.formModificarProveedor.txt_tel_Casa_M.value=datosModalProveedor[0]['Contacto_TelCasa'];
            document.formModificarProveedor.txt_tel_Cel_M.value=datosModalProveedor[0]['Contacto_TelCelular'];
            document.formModificarProveedor.txt_email_M.value=datosModalProveedor[0]['Contacto_Email'];
            document.formModificarProveedor.txt_calle_M.value=datosModalProveedor[0]['Direccion_Calle'];
            document.formModificarProveedor.txt_nInterior_M.value=datosModalProveedor[0]['Direccion_NumeroInterior'];
            document.formModificarProveedor.txt_nExterior_M.value=datosModalProveedor[0]['Direccion_NumeroExterior'];
            
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


function Eliminar_proveedor(element){
    var UsuarioIdGlobal = document.getElementById('UsuarioIdGlobal').value;

    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdId = $(etiquetaTR).children('td#ProveedorId').text();
    var tdProveedor = $(etiquetaTR).children('td#Nombre').text();

    Swal.fire({
        title: '¿Deseas eliminar al proveedor '+tdProveedor+'?',
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
                title: '¡¡¡ El proveedor ha sido eliminado exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
              }),
            $.ajax({
                type: "POST",
                url: $base_url+"Configuracion_Controller/eliminarProveedor",
                data: {
                    UsuarioIdGlobal:UsuarioIdGlobal,
                    ProveedorId: tdId 
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Configuracion_Controller/ConfiguracionProveedores/?UsuarioId="+window.btoa(UsuarioIdGlobal);
                    },100)
                },
                error:function (xhr,message, code){
                    console.log(this);
                }
            });
        }
    });
}

function modificar_proveedor(){
    var usuarioId = document.getElementById('txt-UsuarioId-M').value;
    //alert($('#txt_nombre_M').val());
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
                title: '¡¡¡ El proveedor ha sido modificado exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
             }),
            $.ajax({
                type:"POST",
                url: $base_url+"Configuracion_Controller/modificarProveedor",
                data:{
                    'usuarioId':usuarioId,
                    'proveedorModificarId':$('#txt_proveedorModificarId').val(),
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
                    'municipioId':$('#sel_municipioId_M').val()
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Configuracion_Controller/ConfiguracionProveedores/?UsuarioId="+window.btoa(usuarioId);
                    },100)
                },
                error: function (xhr, message , code){
                    console.log(this);
                }
            });
        }
    });
}





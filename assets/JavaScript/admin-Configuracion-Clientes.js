$(document).ready(function(){

    $('body').on('click','#btn-agregar-cliente',function(){
        $('#modal-agregar-cliente').modal();
    });

    $('body').on('click','#btn-modificar-cliente',function(){
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
        $('#modal-modificar-cliente').modal();
    });

    $('#sel-estadoId').change(function(){
        recargaListaMunicipios();
    });
    $('#sel_estadoId_M').change(function(){
        recargaListaMunicipios_M();
    });

});

function agregar_cliente(){
    var usuarioId = document.getElementById('txt-UsuarioId').value;
    Swal.fire({
        title: '¡¡¡ Agregando un clientes !!!',
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
                title: '¡¡¡ El cliente ha sido agregado exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
              }),
            $.ajax({
                type:"POST",
                url: $base_url+"Configuracion_Controller/agregarCliente",
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
                        location.href=$base_url+"Configuracion_Controller/ConfiguracionClientes/?UsuarioId="+window.btoa(usuarioId);
                    },100)
                },
                error: function (xhr, message , code){
                    console.log(this);
                }
            });
        }
    });
}

function ModificarClienteModal(element){
    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdClienteId = $(etiquetaTR).children('td#ClienteId').text();
    //alert(tdUsuarioId);
    $.ajax({
        type:"POST",
        url:$base_url+"Configuracion_Controller/getClienteByClienteId",
        data:{
            clienteId:tdClienteId
        },
        success: function(data){
            var datosModalCliente=JSON.parse(data);                                                //Debo convertir a JSON
            //console.log(datosModalCliente);
            document.formModificarCliente.sel_estadoId_M.value=datosModalCliente[0]['EstadoId'];
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
            document.formModificarCliente.sel_municipioId_M.value=datosModalCliente[0]['EstadosMunicipiosId'];
            document.formModificarCliente.txt_clienteModificarId.value=datosModalCliente[0]['ClienteId'];
            document.formModificarCliente.txt_nombre_M.value=datosModalCliente[0]['Persona_Nombre'];
            document.formModificarCliente.txt_apellido_paterno_M.value=datosModalCliente[0]['Persona_ApellidoPaterno'];
            document.formModificarCliente.txt_apellido_materno_M.value=datosModalCliente[0]['Persona_ApellidoMaterno'];
            document.formModificarCliente.date_M.value=datosModalCliente[0]['Persona_FechaNacimiento'];
            document.formModificarCliente.txt_sexoId_M.value=datosModalCliente[0]['SexoId'];
            document.formModificarCliente.txt_tel_Rec_M.value=datosModalCliente[0]['Contacto_TelRecados'];
            document.formModificarCliente.txt_tel_Casa_M.value=datosModalCliente[0]['Contacto_TelCasa'];
            document.formModificarCliente.txt_tel_Cel_M.value=datosModalCliente[0]['Contacto_TelCelular'];
            document.formModificarCliente.txt_email_M.value=datosModalCliente[0]['Contacto_Email'];
            document.formModificarCliente.txt_calle_M.value=datosModalCliente[0]['Direccion_Calle'];
            document.formModificarCliente.txt_nInterior_M.value=datosModalCliente[0]['Direccion_NumeroInterior'];
            document.formModificarCliente.txt_nExterior_M.value=datosModalCliente[0]['Direccion_NumeroExterior'];
            

            
        },
        error: function (request, status, error){
            console.log(request.responseText);
        }
    });
    
}

function recargaListaMunicipios(){

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


function Eliminar_cliente(element){
    var UsuarioIdGlobal = document.getElementById('UsuarioIdGlobal').value;

    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdId = $(etiquetaTR).children('td#ClienteId').text();
    var tdCliente = $(etiquetaTR).children('td#Nombre').text();

    Swal.fire({
        title: '¿Deseas eliminar al cliente '+tdCliente+'?',
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
                title: '¡¡¡ El cliente ha sido eliminado exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
              }),
            $.ajax({
                type: "POST",
                url: $base_url+"Configuracion_Controller/eliminarCliente",
                data: {
                    UsuarioIdGlobal:UsuarioIdGlobal,
                    ClienteId: tdId 
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Configuracion_Controller/ConfiguracionClientes/?UsuarioId="+window.btoa(UsuarioIdGlobal);
                    },100)
                },
                error:function (xhr,message, code){
                    console.log(this);
                }
            });
        }
    });
}

function modificar_cliente(){
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
                title: '¡¡¡ El cliente ha sido modificado exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
             }),
            $.ajax({
                type:"POST",
                url: $base_url+"Configuracion_Controller/modificarCliente",
                data:{
                    'usuarioId':usuarioId,
                    'clienteModificarId':$('#txt_clienteModificarId').val(),
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
                        location.href=$base_url+"Configuracion_Controller/ConfiguracionClientes/?UsuarioId="+window.btoa(usuarioId);
                    },100)
                },
                error: function (xhr, message , code){
                    console.log(this);
                }
            });
        }
    });
}





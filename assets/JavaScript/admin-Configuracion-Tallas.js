$(document).ready(function(){
    
    $('body').on('click','#btn-agregar-talla',function(){
        $('#modal-agregar-talla').modal();
    });

    $('body').on('click','#btn-modificar-talla',function(){
        $("#txt_tallaL_M").val("");
        $("#txt_tallaN_M").val("");
        $('#modal-modificar-talla').modal();
    });

});

function agregar_talla(){
    var usuarioId = document.getElementById('txt-UsuarioId').value;
    Swal.fire({
        title: '¡¡¡ Agregando talla !!!',
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
                title: '¡¡¡ La talla ha sido agregado exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
              }),
            $.ajax({
                type:"POST",
                url: $base_url+"Configuracion_Controller/agregarTalla",
                data:{
                    'usuarioId':usuarioId,
                    'Talla_Talla':$('#txt_tallaL').val(),
                    'Talla_Numero':$('#txt_tallaN').val()
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Configuracion_Controller/ConfiguracionTallas/?UsuarioId="+window.btoa(usuarioId);
                    },100)
                },
                error: function (xhr, message , code){
                    console.log(this);
                }
            });
        }
    });
}

function Eliminar_Talla(element){
    var UsuarioIdGlobal = document.getElementById('UsuarioIdGlobal').value;

    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdId = $(etiquetaTR).children('td#TallaId').text();
    var tdTalla = $(etiquetaTR).children('td#Talla_Talla').text();

    Swal.fire({
        title: '¿Deseas eliminar la talla '+tdTalla+'?',
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
                title: '¡¡¡ La talla ha sido eliminado exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
              }),
            $.ajax({
                type: "POST",
                url: $base_url+"Configuracion_Controller/eliminarTalla",
                data: {
                    UsuarioId:UsuarioIdGlobal,
                    TallaId: tdId 
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Configuracion_Controller/ConfiguracionTallas/?UsuarioId="+window.btoa(UsuarioIdGlobal);
                    },100)
                },
                error:function (xhr,message, code){
                    console.log(this);
                }
            });
        }
    });
    
}

function ModificarTallaModal(element){
    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdTallaId = $(etiquetaTR).children('td#TallaId').text();
    //alert(tdColorId);
    $.ajax({
        type:"POST",
        url:$base_url+"Configuracion_Controller/getTallaByTallaId",
        data:{
            TallaId:tdTallaId
        },
        success: function(data){
            var datosModalTalla=JSON.parse(data);                                                //Debo convertir a JSON
            //console.log(datosModalTalla);
            document.formModificarTalla.txt_tallaModificarId_M.value=datosModalTalla[0]['TallaId'];
            document.formModificarTalla.txt_tallaL_M.value=datosModalTalla[0]['Talla_Talla'];  
            document.formModificarTalla.txt_tallaN_M.value=datosModalTalla[0]['Talla_Numero'];          
        },
        error: function (request, status, error){
            console.log(request.responseText);
        }
    });
    
}


function modificar_talla(){
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
                title: '¡¡¡ La talla ha sido modificado exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
             }),
            $.ajax({
                type:"POST",
                url: $base_url+"Configuracion_Controller/modificarTalla",
                data:{
                    'UsuarioId':usuarioId,
                    'TallaId':$('#txt_tallaModificarId_M').val(),
                    'Talla_Talla':$('#txt_tallaL_M').val(),
                    'Talla_Numero':$('#txt_tallaN_M').val()
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Configuracion_Controller/ConfiguracionTallas/?UsuarioId="+window.btoa(usuarioId);
                    },100)
                },
                error: function (request, status, error){
                    console.log(request.responseText);
                }
            });
        }
    });
}

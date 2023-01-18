$(document).ready(function(){

    $('body').on('click','#btn-agregar-color',function(){
        $('#modal-agregar-color').modal();
    });

    $('body').on('click','#btn-modificar-color',function(){
        $("#txt_color_M").val("");
        $('#modal-modificar-color').modal();
    });
});


function agregar_color(){
    
    var usuarioId = document.getElementById('txt-UsuarioId').value;
    Swal.fire({
        title: '¡¡¡ Agregando un color !!!',
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
                title: '¡¡¡ El color ha sido agregado exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
              }),
            $.ajax({
                type:"POST",
                url: $base_url+"Configuracion_Controller/agregarColor",
                data:{
                    'usuarioId':usuarioId,
                    'Color_Color':$('#txt_color').val()
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Configuracion_Controller/ConfiguracionColores/?UsuarioId="+window.btoa(usuarioId);
                        
                    },100)
                },
                error: function (xhr, message , code){
                    console.log(this);
                }
            });
        }
    });
}


function Eliminar_color(element){
    var UsuarioIdGlobal = document.getElementById('UsuarioIdGlobal').value;

    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdId = $(etiquetaTR).children('td#ColorId').text();
    var tdColor = $(etiquetaTR).children('td#Color_Color').text();

    Swal.fire({
        title: '¿Deseas eliminar el color '+tdColor+'?',
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
                title: '¡¡¡ El color ha sido eliminado exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
              }),
            $.ajax({
                type: "POST",
                url: $base_url+"Configuracion_Controller/eliminarColor",
                data: {
                    UsuarioId:UsuarioIdGlobal,
                    ColorId: tdId 
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Configuracion_Controller/ConfiguracionColores/?UsuarioId="+window.btoa(UsuarioIdGlobal);
                    },100)
                },
                error:function (xhr,message, code){
                    console.log(this);
                }
            });
        }
    });
}


function ModificarColorModal(element){
    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdColorId = $(etiquetaTR).children('td#ColorId').text();
    //alert(tdColorId);
    $.ajax({
        type:"POST",
        url:$base_url+"Configuracion_Controller/getColorByColorId",
        data:{
            colorId:tdColorId
        },
        success: function(data){
            var datosModalColor=JSON.parse(data);                                                //Debo convertir a JSON
            //console.log(datosModalColor);
            document.formModificarColor.txt_colorModificarId_M.value=datosModalColor[0]['ColorId'];
            document.formModificarColor.txt_color_M.value=datosModalColor[0]['Color_Color'];           
        },
        error: function (request, status, error){
            console.log(request.responseText);
        }
    });
    
}

function modificar_color(){
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
                title: '¡¡¡ El color ha sido modificado exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
             }),
            $.ajax({
                type:"POST",
                url: $base_url+"Configuracion_Controller/modificarColor",
                data:{
                    'UsuarioId':usuarioId,
                    'ColorId':$('#txt_colorModificarId_M').val(),
                    'Color_Color':$('#txt_color_M').val()
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Configuracion_Controller/ConfiguracionColores/?UsuarioId="+window.btoa(usuarioId);
                    },100)
                },
                error: function (request, status, error){
                    console.log(request.responseText);
                }
            });
        }
    });
}


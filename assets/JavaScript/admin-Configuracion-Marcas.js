$(document).ready(function(){

    $('body').on('click','#btn-agregar-marca',function(){
        $('#modal-agregar-marca').modal();
    });

    $('body').on('click','#btn-modificar-marca',function(){
        $("#txt_marca_M").val("");
        $('#modal-modificar-marca').modal();
    });

});

function agregar_marca(){

    var usuarioId = document.getElementById('txt-UsuarioId').value;
    Swal.fire({
        title: '¡¡¡ Agregando marca !!!',
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
                title: '¡¡¡ La marca ha sido agregada exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
              }),
            $.ajax({
                type:"POST",
                url: $base_url+"Configuracion_Controller/agregarMarca",
                data:{
                    'usuarioId':usuarioId,
                    'Marca_Marca':$('#txt_marca').val()
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Configuracion_Controller/ConfiguracionMarcas/?UsuarioId="+window.btoa(usuarioId);
                        
                    },100)
                },
                error: function (xhr, message , code){
                    console.log(this);
                }
            });
        }
    });
}


function ModificarMarcaModal(element){
    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdMarcaId = $(etiquetaTR).children('td#MarcaId').text();
    //alert(tdColorId);
    $.ajax({
        type:"POST",
        url:$base_url+"Configuracion_Controller/getMarcaByMarcaId",
        data:{
            marcaId:tdMarcaId
        },
        success: function(data){
            var datosModalMarca=JSON.parse(data);                                                //Debo convertir a JSON
            //console.log(datosModalMarca);
            document.formModificarMarca.txt_marcaModificarId_M.value=datosModalMarca[0]['MarcaId'];
            document.formModificarMarca.txt_marca_M.value=datosModalMarca[0]['Marca_Marca'];           
        },
        error: function (request, status, error){
            console.log(request.responseText);
        }
    });
    
}

function modificar_marca(){
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
                title: '¡¡¡ La marca ha sido modificada  exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
             }),
            $.ajax({
                type:"POST",
                url: $base_url+"Configuracion_Controller/modificarMarca",
                data:{
                    'UsuarioId':usuarioId,
                    'MarcaId':$('#txt_marcaModificarId_M').val(),
                    'Marca_Marca':$('#txt_marca_M').val()
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Configuracion_Controller/ConfiguracionMarcas/?UsuarioId="+window.btoa(usuarioId);
                    },100)
                },
                error: function (request, status, error){
                    console.log(request.responseText);
                }
            });
        }
    });
}

function Eliminar_marca(element){
    var UsuarioIdGlobal = document.getElementById('UsuarioIdGlobal').value;

    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdId = $(etiquetaTR).children('td#MarcaId').text();
    var tdMarca = $(etiquetaTR).children('td#Marca_Marca').text();

    Swal.fire({
        title: '¿Deseas eliminar la marca '+tdMarca+'?',
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
                title: '¡¡¡ La marca ha sido eliminada exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
              }),
            $.ajax({
                type: "POST",
                url: $base_url+"Configuracion_Controller/eliminarMarca",
                data: {
                    UsuarioId:UsuarioIdGlobal,
                    MarcaId: tdId 
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Configuracion_Controller/ConfiguracionMarcas/?UsuarioId="+window.btoa(UsuarioIdGlobal);
                    },100)
                },
                error:function (xhr,message, code){
                    console.log(this);
                }
            });
        }
    });
}
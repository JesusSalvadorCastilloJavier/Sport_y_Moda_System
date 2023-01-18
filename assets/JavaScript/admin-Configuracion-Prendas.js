$(document).ready(function(){

    $('body').on('click','#btn-agregar-prenda',function(){
        $('#modal-agregar-prenda').modal();
    });

    $('body').on('click','#btn-modificar-prenda',function(){
        $('#txt_prenda_M').val("");
        $('#txt_prenda_descripcion_M').val("");
        $('#txt_inventario_M').val("");
        $('#txt_precio_entrada_M').val("");
        $('#txt_precio_salida_M').val("");
        $('#modal-modificar-prenda').modal();
    });

    $('body').on('click','#btn-agregar-talla-prenda-existente',function(){
        $('#txt_prenda_T').val("");
        $('#txt_prenda_descripcion_T').val("");
        $('#txt_inventario_T').val("");
        $('#txt_precio_entrada_T').val("");
        $('#txt_precio_salida_T').val("");
        $('#modal-talla-prenda-existente').modal();
    });
});

function agregar_prenda(){
    var usuarioId = document.getElementById('txt-UsuarioId').value;
    Swal.fire({
        title: '¡¡¡ Agregando un prenda !!!',
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
                title: '¡¡¡ La prenda ha sido agregada exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
              }),
            $.ajax({
                type:"POST",
                url: $base_url+"Almacen_Controller/agregarInventario",
                data:{
                    'usuarioId':usuarioId,
                    'Prenda_Prenda':$('#txt-prenda').val(),
                    'Prenda_Descripcion':$('#txt-prenda-descripcion').val(),
                    'Prenda_Inventario':$('#txt-inventario').val(),
                    'Prenda_PrecioEntrada':$('#txt-precio-entrada').val(),
                    'Prenda_PrecioSalida':$('#txt-precio-salida').val(),
                    'Prenda_GeneroId':$('#txt-generoId').val(),
                    'Prenda_MarcaId':$('#txt-marcaId').val(),
                    'Prenda_TallaId':$('#txt-tallaId').val(),
                    'Prenda_ColorPrimarioId':$('#txt-colorIdP').val(),
                    'Prenda_ColorSecundarioId':$('#txt-colorIdS').val(),
                    'Prenda_ProveedorId':$('#txt-proveedorId').val()
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Almacen_Controller/ConfiguracionInventario/?UsuarioId="+window.btoa(usuarioId);
                    },100)
                },
                error: function (xhr, message , code){
                    console.log(this);
                }
            });
        }
    });
}

function ModificarPrendaModal(element){
    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdPrendaId = $(etiquetaTR).children('td#PrendaId').text();
    //alert(tdUsuarioId);
    $.ajax({
        type:"POST",
        url:$base_url+"Almacen_Controller/getPrendaByPrendaId",
        data:{
            PrendaId:tdPrendaId
        },
        success: function(data){
            var datosModalPrenda=JSON.parse(data);                                                //Debo convertir a JSON
            //console.log(datosModalPrenda);
            document.formModificarPrenda.txt_PrendaId_M.value=datosModalPrenda[0]['PrendaId'];
            document.formModificarPrenda.txt_prenda_M.value=datosModalPrenda[0]['Prenda_Prenda'];
            document.formModificarPrenda.txt_prenda_descripcion_M.value=datosModalPrenda[0]['Prenda_Descripcion'];
            document.formModificarPrenda.txt_inventario_M.value=datosModalPrenda[0]['Prenda_Inventario'];
            document.formModificarPrenda.txt_precio_entrada_M.value=datosModalPrenda[0]['Prenda_PrecioEntrada'];
            document.formModificarPrenda.txt_precio_salida_M.value=datosModalPrenda[0]['Prenda_PrecioSalida'];
            document.formModificarPrenda.txt_generoId_M.value=datosModalPrenda[0]['Prenda_GeneroId'];
            document.formModificarPrenda.txt_marcaId_M.value=datosModalPrenda[0]['Prenda_MarcaId'];
            document.formModificarPrenda.txt_tallaId_M.value=datosModalPrenda[0]['Prenda_TallaId'];
            document.formModificarPrenda.txt_colorIdP_M.value=datosModalPrenda[0]['Prenda_ColorPrimarioId'];
            document.formModificarPrenda.txt_colorIdS_M.value=datosModalPrenda[0]['Prenda_ColorSecundarioId'];
            document.formModificarPrenda.txt_proveedorId_M.value=datosModalPrenda[0]['Prenda_ProveedorId'];
        },
        error: function (request, status, error){
            console.log(request.responseText);
        }
    });
    
}

function modificar_prenda(){
    var usuarioId = document.getElementById('txt_UsuarioId_M').value;
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
                title: '¡¡¡ La prenda ha sido modificada exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
             }),
            $.ajax({
                type:"POST",
                url: $base_url+"Almacen_Controller/modificarInventario",
                data:{
                    'usuarioId':usuarioId,
                    'PrendaId':$('#txt_PrendaId_M').val(),
                    'Prenda_Prenda':$('#txt_prenda_M').val(),
                    'Prenda_Descripcion':$('#txt_prenda_descripcion_M').val(),
                    'Prenda_Inventario':$('#txt_inventario_M').val(),
                    'Prenda_PrecioEntrada':$('#txt_precio_entrada_M').val(),
                    'Prenda_PrecioSalida':$('#txt_precio_salida_M').val(),
                    'Prenda_GeneroId':$('#txt_generoId_M').val(),
                    'Prenda_MarcaId':$('#txt_marcaId_M').val(),
                    'Prenda_TallaId':$('#txt_tallaId_M').val(),
                    'Prenda_ColorPrimarioId':$('#txt_colorIdP_M').val(),
                    'Prenda_ColorSecundarioId':$('#txt_colorIdS_M').val(),
                    'Prenda_ProveedorId':$('#txt_proveedorId_M').val()
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Almacen_Controller/ConfiguracionInventario/?UsuarioId="+window.btoa(usuarioId);
                    },100)
                },
                error: function (xhr, message , code){
                    console.log(this);
                }
            });
        }
    });
}


function Eliminar_prenda(element){
    var UsuarioIdGlobal = document.getElementById('UsuarioIdGlobal').value;

    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdId = $(etiquetaTR).children('td#PrendaId').text();
    var tdPrenda_Prenda = $(etiquetaTR).children('td#Prenda_Prenda').text();

    Swal.fire({
        title: '¿Deseas eliminar la prenda '+tdPrenda_Prenda+'?',
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
                title: '¡¡¡ La prenda ha sido eliminada exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
              }),
            $.ajax({
                type: "POST",
                url: $base_url+"Almacen_Controller/eliminarPrenda",
                data: {
                    UsuarioIdGlobal:UsuarioIdGlobal,
                    PrendaId: tdId 
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Almacen_Controller/ConfiguracionInventario/?UsuarioId="+window.btoa(UsuarioIdGlobal);
                    },100)
                },
                error:function (xhr,message, code){
                    console.log(this);
                }
            });
        }
    });
}

function ImprimirPrenda(element){
    
    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdPrendaId = $(etiquetaTR).children('td#PrendaId').text();

    $('#modalTiket').modal('show');
    $('#iframe_ModalTiket').attr('src',$base_url+"Almacen_Controller/ReportePrenda/"+tdPrendaId);
    //window.open($base_url+"Almacen_Controller/ReportePrenda/"+tdPrendaId, '_blank');
    
}


function AgregarTallaPrendaExistente(element){
    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdPrendaId = $(etiquetaTR).children('td#PrendaId').text();
    //alert(tdUsuarioId);
    $.ajax({
        type:"POST",
        url:$base_url+"Almacen_Controller/getPrendaByPrendaId",
        data:{
            PrendaId:tdPrendaId
        },
        success: function(data){
            var datosModalPrenda=JSON.parse(data);                                                //Debo convertir a JSON
            //console.log(datosModalPrenda);
            document.formagregarTallaPrendaExistente.txt_PrendaId_T.value=datosModalPrenda[0]['PrendaId'];
            document.formagregarTallaPrendaExistente.txt_prenda_T.value=datosModalPrenda[0]['Prenda_Prenda'];
            document.formagregarTallaPrendaExistente.txt_prenda_descripcion_T.value=datosModalPrenda[0]['Prenda_Descripcion'];
            document.formagregarTallaPrendaExistente.txt_precio_entrada_T.value=datosModalPrenda[0]['Prenda_PrecioEntrada'];
            document.formagregarTallaPrendaExistente.txt_precio_salida_T.value=datosModalPrenda[0]['Prenda_PrecioSalida'];
            document.formagregarTallaPrendaExistente.txt_generoId_T.value=datosModalPrenda[0]['Prenda_GeneroId'];
            document.formagregarTallaPrendaExistente.txt_marcaId_T.value=datosModalPrenda[0]['Prenda_MarcaId'];
            document.formagregarTallaPrendaExistente.txt_colorIdP_T.value=datosModalPrenda[0]['Prenda_ColorPrimarioId'];
            document.formagregarTallaPrendaExistente.txt_colorIdS_T.value=datosModalPrenda[0]['Prenda_ColorSecundarioId'];
            document.formagregarTallaPrendaExistente.txt_proveedorId_T.value=datosModalPrenda[0]['Prenda_ProveedorId'];
            
        },
        error: function (request, status, error){
            console.log(request.responseText);
        }
    });
    
}

function agregar_talla_prenda_existente(){
   
    var usuarioId = document.getElementById('txt_UsuarioId_T').value;
    var dato=$('#txt_tallaId_T').val();
    //alert(dato);
    Swal.fire({
        title: 'Agregar talla de prenda existente',
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
                title: '¡¡¡ La prenda ha sido agregada exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
             }),
            $.ajax({
                type:"POST",
                url: $base_url+"Almacen_Controller/agregarInventario",
                data:{
                    'usuarioId':usuarioId,
                    'Prenda_Prenda':$('#txt_prenda_T').val(),
                    'Prenda_Descripcion':$('#txt_prenda_descripcion_T').val(),
                    'Prenda_Inventario':$('#txt_inventario_T').val(),
                    'Prenda_PrecioEntrada':$('#txt_precio_entrada_T').val(),
                    'Prenda_PrecioSalida':$('#txt_precio_salida_T').val(),
                    'Prenda_GeneroId':$('#txt_generoId_T').val(),
                    'Prenda_MarcaId':$('#txt_marcaId_T').val(),
                    'Prenda_TallaId':$('#txt_tallaId_T').val(),
                    'Prenda_ColorPrimarioId':$('#txt_colorIdP_T').val(),
                    'Prenda_ColorSecundarioId':$('#txt_colorIdS_T').val(),
                    'Prenda_ProveedorId':$('#txt_proveedorId_T').val()
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Almacen_Controller/ConfiguracionInventario/?UsuarioId="+window.btoa(usuarioId);
                    },100)
                },
                error: function (xhr, message , code){
                    console.log(this);
                }
            });
        }
    });
}

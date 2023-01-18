$(document).ready(function(){

    $('body').on('click','#btn-entrada-prenda',function(){
        $('#txt_prenda_M').val("");
        $('#txt_prenda_descripcion_M').val("");
        $('#txt_inventario_M').val("");
        $('#txt_precio_entrada_M').val("");
        $('#txt_precio_salida_M').val("");
        $('#modal-entrada-prenda').modal();
    });

});

function EntradaPrendaModal(element){
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
            document.formEntradaPrenda.txt_PrendaId_M.value=datosModalPrenda[0]['PrendaId'];
            document.formEntradaPrenda.txt_prenda_M.value=datosModalPrenda[0]['Prenda_Prenda'];
            document.formEntradaPrenda.txt_prenda_descripcion_M.value=datosModalPrenda[0]['Prenda_Descripcion'];
            document.formEntradaPrenda.txt_inventario_M.value=datosModalPrenda[0]['Prenda_Inventario'];
            document.formEntradaPrenda.txt_precio_entrada_M.value=datosModalPrenda[0]['Prenda_PrecioEntrada'];
            document.formEntradaPrenda.txt_precio_salida_M.value=datosModalPrenda[0]['Prenda_PrecioSalida'];
            document.formEntradaPrenda.txt_generoId_M.value=datosModalPrenda[0]['Prenda_GeneroId'];
            document.formEntradaPrenda.txt_marcaId_M.value=datosModalPrenda[0]['Prenda_MarcaId'];
            document.formEntradaPrenda.txt_tallaId_M.value=datosModalPrenda[0]['Prenda_TallaId'];
            document.formEntradaPrenda.txt_colorIdP_M.value=datosModalPrenda[0]['Prenda_ColorPrimarioId'];
            document.formEntradaPrenda.txt_colorIdS_M.value=datosModalPrenda[0]['Prenda_ColorSecundarioId'];
            document.formEntradaPrenda.txt_proveedorId_M.value=datosModalPrenda[0]['Prenda_ProveedorId'];
        },
        error: function (request, status, error){
            console.log(request.responseText);
        }
    });
    
}

function entrada_prenda(){
    var usuarioId = document.getElementById('txt_UsuarioId_M').value;
    Swal.fire({
        title: 'Agregar cantidad de esta prenda',
        text: "¿Los datos son correctos?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, agregar!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'success',
                title: '¡¡¡La prenda ha sido agregada exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
             }),
            $.ajax({
                type:"POST",
                url: $base_url+"Almacen_Controller/AddEntradasInventario",
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
                    'Prenda_ProveedorId':$('#txt_proveedorId_M').val(),
                    'EntradaPrenda_Cantidad':$('#txt_cantidadAgregar').val()
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Almacen_Controller/EntradasInventario/?UsuarioId="+window.btoa(usuarioId);
                    },100)
                },
                error: function (xhr, message , code){
                    console.log(this);
                }
            });
        }
    });
}





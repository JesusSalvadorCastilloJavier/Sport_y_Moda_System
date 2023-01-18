$(document).ready(function(){
    $('body').on('click','#btn-Detalle-Apartado',function(){
        $('#modal-detalle-apartado').modal();
    });
});


function Consultar_Apartado(element){
    $('#tbl-Detalle-Apartado').empty();
    $('#lbl-codigoApartado').empty();
    $("#lbl-Liquidacion").empty();
    $('#lbl-fechaCreacionApartado').empty();
    $('#lbl-CostoTotalFinal').empty();
    $('#lbl-Descuento').empty();
    $('#lbl-Total').empty();
    $("#div-abono").empty();
    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;
    var tdApartadoId = $(etiquetaTR).children('td#apartadoId').text();
    //console.log(tdApartadoId);
    $.ajax({
        type:"POST",
        url:$base_url+"Venta_Controller/getDetalleApartadoByApartadoId",
        data:{
            apartadoId:tdApartadoId
        },
        success: function(data){
            var datosModalDetalleApartado=JSON.parse(data);                                                //Debo convertir a JSON
            //console.log(datosModalDetalleApartado);
            $("#hd-ApartadoId").val(datosModalDetalleApartado[0]['ApartadoId']);
            $("#lbl-codigoApartado").html("<b>Código de apartado:</b> "+datosModalDetalleApartado[0]['Codigo_Apartado']);
            $("#lbl-fechaCreacionApartado").html("<b>Fecha de apartado: </b> "+datosModalDetalleApartado[0]['Fecha']);
            $("#lbl-Total").html("<b>Total: $"+datosModalDetalleApartado[0]['Total']+"</b>");
            $("#lbl-Descuento").html("<b>Descuento de: $"+datosModalDetalleApartado[0]['Descuento']+"</b>");
            $("#lbl-CostoTotalFinal").html("<b>Total Final: $"+datosModalDetalleApartado[0]['TotalFinal']+"</b>");
            $("#lbl-Liquidacion").html("<b>Fecha limite de liquidación:</b> "+datosModalDetalleApartado[0]['FechaLimite']);
            if(datosModalDetalleApartado[0]['Debe']>0){
                $("#div-abono").append('<div class="col-8"><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text">$</span></div><input type="text" class="form-control" id="txt-abono"></div></div><div class="col-4"><button class="btn btn-outline-success btn-block" id="btn-abonar-apartado"><i class="ion-android-add"></i> Abonar</button></div>');    
            }
            for(var i=0;i<datosModalDetalleApartado.length;i++){
                if(i==0){
                    $("#tbl-Detalle-Apartado").append('<thead class="thead-dark"><tr><th scope="col">CÓDIGO</th><th scope="col">DESCRIPCIÓN</th><th scope="col">TALLA</th><th scope="col">PRECIO</th><th scope="col">PIEZAS</th><th scope="col">SUBTOTAL</th></tr></thead>');
                }
                $("#tbl-Detalle-Apartado").append("<tr><td>"+datosModalDetalleApartado[i]['Codigo']+"</td><td>"+datosModalDetalleApartado[i]['Descripcion']+"</td><td>"+datosModalDetalleApartado[i]['Talla']+"</td><td><center><b>$"+datosModalDetalleApartado[i]['Precio']+"</b></center></td><td><center><b>"+datosModalDetalleApartado[i]['Cantidad']+"</b></center></td><td><b>$ "+datosModalDetalleApartado[i]['SubTotal']+"</b></td></tr>");
            }          
        },
        error: function (request, status, error){
            console.log(request.responseText);
        }
    });
}


$('body').on('click','#btn-abonar-apartado',function(){
    var usuarioId = document.getElementById('UsuarioIdGlobal').value;
    if(document.getElementById("txt-abono").value=="" || document.getElementById("txt-abono").value==""==null){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Es necesario una cantidad a abonar!!!.'
          })
    }else{
        Swal.fire({
            title: '¡¡¡ Abonando al apartado !!!',
            text: "¿Los datos son correctos?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, abonar!',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: '¡¡¡ Se ha abonado exitosamente !!!',
                    showConfirmButton: false,
                    timer: 2000
                  }),
                $.ajax({
                    type:"POST",
                    url: $base_url+"Venta_Controller/abonarApartado",
                    data:{
                        'usuarioId':usuarioId,
                        'apartadoId':$("#hd-ApartadoId").val(),
                        'montoAbonar':$("#txt-abono").val()
                    },
                    success: function (dataResponse){
                        setTimeout(function(){
                            location.href=$base_url+"Venta_Controller/ConsultaApartados/?UsuarioId="+window.btoa(usuarioId);
                        },100)
                    },
                    error: function (xhr, message , code){
                        console.log(this);
                    }
                });
            }
        });
    }
    

});
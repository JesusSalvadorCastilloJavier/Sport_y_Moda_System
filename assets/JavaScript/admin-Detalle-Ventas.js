$(document).ready(function(){
    $('body').on('click','#btn-Detalle-Venta',function(){
        $('#modal-detalle-venta').modal();
    });
});


function Consultar_Venta(element){
    $('#tbl-Detalle-Venta').empty();
    $('#lbl-codigoVenta').empty();
    $('#lbl-fechaCreacionVenta').empty();
    $('#lbl-CostoTotalFinal').empty();
    $('#lbl-Descuento').empty();
    $('#lbl-Total').empty();
    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;
    var tdVentaId = $(etiquetaTR).children('td#ventaId').text();
    //console.log(tdVentaId);
    $.ajax({
        type:"POST",
        url:$base_url+"Venta_Controller/getDetalleVentaByVentaId",
        data:{
            ventaId:tdVentaId
        },
        success: function(data){
            var datosModalDetalleVenta=JSON.parse(data);                                                //Debo convertir a JSON
            //console.log(datosModalDetalleVenta);
            $("#lbl-codigoVenta").html("<b>Código de venta:</b> "+datosModalDetalleVenta[0]['CodigoVenta']);
            $("#lbl-fechaCreacionVenta").html("<b>Fecha de venta: </b> "+datosModalDetalleVenta[0]['FechaVenta']);
            $("#lbl-Total").html("<b>Total: $"+datosModalDetalleVenta[0]['Total']+"</b>");
            $("#lbl-Descuento").html("<b>Descuento de: $"+datosModalDetalleVenta[0]['Descuento']+"</b>");
            $("#lbl-CostoTotalFinal").html("<b>Total Final: $"+datosModalDetalleVenta[0]['TotalFinal']+"</b>");
            for(var i=0;i<datosModalDetalleVenta.length;i++){
                if(i==0){
                    $("#tbl-Detalle-Venta").append('<thead class="thead-dark"><tr><th scope="col">CÓDIGO</th><th scope="col">DESCRIPCIÓN</th><th scope="col">PRECIO</th><th scope="col">PIEZAS</th><th scope="col">SUBTOTAL</th></tr></thead>');
                }
                $("#tbl-Detalle-Venta").append("<tr><td>"+datosModalDetalleVenta[i]['CodigoPrenda']+"</td><td>"+datosModalDetalleVenta[i]['Descripcion']+"</td><td><b> $"+datosModalDetalleVenta[i]['PrecioPrenda']+"</b></td><td><center>"+datosModalDetalleVenta[i]['CantidadPrenda']+"</center></td><td><b>$ "+datosModalDetalleVenta[i]['subTotal']+"</b></td></tr>");
            }           
        },
        error: function (request, status, error){
            console.log(request.responseText);
        }
    });
}
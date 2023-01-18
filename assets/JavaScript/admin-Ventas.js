var collectionPrendaId_Cantidad=[];
var totalPagar=0;
var totalFinalPagar=0;
var deposito=0;
var cambio=0;


$(function(){
    $("#txt-descuento").keyup(function (e) {
        if($("#txt-descuento").val()==''){
            totalFinalPagar=totalPagar-parseFloat(0);
            $("#lbl-total-final-pagar").text("$"+totalFinalPagar);
        }else{
            totalFinalPagar=totalPagar-parseFloat($("#txt-descuento").val()) ;
            $("#lbl-total-final-pagar").text("$"+totalFinalPagar);
        }
        
    });
    
    $("#txt-deposito").keyup(function (e) {
        if($("#txt-deposito").val()!=''){
            deposito = parseFloat($("#txt-deposito").val());
            totalFinalPagar = parseFloat(totalFinalPagar);
            cambio=deposito-totalFinalPagar;
            $("#lbl-cambio").text("$"+(deposito-totalFinalPagar));
        }else{
            $("#lbl-cambio").text("$0.00");
        }    
    });
});

$(document).ready(function(){
    $('body').on('click','#btn-agregar-carrito',function(){
        $('#txt_prenda_M').val("");
        $('#txt_prenda_descripcion_M').val("");
        $('#txt_inventario_M').val("");
        $('#txt_precio_entrada_M').val("");
        $('#txt_precio_salida_M').val("");
        $('#modal-venta-prenda').modal();
    });
});

$(document).ready(function(){
    $('body').on('click','#btn-terminar-venta',function(){
        $("txt-descuento").val("0.00");
        $("txt-deposito").val("0.00");
        $("#lbl-total").text("$"+totalPagar);
        $("#lbl-total-final-pagar").text("$"+totalPagar);
        $('#modal-Finaliazr-Venta').modal();
    });
});

function agregarCarritoModal(element){
    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdPrendaId = $(etiquetaTR).children('td#PrendaId').text();
    //alert(tdPrendaId);
    $.ajax({
        type:"POST",
        url:$base_url+"Almacen_Controller/getPrendaByPrendaId",
        data:{
            PrendaId:tdPrendaId
        },
        success: function(data){
            var datosModalPrenda=JSON.parse(data);                                                //Debo convertir a JSON
            //console.log(datosModalPrenda);
            document.formAgregarCarrito.txt_PrendaId_M.value=datosModalPrenda[0]['PrendaId'];
            document.formAgregarCarrito.txt_prenda_M.value=datosModalPrenda[0]['Prenda_Prenda'];
            document.formAgregarCarrito.txt_prenda_descripcion_M.value=datosModalPrenda[0]['Prenda_Descripcion'];
            document.formAgregarCarrito.txt_inventario_M.value=datosModalPrenda[0]['Prenda_Inventario'];
            document.formAgregarCarrito.txt_precio_entrada_M.value=datosModalPrenda[0]['Prenda_PrecioEntrada'];
            document.formAgregarCarrito.txt_precio_salida_M.value=datosModalPrenda[0]['Prenda_PrecioSalida'];
            document.formAgregarCarrito.txt_generoId_M.value=datosModalPrenda[0]['Prenda_GeneroId'];
            document.formAgregarCarrito.txt_marcaId_M.value=datosModalPrenda[0]['Prenda_MarcaId'];
            document.formAgregarCarrito.txt_tallaId_M.value=datosModalPrenda[0]['Prenda_TallaId'];
            document.formAgregarCarrito.txt_colorIdP_M.value=datosModalPrenda[0]['Prenda_ColorPrimarioId'];
            document.formAgregarCarrito.txt_colorIdS_M.value=datosModalPrenda[0]['Prenda_ColorSecundarioId'];
            document.formAgregarCarrito.txt_proveedorId_M.value=datosModalPrenda[0]['Prenda_ProveedorId'];
            document.formAgregarCarrito.txt_cantidadAgregar.value=1;
        },
        error: function (request, status, error){
            console.log(request.responseText);
        }
    });
}

function agregarAlCarrito(){
    
    var tblDatos = document.getElementById('tbl-prendas-carrito').insertRow(1);
    var colPrendaId = tblDatos.insertCell(0); 
    var colPrenda = tblDatos.insertCell(1); 
    var colDesccripcion = tblDatos.insertCell(2); 
    var colCantidad = tblDatos.insertCell(3); 
    var colPrecio = tblDatos.insertCell(4);
    var colBorrar = tblDatos.insertCell(5);
    
    colPrendaId.innerHTML=document.getElementById("txt_PrendaId_M").value;
    colPrenda.innerHTML=document.getElementById("txt_prenda_M").value;
    colDesccripcion.innerHTML=document.getElementById("txt_prenda_descripcion_M").value;
    colCantidad.innerHTML="<center>"+document.getElementById("txt_cantidadAgregar").value+"</center>";
    colPrecio.innerHTML="<center><strong>$"+((document.getElementById("txt_precio_salida_M").value)*(document.getElementById("txt_cantidadAgregar").value))+"<strong></center>";
    colBorrar.innerHTML='<button id="borrarPrenda" onclick="restaPrenda(this)" class="btn btn-outline-danger"><i class="ion-close"></i></button>';

    
    collectionPrendaId_Cantidad.push({"PrendaId":document.getElementById("txt_PrendaId_M").value,"PrendaCantidad":document.getElementById("txt_cantidadAgregar").value});
    //Calcula el Total a pagar
    totalPagar += ((document.getElementById("txt_precio_salida_M").value)*(document.getElementById("txt_cantidadAgregar").value));
    $("#lbl-Total-Pagar").text("$"+totalPagar);
    totalFinalPagar=totalPagar;
    $("#lbl-total-final-pagar").text("$"+totalPagar);
    //console.log(collectionPrendaId_Cantidad);
}

function restaPrenda(element){
    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;
    var tdCosto = $(etiquetaTR).find("td:eq(4)").text();
    var tdPrendaId = $(etiquetaTR).find("td:eq(0)").text();
    var tdCantidad = $(etiquetaTR).find("td:eq(3)").text();
    var eliminados=0;
    for(var i =0 ;i<collectionPrendaId_Cantidad.length;i++){
        //console.log(tdPrendaId+" => "+collectionPrendaId_Cantidad[i]['PrendaId']);
        if(tdPrendaId == collectionPrendaId_Cantidad[i]['PrendaId'] && eliminados==0 && tdCantidad==collectionPrendaId_Cantidad[i]['PrendaCantidad'] ){
            collectionPrendaId_Cantidad.splice(i, 1);
            eliminados +=1;
        }
    }

    $("#txt-descuento").val("");
    $("#txt-deposito").val("");

    $("#lbl-cambio").text("$ 0.00");
    totalPagar = totalPagar - (parseFloat(tdCosto.slice(1)));
    $("#lbl-Total-Pagar").text("$"+totalPagar);
}

$(document).on('click', '#borrarPrenda', function(event) {
    event.preventDefault();
    $(this).closest('tr').remove();
  });

  $(document).on('click', '#btn_VaciarTabla', function(event) {
    collectionPrendaId_Cantidad=[];
    totalFinalPagar=0;
    totalPagar=0;
    deposito=0;
    cambio=0;
    $("#txt-deposito").val("");
    $("#lbl-cambio").text("$ 0.00");
    $("#lbl-Total-Pagar").text("$"+totalPagar);
    $("#tbl-prendas-carrito tr>td").remove(); 
  });

function aplicarDescuento(){
    if($("#txt-descuento").val()==''){
        totalFinalPagar=totalPagar-0;
        $("#lbl-total-final-pagar").text("$"+totalFinalPagar);
    }else{
        totalFinalPagar=totalPagar-parseFloat($("#txt-descuento").val()) ;
        $("#lbl-total-final-pagar").text("$"+totalFinalPagar);
    }
    
}

function ejecutarCompra(){
    deposito=$("#txt-deposito").val();
    var usuarioId = document.getElementById('UsuarioIdGlobal').value;
    if(totalFinalPagar>deposito || totalFinalPagar==0 || deposito==0){
        Swal.fire({
            icon: 'error',
            title: '¡¡¡ El deposito es menor a lo que se debe pagar !!!',
            showConfirmButton: false,
            timer: 4000
          });
    }else{
        
        var campos={
            'UsuarioId':usuarioId,
            'dataCollectionPrenda':collectionPrendaId_Cantidad,
            'ClienteId':$("#cmb-ClienteId").val(),
            'descuento':$("#txt-descuento").val(),
            'deposito':$("#txt-deposito").val(),
            'TotalPagar':totalPagar,
            'TotalFinalPagar':totalFinalPagar,
            'cambio':cambio
        }

        //console.log(campos);

        Swal.fire({
            title: 'Realizando compra',
            text: "¿Los datos son correctos?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí!',
            cancelButtonText: 'No'
          }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: '¡¡¡ Generando Ticket !!!',
                    showConfirmButton: false,
                    timer: 2000
                 }),

                 $('#iframe_ModalTiketVenta').attr('src',$base_url+"Venta_Controller/ejecutandoCompra/?datos="+JSON.stringify(campos));
                 $('#modal-Imprime-Ticket').modal('show');
            }
        });
    }
}




function recargarVentas(){
    var usuarioId = document.getElementById('UsuarioIdGlobal').value;
    location.href=$base_url+"Venta_Controller/Nueva_Venta/?UsuarioId="+window.btoa(usuarioId);
}
function ImprimirReporteEntradasFechas(){
    var campos={
        fechaInicio:$('#fecha_inicio').val(),
        fechaFin:$('#fecha_fin').val()
    }
    //console.log(campos);

    $('#iframe_ModalEntradas').attr('src',$base_url+"Reporte_Controller/ReporteEntradasPrendasPorFechas/?datos="+JSON.stringify(campos));
    $('#modalRepEntradas').modal('show');

}



function ImprimirReporteExistencias(){
    var cantidad=$("#txt_cantMax").val();
    //console.log(campos);

    $('#iframe_ModalExistencias').attr('src',$base_url+"Reporte_Controller/ReporteEntradasPrendasExistencias/"+cantidad);
    $('#modalRepExistencias').modal('show');

}
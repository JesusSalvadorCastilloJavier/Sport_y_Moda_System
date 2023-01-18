
function ImprimirReportPorUsuarioId(){
    var campos={
        usuarioId:$('#sel_usuarios_movimientos').val(),
        FechaInicio:$('#fecha_inicio').val(),
        FechaFin:$('#fecha_fin').val()
    }
    //console.log(campos);

    $('#iframe_ModalMovimientos').attr('src',$base_url+"Reporte_Controller/ReporteMovimientosPorUsuarioId/?datos="+JSON.stringify(campos));
    $('#modalRepMovimientos').modal('show');

}

function ImprimirReportDatosPorUsuarioId(){
    var userId=$('#sel_datos_usuario').val();
    $('#iframe_ModalDatos').attr('src',$base_url+"Reporte_Controller/ReporteDatosPorUsuarioId/?UsuarioId="+window.btoa(userId));
    $('#modalRepDatos').modal('show');

}



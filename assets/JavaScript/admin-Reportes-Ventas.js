var myChart;
var myChart2;
var myChart3;
var calendario;

$(document).ready(function () {
    var fecha = new Date();
    var anio = fecha.getFullYear();
    calendario=[];
    $.ajax({
        type:"POST",
        url:$base_url+"Reporte_Controller/ObtenerDatosGrafica",
        data:{
            anio:anio
        },
        success: function(data){
            var datosGrafica=JSON.parse(data);

            for(var i = 0; i < 12; i++){
                calendario.push("0");
                //console.log(i);
                for(var d = 0; d < datosGrafica.length; d++){
                    if((i+1)==datosGrafica[d]['Mes']){
                        calendario[(i+1)]=datosGrafica[d]['MontoTotal'];
                        //console.log("i=>"+(i+1)+"  Mes=>"+datosGrafica[d]['Mes']+"  $=>"+datosGrafica[d]['MontoTotal']);
                    }
                }
            }
            calendario=calendario.splice(1);
            generaGrafica(calendario,anio);
        },
        error: function (request, status, error){
            console.log(request.responseText);
        }
    });
});

$(document).on('change', '#year', function(event) {
    var anio = parseInt($('#year').val());
    calendario=[];
    $.ajax({
        type:"POST",
        url:$base_url+"Reporte_Controller/ObtenerDatosGrafica",
        data:{
            anio:anio
        },
        success: function(data){
            var datosGrafica=JSON.parse(data);
            for(var i = 0; i < 12; i++){
                calendario.push("0");
                //console.log(i);
                for(var d = 0; d < datosGrafica.length; d++){
                    if((i+1)==datosGrafica[d]['Mes']){
                        calendario[(i+1)]=datosGrafica[d]['MontoTotal'];
                        //console.log("i=>"+(i+1)+"  Mes=>"+datosGrafica[d]['Mes']+"  $=>"+datosGrafica[d]['MontoTotal']);
                    }
                }
            }
            calendario=calendario.splice(1);
            generaGrafica(calendario,anio);
        },
        error: function (request, status, error){
            console.log(request.responseText);
        }
    });
});

function generaGrafica(calendario,anio){
    //console.log(calendario);
    var max;
    for(var i=0;i<12;i++){
        if(max<calendario[i]){
            max=calendario[i];
        }
    }
    var ctx = document.getElementById('myChart').getContext('2d');
    if (myChart) {
        myChart.destroy();
    }
    myChart = new Chart(ctx, {
        type: 'radar', //bar,radar,line,pie
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Ventas realizadas en $',
                data: calendario,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 3
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'VENTAS REALIZADAS EN EL AÑO '+anio+'.'
                }
            },

            animations: {
                tension: {
                    duration: 1000,
                    easing: 'linear',
                    from: 0.5,
                    to: 0,
                    loop: true
                }
            },
            scales: {
            y: { // defining min and max so hiding the dataset does not change scale range
                min: 0,
                max: max
            }
            }
        }
    });

    var ctx2 = document.getElementById('myChart2').getContext('2d');
    if (myChart2) {
        myChart2.destroy();
    }
    myChart2 = new Chart(ctx2, {
        type: 'pie', //bar,radar,line,pie
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Ventas realizadas en $',
                data: calendario,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 3
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'VENTAS REALIZADAS EN EL AÑO '+anio+'.'
                }
            },

            animations: {
                tension: {
                    duration: 1000,
                    easing: 'linear',
                    from: 0.5,
                    to: 0,
                    loop: true
                }
            },
            scales: {
            y: { // defining min and max so hiding the dataset does not change scale range
                min: 0,
                max: max
            }
            }
        }
    });

    var ctx3 = document.getElementById('myChart3').getContext('2d');
    if (myChart3) {
        myChart3.destroy();
    }
    myChart3 = new Chart(ctx3, {
        type: 'line', //bar,radar,line,pie
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Ventas realizadas en $',
                data: calendario,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 3
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'VENTAS REALIZADAS EN EL AÑO '+anio+'.'
                }
            },

            animations: {
                tension: {
                    duration: 1000,
                    easing: 'linear',
                    from: 0.5,
                    to: 0,
                    loop: true
                }
            },
            scales: {
            y: { // defining min and max so hiding the dataset does not change scale range
                min: 0,
                max: max
            }
            }
        }
    });
}
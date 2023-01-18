document.addEventListener('DOMContentLoaded', function() {
    var DataJson =JSON.parse($("#txt-FullCalendar").text());
    var arreglado = DataJson.map( item => { 
        return { 
            title: "Caja = $"+item.Caja_MontoInicio, 
            start : item.Caja_FechaCalendario+"T10:00:00",
            color:"#FF3333",
            textColor:"#000000"
            }
        ; 
    });

//start : item.Caja_FechaCalendario+"T"+item.Caja_FechaCreacion.substring(item.Caja_FechaCreacion.length - 8, item.Caja_FechaCreacion.length),
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: "es",
        initialView: 'dayGridMonth',
        events:
        /*[
            {
                title:'Hola',
                start: '2022-05-10T12:00:00',
                //end: '2022-04-14T10:00:00',
                color:"#FF0000",
                textColor:"#000000",
                description: 'Nueva descripción'
            }
        ] */
            arreglado

        ,
        buttonText:{
            today:    'Hoy',
            month:    'Mes',
            week:     'Semana',
            day:      'Dia'
        },
        dateClick: function (info){
            //console.log(info);
            //info.dayEl.style.backgroundColor = 'red';
            $("#mensaje").text("Monto en la caja para el día "+info.dateStr);
            $('#event-description').html(info.dateStr);
            $("#fecha").val(info.dateStr);
            $('#modalEvent').modal();
        }
    });
    calendar.render();
    calendar.today("locale","es");
  });

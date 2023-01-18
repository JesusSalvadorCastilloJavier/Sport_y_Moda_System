function registraCaja(){
   
    var usuarioId=$('#txt-UsuarioId').val();

    Swal.fire({
        title: '¡¡¡ Registrando monto !!!',
        text: "¿Los datos son correctos?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, registralo!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'success',
                title: '¡¡¡ El monto ha sido registrado exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
              }),
            $.ajax({
                type:"POST",
                url: $base_url+"Configuracion_Controller/agregarMontoCaja",
                data:{
                    'usuarioId':usuarioId,
                    'monto':$('#idMontoCaja').val(),
                    'fecha':$('#fecha').val()
                },
                success: function (dataResponse){
                    console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Configuracion_Controller/configuracionCaja/?UsuarioId="+window.btoa(usuarioId);
                        
                    },100)
                },
                error: function (xhr, message , code){
                    console.log(this);
                }
            });
        }
    });
}
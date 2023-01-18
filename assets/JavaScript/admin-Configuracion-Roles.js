$(document).ready(function(){
    
    $('body').on('click','#btn-agregar-role',function(){
        $('#modal-agregar-role').modal();
    });

    $('body').on('click','#btn-modificar-role',function(){
        $("#txt_role_M").val("");
        $('#modal-modificar-role').modal();
    });

    $('body').on('click','#btn-detalle-role',function(){
        $('#modal-detalle-role').modal();
    });

});

function agregar_role(){
    var usuarioId = document.getElementById('txt-UsuarioId').value;
    Swal.fire({
        title: '¡¡¡ Agregando un role !!!',
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
                title: '¡¡¡ El role ha sido agregado exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
              }),
            $.ajax({
                type:"POST",
                url: $base_url+"Configuracion_Controller/agregarRole",
                data:{
                    'usuarioId':usuarioId,
                    'Role_Role':$('#txt_role').val()
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Configuracion_Controller/ConfiguracionRoles/?UsuarioId="+window.btoa(usuarioId);
                    },100)
                },
                error: function (xhr, message , code){
                    console.log(this);
                }
            });
        }
    });
}


function Eliminar_Role(element){
    var UsuarioIdGlobal = document.getElementById('UsuarioIdGlobal').value;

    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdId = $(etiquetaTR).children('td#RoleId').text();
    var tdRole = $(etiquetaTR).children('td#Role_Role').text();

    
    Swal.fire({
        title: '¿Deseas eliminar el role '+tdRole+'?',
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
                title: '¡¡¡ El role ha sido eliminado exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
              }),
                $.ajax({
                    type: "POST",
                    url: $base_url+"Configuracion_Controller/eliminarRole",
                    data: {
                        UsuarioId:UsuarioIdGlobal,
                        RoleId: tdId 
                    },
                    success: function (dataResponse){
                        //console.log(dataResponse);
                        setTimeout(function(){
                            location.href=$base_url+"Configuracion_Controller/ConfiguracionRoles/?UsuarioId="+window.btoa(UsuarioIdGlobal);
                        },100)
                    },
                    error:function (xhr,message, code){
                        console.log(this);
                    }
                });
            }
        });
}

function ModificarRoleModal(element){
    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdRoleId = $(etiquetaTR).children('td#RoleId').text();
    //alert(tdColorId);
    $.ajax({
        type:"POST",
        url:$base_url+"Configuracion_Controller/getRoleByRoleId",
        data:{
            RoleId:tdRoleId
        },
        success: function(data){
            var datosModalRole=JSON.parse(data);                                                //Debo convertir a JSON
            //console.log(datosModalRole);
            document.formModificarRole.txt_roleModificarId_M.value=datosModalRole[0]['RoleId'];
            document.formModificarRole.txt_role_M.value=datosModalRole[0]['Role_Role'];           
        },
        error: function (request, status, error){
            console.log(request.responseText);
        }
    });   
}


function modificar_role(){
    var usuarioId = document.getElementById('txt-UsuarioId-M').value;
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
                title: '¡¡¡ El role ha sido modificado exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
             }),
            $.ajax({
                type:"POST",
                url: $base_url+"Configuracion_Controller/modificarRole",
                data:{
                    'UsuarioId':usuarioId,
                    'RoleId':$('#txt_roleModificarId_M').val(),
                    'Role_Role':$('#txt_role_M').val()
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        
                        window.location.href=$base_url+"Configuracion_Controller/ConfiguracionRoles/?UsuarioId="+window.btoa(usuarioId);
                    },100)
                },
                error: function (request, status, error){
                    console.log(request.responseText);
                }
            });
        }
    });
}



function DetalleRoleModal(element){
    $('#tbody-provilegios').empty();
    $('#select-privilegios').empty();
    $('#select-privilegios').append('<option value="">Seleccione una opción</option');
    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdRoleId = $(etiquetaTR).children('td#RoleId').text();

    //alert(tdColorId);
    $.ajax({
        type:"POST",
        url:$base_url+"Configuracion_Controller/getMenuHijoByRoleId",
        data:{
            RoleId:tdRoleId
        },
        success: function(data){
            //console.log(data);
            var datosModalRole=JSON.parse(data);
            var opcionesDisponibles=datosModalRole['DatosModalMenuHijo'];
            var opcionesHabilitadas=datosModalRole['DatosModalMenuHijoByRolId']                                                //Debo convertir a JSON
            var TodosDatosModalMenuHijo=datosModalRole['TodosDatosModalMenuHijo']
            //console.log(opcionesDisponibles);
            //console.log(opcionesHabilitadas);
            $('#filarolesSeleccionables').empty();

            
            for(var i=0;i<TodosDatosModalMenuHijo.length;i++){
                for(var l=0;l<opcionesHabilitadas.length;l++){
                    if(TodosDatosModalMenuHijo[i]['MenuHijoId']==opcionesHabilitadas[l]['MenuHijoId']){
                        $('#filarolesSeleccionables').append('<div class="col-4"><div class="form-check-inline">'+TodosDatosModalMenuHijo[i]['MenuHijo_Icon']+'&nbsp;&nbsp;<input type="checkbox" value="'+TodosDatosModalMenuHijo[i]['MenuHijoId']+'" class="form-check-input" checked id="accesoS_'+TodosDatosModalMenuHijo[i]['MenuHijoId']+'"><label class="form-check-label" for="accesoS_'+TodosDatosModalMenuHijo[i]['MenuHijoId']+'">'+TodosDatosModalMenuHijo[i]['MenuHijo_MenuHijo']+'</label></div></div>');
                    }  
                }
                for(var l=0;l<opcionesDisponibles.length;l++){
                    if(TodosDatosModalMenuHijo[i]['MenuHijoId']==opcionesDisponibles[l]['MenuHijoId']){
                        $('#filarolesSeleccionables').append('<div class="col-4"><div class="form-check-inline">'+TodosDatosModalMenuHijo[i]['MenuHijo_Icon']+'&nbsp;&nbsp;<input type="checkbox" value="'+TodosDatosModalMenuHijo[i]['MenuHijoId']+'" class="form-check-input"  id="accesoD_'+TodosDatosModalMenuHijo[i]['MenuHijoId']+'"><label class="form-check-label" for="accesoD_'+TodosDatosModalMenuHijo[i]['MenuHijoId']+'">'+TodosDatosModalMenuHijo[i]['MenuHijo_MenuHijo']+'</label></div></div>');
                    }
                }
            }

            document.formDetalleRole.txt_roleDetalleId_M.value=tdRoleId;

           /* for(var i=0;i<opcionesDisponibles.length;i++){
                $('#select-privilegios').append('<option value="'+opcionesDisponibles[i]['MenuHijoId']+'">'+opcionesDisponibles[i]['MenuPadre_MenuPadre']+' > '+opcionesDisponibles[i]['MenuHijo_MenuHijo']+'</option>');
            }
            var folio=1;
            for(var i=0;i<opcionesHabilitadas.length;i++) {
                $('#tbody-provilegios').append('<tr><td id="AccesoId" style="display:none;">'+opcionesHabilitadas[i]['AccesoId']+'</td><td>'+folio+'</td><td>'+opcionesHabilitadas[i]['MenuHijo_Icon']+'</td><td id="MenuHijo_MenuHijo">'+opcionesHabilitadas[i]['MenuHijo_MenuHijo']+'</td><td><button type="button" onclick="Eliminar_Acceso(this)" class="btn btn-danger"><ion-icon name="trash-sharp"></ion-icon></button></td><tr>');
                folio=folio+1;
            }*/
            
        },
        error: function (request, status, error){
            console.log(request.responseText);
        }
    });   
}

function Eliminar_Acceso(element){
    var UsuarioIdGlobal = document.getElementById('UsuarioIdGlobal').value;
    
    var etiquetaTD = element.parentNode;
    var etiquetaTR = etiquetaTD.parentNode;

    var tdId = $(etiquetaTR).children('td#AccesoId').text();
    var tdMenuHijo = $(etiquetaTR).children('td#MenuHijo_MenuHijo').text();

    Swal.fire({
        title: '¿Deseas eliminar el acceso?',
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
                title: '¡¡¡ El acceso ha sido eliminado exitosamente !!!',
                showConfirmButton: false,
                timer: 2000
            }),
            $.ajax({
                type: "POST",
                url: $base_url+"Configuracion_Controller/eliminarAcceso",
                data: {
                    UsuarioId:UsuarioIdGlobal,
                    AccesoId: tdId 
                },
                success: function (dataResponse){
                    //console.log(dataResponse);
                    setTimeout(function(){
                        location.href=$base_url+"Configuracion_Controller/ConfiguracionRoles/?UsuarioId="+window.btoa(UsuarioIdGlobal);
                    },100)
                },
                error:function (xhr,message, code){
                    console.log(this);
                }
            });
        }
    });
}

$('#verModulosSeleccionados').on('click', function() {

    var modulosSeleccionados = new Array();

    $('input[type=checkbox]:checked').each(function() {
        modulosSeleccionados.push($(this).val());
    });
    var UsuarioIdGlobal = document.getElementById('UsuarioIdGlobal').value;
    var RoleId = document.getElementById('txt_roleDetalleId_M').value;
    
    $.ajax({
        type:"POST",
        url: $base_url+"Configuracion_Controller/agregarAcceso",
        data:{
            'UsuarioId':UsuarioIdGlobal,
            'MenuHijoIds':modulosSeleccionados,
            'RoleId':RoleId
        },
        success: function (dataResponse){
            //console.log(dataResponse);
            setTimeout(function(){
                location.href=$base_url+"Configuracion_Controller/ConfiguracionRoles/?UsuarioId="+window.btoa(UsuarioIdGlobal);
            },100)
        },
        error: function (xhr, message , code){
            console.log(this);
        }
    });
});





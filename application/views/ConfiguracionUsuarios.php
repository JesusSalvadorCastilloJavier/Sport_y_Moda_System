<?php
        $datosUsuario=array(
            'datos' => $datos,
            'respuesta'=> $respuesta,
            'menuPadre'=>$menuPadre,
            'menus' => $menus,
            'datosTablaUsuarios'=>$datosTablaUsuarios,
            'datosCatSexo'=>$datosCatSexo,
            'datosCatEstado'=>$datosCatEstado,
            'datosCatRole'=>$datosCatRole
        );
        //print_r($datosUsuario);
    ?>
    <nav class="navbar sticky-top navbar-expand-lg navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="#"><i class="ion-android-globe"></i>   Sport & Moda</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav mr-auto">
                <!--<a class="nav-item nav-link active" href="#">Inicio<span class="sr-only">(current)</span></a>-->
                <?php
                foreach($menuPadre as $menuP):
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $menuP['MenuPadre_Icon']." ".$menuP['MenuPadre_MenuPadre'];?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                           <?php
                                foreach($menus as $menuHijo):
                                    if($menuP['MenuPadreId']==$menuHijo['MenuHijo_MenuPadreId']){
                            ?>
                                        
                                        <a class="dropdown-item" href="<?php echo base_url().$menuHijo['MenuHijo_URL'];?>/?UsuarioId=<?php echo base64_encode($datosUsuario['respuesta'][0]['UsuarioId']);?>"><?php echo $menuHijo['MenuHijo_Icon']."    ".$menuHijo['MenuHijo_MenuHijo'];?></a>
                            <?php
                                    }
                                endforeach;
                           ?>
                        </div> 
                    <li>   
                    <?php
                endforeach; 
                ?>
            </div>
            </div>
            <form class="form-inline my-2 my-lg-0">
                <font color="#ffffff">
                    <i class="ion-person"></i>
                    <?php echo $datosUsuario['respuesta'][0]['Persona']; ?>
                </font>
            </form>
        
    </nav>
<br>
<input type="hidden" name="UsuarioIdGlobal" id="UsuarioIdGlobal" value="<?php echo $datosUsuario['respuesta'][0]['UsuarioId'];?>" disabled>
<div class="container-fluid">
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <i class="ion-person"></i>
            Configuraci??n de usuarios
        </a>
    </nav>
    <div class="modal-footer">
        <button type="button" id="btn-agregar-usuario" class="btn btn-primary"><i class="ion-person-add"></i>   Nuevo usuario</button>
    </div>
    <div class="card">
        <div class="card-header">
            <h5>Usuarios registrados</h5>
        </div>
        <div class="card-body">
            <table id="tbl-usuarios" class="display compact" style="width:100%">
                <thead>
                    <tr>
                        <th>F??lio</th>
                        <th style="display:none;">C??digo</th>
                        <th>Nombre completo</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Usuario</th>
                        <th>Celular</th>
                        <th>Cargo</th>
                        <th>Estatus</th>
                        <th><center>- ACCIONES -</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $folio=1;
                        foreach($datosTablaUsuarios as $dato):
                            ?>
                            <tr>
                                <td><?php echo $folio;?></td>
                                <td id="UsuarioId" style="display:none;"><?php echo $dato['UsuarioId']?></td>
                                <td id="Nombre"><?php echo $dato['Nombre']?></td>
                                <td id="Persona_FechaNacimiento"><center><i class="ion-calendar"> <?php echo $dato['Persona_FechaNacimiento']?></center></td>
                                <td id="Usuario_Usuario"><i class="ion-person">  <?php echo $dato['Usuario_Usuario']?></td>
                                <td id="Contacto_TelCelular"> <i class="ion-ios-telephone"> <?php echo $dato['Contacto_TelCelular']?></td>
                                <td id="Role_Role"><i class="ion-card"> <?php echo $dato['Role_Role']?></td>
                                <td><div class="badge badge-<?php if ($dato['Usuario_Activo']=='Inactivo'){echo 'danger';} else {echo 'info';}?>"> <?php if ($dato['Usuario_Activo']=='Inactivo'){echo '<i class="ion-close"></i>';} else {echo '<i class="ion-checkmark">';}?> </i> <?php echo $dato['Usuario_Activo']?></div> </td>
                                <td>
                                    <button <?php if ($dato['Usuario_Activo']=='Inactivo' || $dato['UsuarioId']==1 ){echo 'disabled';}?> type="button" onclick="ModificarUsuarioModal(this)" id="btn-modificar-usuario" class="btn btn-warning btn-sm"><i class="ion-loop"></i> </button>
                                    <button <?php if ($dato['Usuario_Activo']=='Inactivo' || $dato['UsuarioId']==1 ){echo 'disabled';}?> type="button" onclick="Eliminar_usuario(this)" class="btn btn-danger btn-sm"><i class="ion-trash-a"></i></button>
                                </td>
                            </tr>
                            <?php
                            $folio=$folio+1;
                        endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>


<div class="modal fade" id="modal-agregar-usuario" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                <i class="ion-person-add"></i>Agregar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="container-fluid">
                <center>
                    <div class="alert alert-info" role="alert">
                    - DATOS PERSONALES -
                    </div>
                    
                </center>
                <input type="hidden" name="txt-UsuarioId" id="txt-UsuarioId" value="<?php echo $datosUsuario['respuesta'][0]['UsuarioId'];  ?>" disabled>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        Nombre<input type="text" class="form-control" id="txt-nombre" name="txt-nombre"/>
                    </div>
                    <div class="col-md-4">
                        Apellido Paterno<input type="text" class="form-control" id="txt-apellido-paterno" name="txt-apellido-paterno"/>
                    </div>
                    <div class="col-md-4">
                        Apllido Materno<input type="text" class="form-control" id="txt-apellido-materno" name="txt-apellido-materno"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        Fecha de Nacimiento<input class="form-control" type="date" value="1990-01-01" name="date" id="date">
                    </div>
                    <div class="col-md-4">
                        Seleccione Sexo
                            <select class="form-control" style="width:100%" name="txt-sexoId" id="txt-sexoId">
                                <option>Seleccione una opci??n</option>
                                <?php
                                    foreach($datosCatSexo as $dato):
                                        ?>
                                        <option value="<?php echo$dato['SexoId'];?>"><?php echo$dato['Sexo_Sexo'];?></option>
                                        <?php
                                    endforeach;
                                ?>
                            </select>
                    </div>
                </div>
                <hr>
                <center>
                    <div class="alert alert-info" role="alert">
                    - CONTACTO -
                    </div>
                   
                </center>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        Telefono de Recados
                        <input type="text" class="form-control" id="txt-tel-Rec" name="txt-tel-Rec"/>
                    </div>
                    <div class="col-md-4">
                        Telefono de Casa
                        <input type="text" class="form-control" id="txt-tel-Casa" name="txt-tel-Casa"/>
                    </div>
                    <div class="col-md-4">
                        Telefono de Celular
                        <input type="text" class="form-control" id="txt-tel-Cel" name="txt-tel-Cel"/>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        Correo electr??nico
                        <input type="email" class="form-control" id="txt-email" name="txt-email" placeholder="juan@gmail.com">
                    </div>
                </div>

                <hr>
                <center>
                    <div class="alert alert-info" role="alert">
                        - DIRECCI??N -
                     </div>
                    
                </center>
                <hr>

                <div class="row">
                    <div class="col-md-4">
                        Calle
                        <input type="text" class="form-control" id="txt-calle" name="txt-calle"/>
                    </div>
                    <div class="col-md-4">
                        Numero Interior
                        <input type="text" class="form-control" id="txt-nInterior" name="txt-nInterior"/>
                    </div>
                    <div class="col-md-4">
                        Numero Exterior
                        <input type="text" class="form-control" id="txt-nExterior" name="txt-nExterior"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        Seleccione Estado
                        <select class="form-control" style="width:100%" id="sel-estadoId" name="sel-estadoId">
                        <option value="0">Seleccione una opci??n</option>
                        <?php
                            foreach($datosCatEstado as $dato):
                                ?>
                                    <option value="<?php echo $dato['EstadoId'];?>"><?php echo $dato['Estado_Estado'];?></option>
                                <?php
                            endforeach;
                        ?>
                        </select>   
                    </div>
                    <div class="col-md-4">
                        Seleccione Municipio
                        <select class="form-control" style="width:100%" id="sel-municipioId" name="sel-municipioId">
                        <option value="0">Seleccione una opci??n</option>
                        </select>   
                    </div>
                    <div class="col-md-4"></div>
                </div>
                <hr>
                <center>
                    <div class="alert alert-dark" role="alert">
                        - Datos de usuario -
                    </div>
                </center>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        Seleccione cargo
                        <select class="form-control" style="width:100%" id="sel-roleId" name="sel-roleId">
                        <option value="0">Seleccione una opci??n</option>
                            <?php
                                foreach($datosCatRole as $dato):
                                    ?>
                                        <option value="<?php echo $dato['RoleId'];?>"><?php echo $dato['Role_Role'];?></option>
                                    <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        Usuario
                        <input class="form-control" type="text" name="txt-usuario" id="txt-usuario" disabled/>
                    </div>
                    <div class="col-md-4">
                        Contrase??a
                        <input class="form-control" type="text" name="txt-contrasenia" id="txt-contrasenia" disabled/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="agregar_usuarios()" class="btn btn-primary"><i class="ion-loop"></i> Guardar</button>
                <button type="button" class="btn btn-danger"data-dismiss="modal"><i class="ion-trash-a"></i> Cancelar</button>
            </div>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="modal-modificar-usuario"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="ion-loop"></i>    Modificar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="container-fluid">
                <form name="formModificarUsuario">
                <center>
                    <div class="alert alert-info" role="alert">
                        - DATOS PERSONALES -
                    </div>
                </center>
                <input type="hidden" name="txt-UsuarioId-M" id="txt-UsuarioId-M" value="<?php echo $datosUsuario['respuesta'][0]['UsuarioId'];  ?>" disabled>
                <input type="hidden" name="txt_usuarioModificarId" id="txt_usuarioModificarId" disabled>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        Nombre<input type="text" class="form-control" id="txt_nombre_M" name="txt_nombre_M"/>
                    </div>
                    <div class="col-md-4">
                        Apellido Paterno<input type="text" class="form-control" id="txt_apellido_paterno_M" name="txt_apellido_paterno_M"/>
                    </div>
                    <div class="col-md-4">
                        Apllido Materno<input type="text" class="form-control" id="txt_apellido_materno_M" name="txt_apellido_materno_M"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        Fecha de Nacimiento<input class="form-control" type="date" name="date_M" id="date_M">
                    </div>
                    <div class="col-md-4">
                        Seleccione Sexo
                        <select class="form-control" style="width:100%" name="txt_sexoId_M" id="txt_sexoId_M">
                                <?php
                                    foreach($datosCatSexo as $dato):
                                        ?>
                                        <option value="<?php echo$dato['SexoId'];?>"><?php echo$dato['Sexo_Sexo'];?></option>
                                        <?php
                                    endforeach;
                                ?>
                            </select>
                    </div>
                </div>
                <hr>
                <center>
                    <div class="alert alert-info" role="alert">
                        - CONTACTO -
                    </div>
                </center>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        Telefono de Recados
                        <input type="text" class="form-control" id="txt_tel_Rec_M" name="txt_tel_Rec_M"/>
                    </div>
                    <div class="col-md-4">
                        Telefono de Casa
                        <input type="text" class="form-control" id="txt_tel_Casa_M" name="txt_tel_Casa_M"/>
                    </div>
                    <div class="col-md-4">
                        Telefono de Celular
                        <input type="text" class="form-control" id="txt_tel_Cel_M" name="txt_tel_Cel_M"/>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        Correo electr??nico
                        <input type="email" class="form-control" id="txt_email_M" name="txt_email_M" placeholder="juan@gmail.com">
                    </div>
                </div>

                <hr>
                <center>
                    <div class="alert alert-info" role="alert">
                        - DIRECCI??N -
                    </div>
                </center>
                <hr>

                <div class="row">
                    <div class="col-md-4">
                        Calle
                        <input type="text" class="form-control" id="txt_calle_M" name="txt_calle_M"/>
                    </div>
                    <div class="col-md-4">
                        Numero Interior
                        <input type="text" class="form-control" id="txt_nInterior_M" name="txt_nInterior_M"/>
                    </div>
                    <div class="col-md-4">
                        Numero Exterior
                        <input type="text" class="form-control" id="txt_nExterior_M" name="txt_nExterior_M"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        Seleccione Estado
                        <select class="form-control" style="width:100%" id="sel_estadoId_M" name="sel_estadoId_M">
                        <?php
                            foreach($datosCatEstado as $dato):
                                ?>
                                    <option value="<?php echo $dato['EstadoId'];?>"><?php echo $dato['Estado_Estado'];?></option>
                                <?php
                            endforeach;
                        ?>
                        </select>   
                    </div>
                    <div class="col-md-4">
                        Seleccione Municipio
                        <select class="form-control" style="width:100%" id="sel_municipioId_M" name="sel_municipioId_M">
                        </select>   
                    </div>
                    <div class="col-md-4"></div>
                </div>
                <hr>
                <center>
                    <div class="alert alert-dark" role="alert">
                        - Datos de usuario -
                    </div>
                </center>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        Seleccione cargo
                        <select class="form-control" style="width:100%" id="sel_roleId_M" name="sel_roleId_M">
                            <?php
                                foreach($datosCatRole as $dato):
                                    ?>
                                        <option value="<?php echo $dato['RoleId'];?>"><?php echo $dato['Role_Role'];?></option>
                                    <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="modificar_usuarios()" class="btn btn-primary"><i class="ion-loop"></i> Modificar</button>
                <button type="button" class="btn btn-danger"data-dismiss="modal"><i class="ion-trash-a"></i> Cancelar</button>
            </div>
            </div>
                            
        </div>
    </div>
</div>

<div class="modal fade" id="ModalImprimeCredenciales" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalImprimeCredencialesLabel">Credenciales de acceso</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
            <iframe id="iframe_ModalCredenciales" frameborder="0" width="100%" height="500"></iframe>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="redireccionarPorCredencialesAcceso()" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<script src="<?php echo base_url();?>assets/JavaScript/admin-Configuracion-Usuarios.js"></script>

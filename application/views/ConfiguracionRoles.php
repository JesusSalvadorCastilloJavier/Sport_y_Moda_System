<?php
        $datosUsuario=array(
            'datos' => $datos,
            'respuesta'=> $respuesta,
            'menuPadre'=>$menuPadre,
            'menus' => $menus,
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
            <div class="navbar-nav">
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
            <i class="ion-cube"></i>
            Configuración de Roles
        </a>
    </nav>

    <div class="modal-footer">
        <button type="button" id="btn-agregar-role" class="btn btn-primary"><i class="ion-android-add-circle"></i>   Nuevo Role</button>
    </div>
    <div class="card">
        <div class="card-header">
            <h5>Roles registrados</h5>
        </div>
        <div class="card-body">
            <table id="tbl-roles" class="display compact" style="width:100%">
                <thead>
                    <tr>
                        <th>Detalles</th>
                        <th style="display:none;">Código</th>
                        <th>Role</th>
                        <th>Fecha Creación</th>
                        <th><center>- ACCIONES -</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($datosCatRole as $dato):
                            ?>
                            <tr>
                                <td>
                                    <button type="button" onclick="DetalleRoleModal(this)" id="btn-detalle-role" class="btn btn-outline-dark btn-sm"><i class="ion-android-search"></i> Ver detalle</button>
                                </td>
                                <td id="RoleId" style="display:none;"><?php echo $dato['RoleId']?></td>
                                <td id="Role_Role"><?php echo $dato['Role_Role']?></td>
                                <td id="Role_FechaCreacion"><?php echo $dato['Role_FechaCreacion']?></td>
                                <td>
                                    <button type="button" onclick="ModificarRoleModal(this)" id="btn-modificar-role" class="btn btn-warning btn-sm"><i class="ion-loop"></i></button>
                                    <button type="button" onclick="Eliminar_Role(this)" class="btn btn-danger btn-sm"><i class="ion-trash-a"></i></button>
                                </td>
                            </tr>
                        <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="modal fade" id="modal-agregar-role" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="ion-android-add-circle"></i>   Agregar Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form name="formAgregarRole">
                            <input type="hidden" name="txt-UsuarioId" id="txt-UsuarioId" value="<?php echo $datosUsuario['respuesta'][0]['UsuarioId'];  ?>" disabled>
                            <div class="row">
                                <div class="col-md-4">
                                    Nombre del nuevo Role
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="txt_role" name="txt_role"/>
                                </div>
                            </div>
                        </form>
                    <div class="modal-footer">
                        <button type="button" onclick="agregar_role()" class="btn btn-primary"><i class="ion-android-add-circle"></i> Agregar Role</button>
                        <button type="button" class="btn btn-danger"data-dismiss="modal"><i class="ion-trash-a"></i> Cancelar</button>
                    </div>
                </div>     
            </div> 
        </div>
    </div>
</div>
<div class="modal fade" id="modal-modificar-role" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="ion-loop"></i>    Modificar Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form name="formModificarRole">
                            <input type="hidden" name="txt-UsuarioId-M" id="txt-UsuarioId-M" value="<?php echo $datosUsuario['respuesta'][0]['UsuarioId'];  ?>" disabled>
                            <input type="hidden" name="txt_roleModificarId_M" id="txt_roleModificarId_M" disabled>
                            <div class="row">
                                <div class="col-md-4">
                                    Nombre del Role
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="txt_role_M" name="txt_role_M"/>
                                </div>
                            </div>
                        </form>
                    <div class="modal-footer">
                        <button type="button" onclick="modificar_role()" class="btn btn-primary"><i class="ion-loop"></i>  Modificar Role</button>
                        <button type="button" class="btn btn-danger"data-dismiss="modal"><i class="ion-trash-a"></i> Cancelar</button>
                    </div>
                </div>     
            </div> 
        </div>
    </div>
</div>
<div class="modal fade" id="modal-detalle-role" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="ion-android-search"></i>   Detalle Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form name="formDetalleRole">
                            <input type="hidden" name="txt-UsuarioId-D" id="txt-UsuarioId-D" value="<?php echo $datosUsuario['respuesta'][0]['UsuarioId'];  ?>" disabled>
                            <input type="hidden" name="txt_roleDetalleId_M" id="txt_roleDetalleId_M" disabled>
                             <center>
                                <img src="<?php echo base_url();?>assets/Imagenes/tarjeta-de-credito.png" height="200" width="200" class="img-fluid" alt="Responsive image"></center>
                            </center>
                            <br>
                            <div class="row" id="filarolesSeleccionables">
                                    
                            </div>
                            
                            <!--<div class="row">
                                <div class="col-md-4">
                                    <hr>
                                    Seleccione privilegio
                                    <br>
                                    <select class="form-control" style="width:100%" id="select-privilegios">
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <table class="table table-striped table-dark"  id="tbl-privilegios">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="display:none;">Código</th>
                                                <th scope="col">Fólio</th>
                                                <th scope="col">Icono</th>
                                                <th scope="col">Módulo</th>
                                                <th scope="col">Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-provilegios">

                                        </tbody>
                                    </table>
                                </div>
                            </div>-->
                        </form>
                    <div class="modal-footer">
                        <button type="button"  id="verModulosSeleccionados" class="btn btn-primary"><i class="ion-loop"></i> Guardar cambios</button>
                        <button type="button" class="btn btn-danger"data-dismiss="modal"><i class="ion-trash-a"></i> Cancelar</button>
                    </div>
                </div>     
            </div> 
        </div>
    </div>
</div>
</div>







<script src="<?php echo base_url();?>assets/JavaScript/admin-Configuracion-Roles.js"></script>

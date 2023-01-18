<?php
        $datosUsuario=array(
            'datos' => $datos,
            'respuesta'=> $respuesta,
            'menuPadre'=>$menuPadre,
            'menus' => $menus,
            'datosCatTalla'=>$datosCatTalla
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
        <i class="ion-ios-list-outline"></i>
            Configuración de tallas
        </a>
    </nav>


    <div class="modal-footer">
        <button type="button" id="btn-agregar-talla" class="btn btn-primary"><i class="ion-android-add-circle"></i>   Nueva talla</button>
    </div>
    <div class="card">
        <div class="card-header">
            <h5>Tallas registradas</h5>
        </div>
        <div class="card-body">
            <table id="tbl-tallas" class="display compact" style="width:100%">
                <thead>
                    <tr>
                        <th>Fólio</th>
                        <th style="display:none;">Código</th>
                        <th>Talla - Letra</th>
                        <th>Talla - Número</th>
                        <th>Fecha Creación</th>
                        <th><center>- ACCIONES -</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $folio=1;
                        foreach($datosCatTalla as $dato):
                            ?>
                            <tr>
                                <td><?php echo $folio;?></td>
                                <td id="TallaId" style="display:none;"><?php echo $dato['TallaId']?></td>
                                <td id="Talla_Talla"><?php echo $dato['Talla_Talla']?></td>
                                <td id="Talla_Numero"><?php echo $dato['Talla_Numero']?></td>
                                <td id="Talla_FechaCreacion"><?php echo $dato['Talla_FechaCreacion']?></td>
                                <td>
                                    <button type="button" onclick="ModificarTallaModal(this)" id="btn-modificar-talla" class="btn btn-warning btn-sm"><i class="ion-loop"></i> </button>
                                    <button type="button" onclick="Eliminar_Talla(this)" class="btn btn-danger btn-sm"><i class="ion-trash-a"></i></button>
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
    <div class="modal fade" id="modal-agregar-talla" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="ion-android-add-circle"></i>   Agregar Talla</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form name="formAgregarTalla">
                            <input type="hidden" name="txt-UsuarioId" id="txt-UsuarioId" value="<?php echo $datosUsuario['respuesta'][0]['UsuarioId'];  ?>" disabled>
                            <input type="hidden" name="txt_usuarioModificarId" id="txt_usuarioModificarId" disabled>
                        
                            <div class="row">
                                <div class="col-md-6">
                                    Nombre de la talla
                                    <input type="text" class="form-control" id="txt_tallaL" name="txt_tallaL"/>
                                </div>
                                <div class="col-md-6">
                                    Número de la talla
                                    <input type="number" class="form-control" id="txt_tallaN" name="txt_tallaN"/>
                                </div>
                            </div>
                        </form>
                    <div class="modal-footer">
                        <button type="button" onclick="agregar_talla()" class="btn btn-primary"><i class="ion-android-add-circle"></i> Agregar Talla</button>
                        <button type="button" class="btn btn-danger"data-dismiss="modal"><i class="ion-trash-a"></i> Cancelar</button>
                    </div>
                </div>     
            </div> 
        </div>
    </div>
</div>
<div class="modal fade" id="modal-modificar-talla" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="ion-android-add-circle"></i>   Agregar Talla</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form name="formModificarTalla">
                            <input type="hidden" name="txt-UsuarioId-M" id="txt-UsuarioId-M" value="<?php echo $datosUsuario['respuesta'][0]['UsuarioId'];  ?>" disabled>
                            <input type="hidden" name="txt_tallaModificarId_M" id="txt_tallaModificarId_M" disabled>
                        
                            <div class="row">
                                <div class="col-md-6">
                                    Nombre de la talla
                                    <input type="text" class="form-control" id="txt_tallaL_M" name="txt_tallaL_M"/>
                                </div>
                                <div class="col-md-6">
                                    Número de la talla
                                    <input type="number" class="form-control" id="txt_tallaN_M" name="txt_tallaN_M"/>
                                </div>
                            </div>
                        </form>
                    <div class="modal-footer">
                        <button type="button" onclick="modificar_talla()" class="btn btn-primary"><i class="ion-loop"></i>  Modificar Talla</button>
                        <button type="button" class="btn btn-danger"data-dismiss="modal"><i class="ion-trash-a"></i> Cancelar</button>
                    </div>
                </div>     
            </div> 
        </div>
    </div>
</div>
</div>

<script src="<?php echo base_url();?>assets/JavaScript/admin-Configuracion-Tallas.js"></script>


<?php
        $datosUsuario=array(
            'datos' => $datos,
            'respuesta'=> $respuesta,
            'menuPadre'=>$menuPadre,
            'menus' => $menus,
            'datosTablaMarcas'=>$datosTablaMarcas
        );
        //print_r($datosUsuario);
    ?>
    <nav class="navbar sticky-top navbar-expand-lg navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="#"><i class="ion-android-globe"></i>    Sport & Moda</a>
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
            <i class="ion-document-text"></i>
            Configuración de marcas
        </a>
    </nav>


    <div class="modal-footer">
        <button type="button" id="btn-agregar-marca" class="btn btn-primary"><i class="ion-android-add-circle"></i>   Nueva marca</button>
    </div>
    <div class="card">
        <div class="card-header">
            <h5>Marcas registradas</h5>
        </div>
        <div class="card-body">
            <table id="tbl-marcas" class="display compact" style="width:100%">
                <thead>
                    <tr>
                        <th>Fólio</th>
                        <th style="display:none;">Código</th>
                        <th>Marca</th>
                        <th>Fecha Creación</th>
                        <th><center>- ACCIONES -</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $folio=1;
                        foreach($datosTablaMarcas as $dato):
                            ?>
                            <tr>
                                <td><?php echo $folio;?></td>
                                <td id="MarcaId" style="display:none;"><?php echo $dato['MarcaId']?></td>
                                <td id="Marca_Marca"><?php echo $dato['Marca_Marca']?></td>
                                <td id="Marca_FechaCreacion"><?php echo $dato['Marca_FechaCreacion']?></td>
                                <td>
                                    <button type="button" onclick="ModificarMarcaModal(this)" id="btn-modificar-marca" class="btn btn-warning btn-sm"><i class="ion-loop"></i> </button>
                                    <button type="button" onclick="Eliminar_marca(this)" class="btn btn-danger btn-sm"><i class="ion-trash-a"></i></button>
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
    
    <div class="modal fade" id="modal-agregar-marca" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="ion-android-add-circle"></i>   Agregar Marca</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form name="formAgregarMarca">
                            <input type="hidden" name="txt-UsuarioId" id="txt-UsuarioId" value="<?php echo $datosUsuario['respuesta'][0]['UsuarioId'];  ?>" disabled>
                            <div class="row">
                                <div class="col-md-4">
                                    Nombre de la nueva Marca
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="txt_marca" name="txt_marca"/>
                                </div>
                            </div>
                        </form>
                    <div class="modal-footer">
                        <button type="button" onclick="agregar_marca()" class="btn btn-primary"><i class="ion-android-add-circle"></i> Agregar Marca</button>
                        <button type="button" class="btn btn-danger"data-dismiss="modal"><i class="ion-trash-a"></i> Cancelar</button>
                    </div>
                </div>     
            </div> 
        </div>
    </div>
</div>

<div class="modal fade" id="modal-modificar-marca" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="ion-loop"></i>    Modificar Marca</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form name="formModificarMarca">
                            <input type="hidden" name="txt-UsuarioId-M" id="txt-UsuarioId-M" value="<?php echo $datosUsuario['respuesta'][0]['UsuarioId'];  ?>" disabled>
                            <input type="hidden" name="txt_marcaModificarId_M" id="txt_marcaModificarId_M" disabled>
                        
                            <div class="row">
                                <div class="col-md-4">
                                    Nombre de la marca
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="txt_marca_M" name="txt_marca_M"/>
                                </div>
                            </div>
                        </form>
                    <div class="modal-footer">
                        <button type="button" onclick="modificar_marca()" class="btn btn-primary"><i class="ion-loop"></i>  Modificar Marca</button>
                        <button type="button" class="btn btn-danger"data-dismiss="modal"><i class="ion-trash-a"></i> Cancelar</button>
                    </div>
                </div>   
            </div>      
        </div>
    </div>
</div>
</div>





<script src="<?php echo base_url();?>assets/JavaScript/admin-Configuracion-Marcas.js"></script>
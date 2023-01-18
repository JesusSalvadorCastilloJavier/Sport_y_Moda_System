<?php
        $datosUsuario=array(
            'datos' => $datos,
            'respuesta'=> $respuesta,
            'menuPadre'=>$menuPadre,
            'menus' => $menus,
            'datosTablaPrendas'=>$datosTablaPrendas,
            'datosCatGenero'=>$datosCatGenero,
            'datosCatMarca'=>$datosCatMarca,
            'datosCatTalla'=>$datosCatTalla,
            'datosCatColorP'=>$datosCatColorP,
            'datosCatColorS'=>$datosCatColorS,
            'datosCatProveedor'=>$datosCatProveedor
        );
        //print_r($datosUsuario);
    ?>

    <nav class="navbar sticky-top sticky-top navbar-expand-lg navbar navbar-dark bg-dark">
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
        <i class="ion-ios-browsers"></i>
            Entradas de inventario
        </a>
    </nav>
    <br>
    <div class="card">
        <div class="card-header">
            <h5>Prendas registradas</h5>
        </div>
        <div class="card-body">
            <table id="tbl-prendas" class="display compact" style="width:100%">
                <thead>
                    <tr>
                        <th style="display:none;">Código</th>
                        <th>Prenda</th>
                        <th>Descripción</th>
                        <th>Talla</th>
                        <th>Piezas</th>
                        <th>Genero</th>
                        <th>Marca</th>
                        <th>Color</th>
                        <th style="display:none;">Proveedor</th>
                        <th>Código</th>
                        <th style="display:none;">Fecha Creacion</th>
                        <th>PRECIO</th>
                        <th>- ACCIONES -</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($datosTablaPrendas as $dato):
                            ?>
                            <tr style="color:black; background-color: <?php if ($dato['Prenda_Inventario']<=2){echo '#FED5D9';} else if ($dato['Prenda_Inventario']==3) {echo '#FFF5C9';} else {echo '#C8E4FF';}?>">
                                <td id="PrendaId" style="display:none;"><?php echo $dato['PrendaId']?></td>
                                <td id="Prenda_Prenda"><?php echo $dato['Prenda_Prenda']?></td>
                                <td id="Prenda_Descripcion"><?php echo $dato['Prenda_Descripcion']?></td>
                                <td id="Talla_Talla"><?php echo $dato['Talla_Talla']?></td>
                                <td id="Prenda_Inventario"><center><?php echo $dato['Prenda_Inventario']?><center></td>
                                <td id="Genero_Genero"><?php echo $dato['Genero_Genero']?></td>
                                <td id="Marca_Marca"><?php echo $dato['Marca_Marca']?></td>
                                <td id="Color_P"><?php echo $dato['Color_P']?> / <?php echo $dato['Color_S']?></td>
                                <td style="display:none;" id="Proveedor_Proveedor"><?php echo $dato['Proveedor_Proveedor']?></td>
                                <td id="Prenda_CodigoPrendaParalelo">
                                    <?php echo $dato['Prenda_CodigoPrendaParalelo']?>
                                </td>
                                <td style="display:none;" id="Prenda_FechaCreacion"><?php echo $dato['Prenda_FechaCreacion']?></td>
                                <td id="Prenda_PrecioSalida"><center><h5>$<?php echo $dato['Prenda_PrecioSalida']?></h5><center></td>
                                <td>
                                    <button type="button" onclick="EntradaPrendaModal(this)" id="btn-entrada-prenda" class="btn btn-dark btn-sm"><i class="ion-android-add-circle"></i> Agregar</button>
                            </td>
                            </tr>
                            <?php
                        endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
        
    <br>
</div>

<div class="modal fade" id="modal-entrada-prenda" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="ion-tshirt"></i>    Entrada Prenda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form name="formEntradaPrenda">
            <div class="modal-body">
            <div class="container-fluid">
                <input type="hidden" name="txt_UsuarioId_M" id="txt_UsuarioId_M" value="<?php echo $datosUsuario['respuesta'][0]['UsuarioId'];  ?>" disabled>
                <input type="hidden" name="txt_PrendaId_M" id="txt_PrendaId_M" value="<?php echo $datosUsuario['respuesta'][0]['UsuarioId'];  ?>" disabled>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        Prenda<input type="text" class="form-control" id="txt_prenda_M" name="txt_prenda_M"  disabled />
                    </div>
                    <div class="col-md-8">
                        Descripción<textarea type="text" class="form-control" id="txt_prenda_descripcion_M" name="txt_prenda-descripcion_M" disabled></textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        Cantidad en Inventario<input type="number" class="form-control" id="txt_inventario_M" name="txt_inventario_M" disabled/>
                    </div>
                    <div class="col-md-4">
                        Precio Entrada<input type="text" class="form-control" id="txt_precio_entrada_M" name="txt_precio-entrada_M" disabled/>
                    </div>
                    <div class="col-md-4">
                        Precio Venta<input type="text" class="form-control" id="txt_precio_salida_M" name="txt_precio_salida_M" disabled/>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        Sexo
                            <select class="form-control" style="width:100%" name="txt_generoId_M" id="txt_generoId_M" disabled>
                                <?php
                                    foreach($datosCatGenero as $dato):
                                        ?>
                                        <option value="<?php echo$dato['GeneroId'];?>"><?php echo$dato['Genero_Genero'];?></option>
                                        <?php
                                    endforeach;
                                ?>
                            </select>
                    </div>
                    <div class="col-md-4">
                        Marca
                            <select class="form-control" style="width:100%" name="txt_marcaId_M" id="txt_marcaId_M" disabled>
                                <?php
                                    foreach($datosCatMarca as $dato):
                                        ?>
                                        <option value="<?php echo$dato['MarcaId'];?>"><?php echo$dato['Marca_Marca'];?></option>
                                        <?php
                                    endforeach;
                                ?>
                            </select>
                    </div>
                    <div class="col-md-4">
                        Talla
                            <select class="form-control" style="width:100%" name="txt_tallaId_M" id="txt_tallaId_M" disabled>
                                <?php
                                    foreach($datosCatTalla as $dato):
                                        ?>
                                        <option value="<?php echo $dato['TallaId'];?>"><?php echo $dato['Talla_Talla'];?> / <?php echo $dato['Talla_Numero'];?></option>
                                        <?php
                                    endforeach;
                                ?>
                            </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        Color Primario
                            <select class="form-control" style="width:100%" name="txt_colorIdP_M" id="txt_colorIdP_M" disabled>
                                <?php
                                    foreach($datosCatColorP as $dato):
                                        ?>
                                        <option value="<?php echo $dato['ColorId'];?>"><?php echo $dato['Color_Color'];?></option>
                                        <?php
                                    endforeach;
                                ?>
                            </select>
                    </div>
                    <div class="col-md-4">
                        Color Secundario
                            <select class="form-control" style="width:100%" name="txt_colorIdS_M" id="txt_colorIdS_M" disabled>
                                <?php
                                    foreach($datosCatColorS as $dato):
                                        ?>
                                        <option value="<?php echo $dato['ColorId'];?>"><?php echo $dato['Color_Color'];?></option>
                                        <?php
                                    endforeach;
                                ?>
                            </select>
                    </div>
                    <div class="col-md-4">
                        Proveedor
                            <select class="form-control" style="width:100%" name="txt_proveedorId_M" id="txt_proveedorId_M" disabled>
                                <?php
                                    foreach($datosCatProveedor as $dato):
                                        ?>
                                            <option value="<?php echo $dato['ProveedorId'];?>"><?php echo $dato['Proveedor_Proveedor'];?></option>
                                        <?php
                                    endforeach;
                                ?>
                            </select>
                    </div>
                </div>
                <hr>
                <div class="alert alert-success" role="alert">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>¿Cuantas piezas se van agregar?</strong>
                        </div>
                        <div class="col-md-4">
                            <input type="number" class="form-control" id="txt_cantidadAgregar" name="txt_cantidadAgregar"/>
                        </div>
                    </div>
                </div>
                
            </form>
            <div class="modal-footer">
                <button type="button" onclick="entrada_prenda()" class="btn btn-primary"><i class="ion-loop"></i> Agregar</button>
                <button type="button" class="btn btn-danger"data-dismiss="modal"><i class="ion-trash-a"></i> Cancelar</button>
            </div>
            </div>
        </div>
    </div>
</div>
</DIV>



<script src="<?php echo base_url();?>assets/JavaScript/admin-Entradas-Prendas.js"></script>
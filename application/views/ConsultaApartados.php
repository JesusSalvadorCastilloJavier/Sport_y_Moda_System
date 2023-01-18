<?php
        $datosApartados=array(
            'datos' => $datos,
            'respuesta'=> $respuesta,
            'menuPadre'=>$menuPadre,
            'menus' => $menus,
            'datosTablaApartados'=>$datosTablaApartados
        );
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
                                        
                                        <a class="dropdown-item" href="<?php echo base_url().$menuHijo['MenuHijo_URL'];?>/?UsuarioId=<?php echo base64_encode($datosApartados['respuesta'][0]['UsuarioId']);?>"><?php echo $menuHijo['MenuHijo_Icon']."    ".$menuHijo['MenuHijo_MenuHijo'];?></a>
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
                    <?php echo $datosApartados['respuesta'][0]['Persona']; ?>
                </font>
            </form>
        
    </nav>
<br>
<input type="hidden" name="UsuarioIdGlobal" id="UsuarioIdGlobal" value="<?php echo $datosApartados['respuesta'][0]['UsuarioId'];?>" disabled>

<div class="container-fluid">
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <i class="ion-navicon"></i>
            Historial de apartados
        </a>
    </nav>
    
    <div class="card">
        <div class="card-header">
            <h5>Apartados realizados</h5>
        </div>
        <div class="card-body">
            <table id="tbl-apartados" class="display compact" style="width:100%">
                <thead>
                    <tr>
                        <th style="display:none;">Código</th>
                        <th>Fólio</th>
                        <th><center>- DETALLE -</center></th>
                        <th>Usuario</th>
                        <th>Cliente</th>
                        <th>Código apartado</th>
                        <th>Fecha Creación</th>
                        <th>Fecha Limite</th>
                        <th>Total</th>
                        <th>Descuento</th>
                        <th>Total Final</th>
                        <th>A Cuenta</th>
                        <th>Debe</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $folio=1;
                        foreach($datosTablaApartados as $dato):
                            ?>
                            <tr>
                                <td id="apartadoId" style="display:none;"><?php echo $dato['ApartadoId']?></td>
                                <td><?php echo $folio;?></td>
                                <td>
                                    <button type="button" onclick="Consultar_Apartado(this)" id="btn-Detalle-Apartado" class="btn btn-success btn-sm"><i class="ion-android-search"></i> Ver Detalle</button>
                                </td>
                                <td id="NombreUsuario"><?php echo $dato['Usuario'];?></td>
                                <td id="NombreCliente"><?php echo $dato['Alias'];?></td>
                                <td id="CodioVenta"><?php echo $dato['Codigo']?></td>
                                <td id="Fecha"><?php echo $dato['Fecha'];?></td>
                                <td id="FechaLimite"><?php echo $dato['FechaLimite']?></td>
                                <td id="Total"><center><b>$ <?php echo $dato['Total']?></b></center></td>
                                <td id="Descuento"><center><b>$ <?php echo $dato['Descuento'];?></b></center></td>
                                <td id="TotalFinal"><center><b>$ <?php echo $dato['TotalFinal']?></b></center></td>
                                <td id="aCuenta"><center><b>$ <?php echo $dato['aCuenta'];?></b></center></td>
                                <td id="Debe"><center><b>$ <?php echo $dato['Debe']?></b></center></td>
                                
                            </tr>
                            <?php
                            $folio=$folio+1;
                        endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    

    <div class="modal fade" id="modal-detalle-apartado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="ion-android-add-circle"></i>   Detalle del apartado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid" id="div-detalleApartado">
                        <div class="alert alert-success" role="alert">
                            <div class="row">
                                <div class="col-8">
                                    <label for="" id="lbl-codigoApartado"></label>
                                </div>
                                <div class="col-4">
                                    <label for="" id="lbl-Total"></label>
                                </div>
                                <div class="col-8">
                                    <label for="" id="lbl-fechaCreacionApartado"></label>
                                </div>
                                <div class="col-4">
                                    <label for="" id="lbl-Descuento"></label>
                                </div>
                                <div class="col-8">
                                <label for="" id="lbl-Liquidacion"></label>
                                </div>
                                <div class="col-4">
                                    <label for="" id="lbl-CostoTotalFinal"></label>
                                </div>
                            </div>
                            <hr>
                            <div id="div-abono" class="row">
                                    
                            </div>
                        </div>
                        <hr>
                        <input type="hidden" id="hd-ApartadoId">
                        <table class="table table-striped" id="tbl-Detalle-Apartado">
                        </table>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>     
            </div> 
        </div>
    </div>
</div>
</div>

<script src="<?php echo base_url();?>assets/JavaScript/admin-Detalle-Apartado.js"></script>


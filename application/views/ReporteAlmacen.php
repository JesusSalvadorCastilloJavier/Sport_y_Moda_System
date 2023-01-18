<?php
        $datosUsuario=array(
            'datos' => $datos,
            'respuesta'=> $respuesta,
            'menuPadre'=>$menuPadre,
            'menus' => $menus,
            'datosUsuarios'=>$datosUsuarios
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
        <i class="ion-clipboard"></i>
            Reportes del almacen
        </a>
    </nav>
    <br>
    <div class="card-deck">
        <div class="card">
            <div class="card-header">Reporte de prendas agragadas por usuarios</div>
                <div class="card-body text-secondary">
                    Busqueda de Entradas por Fecha
                    <br>
                    De
                    <input class="form-control" type="datetime-local" name="fecha_inicio" id="fecha_inicio">
                    a
                    <input class="form-control" type="datetime-local" name="fecha_fin" id="fecha_fin">
                </div>
                <div class="card-footer text-muted">
                    <botton class="btn btn-info" onclick="ImprimirReporteEntradasFechas()" id="btn_repEntFechas">
                    <i class="ion-printer"></i>
                    Imprimir reporte
                    </booton>
                </div>
            </div>
        <div class="card">
            <div class="card-header">Reporte de prendas faltantes</div>
                <div class="card-body text-secondary">
                    Muestra las prendas que estan escaseando    
                    <br>
                    Prendas con existencia menor a 
                    <input class="form-control" type="number" name="txt_cantMax" id="txt_cantMax">
                    <br>
                </div>
                <div class="card-footer text-muted">
                    <botton class="btn btn-info" onclick="ImprimirReporteExistencias()" id="btn_repExistencias">
                    <i class="ion-printer"></i>
                    Imprimir reporte
                    </booton>
                </div>
            </div>
        </div>
    <br>
</div>

<div class="modal fade" id="modalRepEntradas" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="ion-printer"></i> Entradas realizadas por usuarios</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
            <iframe id="iframe_ModalEntradas" frameborder="0" width="100%" height="500"></iframe>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalRepExistencias" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="ion-printer"></i> Prendas que tienen pocas prendas en existencia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
            <iframe id="iframe_ModalExistencias" frameborder="0" width="100%" height="500"></iframe>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url();?>assets/JavaScript/admin-Reportes-Prendas.js"></script>
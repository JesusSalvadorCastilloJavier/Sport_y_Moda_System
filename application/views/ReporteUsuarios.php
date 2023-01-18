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
            <i class="ion-person"></i>
            Reportes de Usuarios
        </a>
    </nav>
    <br>
            <div class="card-deck">
                <div class="card h-100">
                    <div class="card-header"> <i class="ion-clipboard"></i> Movimientos realizados por usuario</div>
                    <div class="card-body text-secondary">
                        Seleccione el usuario
                        <select class="form-control" id="sel_usuarios_movimientos">
                            <option>Seleccione una opción</option>
                            <?php
                                foreach($datosUsuarios as $dato):
                                    ?>
                                        <option value="<?php echo $dato['UsuarioId'];?>"><?php echo $dato['Persona_ApellidoPaterno'].' '.$dato['Persona_ApellidoMaterno'].' '.$dato['Persona_Nombre'];?></option>
                                    <?php
                                endforeach;
                            ?>
                        </select>
                        <br>
                        De la fecha
                        <input class="form-control" type="datetime-local" name="fecha_inicio" id="fecha_inicio">
                        a la fecha
                        <input class="form-control" type="datetime-local" name="fecha_fin" id="fecha_fin">
                    </div>
                    <div class="card-footer text-muted">
                        <botton class="btn btn-info" onclick="ImprimirReportPorUsuarioId()" id="btn_repMovUser">
                            <i class="ion-printer"></i>
                            Imprimir reporte
                        </booton>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header"> <i class="ion-document-text"></i> Datos generales del usuario</div>
                    <div class="card-body text-secondary">
                        Seleccione el usuario
                        <select class="form-control" id="sel_datos_usuario">
                            <option>Seleccione una opción</option>
                            <?php
                                foreach($datosUsuarios as $dato):
                                    ?>
                                        <option value="<?php echo $dato['UsuarioId'];?>"><?php echo $dato['Persona_ApellidoPaterno'].' '.$dato['Persona_ApellidoMaterno'].' '.$dato['Persona_Nombre'];?></option>
                                    <?php
                                endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="card-footer text-muted">
                        <botton class="btn btn-info" onclick="ImprimirReportDatosPorUsuarioId()" id="btn_repDatosUser">
                        <i class="ion-printer"></i>
                            Imprimir reporte
                        </booton>
                    </div>
                </div>
            </div>
    </div>
<div class="modal fade" id="modalRepMovimientos" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Movimientos por Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
            <iframe id="iframe_ModalMovimientos" frameborder="0" width="100%" height="500"></iframe>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalRepDatos" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Datos generales del usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
            <iframe id="iframe_ModalDatos" frameborder="0" width="100%" height="500"></iframe>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



<script src="<?php echo base_url();?>assets/JavaScript/admin-Reportes-Usuarios.js"></script>
<?php
        $datosUsuario=array(
            'datos' => $datos,
            'respuesta'=> $respuesta,
            'menuPadre'=>$menuPadre,
            'menus' => $menus,
            'montosCaja' => $montosCaja
        );
    ?>
    <label style="display:none;" id="txt-FullCalendar"><?php echo json_encode($datosUsuario['montosCaja']);?></label>
    
    <!-- LIBRERIAS DEL CALENDARIO -->
    <link href='<?php echo base_url();?>Libraries/Fullcalendar/Lib/main.css' rel='stylesheet'/>
    <script src='<?php echo base_url();?>Libraries/Fullcalendar/Lib/main.js'></script>
    <script src="<?php echo base_url();?>assets/JavaScript/FullCalendar-Caja.js"></script>

    
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
            <i class="ion-cash"></i>
            Configuración de caja registradora
        </a>
    </nav>
</div>

<br>

<input type="hidden" name="txt-UsuarioId" id="txt-UsuarioId" value="<?php echo $datosUsuario['respuesta'][0]['UsuarioId'];  ?>" disabled>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <i class="ion-ios-calendar-outline"></i> - CALENDARIO -
        </div>
        <div class="card-body">
            <div id='calendar'></div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalEvent" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registro de efectivo en caja registradora</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <center>
                        <img src="<?php echo base_url();?>assets/Imagenes/caja-registradora (2).png" height="200" width="200" class="img-fluid" alt="Responsive image"></center>
                    <center>
                    <br>
                    <div class="alert alert-warning" role="alert">
                        <label id="mensaje" ></label>
                        <input type="hidden" id="fecha" ></input>
                    </div>
                        
                    </center>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">$</div>
                        </div>
                        <input type="text" class="form-control" id="idMontoCaja" placeholder="1500">
                    </div>
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-info" onclick="registraCaja()"><i class="ion-loop"></i> Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ion-trash-a"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>



<script src="<?php echo base_url();?>assets/JavaScript/admin-Configuracion-Caja.js"></script>
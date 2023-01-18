<?php
        $datosUsuario=array(
            'datos' => $datos,
            'respuesta'=> $respuesta,
            'menuPadre'=>$menuPadre,
            'menus' => $menus
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

<div class="container-fluid">
    <nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="#">
        <i class="ion-card"></i>
        Configuración de credenciales
    </a>
    </nav>
    <br>
    <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong><h6>Nota:</h6></strong>
            Al cambiar las credenciales, deberá iniciar sesión nuevamente.
    </div>
    <br>
    <form name="formUpdatePassword">
        <div class="card">
            <div class="card-header">
                <h5>Modificación de credenciales</h5>
            </div>
                <div class="container-fluid">
                    <br>
                    Usuario
                    <input type="text" id="txt-user" name="txt-user" class="form-control"  value="<?php echo $datosUsuario['respuesta'][0]['usuario'];?>" disabled />    
                    <br>
                    Nueva contraseña
                    <input type="password" id="txt-password" name="txt-password" autocomplete="new-password" class="form-control" required=true placeholder="*********">
                    Confirmar contraseña
                    <input type="password" id="txt-rep-password" name="txt-rep-password" autocomplete="new-password" class="form-control" required=true placeholder="*********">
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <button id="btn-guardarPassword" onclick="guardarCredenciales()" class="btn btn-primary btn-block"><i class="ion-key"></i> Guardar</button>
                        </div>
                        <div class="col-6">
                            <button id="btn-limpiarCasillas" onclick="limpiarCredenciales()" class="btn btn-danger btn-block"><i class="ion-trash-a"></i> Cancelar</button>
                        </div>
                    </div>
                    <input type="hidden" name="txt-usuarioId" id="txt-usuarioId" value="<?php echo $datosUsuario['respuesta'][0]['UsuarioId'];?>" disabled/>
                    <br>
                </div>
            </div>
        </div>
    </form>
</div>





<script src="<?php echo base_url();?>assets/JavaScript/admin-Configuracion-Usuarios.js"></script>
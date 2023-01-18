<?php
        $datosUsuario=array(
            'datos' => $datos,
            'respuesta'=> $respuesta,
            'menuPadre'=>$menuPadre,
            'menus' => $menus,
            'datosUsuarios'=>$datosUsuarios
        );
    ?>
<script src="<?php echo base_url();?>Libraries/package/dist/chart.js"></script>
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
    <div class="card">
    <h5 class="card-header"><i class="ion-podium"></i> GRÁFICA DE VENTAS</h5>
        <div class="card-body">
        <select name="year" id="year" class="form-control">
            <option value="0">Seleccione el año.</option>
            <?php for($i=2022;$i<=date("Y");$i++) { echo "<option value='".$i."'>".$i."</option>"; } ?>
        </select>
            <div class="row">
                <div class="col-12">
                    <div>
                        <canvas id="myChart3" style="position: relative; height:70vh; width:100vw"></canvas>
                    </div>
                </div>
                <div class="col-6">
                    <div>
                        <canvas id="myChart2" style="position: relative; height:70vh; width:100vw"></canvas>
                    </div>
                </div>
                <div class="col-6">
                    <div>
                        <canvas id="myChart" style="position: relative; height:70vh; width:100vw"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>



<script src="<?php echo base_url();?>assets/JavaScript/admin-Reportes-Ventas.js"></script>
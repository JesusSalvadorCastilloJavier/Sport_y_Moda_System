<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_Controller extends CI_Controller {

	//$datosMovimientosGlobal;

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('Almacen_Model');
		$this->load->model('Catalogos_Model');
		$this->load->model('Rutas_Model');
        $this->load->model('Configuracion_Model');
		$this->load->model('Reporte_Model');

		
	}

    public function ReporteUsuarios(){
		$UsuarioId = base64_decode($_GET['UsuarioId']);
        $respuesta = $this->Rutas_Model->inicio($UsuarioId);
		$menuPadre = $this->Rutas_Model->getMenuPadre($respuesta[0]['UsuarioId']);
		$menus = $this->Rutas_Model->getMenus($respuesta[0]['UsuarioId']);

        $datos = array(
            'user'=> $respuesta[0]['usuario'],
            'password'=> $respuesta[0]['contrasenia']
        );

		if($respuesta == null){
			$this->load->view('Login/Login');
		}else{
            $datosUsuarios = $this->Configuracion_Model->getAllUsuarios();
			$datosUsuario=array(
				'datos' => $datos,
				'respuesta'=> $respuesta,
				'menuPadre'=>$menuPadre,
				'menus' => $menus,
                'datosUsuarios'=>$datosUsuarios
			);
			$this->load->view('Layout/header',$datosUsuario);
			$this->load->view('ReporteUsuarios');
			$this->load->view('Layout/footer');
		}
    }

	public function ReporteAlmacen(){
		$UsuarioId = base64_decode($_GET['UsuarioId']);
        $respuesta = $this->Rutas_Model->inicio($UsuarioId);
		$menuPadre = $this->Rutas_Model->getMenuPadre($respuesta[0]['UsuarioId']);
		$menus = $this->Rutas_Model->getMenus($respuesta[0]['UsuarioId']);

        $datos = array(
            'user'=> $respuesta[0]['usuario'],
            'password'=> $respuesta[0]['contrasenia']
        );

		if($respuesta == null){
			$this->load->view('Login/Login');
		}else{
            $datosUsuarios = $this->Configuracion_Model->getAllUsuarios();
			$datosUsuario=array(
				'datos' => $datos,
				'respuesta'=> $respuesta,
				'menuPadre'=>$menuPadre,
				'menus' => $menus,
                'datosUsuarios'=>$datosUsuarios
			);
			$this->load->view('Layout/header',$datosUsuario);
			$this->load->view('ReporteAlmacen');
			$this->load->view('Layout/footer');
		}
    }

	public function ReporteMovimientosPorUsuarioId(){

		$campos= json_decode($_REQUEST['datos'],true);

		$datos=array(
			'usId'=>$campos['usuarioId'],
			'FechaI'=>$campos['FechaInicio'],
			'FechaF'=>$campos['FechaFin']
		);

		$datosMovimientos = $this->Reporte_Model->getAllMovimientosByUserId($datos);
		date_default_timezone_set('America/Mexico_City');
        require('Libraries/FPDF/fpdf.php');

		$pdf = new FPDF();
        
		$pdf->AddPage();
		$pdf->AliasNbPages();
		
		$pdf->SetFont('Times','',12);

		$pdf->SetFont('Helvetica','B',16);
		// Movernos a la derecha
		$pdf->Cell(80);
		// Título
		$pdf->Cell(30,10,'- Sport & Moda -',0,0,'C');
		$pdf->Image('assets/Imagenes/reportes.png',5,0,40,0,'PNG');
		$pdf->Image('assets/Imagenes/logo_vertical.png',174,12,30,0,'PNG');

		//Tipo de Texto
        $pdf->SetFont('Courier','B',12);

        $pdf->SetY(20);
        $pdf->SetX(5);
		$pdf->Cell(200,12,utf8_decode("MOVIMIENTOS REALIZADOS POR EL USUARIO"),0,0,'C');


		//Tipo de Texto
        $pdf->SetFont('Courier','B',10);	
		
		$pdf->SetY(40);
        $pdf->SetX(5);
        $pdf->Cell(40,8,utf8_decode('Usuario: '),0);
		$pdf->SetY(40);
        $pdf->SetX(30);
        $pdf->Cell(100,8,utf8_decode($datosMovimientos[0]['Usuario']),0);

		$pdf->SetY(40);
        $pdf->SetX(130);
		$pdf->Cell(40,8,"Fecha: ".date("F j, Y, g:i a"),0,1,'L');
		
		
		//ENCABEZADO DE LA TABLA
		$pdf->setFillColor(0, 203, 255 );
		$pdf->SetY(52);
        $pdf->SetX(5);
        $pdf->Cell(40,8,utf8_decode('FECHA DE MOVIMIENTO'),1,0,'C',true);
		$pdf->SetY(52);
        $pdf->SetX(45);
        $pdf->Cell(155,8,utf8_decode("MOVIMIENTOS REALIZADOS POR EL USUARIO"),1,0,'C',true);
		
		//Tipo de Texto
        $pdf->SetFont('Courier','',8);
		$pdf->SetY(60);
		
		// Datos
		$contador=0;
		foreach($datosMovimientos as $col)
		{
			if($contador%2==1){
				$pdf->setFillColor(234, 237, 237);	
				$pdf->SetX(5);
				$pdf->Cell(40,6,utf8_decode($col['Logs_fechaMovimiento']),1,0,'',true);
				$pdf->SetX(45);
				$pdf->MultiCell(155,6,utf8_decode($col['Logs_Descripcion']),1,1,'L',true);
			}else{
				$pdf->SetX(5);
				$pdf->Cell(40,6,utf8_decode($col['Logs_fechaMovimiento']),1);
				$pdf->SetX(45);
				$pdf->MultiCell(155,6,utf8_decode($col['Logs_Descripcion']),1);
			}
			$contador=$contador+1;
		}
		
		$pdf->SetY(265);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(0,10,utf8_decode('Página ').$pdf->PageNo().'/{nb}',0,0,'C');
		
		$pdf->Output();
	}


	public function ReporteDatosPorUsuarioId(){
		$userId = base64_decode($_GET['UsuarioId']);
		$datosUsuario = $this->Reporte_Model->getAllDatosByUserId($userId);
		//print_r($datosUsuario);
        require('Libraries/FPDF/fpdf.php');
		date_default_timezone_set('America/Mexico_City');
		$pdf = new FPDF();
        
		$pdf->AddPage();
		$pdf->AliasNbPages();
		
		$pdf->SetFont('Times','',12);

		$pdf->SetFont('Helvetica','B',16);
		// Movernos a la derecha
		$pdf->Cell(80);
		// Título
		$pdf->Cell(30,10,'- Sport & Moda -',0,0,'C');
		$pdf->Image('assets/Imagenes/reportes.png',5,0,40,0,'PNG');
		$pdf->Image('assets/Imagenes/logo_vertical.png',174,12,30,0,'PNG');


		//Tipo de Texto
        $pdf->SetFont('Courier','B',12);

        $pdf->SetY(20);
        $pdf->SetX(5);
		$pdf->SetFillColor(0, 0, 255);
        $pdf->Cell(200,12,utf8_decode("DATOS GENERALES DEL USUARIO"),0,0,'C');


		//Tipo de Texto
        $pdf->SetFont('Courier','B',10);	

		$pdf->SetY(40);
        $pdf->SetX(5);
        $pdf->Cell(40,8,utf8_decode('Usuario: '),0);
		$pdf->SetY(40);
        $pdf->SetX(30);
        $pdf->Cell(100,8,utf8_decode($datosUsuario[0]['Nombre']),0);

		$pdf->SetY(40);
        $pdf->SetX(130);
		$pdf->Cell(40,8,"Fecha: ".date("F j, Y, g:i a"),0,1,'L');


		$pdf->setFillColor(0, 203, 255 );
		$pdf->SetY(52);
        $pdf->SetX(5);
        $pdf->Cell(200,8,utf8_decode("DATOS COMPLETOS DEL USUARIO"),1,0,'C',true);


		//Datos del usuario
		$pdf->SetFont('Courier','',10);	
		$pdf->setFillColor(234, 237, 237);
		
		$pdf->SetY(60);
        $pdf->SetX(5);
        $pdf->Cell(45,8,utf8_decode('Usuario '),1,0,'',true);
		$pdf->SetY(60);
        $pdf->SetX(50);
        $pdf->Cell(155,8,utf8_decode($datosUsuario[0]['Usuario']),1);

		$pdf->SetY(68);
        $pdf->SetX(5);
        $pdf->Cell(45,8,utf8_decode('Fecha de creación '),1,0,'',true);
		$pdf->SetY(68);
        $pdf->SetX(50);
        $pdf->Cell(155,8,utf8_decode($datosUsuario[0]['FechaCreacion']),1);

		$pdf->SetY(76);
        $pdf->SetX(5);
        $pdf->Cell(45,8,utf8_decode('Fecha de nacimiento '),1,0,'',true);
		$pdf->SetY(76);
        $pdf->SetX(50);
        $pdf->Cell(155,8,utf8_decode($datosUsuario[0]['FechaNacimiento']),1);

		$pdf->SetY(84);
        $pdf->SetX(5);
        $pdf->Cell(45,8,utf8_decode('Cargo'),1,0,'',true);
		$pdf->SetY(84);
        $pdf->SetX(50);
        $pdf->Cell(155,8,utf8_decode($datosUsuario[0]['Role']),1);

		$pdf->SetY(92);
        $pdf->SetX(5);
        $pdf->Cell(45,8,utf8_decode('Sexo'),1,0,'',true);
		$pdf->SetY(92);
        $pdf->SetX(50);
        $pdf->Cell(155,8,utf8_decode($datosUsuario[0]['Sexo']),1);

		$pdf->SetY(100);
        $pdf->SetX(5);
        $pdf->Cell(45,8,utf8_decode('Correo electrónico'),1,0,'',true);
		$pdf->SetY(100);
        $pdf->SetX(50);
        $pdf->Cell(155,8,utf8_decode($datosUsuario[0]['Email']),1);

		$pdf->SetY(108);
        $pdf->SetX(5);
        $pdf->Cell(45,8,utf8_decode('Teléfono de recados'),1,0,'',true);
		$pdf->SetY(108);
        $pdf->SetX(50);
        $pdf->Cell(155,8,utf8_decode($datosUsuario[0]['TelRecados']),1);
		
		$pdf->SetY(116);
        $pdf->SetX(5);
        $pdf->Cell(45,8,utf8_decode('Teléfono celular'),1,0,'',true);
		$pdf->SetY(116);
        $pdf->SetX(50);
        $pdf->Cell(155,8,utf8_decode($datosUsuario[0]['TelCelular']),1);

		$pdf->SetY(124);
        $pdf->SetX(5);
        $pdf->Cell(45,8,utf8_decode('Teléfono de casa'),1,0,'',true);
		$pdf->SetY(124);
        $pdf->SetX(50);
        $pdf->Cell(155,8,utf8_decode($datosUsuario[0]['TelCasa']),1);

		$pdf->SetY(132);
        $pdf->SetX(5);
        $pdf->Cell(45,8,utf8_decode('Calle'),1,0,'',true);
		$pdf->SetY(132);
        $pdf->SetX(50);
        $pdf->Cell(65,8,utf8_decode($datosUsuario[0]['Calle']),1);
        $pdf->SetX(115);
        $pdf->Cell(30,8,utf8_decode("N° Interior"),1,0,'',true);
        $pdf->SetX(145);
        $pdf->Cell(15,8,utf8_decode($datosUsuario[0]['NumeroInterior']),1,0,'C');
		$pdf->SetX(160);
		$pdf->Cell(30,8,utf8_decode("N° Exterior"),1,0,'',true);
        $pdf->SetX(190);
        $pdf->Cell(15,8,utf8_decode($datosUsuario[0]['NumeroExterior']),1,0,'C');

		$pdf->SetY(140);
        $pdf->SetX(5);
        $pdf->Cell(45,8,utf8_decode('Estado'),1,0,'',true);
		$pdf->SetY(140);
        $pdf->SetX(50);
        $pdf->Cell(155,8,utf8_decode($datosUsuario[0]['Estado']),1);

		$pdf->SetY(148);
        $pdf->SetX(5);
        $pdf->Cell(45,8,utf8_decode('Municipio'),1,0,'',true);
		$pdf->SetY(148);
        $pdf->SetX(50);
        $pdf->Cell(155,8,utf8_decode($datosUsuario[0]['Municipio']),1);


		$pdf->SetY(265);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(0,10,utf8_decode('Página ').$pdf->PageNo().'/{nb}',0,0,'C');
		
		$pdf->Output();
	}

	public function ReporteEntradasPrendasPorFechas(){

		$campos= json_decode($_REQUEST['datos'],true);

		$datos=array(
			'fechaInicio'=>$campos['fechaInicio'],
			'fechaFin'=>$campos['fechaFin'],
		);

		$datosEntradasPrendas = $this->Reporte_Model->getAllEntradasPrendasByFecha($datos);

		//print_r($datosEntradasPrendas);
		date_default_timezone_set('America/Mexico_City');
        require('Libraries/FPDF/fpdf.php');
		
		$pdf = new FPDF();
        
		$pdf->AddPage();
		//$pdf->Image('assets/Imagenes/fondo_azul.jpg',0,0,200,300,'JPG');
		$pdf->AliasNbPages();
		
		$pdf->SetFont('Times','',12);

		$pdf->SetFont('Helvetica','B',16);
		// Movernos a la derecha
		$pdf->Cell(80);
		// Título
		$pdf->Cell(30,10,'- Sport & Moda -',0,0,'C');
		$pdf->Image('assets/Imagenes/reportes.png',5,0,40,0,'PNG');
		$pdf->Image('assets/Imagenes/logo_vertical.png',174,12,30,0,'PNG');

		//Tipo de Texto
        $pdf->SetFont('Courier','B',12);

        $pdf->SetY(20);
        $pdf->SetX(5);
		$pdf->Cell(200,12,utf8_decode("ENTRADAS DE PRENDAS REALIZADAS POR FECHAS"),0,0,'C');


		//Tipo de Texto
        $pdf->SetFont('Courier','B',10);	

		$pdf->SetY(40);
        $pdf->SetX(130);
		$pdf->Cell(40,8,"Fecha: ".date("F j, Y, g:i a"),0,1,'L');
		
		
		//ENCABEZADO DE LA TABLA
		$pdf->setFillColor(0, 203, 255 );
		$pdf->SetY(52);
        $pdf->SetX(5);
        $pdf->Cell(55,8,utf8_decode('Nombre'),1,0,'C',true);
        $pdf->SetX(60);
        $pdf->Cell(35,8,utf8_decode("Prenda"),1,0,'C',true);
        $pdf->SetX(95);
        $pdf->Cell(60,8,utf8_decode("Descripción"),1,0,'C',true);
        $pdf->SetX(155);
        $pdf->Cell(15,8,utf8_decode("Piezas"),1,0,'C',true);
        $pdf->SetX(170);
        $pdf->Cell(30,8,utf8_decode("Fecha"),1,0,'C',true);
		//Tipo de Texto
        $pdf->SetFont('Courier','',8);
		$pdf->SetY(60);
		
		// Datos
		$contador=0;
		foreach($datosEntradasPrendas as $col)
		{
			if($contador%2==1){
				$pdf->setFillColor(234, 237, 237);	
				$pdf->SetX(5);
				$pdf->Cell(55,6,utf8_decode($col['Nombre']),1,0,'',true);
				$pdf->SetX(60);
				$pdf->Cell(35,6,utf8_decode($col['prenda']),1,0,'',true);
				$pdf->SetX(95);
				$pdf->Cell(60,6,utf8_decode($col['detalle']),1,0,'',true);
				$pdf->SetX(155);
				$pdf->Cell(15,6,utf8_decode($col['cantidad']),1,0,'C',true);
				$pdf->SetX(170);
				$pdf->Cell(30,6,utf8_decode($col['Fecha']),1,0,'C',true);
			}else{
				$pdf->SetX(5);
				$pdf->Cell(55,6,utf8_decode($col['Nombre']),1);
				$pdf->SetX(60);
				$pdf->Cell(35,6,utf8_decode($col['prenda']),1);
				$pdf->SetX(95);
				$pdf->Cell(60,6,utf8_decode($col['detalle']),1);
				$pdf->SetX(155);
				$pdf->Cell(15,6,utf8_decode($col['cantidad']),1,0,'C',);
				$pdf->SetX(170);
				$pdf->Cell(30,6,utf8_decode($col['Fecha']),1,0,'C',);
			}
			$contador=$contador+1;
			$pdf->Ln();
		}
		
		$pdf->SetY(265);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(0,10,utf8_decode('Página ').$pdf->PageNo().'/{nb}',0,0,'C');
		
		$pdf->Output();
	}

	public function ReporteImprimeCredenciales(){
		$campos= json_decode($_REQUEST['datos'],true);

		$datos=array(
			'usuario'=>$campos['usuario'],
			'contrasenia'=>$campos['contrasenia'],
		);

		require('Libraries/FPDF/fpdf.php');

        $pdf = new FPDF('p','mm',array(80,90));
        $pdf->AddPage();

        $pdf->setTitle('Sport y Moda');
        
        $pdf->SetFont('Helvetica','B',18);
        $pdf->SetY(10);
        $pdf->SetX(5);
        $pdf->Cell(70,10,utf8_decode("- Sport & Moda -"),0,'', 'C');
        
		$pdf->SetFont('Helvetica','B',12);
        $pdf->SetY(20);
        $pdf->SetX(5);
        $pdf->Cell(70,10,utf8_decode("*** Credenciales de acceso ***"),0,'', 'C');



        //Tipo de Texto
        $pdf->SetFont('Courier','',10);
        //Primer Columna
        $pdf->SetY(30);
        $pdf->SetX(5);
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(20,8,utf8_decode("Usuario:"),0);
        //Segunda columna
        $pdf->SetY(30);
        $pdf->SetX(30);
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(55,8,utf8_decode($datos['usuario']),0);

        //Primer Columna
        $pdf->SetY(38);
        $pdf->SetX(5);
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(20,8,utf8_decode("Contraseña:"),0);
        //Segunda columna
        $pdf->SetY(38);
        $pdf->SetX(30);
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(55,8,utf8_decode($datos['contrasenia']),0);


		$pdf->SetFont('Helvetica','B',8);
        $pdf->SetY(50);
        $pdf->SetX(5);
        $pdf->MultiCell(70,3,utf8_decode("NOTA: Una vez iniciada sesión por primera vez, recordar que debe hacer su cambio de contraseña, esto es totalmente responsabilidad del usuario."),'C');

        $pdf->SetFont('Courier','',12);
        //Primer Columna
        $pdf->SetY(60);
        $pdf->SetX(5);

        $y = $pdf->GetY();

        $pdf->Output();
	}

	public function ReporteEntradasPrendasExistencias($cantidad){

		$datosPrendasExistentes = $this->Reporte_Model->getAllPrendasExistentes($cantidad);

		//print_r($datosPrendasExistentes);

		
		date_default_timezone_set('America/Mexico_City');
        require('Libraries/FPDF/fpdf.php');
		
		$pdf = new FPDF();
        
		$pdf->AddPage();
		//$pdf->Image('assets/Imagenes/fondo_azul.jpg',0,0,200,300,'JPG');
		$pdf->AliasNbPages();
		
		$pdf->SetFont('Times','',12);

		$pdf->SetFont('Helvetica','B',16);
		// Movernos a la derecha
		$pdf->Cell(80);
		// Título
		$pdf->Cell(30,10,'- Sport & Moda -',0,0,'C');
		$pdf->Image('assets/Imagenes/reportes.png',5,0,40,0,'PNG');
		$pdf->Image('assets/Imagenes/logo_vertical.png',174,12,30,0,'PNG');

		//Tipo de Texto
        $pdf->SetFont('Courier','B',12);

        $pdf->SetY(20);
        $pdf->SetX(5);
		$pdf->Cell(200,12,utf8_decode("PRENDAS CON UN MAXIMO DE ".$cantidad." PRENDAS"),0,0,'C');


		//Tipo de Texto
        $pdf->SetFont('Courier','B',10);	

		$pdf->SetY(40);
        $pdf->SetX(130);
		$pdf->Cell(40,8,"Fecha: ".date("F j, Y, g:i a"),0,1,'L');
		
		
		//ENCABEZADO DE LA TABLA
		$pdf->setFillColor(0, 203, 255 );
		$pdf->SetY(52);
        $pdf->SetX(5);
        $pdf->Cell(35,8,utf8_decode('Prenda'),1,0,'C',true);
        $pdf->SetX(40);
        $pdf->Cell(65,8,utf8_decode("Descripción"),1,0,'C',true);
        $pdf->SetX(105);
        $pdf->Cell(20,8,utf8_decode("Talla"),1,0,'C',true);
        $pdf->SetX(125);
        $pdf->Cell(25,8,utf8_decode("Cantidad"),1,0,'C',true);
        $pdf->SetX(150);
        $pdf->Cell(50,8,utf8_decode("Color"),1,0,'C',true);
		//Tipo de Texto
        $pdf->SetFont('Courier','',8);
		$pdf->SetY(60);
		
		// Datos
		$contador=0;
		foreach($datosPrendasExistentes as $col)
		{
			if($contador%2==1){
				$pdf->setFillColor(234, 237, 237);	
				$pdf->SetX(5);
				$pdf->Cell(35,6,utf8_decode($col['Prenda']),1,0,'',true);
				$pdf->SetX(40);
				$pdf->Cell(65,6,utf8_decode($col['Descripcion']),1,0,'',true);
				$pdf->SetX(105);
				$pdf->Cell(20,6,utf8_decode($col['Talla']),1,0,'C',true);
				$pdf->SetX(125);
				$pdf->Cell(25,6,utf8_decode($col['Cantidad']),1,0,'C',true);
				$pdf->SetX(150);
				$pdf->Cell(50,6,utf8_decode($col['Color']),1,0,'',true);
			}else{
				$pdf->SetX(5);
				$pdf->Cell(35,6,utf8_decode($col['Prenda']),1);
				$pdf->SetX(40);
				$pdf->Cell(65,6,utf8_decode($col['Descripcion']),1);
				$pdf->SetX(105);
				$pdf->Cell(20,6,utf8_decode($col['Talla']),1,0,'C');
				$pdf->SetX(125);
				$pdf->Cell(25,6,utf8_decode($col['Cantidad']),1,0,'C',);
				$pdf->SetX(150);
				$pdf->Cell(50,6,utf8_decode($col['Color']),1,0,'',);
			}
			$contador=$contador+1;
			$pdf->Ln();
		}
		
		$pdf->SetY(265);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(0,10,utf8_decode('Página ').$pdf->PageNo().'/{nb}',0,0,'C');
		
		$pdf->Output();
	}

	public function ReporteVentas(){
		$UsuarioId = base64_decode($_GET['UsuarioId']);
        $respuesta = $this->Rutas_Model->inicio($UsuarioId);
		$menuPadre = $this->Rutas_Model->getMenuPadre($respuesta[0]['UsuarioId']);
		$menus = $this->Rutas_Model->getMenus($respuesta[0]['UsuarioId']);

        $datos = array(
            'user'=> $respuesta[0]['usuario'],
            'password'=> $respuesta[0]['contrasenia']
        );

		if($respuesta == null){
			$this->load->view('Login/Login');
		}else{
            $datosUsuarios = $this->Configuracion_Model->getAllUsuarios();
			
			$datosUsuario=array(
				'datos' => $datos,
				'respuesta'=> $respuesta,
				'menuPadre'=>$menuPadre,
				'menus' => $menus,
                'datosUsuarios'=>$datosUsuarios
			);
			$this->load->view('Layout/header',$datosUsuario);
			$this->load->view('ReporteVentas');
			$this->load->view('Layout/footer');
		}
    }

	public function ObtenerDatosGrafica(){
		$anio=$_POST['anio'];
		if($anio=="" || $anio==NULL){
			$anio=date("Y");
		}
		$datosCalendario = $this->Reporte_Model->getAllCalendario($anio);
		print_r(json_encode($datosCalendario));
		
	}

}
?>
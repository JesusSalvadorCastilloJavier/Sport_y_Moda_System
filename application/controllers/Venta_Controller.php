<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venta_Controller extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('Almacen_Model');
		$this->load->model('Catalogos_Model');
		$this->load->model('Rutas_Model');
		$this->load->model('Configuracion_Model');
		$this->load->model('Ventas_Model');
	}


    //----------------------------------------------------------------------------------- APARTADO DE VENTAS

	public function Nueva_Venta(){
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
            
            $datosTablaPrendas = $this->Almacen_Model->getAllPrendas();				//Obtengo los datos para la tabla del inventario
            $datosCatGenero = $this->Catalogos_Model->getAllGenero();
            $datosCatMarca = $this->Catalogos_Model->getAllMarca();
            $datosCatTalla = $this->Catalogos_Model->getAllTalla();
            $datosCatColorP = $this->Catalogos_Model->getAllColor();
            $datosCatColorS = $this->Catalogos_Model->getAllColor();
            $datosCatProveedor = $this->Catalogos_Model->getAllProveedor();
			$datosCatCliente = $this->Configuracion_Model->getAllClientes();

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
                'datosCatProveedor'=>$datosCatProveedor,
				'datosCatCliente'=>$datosCatCliente
			);
			$this->load->view('Layout/header',$datosUsuario);
			$this->load->view('NuevaVenta');
			$this->load->view('Layout/footer');
		}
	}
	
	public function ejecutandoCompra(){
		
		$campos= json_decode($_REQUEST['datos'],true);

		if($campos['ClienteId']==''){
			$campos['ClienteId']=1;
		}

		$datos=array(
			'UsuarioId'=>$campos['UsuarioId'],
            'dataCollectionPrenda'=>$campos['dataCollectionPrenda'],
            'ClienteId'=>$campos['ClienteId'],
            'Descuento'=>$campos['descuento'],
            'deposito'=>$campos['deposito'],
            'TotalPagar'=>$campos['TotalPagar'],
            'TotalFinalPagar'=>$campos['TotalFinalPagar'],
            'cambio'=>$campos['cambio']
		);

		$datosEntradasPrendas = $this->Ventas_Model->addVenta($datos);
		
		require('Libraries/FPDF/fpdf.php');
		include 'Libraries/barcode.php';

        $pdf = new FPDF('p','mm',array(120,220));
        $pdf->AddPage();

        $pdf->setTitle('Sport y Moda');
        
        $pdf->SetFont('Helvetica','B',30);
        $pdf->SetY(10);
        $pdf->SetX(5);
        $pdf->Cell(110,10,utf8_decode("- Sport & Moda -"),0,'', 'C');
        
		$pdf->SetFont('Helvetica','B',20);
        $pdf->SetY(20);
        $pdf->SetX(5);
        $pdf->Cell(110,10,utf8_decode("*** Ticket de Venta ***"),0,'', 'C');

		$pdf->SetFont('Courier','B',15);	

		$pdf->SetY(35);
        $pdf->SetX(5);
		$pdf->Cell(40,3,"Fecha de venta: ".date("Y-m-d H:i:s"));
		$pdf->SetY(40);
        $pdf->SetX(5);
		$pdf->Cell(40,3,"Fecha cambios:  ".$datosEntradasPrendas[0]['FechaLimiteCambio']);
		$pdf->SetY(45);
        $pdf->SetX(5);
		$pdf->Cell(40,3,"Fue atendido por:".utf8_decode($datosEntradasPrendas[0]['Usuario']));


		//ENCABEZADO DE LA TABLA
		$pdf->SetFont('Courier','B',15);
		//$pdf->setFillColor(0, 203, 255 );
		$pdf->SetY(55);
        $pdf->SetX(5);
        $pdf->Cell(90,8,utf8_decode('DESCRIPCIÓN DE LA PRENDA'),0,0,'',false);
        $pdf->SetX(25);
        /*$pdf->Cell(30,8,utf8_decode("DESCRIPCIÓN"),0,0,'C',false);
        $pdf->SetX(55);
        $pdf->Cell(10,8,utf8_decode("TALLA"),0,0,'C',false);
        $pdf->SetX(65);
        $pdf->Cell(20,8,utf8_decode("PRECIO c/u"),0,0,'C',false);
        $pdf->SetX(85);
        $pdf->Cell(10,8,utf8_decode("PIEZAS"),0,0,'C',false);*/
		$pdf->SetX(95);
        $pdf->Cell(15,8,utf8_decode("SUBTOTAL"),0,0,'C',false);
		//Tipo de Texto
        
		$pdf->SetY(65);

		foreach($datosEntradasPrendas as $col)
		{
			$pdf->SetFont('Courier','B',15);
			$pdf->SetX(5);
			$pdf->Cell(90,5,utf8_decode($col['Prenda']." ".$col['Cantidad']." x $".$col['PrecioSalida']),0,0,'',false);
			/*$pdf->SetX(25);
			$pdf->Cell(30,5,utf8_decode($col['Descripcion']),0,0,'',false);
			$pdf->SetX(55);
			$pdf->Cell(10,5,utf8_decode($col['Talla']),0,0,'C',false);
			$pdf->SetX(65);
			$pdf->Cell(20,5,utf8_decode("$".$col['PrecioSalida']),0,0,'C',false);
			$pdf->SetX(85);
			$pdf->Cell(10,5,utf8_decode($col['Cantidad']),0,0,'C',false);
			$pdf->SetX(95);
			$pdf->SetFont('Courier','B',14);*/
			$pdf->Cell(17,5,utf8_decode("$".$col['Cantidad']*$col['PrecioSalida']),0,0,'C',false);
			$pdf->Ln();
		}



		$code=utf8_decode($datosEntradasPrendas[0]['CodigoVenta']);
        barcode('assets/CodigosVentas/'.$code.'.png', $code, 35, 'horizontal', 'code128', true);   //Genera el codigo en Imagen PNG
        $pdf->Image('assets/CodigosVentas/'.$code.'.png',5,130,110,0,'PNG');                        //Consulta la imagen de código
        //$pdf->Cell(70,9,utf8_decode($datosPrenda[0]['Codigo']),0,'', 'C');


		$pdf->SetFont('Courier','B',13);
		$pdf->SetY(150);
		$pdf->SetX(5);
		$pdf->Cell(105,4,utf8_decode("TOTAL............................. $".$datosEntradasPrendas[0]['Total']),0,0,'',false);
		$pdf->SetY(155);
		$pdf->SetX(5);
		$pdf->Cell(105,4,utf8_decode("DESCUENTO......................... $".$datosEntradasPrendas[0]['Descuento']),0,0,'',false);
		$pdf->SetY(160);
		$pdf->SetX(5);
		$pdf->Cell(105,4,utf8_decode("TOTAL FINAL A PAGAR............... $".$datosEntradasPrendas[0]['TotalFinal']),0,0,'',false);
		$pdf->SetY(165);
		$pdf->SetX(5);
		$pdf->Cell(105,4,utf8_decode("DEPOSITO.......................... $".$datosEntradasPrendas[0]['Deposito']),0,0,'',false);
		$pdf->SetY(170);
		$pdf->SetX(5);
		$pdf->Cell(105,4,utf8_decode("CAMBIO............................ $".$datosEntradasPrendas[0]['Cambio']),0,0,'',false);
        
		$pdf->SetFont('Courier','B',10);
		$pdf->SetY(180);
		$pdf->SetX(5);
		$pdf->MultiCell(105,3,utf8_decode("Para cualquier tipo de cambio o aclaración, debe ser presentado este Ticket de Venta"),0,1,'',false);
        
        $y = $pdf->GetY();

        $pdf->Output();

		//print_r($datosEntradasPrendas);
	}


	public function Apartar_Prenda(){
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

            $datosTablaPrendas = $this->Almacen_Model->getAllPrendas();				//Obtengo los datos para la tabla del inventario
            $datosCatGenero = $this->Catalogos_Model->getAllGenero();
            $datosCatMarca = $this->Catalogos_Model->getAllMarca();
            $datosCatTalla = $this->Catalogos_Model->getAllTalla();
            $datosCatColorP = $this->Catalogos_Model->getAllColor();
            $datosCatColorS = $this->Catalogos_Model->getAllColor();
            $datosCatProveedor = $this->Catalogos_Model->getAllProveedor();
			$datosCatCliente = $this->Configuracion_Model->getAllClientes();

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
                'datosCatProveedor'=>$datosCatProveedor,
				'datosCatCliente'=>$datosCatCliente
			);
			$this->load->view('Layout/header');
			$this->load->view('ApartarPrenda',$datosUsuario);
			$this->load->view('Layout/footer');

		}
	}

	public function ejecutandoApartado(){
		
		$campos= json_decode($_REQUEST['datos'],true);

		if($campos['ClienteId']==''){
			$campos['ClienteId']=1;
		}

		$datos=array(
			'UsuarioId'=>$campos['UsuarioId'],
            'dataCollectionPrenda'=>$campos['dataCollectionPrenda'],
            'ClienteId'=>$campos['ClienteId'],
            'Descuento'=>$campos['descuento'],
            'deposito'=>$campos['deposito'],
            'TotalPagar'=>$campos['TotalPagar'],
            'TotalFinalPagar'=>$campos['TotalFinalPagar'],
            'debe'=>$campos['debe'],
			'alias'=>$campos['alias']
		);
		// **************************************** AQUÍ ME QUEDE ***************************************
		$datosEntradasPrendas = $this->Ventas_Model->addApartado($datos);
		//print_r($datos['dataCollectionPrenda']);
		require('Libraries/FPDF/fpdf.php');
		include 'Libraries/barcode.php';

        $pdf = new FPDF('p','mm',array(120,220));
        $pdf->AddPage();

        $pdf->setTitle('Sport y Moda');
        
        $pdf->SetFont('Helvetica','B',30);
        $pdf->SetY(10);
        $pdf->SetX(5);
        $pdf->Cell(110,10,utf8_decode("- Sport & Moda -"),0,'', 'C');
        
		$pdf->SetFont('Helvetica','B',20);
        $pdf->SetY(20);
        $pdf->SetX(5);
        $pdf->Cell(110,10,utf8_decode("*** Ticket de Apartado ***"),0,'', 'C');

		$pdf->SetFont('Courier','B',15);	

		$pdf->SetY(35);
        $pdf->SetX(5);
		$pdf->Cell(40,3,"Fecha de venta: ".date("Y-m-d H:i:s"));
		$pdf->SetY(40);
        $pdf->SetX(5);
		$pdf->Cell(40,3,"Fecha limite:  ".$datosEntradasPrendas[0]['FechaLimite']);
		$pdf->SetY(45);
        $pdf->SetX(5);
		$pdf->Cell(40,3,"Fue atendido por:".utf8_decode($datosEntradasPrendas[0]['Usuario']));


		//ENCABEZADO DE LA TABLA
		$pdf->SetFont('Courier','B',15);
		//$pdf->setFillColor(0, 203, 255 );
		$pdf->SetY(55);
        $pdf->SetX(5);
        $pdf->Cell(90,8,utf8_decode('DESCRIPCIÓN DE LA PRENDA'),0,0,'',false);
        $pdf->SetX(25);
        /*$pdf->Cell(30,8,utf8_decode("DESCRIPCIÓN"),0,0,'C',false);
        $pdf->SetX(55);
        $pdf->Cell(10,8,utf8_decode("TALLA"),0,0,'C',false);
        $pdf->SetX(65);
        $pdf->Cell(20,8,utf8_decode("PRECIO c/u"),0,0,'C',false);
        $pdf->SetX(85);
        $pdf->Cell(10,8,utf8_decode("PIEZAS"),0,0,'C',false);*/
		$pdf->SetX(95);
        $pdf->Cell(15,8,utf8_decode("SUBTOTAL"),0,0,'C',false);
		//Tipo de Texto
        
		$pdf->SetY(65);

		foreach($datosEntradasPrendas as $col)
		{
			$pdf->SetFont('Courier','B',15);
			$pdf->SetX(5);
			$pdf->Cell(90,5,utf8_decode($col['Prenda']." ".$col['Cantidad']." x $".$col['PrecioSalida']),0,0,'',false);
			/*$pdf->SetX(25);
			$pdf->Cell(30,5,utf8_decode($col['Descripcion']),0,0,'',false);
			$pdf->SetX(55);
			$pdf->Cell(10,5,utf8_decode($col['Talla']),0,0,'C',false);
			$pdf->SetX(65);
			$pdf->Cell(20,5,utf8_decode("$".$col['PrecioSalida']),0,0,'C',false);
			$pdf->SetX(85);
			$pdf->Cell(10,5,utf8_decode($col['Cantidad']),0,0,'C',false);
			$pdf->SetX(95);
			$pdf->SetFont('Courier','B',14);*/
			$pdf->Cell(17,5,utf8_decode("$".$col['Cantidad']*$col['PrecioSalida']),0,0,'C',false);
			$pdf->Ln();
		}



		$code=utf8_decode($datosEntradasPrendas[0]['CodigoVenta']);
        barcode('assets/CodigosVentas/'.$code.'.png', $code, 35, 'horizontal', 'code128', true);   //Genera el codigo en Imagen PNG
        $pdf->Image('assets/CodigosVentas/'.$code.'.png',5,130,110,0,'PNG');                        //Consulta la imagen de código
        //$pdf->Cell(70,9,utf8_decode($datosPrenda[0]['Codigo']),0,'', 'C');


		$pdf->SetFont('Courier','B',13);
		$pdf->SetY(150);
		$pdf->SetX(5);
		$pdf->Cell(105,4,utf8_decode("TOTAL............................. $".$datosEntradasPrendas[0]['Total']),0,0,'',false);
		$pdf->SetY(155);
		$pdf->SetX(5);
		$pdf->Cell(105,4,utf8_decode("DESCUENTO......................... $".$datosEntradasPrendas[0]['Descuento']),0,0,'',false);
		$pdf->SetY(160);
		$pdf->SetX(5);
		$pdf->Cell(105,4,utf8_decode("TOTAL FINAL A PAGAR............... $".$datosEntradasPrendas[0]['TotalFinal']),0,0,'',false);
		$pdf->SetY(165);
		$pdf->SetX(5);
		$pdf->Cell(105,4,utf8_decode("DEPOSITO.......................... $".$datosEntradasPrendas[0]['Deposito']),0,0,'',false);
		$pdf->SetY(170);
		$pdf->SetX(5);
		$pdf->Cell(105,4,utf8_decode("RESTA............................ $".($datosEntradasPrendas[0]['TotalFinal'] - $datosEntradasPrendas[0]['Deposito'])),0,0,'',false);
        
		$pdf->SetFont('Courier','B',10);
		$pdf->SetY(180);
		$pdf->SetX(5);
		$pdf->MultiCell(105,3,utf8_decode("Para cualquier tipo de cambio o aclaración, debe ser presentado este Ticket de Venta"),0,1,'',false);
        
        $y = $pdf->GetY();

        $pdf->Output();

		//print_r($datosEntradasPrendas);
	}

	public function ConsultaVentas(){
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
			$datosTablaVentas = $this->Ventas_Model->getAllVentas();				//Obtengo los datos para la tabla de Ventas

			$datosVentas=array(
				'datos' => $datos,
				'respuesta'=> $respuesta,
				'menuPadre'=>$menuPadre,
				'menus' => $menus,
				'datosTablaVentas'=>$datosTablaVentas,
			);
			$this->load->view('Layout/header',$datosVentas);
			$this->load->view('ConsultaVentas');
			$this->load->view('Layout/footer');
		}
	}

	public function getDetalleVentaByVentaId(){
		$ventaId=$_POST['ventaId'];
		$DatosModalDetalleVenta = $this->Ventas_Model->getDetalleVentasByVentaId($ventaId);
		print_r(json_encode($DatosModalDetalleVenta));
	}

	public function ConsultaApartados(){
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
			$datosTablaApartados = $this->Ventas_Model->getAllApartados();				//Obtengo los datos para la tabla de Ventas

			$datosApartados=array(
				'datos' => $datos,
				'respuesta'=> $respuesta,
				'menuPadre'=>$menuPadre,
				'menus' => $menus,
				'datosTablaApartados'=>$datosTablaApartados,
			);
			$this->load->view('Layout/header',$datosApartados);
			$this->load->view('ConsultaApartados');
			$this->load->view('Layout/footer');
		}
	}

	public function getDetalleApartadoByApartadoId(){
		$apartadoId=$_POST['apartadoId'];
		$DatosModalDetalleApartado = $this->Ventas_Model->getDetalleApartadoByApartadoId($apartadoId);
		print_r(json_encode($DatosModalDetalleApartado));
	}

	public function abonarApartado(){
		$campos=$this->input->post();
		$datos=array(
			'UsuarioId'=>$campos['usuarioId'],
			'ApartadoId'=>$campos['apartadoId'],
			'Monto'=>$campos['montoAbonar']
		);
		$this->Ventas_Model->abonarApartado($datos);
	}

}
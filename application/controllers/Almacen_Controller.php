<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Almacen_Controller extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('Almacen_Model');
		$this->load->model('Catalogos_Model');
		$this->load->model('Rutas_Model');
	}


    //----------------------------------------------------------------------------------- APARTADO DE CONFIGURACIÓN DE INVENTARIO

	public function ConfiguracionInventario(){
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
			$this->load->view('Layout/header',$datosUsuario);
			$this->load->view('ConfiguracionInventario');
			$this->load->view('Layout/footer');
		}
	}


	public function agregarInventario(){
		$campos=$this->input->post();
        //print_r($campos);
        $datos=array(
			'UsuarioId'=>$campos['usuarioId'],
            'Prenda_Prenda'=>$campos['Prenda_Prenda'],
            'Prenda_Descripcion'=>$campos['Prenda_Descripcion'],
            'Prenda_Inventario'=>$campos['Prenda_Inventario'],
            'Prenda_PrecioEntrada'=>$campos['Prenda_PrecioEntrada'],
            'Prenda_PrecioSalida'=>$campos['Prenda_PrecioSalida'],
            'Prenda_GeneroId'=>$campos['Prenda_GeneroId'],
            'Prenda_MarcaId'=>$campos['Prenda_MarcaId'],
            'Prenda_TallaId'=>$campos['Prenda_TallaId'],
            'Prenda_ColorPrimarioId'=>$campos['Prenda_ColorPrimarioId'],
            'Prenda_ColorSecundarioId'=>$campos['Prenda_ColorSecundarioId'],
            'Prenda_ProveedorId'=>$campos['Prenda_ProveedorId']
		);
        $this->Almacen_Model->addPrenda($datos);
	}

    public function getPrendaByPrendaId(){
		$PrendaId=$_POST['PrendaId'];
		$datosPrenda = $this->Almacen_Model->getAllPrendaByPrendaId($PrendaId);
		print_r(json_encode($datosPrenda));											//Debo pintar todo el objeto en formato Json
	}

    public function modificarInventario(){
		$campos=$this->input->post();
        //print_r($campos);
        $datos=array(
			'UsuarioId'=>$campos['usuarioId'],
            'PrendaId'=>$campos['PrendaId'],
            'Prenda_Prenda'=>$campos['Prenda_Prenda'],
            'Prenda_Descripcion'=>$campos['Prenda_Descripcion'],
            'Prenda_Inventario'=>$campos['Prenda_Inventario'],
            'Prenda_PrecioEntrada'=>$campos['Prenda_PrecioEntrada'],
            'Prenda_PrecioSalida'=>$campos['Prenda_PrecioSalida'],
            'Prenda_GeneroId'=>$campos['Prenda_GeneroId'],
            'Prenda_MarcaId'=>$campos['Prenda_MarcaId'],
            'Prenda_TallaId'=>$campos['Prenda_TallaId'],
            'Prenda_ColorPrimarioId'=>$campos['Prenda_ColorPrimarioId'],
            'Prenda_ColorSecundarioId'=>$campos['Prenda_ColorSecundarioId'],
            'Prenda_ProveedorId'=>$campos['Prenda_ProveedorId']
		);
        $this->Almacen_Model->updatePrenda($datos);
	}

    public function eliminarPrenda(){
		$campos=$this->input->post();
		$datos=array(
			'UsuarioIdGlobal'=>$campos['UsuarioIdGlobal'],
			'PrendaId'=>$campos['PrendaId']
		);
		$this->Almacen_Model->deletePrenda($datos);
	}

    public function ReportePrenda($PrendaId){

		$datosPrenda = $this->Almacen_Model->getAllPrendaByPrendaId_Tiket($PrendaId);
        //print_r($datosPrenda);
		//print_r(json_encode($datosPrenda));			


        
        require('Libraries/FPDF/fpdf.php');
        include 'Libraries/barcode.php';

        $pdf = new FPDF('p','mm',array(80,90));
        $pdf->AddPage();

        $pdf->setTitle('Sport y Moda');
        
        $pdf->SetFont('Helvetica','B',18);
        $pdf->SetY(10);
        $pdf->SetX(5);
        $pdf->Cell(70,10,utf8_decode("- SPORT & MODA -"),0,'', 'C');
        
        //Tipo de Texto
        $pdf->SetFont('Courier','',10);
        
        //Primer Columna
        $pdf->SetY(20);
        $pdf->SetX(5);
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(20,8,utf8_decode("PRENDA:"),0);
        //Segunda columna
        $pdf->SetY(20);
        $pdf->SetX(22);
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(60,8,utf8_decode($datosPrenda[0]['Prenda_Prenda']),0);

        //Primer Columna
        $pdf->SetY(28);
        $pdf->SetX(5);
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(20,8,utf8_decode("DETALLE:"),0);
        //Segunda columna
        $pdf->SetY(28);
        $pdf->SetX(22);
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(60,8,utf8_decode($datosPrenda[0]['Prenda_Descripcion']),0);

        //Primer Columna
        $pdf->SetY(36);
        $pdf->SetX(5);
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(20,8,utf8_decode("COLOR:"),0);
        //Segunda columna
        $pdf->SetY(36);
        $pdf->SetX(22);
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(60,8,utf8_decode($datosPrenda[0]['Color']),0);

        //Primer Columna
        $pdf->SetY(44);
        $pdf->SetX(5);
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(20,8,utf8_decode("TALLA:"),0);
        //Segunda columna
        $pdf->SetY(44);
        $pdf->SetX(22);
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(60,8,utf8_decode($datosPrenda[0]['Talla']),0);

        //Primer Columna
        $pdf->SetY(52);
        $pdf->SetX(5);
        $pdf->SetFont('Courier','B',10);
        $pdf->Cell(20,8,utf8_decode("PRECIO:"),0);
        //Segunda columna
        
        $pdf->SetY(52);
        $pdf->SetX(22);
        $pdf->SetFont('Courier','B',12);
        $pdf->Cell(60,8,utf8_decode($datosPrenda[0]['Precio']),0);
        
        $pdf->SetFont('Courier','',10);
        //Primer Columna
        $pdf->SetY(55);
        $pdf->SetX(5);

        $y = $pdf->GetY();

        $code=utf8_decode($datosPrenda[0]['Codigo']);
        barcode('assets/CodigosPrendas/'.$code.'.png', $code, 25, 'horizontal', 'code128', true);   //Genera el codigo en Imagen PNG
        $pdf->Image('assets/CodigosPrendas/'.$code.'.png',10,62,60,0,'PNG');                        //Consulta la imagen de código
        //$pdf->Cell(70,9,utf8_decode($datosPrenda[0]['Codigo']),0,'', 'C');
        

        $pdf->Output();
    }

    //----------------------------------------------------------------------------------- APARTADO DE ENTRADAS DE INVENTARIO

	public function EntradasInventario(){

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
			$this->load->view('Layout/header',$datosUsuario);
			$this->load->view('EntradasInventario');
			$this->load->view('Layout/footer');
		}
	}

    public function addEntradasInventario(){
		$campos=$this->input->post();
        //print_r($campos);
        $datos=array(
			'UsuarioId'=>$campos['usuarioId'],
            'PrendaId'=>$campos['PrendaId'],
            'Prenda_Prenda'=>$campos['Prenda_Prenda'],
            'Prenda_Descripcion'=>$campos['Prenda_Descripcion'],
            'Prenda_Inventario'=>$campos['Prenda_Inventario'],
            'Prenda_PrecioEntrada'=>$campos['Prenda_PrecioEntrada'],
            'Prenda_PrecioSalida'=>$campos['Prenda_PrecioSalida'],
            'Prenda_GeneroId'=>$campos['Prenda_GeneroId'],
            'Prenda_MarcaId'=>$campos['Prenda_MarcaId'],
            'Prenda_TallaId'=>$campos['Prenda_TallaId'],
            'Prenda_ColorPrimarioId'=>$campos['Prenda_ColorPrimarioId'],
            'Prenda_ColorSecundarioId'=>$campos['Prenda_ColorSecundarioId'],
            'Prenda_ProveedorId'=>$campos['Prenda_ProveedorId'],
            'EntradaPrenda_Cantidad'=>$campos['EntradaPrenda_Cantidad']
		);
        $this->Almacen_Model->entradaPrenda($datos);
	}
}
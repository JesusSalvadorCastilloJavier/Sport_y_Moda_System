<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracion_Controller extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('Configuracion_Model');
		$this->load->model('Catalogos_Model');
		$this->load->model('Rutas_Model');
	}


//----------------------------------------------------------------------------------- APARTADO DE CONFIGURACIÓN DE CREDENCIALES

	public function ConfiguracionCredenciales(){
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

			$datosUsuario=array(
				'datos' => $datos,
				'respuesta'=> $respuesta,
				'menuPadre'=>$menuPadre,
				'menus' => $menus
			);
			$this->load->view('Layout/header',$datosUsuario);
			$this->load->view('ConfiguracionCredenciales');
			$this->load->view('Layout/footer');
		}
	}

	public function updateCredenciales(){
		$campos=$this->input->post();
		//print_r($campos);
		$this->Configuracion_Model->updatePasswordByUsuarioId($campos);
		$this->load->view('Login/Login');

	}

	public function getAllCatMunicipiosByEstadoId(){
		$estadoId=$_POST['estadoId'];
		$datosCatMunicipio = $this->Catalogos_Model->getAllCatMunicipio($estadoId);
		print_r(json_encode($datosCatMunicipio));											//Debo pintar todo el objeto en formato Json
	}

	public function getUsuarioByUsuarioId(){
		$usuarioId=$_POST['usuarioId'];
		$DatosModalUsuario = $this->Configuracion_Model->getUsuarioByUsuarioId($usuarioId);
		print_r(json_encode($DatosModalUsuario));
	}


//----------------------------------------------------------------------------------- APARTADO DE CONFIGURACIÓN DE USUARIOS


	public function ConfiguracionUsuarios(){
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
			$datosTablaUsuarios = $this->Configuracion_Model->getAllUsuarios();				//Obtengo los datos para la tabla de Usuarios
			$datosCatSexo = $this->Catalogos_Model->getAllCatSexo();						//Obtengo los datos de catalogo Sexo
			$datosCatEstado = $this->Catalogos_Model->getAllCatEstado();					//Obtengo los datos de catalogo Estado
			$datosCatRole = $this->Catalogos_Model->getAllRole();							//Obtengo los datos de catalogo Role

			$datosUsuario=array(
				'datos' => $datos,
				'respuesta'=> $respuesta,
				'menuPadre'=>$menuPadre,
				'menus' => $menus,
				'datosTablaUsuarios'=>$datosTablaUsuarios,
				'datosCatSexo'=>$datosCatSexo,
				'datosCatEstado'=>$datosCatEstado,
				'datosCatRole'=>$datosCatRole

			);
			$this->load->view('Layout/header',$datosUsuario);
			$this->load->view('ConfiguracionUsuarios');
			$this->load->view('Layout/footer');
		}
	}


	public function agregarUsuarios(){
		$campos=$this->input->post();
        //print_r($campos);
        $datos=array(
			'UsuarioId'=>$campos['usuarioId'],
            'Persona_Nombre'=>$campos['nombre'],
            'Persona_ApellidoPaterno'=>$campos['apellidoP'],
            'Persona_ApellidoMaterno'=>$campos['apellidoM'],
            'Persona_FechaNacimiento'=>$campos['fechaN'],
            'Persona_SexoId'=>$campos['sexoId'],
            'Contacto_TelRecados'=>$campos['tel_rec'],
            'Contacto_TelCasa'=>$campos['tel_casa'],
            'Contacto_TelCelular'=>$campos['tel_cel'],
            'Contacto_Email'=>$campos['email'],
            'Direccion_Calle'=>$campos['calle'],
            'Direccion_NumeroInterior'=>$campos['nInt'],
            'Direccion_NumeroExterior'=>$campos['nExt'],
            'EstadoId'=>$campos['estadoId'],
            'MunicipioId'=>$campos['municipioId'],
			'RoleId'=>$campos['roleId'],
			'Usuario_Usuario'=>$campos['usuario'],
			'Usuario_Contrasenia'=>$campos['contrasenia']
		);
        $this->Configuracion_Model->addUsuario($datos);
	}

	public function modificarUsuarios(){
		$campos=$this->input->post();
        //print_r($campos);
        $datos=array(
			'UsuarioId'=>$campos['usuarioId'],
			'usuarioModificarId'=>$campos['usuarioModificarId'],
            'Persona_Nombre'=>$campos['nombre'],
            'Persona_ApellidoPaterno'=>$campos['apellidoP'],
            'Persona_ApellidoMaterno'=>$campos['apellidoM'],
            'Persona_FechaNacimiento'=>$campos['fechaN'],
            'Persona_SexoId'=>$campos['sexoId'],
            'Contacto_TelRecados'=>$campos['tel_rec'],
            'Contacto_TelCasa'=>$campos['tel_casa'],
            'Contacto_TelCelular'=>$campos['tel_cel'],
            'Contacto_Email'=>$campos['email'],
            'Direccion_Calle'=>$campos['calle'],
            'Direccion_NumeroInterior'=>$campos['nInt'],
            'Direccion_NumeroExterior'=>$campos['nExt'],
            'EstadoId'=>$campos['estadoId'],
            'MunicipioId'=>$campos['municipioId'],
			'RoleId'=>$campos['roleId']
		);
        $this->Configuracion_Model->updateUsuario($datos);
	}

	public function eliminarUsuarios(){
		$campos=$this->input->post();
		$datos=array(
			'UsuarioModificadorId'=>$campos['UsuarioIdGlobal'],
			'UsuarioId'=>$campos['UsuarioId']
		);
		$this->Configuracion_Model->deleteUsuario($datos);
	}


//----------------------------------------------------------------------------------- APARTADO DE COLORES


	public function ConfiguracionColores(){
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

			$datosTablaColores = $this->Configuracion_Model->getAllColores();					//Obtengo los datos de Catalogo Colores

			$datosUsuario=array(
				'datos' => $datos,
				'respuesta'=> $respuesta,
				'menuPadre'=>$menuPadre,
				'menus' => $menus,
				'datosTablaColores'=> $datosTablaColores
			);
			$this->load->view('Layout/header',$datosUsuario);
			$this->load->view('ConfiguracionColores');
			$this->load->view('Layout/footer');
		}
	}
    
	public function agregarColor(){
		$campos=$this->input->post();
        //print_r($campos);
        $datos=array(
			'UsuarioId'=>$campos['usuarioId'],
            'Color_Color'=>$campos['Color_Color']
		);
        $this->Configuracion_Model->addColor($datos);
	}

	public function eliminarColor(){
		$campos=$this->input->post();
		$datos=array(
			'UsuarioId'=>$campos['UsuarioId'],
			'ColorId'=>$campos['ColorId']
		);
		$this->Configuracion_Model->deleteColor($datos);
	}

	public function getColorByColorId(){
		$colorId=$_POST['colorId'];
		$DatosModalColor = $this->Configuracion_Model->getColorByColorId($colorId);
		print_r(json_encode($DatosModalColor));
	}

	public function modificarColor(){
		$campos=$this->input->post();
        $datos=array(
			'UsuarioId'=>$campos['UsuarioId'],
			'ColorId'=>$campos['ColorId'],
            'Color_Color'=>$campos['Color_Color']
		);
        $this->Configuracion_Model->updateColor($datos);
	}



//----------------------------------------------------------------------------------- APARTADO DE ROLES

	public function ConfiguracionRoles(){
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

			$datosCatRole = $this->Catalogos_Model->getAllRole();							//Obtengo los datos de Catalogo Roles

			$datosUsuario=array(
				'datos' => $datos,
				'respuesta'=> $respuesta,
				'menuPadre'=>$menuPadre,
				'menus' => $menus,
				'datosCatRole'=>$datosCatRole
			);
			$this->load->view('Layout/header',$datosUsuario);
			$this->load->view('ConfiguracionRoles');
			$this->load->view('Layout/footer');
		}
	}

	public function agregarRole(){
		$campos=$this->input->post();
        //print_r($campos);
        $datos=array(
			'UsuarioId'=>$campos['usuarioId'],
            'Role_Role'=>$campos['Role_Role']
		);
        $this->Configuracion_Model->addRole($datos);
	}

	public function eliminarRole(){
		$campos=$this->input->post();
		$datos=array(
			'UsuarioId'=>$campos['UsuarioId'],
			'RoleId'=>$campos['RoleId']
		);
		$this->Configuracion_Model->deleteRole($datos);
	}

	public function getRoleByRoleId(){
		$RoleId=$_POST['RoleId'];
		$DatosModalRole = $this->Configuracion_Model->getRoleByRoleId($RoleId);
		print_r(json_encode($DatosModalRole));
	}

	public function modificarRole(){
		$campos=$this->input->post();
        $datos=array(
			'UsuarioId'=>$campos['UsuarioId'],
			'RoleId'=>$campos['RoleId'],
            'Role_Role'=>$campos['Role_Role']
		);
        $this->Configuracion_Model->updateRole($datos);
	}

	public function getMenuHijoByRoleId(){
		$RoleId=$_POST['RoleId'];
		$DatosModalMenuHijo = $this->Configuracion_Model->getMenuHijo($RoleId);					//Obtengo todo el listado de todos modulos
		$DatosModalMenuHijoByRolId = $this->Configuracion_Model->getMenuHijoByRolId($RoleId);	//Obtengo los modulos por RoleId
		$TodosDatosModalMenuHijo = $this->Configuracion_Model->getAllMenuHijo();					//Obtengo los modulos

        $datosPrivilegios=array(
			'DatosModalMenuHijo'=>$DatosModalMenuHijo,
			'DatosModalMenuHijoByRolId'=>$DatosModalMenuHijoByRolId,
			'TodosDatosModalMenuHijo'=>$TodosDatosModalMenuHijo
		);
		print_r(json_encode($datosPrivilegios));
	}

	public function eliminarAcceso(){
		$campos=$this->input->post();
		$datos=array(
			'UsuarioId'=>$campos['UsuarioId'],
			'AccesoId'=>$campos['AccesoId']
		);
		$this->Configuracion_Model->deleteAcceso($datos);
	}

	public function agregarAcceso(){
		$campos=$this->input->post();
        //print_r($campos);
        $datos=array(
			'UsuarioId'=>$campos['UsuarioId'],
            'MenuHijoIds'=>$campos['MenuHijoIds'],
			'RoleId'=>$campos['RoleId']
		);
        $this->Configuracion_Model->addAcceso($datos);
	}

	//----------------------------------------------------------------------------------- APARTADO DE TALLAS

	public function ConfiguracionTallas(){
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

			$datosCatTalla = $this->Catalogos_Model->getAllTalla();							//Obtengo los datos de Catalogo Roles

			$datosUsuario=array(
				'datos' => $datos,
				'respuesta'=> $respuesta,
				'menuPadre'=>$menuPadre,
				'menus' => $menus,
				'datosCatTalla'=>$datosCatTalla
			);
			$this->load->view('Layout/header',$datosUsuario);
			$this->load->view('ConfiguracionTallas');
			$this->load->view('Layout/footer');
		}
	}

	public function agregarTalla(){
		$campos=$this->input->post();
        //print_r($campos);
        $datos=array(
			'UsuarioId'=>$campos['usuarioId'],
            'Talla_Talla'=>$campos['Talla_Talla'],
			'Talla_Numero'=>$campos['Talla_Numero']
		);
        $this->Configuracion_Model->addTalla($datos);
	}

	public function eliminarTalla(){
		$campos=$this->input->post();
		$datos=array(
			'UsuarioId'=>$campos['UsuarioId'],
			'TallaId'=>$campos['TallaId']
		);
		$this->Configuracion_Model->deleteTalla($datos);
	}

	public function getTallaByTallaId(){
		$TallaId=$_POST['TallaId'];
		$DatosModalTalla = $this->Configuracion_Model->getTallaByTallaId($TallaId);
		print_r(json_encode($DatosModalTalla));
	}

	public function modificarTalla(){
		$campos=$this->input->post();
        $datos=array(
			'UsuarioId'=>$campos['UsuarioId'],
			'TallaId'=>$campos['TallaId'],
            'Talla_Talla'=>$campos['Talla_Talla'],
			'Talla_Numero'=>$campos['Talla_Numero']
		);
        $this->Configuracion_Model->updateTalla($datos);
	}


	//----------------------------------------------------------------------------------- APARTADO DE MARCAS


	public function ConfiguracionMarcas(){
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

			$datosTablaMarcas = $this->Configuracion_Model->getAllMarcas();					//Obtengo los datos de Catalogo Colores

			$datosUsuario=array(
				'datos' => $datos,
				'respuesta'=> $respuesta,
				'menuPadre'=>$menuPadre,
				'menus' => $menus,
				'datosTablaMarcas'=> $datosTablaMarcas
			);
			$this->load->view('Layout/header',$datosUsuario);
			$this->load->view('ConfiguracionMarcas');
			$this->load->view('Layout/footer');
		}
	}
    
	public function agregarMarca(){
		$campos=$this->input->post();
        //print_r($campos);
        $datos=array(
			'UsuarioId'=>$campos['usuarioId'],
            'Marca_Marca'=>$campos['Marca_Marca']
		);
        $this->Configuracion_Model->addMarca($datos);
	}

	public function eliminarMarca(){
		$campos=$this->input->post();
		$datos=array(
			'UsuarioId'=>$campos['UsuarioId'],
			'MarcaId'=>$campos['MarcaId']
		);
		$this->Configuracion_Model->deleteMarca($datos);
	}

	public function getMarcaByMarcaId(){
		$marcaId=$_POST['marcaId'];
		$DatosModalMarca = $this->Configuracion_Model->getMarcaByMarcaId($marcaId);
		print_r(json_encode($DatosModalMarca));
	}

	public function modificarMarca(){
		$campos=$this->input->post();
        $datos=array(
			'UsuarioId'=>$campos['UsuarioId'],
			'MarcaId'=>$campos['MarcaId'],
            'Marca_Marca'=>$campos['Marca_Marca']
		);
        $this->Configuracion_Model->updateMarca($datos);
	}



	//----------------------------------------------------------------------------------- APARTADO DE CONFIGURACIÓN DE PROVEEDORES


	public function ConfiguracionProveedores(){
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
			$datosTablaProveedores = $this->Configuracion_Model->getAllProveedores();		//Obtengo los datos para la tabla de Usuarios
			$datosCatSexo = $this->Catalogos_Model->getAllCatSexo();						//Obtengo los datos de catalogo Sexo
			$datosCatEstado = $this->Catalogos_Model->getAllCatEstado();					//Obtengo los datos de catalogo Estado
			
			$datosProveedor=array(
				'datos' => $datos,
				'respuesta'=> $respuesta,
				'menuPadre'=>$menuPadre,
				'menus' => $menus,
				'datosTablaProveedores'=>$datosTablaProveedores,
				'datosCatSexo'=>$datosCatSexo,
				'datosCatEstado'=>$datosCatEstado

			);
			$this->load->view('Layout/header',$datosProveedor);
			$this->load->view('ConfiguracionProveedores');
			$this->load->view('Layout/footer');
		}
	}

	public function getProveedorByProveedorId(){
		$ProveedorId=$_POST['proveedorId'];
		$DatosModalUsuario = $this->Configuracion_Model->getProveedorByProveedorId($ProveedorId);
		print_r(json_encode($DatosModalUsuario));
	}


	public function agregarProveedor(){
		$campos=$this->input->post();
        //print_r($campos);
        $datos=array(
			'UsuarioId'=>$campos['usuarioId'],
            'Persona_Nombre'=>$campos['nombre'],
            'Persona_ApellidoPaterno'=>$campos['apellidoP'],
            'Persona_ApellidoMaterno'=>$campos['apellidoM'],
            'Persona_FechaNacimiento'=>$campos['fechaN'],
            'Persona_SexoId'=>$campos['sexoId'],
            'Contacto_TelRecados'=>$campos['tel_rec'],
            'Contacto_TelCasa'=>$campos['tel_casa'],
            'Contacto_TelCelular'=>$campos['tel_cel'],
            'Contacto_Email'=>$campos['email'],
            'Direccion_Calle'=>$campos['calle'],
            'Direccion_NumeroInterior'=>$campos['nInt'],
            'Direccion_NumeroExterior'=>$campos['nExt'],
            'EstadoId'=>$campos['estadoId'],
            'MunicipioId'=>$campos['municipioId']
		);
        $this->Configuracion_Model->addProveedor($datos);
	}

	public function modificarProveedor(){
		$campos=$this->input->post();
        //print_r($campos);
        $datos=array(
			'UsuarioId'=>$campos['usuarioId'],
			'proveedorModificarId'=>$campos['proveedorModificarId'],
            'Persona_Nombre'=>$campos['nombre'],
            'Persona_ApellidoPaterno'=>$campos['apellidoP'],
            'Persona_ApellidoMaterno'=>$campos['apellidoM'],
            'Persona_FechaNacimiento'=>$campos['fechaN'],
            'Persona_SexoId'=>$campos['sexoId'],
            'Contacto_TelRecados'=>$campos['tel_rec'],
            'Contacto_TelCasa'=>$campos['tel_casa'],
            'Contacto_TelCelular'=>$campos['tel_cel'],
            'Contacto_Email'=>$campos['email'],
            'Direccion_Calle'=>$campos['calle'],
            'Direccion_NumeroInterior'=>$campos['nInt'],
            'Direccion_NumeroExterior'=>$campos['nExt'],
            'EstadoId'=>$campos['estadoId'],
            'MunicipioId'=>$campos['municipioId']
		);
        $this->Configuracion_Model->updateProveedor($datos);
	}

	public function eliminarProveedor(){
		$campos=$this->input->post();
		$datos=array(
			'UsuarioModificadorId'=>$campos['UsuarioIdGlobal'],
			'ProveedorId'=>$campos['ProveedorId']
		);
		$this->Configuracion_Model->deleteProveedor($datos);
	}

//----------------------------------------------------------------------------------- APARTADO DE CONFIGURACIÓN DE CLIENTES


	public function ConfiguracionClientes(){
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
			$datosTablaClientes = $this->Configuracion_Model->getAllClientes();				//Obtengo los datos para la tabla de Usuarios
			$datosCatSexo = $this->Catalogos_Model->getAllCatSexo();						//Obtengo los datos de catalogo Sexo
			$datosCatEstado = $this->Catalogos_Model->getAllCatEstado();					//Obtengo los datos de catalogo Estado
			
			$datosClientes=array(
				'datos' => $datos,
				'respuesta'=> $respuesta,
				'menuPadre'=>$menuPadre,
				'menus' => $menus,
				'datosTablaClientes'=>$datosTablaClientes,
				'datosCatSexo'=>$datosCatSexo,
				'datosCatEstado'=>$datosCatEstado

			);
			$this->load->view('Layout/header',$datosClientes);
			$this->load->view('ConfiguracionClientes');
			$this->load->view('Layout/footer');
		}
	}

	public function getClienteByClienteId(){
		$ClienteId=$_POST['clienteId'];
		$DatosModalCliente = $this->Configuracion_Model->getClienteByClienteId($ClienteId);
		print_r(json_encode($DatosModalCliente));
	}


	public function agregarCliente(){
		$campos=$this->input->post();
		//print_r($campos);
		$datos=array(
			'UsuarioId'=>$campos['usuarioId'],
			'Persona_Nombre'=>$campos['nombre'],
			'Persona_ApellidoPaterno'=>$campos['apellidoP'],
			'Persona_ApellidoMaterno'=>$campos['apellidoM'],
			'Persona_FechaNacimiento'=>$campos['fechaN'],
			'Persona_SexoId'=>$campos['sexoId'],
			'Contacto_TelRecados'=>$campos['tel_rec'],
			'Contacto_TelCasa'=>$campos['tel_casa'],
			'Contacto_TelCelular'=>$campos['tel_cel'],
			'Contacto_Email'=>$campos['email'],
			'Direccion_Calle'=>$campos['calle'],
			'Direccion_NumeroInterior'=>$campos['nInt'],
			'Direccion_NumeroExterior'=>$campos['nExt'],
			'EstadoId'=>$campos['estadoId'],
			'MunicipioId'=>$campos['municipioId']
		);
		$this->Configuracion_Model->addCliente($datos);
	}

	public function modificarCliente(){
		$campos=$this->input->post();
		//print_r($campos);
		$datos=array(
			'UsuarioId'=>$campos['usuarioId'],
			'clienteModificarId'=>$campos['clienteModificarId'],
			'Persona_Nombre'=>$campos['nombre'],
			'Persona_ApellidoPaterno'=>$campos['apellidoP'],
			'Persona_ApellidoMaterno'=>$campos['apellidoM'],
			'Persona_FechaNacimiento'=>$campos['fechaN'],
			'Persona_SexoId'=>$campos['sexoId'],
			'Contacto_TelRecados'=>$campos['tel_rec'],
			'Contacto_TelCasa'=>$campos['tel_casa'],
			'Contacto_TelCelular'=>$campos['tel_cel'],
			'Contacto_Email'=>$campos['email'],
			'Direccion_Calle'=>$campos['calle'],
			'Direccion_NumeroInterior'=>$campos['nInt'],
			'Direccion_NumeroExterior'=>$campos['nExt'],
			'EstadoId'=>$campos['estadoId'],
			'MunicipioId'=>$campos['municipioId']
		);
		$this->Configuracion_Model->updateCliente($datos);
	}

	public function eliminarCliente(){
		$campos=$this->input->post();
		$datos=array(
			'UsuarioModificadorId'=>$campos['UsuarioIdGlobal'],
			'ClienteId'=>$campos['ClienteId']
		);
		$this->Configuracion_Model->deleteCliente($datos);
	}



//----------------------------------------------------------------------------------- APARTADO DE CONFIGURACIÓN DE CAJA

public function configuracionCaja(){
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

		$montosCaja = $this->Configuracion_Model->getAllmontosCaja();		//Obtengo los datos de los montos en caja
		
		$datosUsuario=array(
			'datos' => $datos,
			'respuesta'=> $respuesta,
			'menuPadre'=>$menuPadre,
			'menus' => $menus,
			'montosCaja' => $montosCaja
		);
		$this->load->view('Layout/header',$datosUsuario);
		$this->load->view('ConfiguracionCaja');
		$this->load->view('Layout/footer');
	}
}

public function agregarMontoCaja(){
	$campos=$this->input->post();
	//print_r($campos);
	$datos=array(
		'UsuarioId'=>$campos['usuarioId'],
		'monto'=>$campos['monto'],
		'fecha'=>$campos['fecha']
	);
	$this->Configuracion_Model->addMontoCaja($datos);
}

}

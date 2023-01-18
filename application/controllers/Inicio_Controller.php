<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio_Controller extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('Rutas_Model');
	}

	public function Inicio()
	{
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
			$this->load->view('Inicio');
			$this->load->view('Layout/footer');
		}
	}

    public function CerrarSesion(){
		Redirect(base_url(), false);
    }
}

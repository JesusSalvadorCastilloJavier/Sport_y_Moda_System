<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_Controller extends CI_Controller {


	public function index()
	{
		$this->load->view('Login/Login');
	}

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('Login_Model');
	}

	public function Login()
	{
		if($_POST['user'] && $_POST['password']){
			$datos=array(
				"user" => $_POST['user'],
				"password" => $_POST['password']
			);
			

			$respuesta = $this->Login_Model->login($datos);
			
			if($respuesta){
				$menuPadre = $this->Login_Model->getMenuPadre($respuesta[0]['UsuarioId']);
				$menus = $this->Login_Model->getMenus($respuesta[0]['UsuarioId']);

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
			}else{
				$this->load->view('Login/Login');
			}
		}else{
			$this->load->view('Login/Login');
		}
		
		
	}
}

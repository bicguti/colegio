<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autenticacion extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Usuario_model');
		$this->load->model('Permisos_model');
		$this->load->model('Persona_model');
	}
	public function index($value = '')
	{
		if (isset($_SESSION['autenticado'])) {//si ya existe la variable de session entonces no mostramos el formulario
			redirect('bienvenida','refresh');//de autenticación, solo lo redirigimos a la pantalla de bienvenida
		} else {//cuando no exista la session autenticado, entonces mostramos el formulario de logueo

			$data['titulo'] = 'Autenticacion';
			$data['msg'] = $value;
			$this->load->view('secretaria/autenticacion', $data);
		}
	}

	public function autenticar_usuario()
	{
		$this->form_validation->set_rules('usuario', 'Usuario', 'trim|required');//validacion de los campos
		$this->form_validation->set_rules('contrasena', 'Contraseña', 'trim|required');//validacion de los campos

		$this->form_validation->set_message('required', 'El campo %s es obligatorio, llenelo');//mensaje para el campo con propiedad required

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		}//fin del if
		else {
			$usuario = $this->input->post('usuario');
			$contrasena = $this->input->post('contrasena');
			$datos = $this->Usuario_model->getUsuario($usuario);
			if (count($datos)==0) {
				$msg = 'El nombre de usuario o contraseña ingresados son incorrectos';
				$this->index($msg);
			}//fin del if
			else{

				foreach ($datos as $value) {
					$pass = $value['contrasena_usuario'];
					$idusuario = $value['id_usuario'];
				}//fin del foreach
				if (password_verify($contrasena, $pass) == TRUE) {
					$permisos = $this->Permisos_model->findSubPermisosUsuario($idusuario);
					$datos = array();
					foreach ($permisos as $value) {
						$temp = array('opcion'=>$value['nombre_opcion'], 'subopcion'=>$value['nombre_sub_opcion'], 'url'=>$value['url_subopcion']);
						$idPersona = $value['id_persona'];
						array_push($datos, $temp);
					}//fin del foreach

					$this->session->set_userdata('autenticado', $datos);
					$datos = array();
					$persona = $this->Persona_model->getPersona($idPersona);
					foreach ($persona as $value) {
						$temp = array('nombre'=>$value['nombre_persona'], 'apellidos'=>$value['apellidos_persona'], 'id'=>$idPersona);
						array_push($datos, $temp);
					}//fin del foreach
					//SESSION_SET_COOKIE_PARAMS(0,"/");

					$this->session->set_userdata('nombreautenticado', $datos);
					//session_set_cookie_params(0, "/", $HTTP_SERVER_VARS["HTTP_HOST"], 0);

					redirect('bienvenida','refresh');
				}//fin del if
				else{
					$msg = 'El nombre de usuario o contraseña ingresados son incorrectos';
					$this->index($msg);
				}//fin del else
			}//fin del else

		}//fin del else
	}//fin del metodo

	public function cerrar_sistema()
	{
		$this->session->sess_destroy();
		redirect('autenticacion','refresh');
	}

}

/* End of file Autenticacion.php */
/* Location: ./application/controllers/Autenticacion.php */

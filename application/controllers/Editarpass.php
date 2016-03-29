<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Editarpass extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Persona_model');
		$this->load->model('Opciones_model');
		$this->load->model('Usuario_model');	
		$this->load->model('Permisos_model');
	}
	public function index($value='')
	{
		$datos = $_SESSION['nombreautenticado'];
		$idpersona = $datos[0]['id'];//obtenemos el id de la persona que esta autenticada
		$datos = $this->Usuario_model->findUsuario($idpersona);
		$data['nusuario'] = $datos[0]['nombre_usuario'];
		$data['error'] = $value;
		$data['titulo'] = 'Editar Contraseña';
		$data['activo'] = '';
		$this->load->view('plantilla/header', $data);
		$this->load->view('editar/editarcontrasena', $data);
		$this->load->view('plantilla/footer');
	}

	/*metodo que muestra el formulario para editar la contraseña del usuario*/
/*	public function editar_contrasena($value='')
	{	
		$datos = $_SESSION['nombreautenticado'];
		$idpersona = $datos[0]['id'];//obtenemos el id de la persona que esta autenticada
		$datos = $this->Usuario_model->findUsuario($idpersona);
		$data['nusuario'] = $datos[0]['nombre_usuario'];
		$data['error'] = $value;
		$data['titulo'] = 'Editar Contraseña';
		$data['activo'] = '';
		$this->load->view('plantilla/header', $data);
		$this->load->view('editar/editarcontrasena', $data);
		$this->load->view('plantilla/footer');
	}*/

	/*metodo para guardar la nueva contraseña del usuario autenticado*/
	public function guardar_edicion_contrasena($value='')
	{
		//$this->form_validation->set_rules('passant', 'Contraseña actual', 'trim|required');
		$this->form_validation->set_rules('npass', 'Nueva contraseña', 'trim|required|min_length[5]|max_length[15]');
		$this->form_validation->set_rules('rnpass', 'Repetir nueva contraseña', 'trim|required|min_length[5]|max_length[15]|matches[npass]');

		$this->form_validation->set_message('required', 'El campo %s es requerido, por favor llene el campo.');
		$this->form_validation->set_message('min_length', 'El campo %s, debe tener al menos %d caracteres.');
		$this->form_validation->set_message('max_length', 'El campo %d no puede tener más de %d caracteres.');
		$this->form_validation->set_message('matches', 'El campo %s, debe ser igual al campo Nueva contraseña.');

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			//$actual = $this->input->post('passant');
			$npass = $this->input->post('npass');
			$datos = $_SESSION['nombreautenticado'];
			$idpersona = $datos[0]['id'];//obtenemos el id de la persona que esta autenticada
			//$datos1 = $this->Usuario_model->findUsuario($idpersona);
			/*foreach ($datos1 as $value) {
				$pass = $value['contrasena_usuario'];
			}*/
			//$hash = $datos1[0]['contrasena_usuario'];
			
			//if (password_verify($actual, $pass) == TRUE) {
				$contrasena = password_hash($npass, PASSWORD_DEFAULT);
				$this->Usuario_model->updateContrasena($idpersona, $contrasena);
				
				$data['msg'] = 'La contraseña a sido modificada con exito, la proxima vez que ingrese al sistema sera con la nueva contraseña que acaba de crear.';
				$data['titulo'] = 'Mensaje del Sistema';
				$data['activo'] = '';
				$this->load->view('plantilla/header', $data);
				$this->load->view('msg/listo', $data);
				$this->load->view('plantilla/footer');
			/*} else {
				$this->editar_contrasena('La contraseña actual es incorrecta, por favor vuelva a introducir la contraseña actual');
				
			}*/
			
		}
	}

}

/* End of file Editarpass.php */
/* Location: ./application/controllers/Editarpass.php */
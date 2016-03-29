<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Persona_model');
		$this->load->model('Opciones_model');
		$this->load->model('Usuario_model');
		$this->load->model('Permisos_model');
	}
	public function index($msg='')
	{
		$url = $_SERVER['REQUEST_URI'];
		$datos = $_SESSION['autenticado'];
		$bandera = false;
		/*foreach ($datos as $value) {
			$aux = '/'.$value['url'];
			if ($aux==$url) {
				$bandera = false;
			}
		}*/
		if ($bandera == true) {
			$data['msg'] = 'Lo sentimos no tienes permisos para utilizar este modulo';
			$data['titulo'] = 'Mensaje del Sistema';
			$data['activo'] = '';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/denegado', $data);
			$this->load->view('plantilla/footer');
		} else {
			$data['titulo'] = 'Nuevo Usuario';
			$data['activo'] = 'persona';
			$data['mimsg'] = $msg;
			$this->load->view('plantilla/header', $data);
			$this->load->view('secretaria/nusuario', $data);
			$this->load->view('plantilla/footer');
		}


	}

	public function buscar_persona()
	{
		$this->form_validation->set_rules('apellido', 'Persona', 'trim|required');
		$this->form_validation->set_message('required', 'El campo %s es obligatorio, no puede estar vacio.');

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$datos = array();
			$apellido = $this->input->post('apellido');
			$persona = $this->Persona_model->findPersona($apellido);
			foreach ($persona as $value) {
				$temp = array('id'=>$value['id_persona'], 'nombres'=>$value['nombre_persona'], 'apellidos'=>$value['apellidos_persona'], 'puesto'=>$value['nombre_puesto']);
				array_push($datos, $temp);
			}
			$this->session->set_userdata('dPersona', $datos);
			$this->index();
		}
	}

	public function seleccionar_docente()
	{
		$this->form_validation->set_rules('persona', 'Persona', 'trim|required');
		$this->form_validation->set_message('required', 'Es necesario seleccionar el campo %s');

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {

				$idPersona = $this->input->post('persona');
				$persona = $this->Persona_model->nomapeDocente($idPersona);
				$datos = array();
				foreach ($persona as $value) {
					$temp = array('id'=>$idPersona, 'nombres' => $value['nombre_persona'], 'apellidos'=>$value['apellidos_persona'], 'puesto'=>$value['nombre_puesto'], 'email'=>$value['correo_electr_persona']);
					array_push($datos, $temp);
				}

				$this->session->set_userdata('idPersona', $datos );

			$this->index();
		}
	}

	public function nuevo_usuario()//establece el nuevo usuario, crea la session de nombre de usuario y contraseña, cifra la contraseñ pero no lo guarda en l abase de datos
	{
		//$this->form_validation->set_rules('usuario', 'Usuario', 'trim|required|min_length[5]|max_length[40]|is_unique[USUARIOS.nombre_usuario]');
		$this->form_validation->set_rules('contrasena', 'Contraseña', 'trim|required|min_length[5]|max_length[70]');
		$this->form_validation->set_rules('rcontrasena', 'Repetir contraseña', 'trim|required|min_length[5]|max_length[70]');
		$this->form_validation->set_message('required', 'El campo %s es obligatorio, no puede estar en blanco.');
		$this->form_validation->set_message('min_length', 'El campo %s debe tener al menos %d caracteres.');
		$this->form_validation->set_message('max_length', 'El campo %s no debe superar los %d caracteres.');
		$this->form_validation->set_message('is_unique', 'El campo %s ya existe en la base de datos, elija otro nombre de usuario.');

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
				$aux = $_SESSION['idPersona'];
				$usuario = $aux[0]['email'];
				//$usuario = $this->input->post('usuario');
				$contrasena = $this->input->post('contrasena');
				$pass = password_hash($contrasena, PASSWORD_DEFAULT);
				$datos = array();
				$temp = array('usuario'=>$usuario, 'contrasena'=>$pass);
				array_push($datos, $temp);
				$this->session->set_userdata('usuario', $datos);

				$this->index_opciones();

		}
	}

	public function cancelar_usuario()
	{
		$this->session->unset_userdata('idPersona');
		$this->session->unset_userdata('dPersona');
		$this->session->unset_userdata('usuario');
		$this->session->unset_userdata('asignacionopciones');
		$this->session->unset_userdata('datosAsignacion');
		$this->index();
	}



	public function buscar_subopciones()
	{
		$opcion = $this->input->get('id');
		$datos = $this->Opciones_model->findSubOpcion($opcion);
		echo json_encode($datos);
	}

	public function asignar_subopcion()
	{
		$this->form_validation->set_rules('subopcion[]', 'Sub-Opciones', 'trim|required');
		$this->form_validation->set_rules('opciones', 'Opciones', 'trim|required');
		$this->form_validation->set_message('required', 'El campo %s es requerido, debe seleccionar al menos una opcion');

		if ($this->form_validation->run() == FALSE) {
			$this->index_opciones();
		} else {
			$subopcion = $this->input->post('subopcion[]');
			$opcion = $this->input->post('opciones');
			if (isset($_SESSION['asignacionopciones'])) {//si existe la session
				$datos = $_SESSION['asignacionopciones'];
				$datos2 = $_SESSION['datosAsignacion'];
				for ($i=0; $i < count($subopcion); $i++) {
					$temp = array('sub_opcion'=>$subopcion[$i], 'opcion'=>$opcion);
					if (in_array($temp, $datos)==false) {
						array_push($datos, $temp);
						$aux = $this->Permisos_model->getDatosPermisos($subopcion[$i], $opcion);
						foreach ($aux as $value) {
							$temp = array('opcion'=>$value['nombre_opcion'], 'subopcion'=>$value['nombre_sub_opcion']);
							array_push($datos2, $temp);
						}
					}
				}

				$this->session->set_userdata('asignacionopciones', $datos);
				$this->session->set_userdata('datosAsignacion', $datos2);
			}
			else//si no existe la session que esto lo hara la primera vez
			{
				$datos = array();
				$datos2 = array();
				for ($i=0; $i < count($subopcion); $i++) {
					$temp = array('sub_opcion'=>$subopcion[$i],'opcion'=>$opcion);
					array_push($datos, $temp);
					$aux = $this->Permisos_model->getDatosPermisos($subopcion[$i], $opcion);
					foreach ($aux as $value) {
						$temp = array('opcion'=>$value['nombre_opcion'], 'subopcion'=>$value['nombre_sub_opcion']);
						array_push($datos2, $temp);
					}
				}
				$this->session->set_userdata('asignacionopciones', $datos);
				$this->session->set_userdata('datosAsignacion', $datos2);
			}

			$this->index_opciones();
		}
	}

	private function index_opciones()//muestra el formulario para crear un usuario pero ya con las opciones que se le asignaran al susuario
	{
		$data['titulo'] = 'Nuevo Usuario';
			$data['activo'] = 'persona';
			$data['opciones'] = $this->Opciones_model->getOpciones();
			$this->load->view('plantilla/header', $data);
			$this->load->view('secretaria/nusuario', $data);
			$this->load->view('plantilla/footer');
	}

	public function guardar_usuario_permisos()//metodo que guarda el nuevo usuario y contraseña creados, con los permisos correspondientes
	{
		$usuario = $_SESSION['usuario'];
		$idPersona = $_SESSION['idPersona'];
		$asignacion = $_SESSION['asignacionopciones'];
		foreach ($usuario as $value) {
			foreach ($idPersona as $value2) {
				$idUsuario = $this->Usuario_model->setUsuario($value['usuario'], $value['contrasena'], $value2['id']);
			}
		}
		if ($idUsuario == -1) {
			$this->session->unset_userdata('usuario');
			$data = 'Error, el nombre de usuario ya existe en la base de datos, escriba un nombre de usuario diferente';
			$this->index($data);
		}
		elseif ($idUsuario == 0) {
			$this->session->unset_userdata('idPersona');
			$this->session->unset_userdata('dPersona');
			$this->session->unset_userdata('usuario');
			$this->session->unset_userdata('asignacionopciones');
			$this->session->unset_userdata('datosAsignacion');

			$data['msg'] = 'No se pudo crear un nuevo usuario para la persona porque ya tiene uno registrado en la base de datos y por lo tanto no se asignaron los persmiso correspondientes, ve directamente a Editar Usuario, sí deseas agregar mas permisos';
			$data['titulo'] = 'Mensaje del Sistema';
			$data['activo'] = 'ninguno';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');
		}
		else{
			foreach ($asignacion as $value) {
				$this->Permisos_model->setPermisos($idUsuario, $value['opcion']);//guardamos los permisos asignados al usuario
			}
			$PermisosAsignados = $this->Permisos_model->getPermisosUsuario($idUsuario);

			foreach ($asignacion as $value) {
				foreach ($PermisosAsignados as $value2) {
					if ($value['opcion'] == $value2['id_opcion']) {
						$this->Permisos_model->setSubPermisos($value2['id_permiso_usuario'], $value['sub_opcion']);
					}//fin del if
				}//fin del foreach

			}//fin de foreach

			//destruimos las sessiones
			$this->session->unset_userdata('idPersona');
			$this->session->unset_userdata('dPersona');
			$this->session->unset_userdata('usuario');
			$this->session->unset_userdata('asignacionopciones');
			$this->session->unset_userdata('datosAsignacion');

			//cargamos las vistas
			$data['msg'] = 'Se a registrado al nuevo usuario y los permisos que tendra en el sistema, ya puede ingresar al sistema con su nombre de usuario y contraseña creados.';
			$data['activo'] = 'ninguno';
			$data['titulo'] = 'Mensaje del Sistema';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');

		}//fin del else
	}

	/*
		metodo que muestra el formulario para agregar más permisos al usuario o desahabilitar los que tiene
	*/
	public function editar_usuario()
	{
		$data['bandera'] = false;
		$data['titulo'] = 'Editar Permisos Usuario';
		$data['activo'] = 'persona';
		$this->load->view('plantilla/header', $data);
		$this->load->view('editar/editarusuario', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		metodo que muestra todos los permisos asignados a un usuario
	*/
	public function permisos_usuario()
	{
		$this->form_validation->set_rules('seleccion', 'Seleccionar*', 'trim|required');

		$this->form_validation->set_message('required', 'El campo %s es requerido, por favor seleccione a una persona.');
		if ($this->form_validation->run() == FALSE) {
			$this->editar_usuario();
		} else {
			$id = $this->input->post('seleccion');
			$data['bandera'] = true;
			$data['permisos'] = $this->Usuario_model->findPermisosUsuario($id);
			$data['opcion'] = $this->Opciones_model->getOpciones();
			$data['titulo'] = 'Permisos Asignados al Usuario';
			$data['activo'] = 'persona';
			$this->load->view('plantilla/header', $data);
			$this->load->view('editar/editarusuario', $data);
			$this->load->view('plantilla/footer');
		}//fin del if else

	}

	/*
		metodo para habilitar o deshabilitar un permiso asignado a un usuario
	*/
	public function editar_permiso()
	{
		$id = $this->input->get('dato');
		$estado = $this->input->get('estado');
		$dato = $this->Usuario_model->updatePermiso($id, $estado);
		echo $dato;
	}

	/*metodo que agrega un nuevo permiso a un usuario*/
	public function agregar_permiso()
	{
		$opcion =$this->input->get('opcion');
		$subopcion = $this->input->get('sub');
		$usuario = $this->input->get('usuario');
		$idPermiso = $this->Usuario_model->searchPermisoUsuario($usuario, $opcion);
		if (count($idPermiso) == 0) {
			$this->Permisos_model->setPermisos($usuario, $opcion);//guardamos los permisos asignados al usuario
			$idPermiso = $this->Usuario_model->searchPermisoUsuario($usuario, $opcion);
			$id = $idPermiso[0]['id_permiso_usuario'];
			$this->Permisos_model->setSubPermisos($id, $subopcion);
		} else {
			$id = $idPermiso[0]['id_permiso_usuario'];
			$this->Permisos_model->setSubPermisos($id, $subopcion);
		}//fin del if else

		$datos = $this->Usuario_model->findPermisosUsuario($usuario);
		echo json_encode($datos);
	}//fin del metodo agregar_permiso


}

/* End of file Usuario.php */
/* Location: ./application/controllers/Usuario.php */

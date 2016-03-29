<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notas extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Cuadros_model');
		$this->load->model('Puntos_model');
		$this->load->model('Asignaciondocente_model');
		$this->load->model('Docente_model');
		$this->load->model('Estudiante_model');
	}
	public function index()
	{
		$area = $this->input->post('area');
		$array = explode(",", $area);//convertimos el estring en un array
		$fecha = date('Y-m-d');
		$anio = date('Y-00-00');
		$ciclo = date('Y').'-00-00';
		if ($array[0] == 'diversificado') {
			$aux = $this->Puntos_model->existe_notasc($array[1], $fecha);
		} else {
			$aux = $this->Puntos_model->existe_notas($array[1], $fecha);
		}


		if (count($aux) == 0) {
			$data['bandera'] = false;
			if ($array[0] == 'diversificado') {
				$cuadros = $this->Puntos_model->findIdCuadrosC($array[1], $fecha, $anio);
			} else {
				$cuadros = $this->Puntos_model->findIdCuadros($array[1], $fecha, $anio);
			}



			$this->session->set_userdata('nivel', $array[0] );
			$this->session->set_userdata('cuadros', $cuadros);
		}
		else{
			$data['bandera'] = true;
		}
		if ($array[0]=='diversificado') {
			$data['estudiante'] = $this->Cuadros_model->findEstudiantesC($array[1], $fecha, $ciclo);
		}
		else{
			$data['estudiante'] = $this->Cuadros_model->findEstudiantes($array[1], $fecha, $ciclo);
		}

		$data['activo'] = 'notas';
		$data['titulo'] = 'Notas Estudiantes';
		$this->load->view('plantilla/header', $data);
		$this->load->view('notas/nestudiante', $data);
		$this->load->view('plantilla/footer');

	}

	public function nuevas_acreditaciones()
	{
		$this->form_validation->set_rules('uno', '1', 'trim|required');

		$this->form_validation->set_message('required', 'El campo %s es obligatorio');

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$uno = $this->input->post('uno');
			$dos = $this->input->post('dos');
			$tres = $this->input->post('tres');
			$cuatro = $this->input->post('cuatro');
			$cinco = $this->input->post('cinco');
			$seis =  $this->input->post('seis');
			$datos = array();

			$cuadros = $_SESSION['cuadros'];
			//echo "contenido: ".count($cuadros);
			$nivel = $_SESSION['nivel'];


			$aux = $this->Puntos_model->setNuevaAcreditacion($uno);
			$temp = array('id'=>$aux);
			array_push($datos, $temp);
			$aux = $this->Puntos_model->setNuevaAcreditacion($dos);
			$temp = array('id'=>$aux);
			array_push($datos, $temp);
			$aux = $this->Puntos_model->setNuevaAcreditacion($tres);
			$temp = array('id'=>$aux);
			array_push($datos, $temp);
			$aux = $this->Puntos_model->setNuevaAcreditacion($cuatro);
			$temp = array('id'=>$aux);
			array_push($datos, $temp);
			$aux = $this->Puntos_model->setNuevaAcreditacion($cinco);
			$temp = array('id'=>$aux);
			array_push($datos, $temp);
			$aux = $this->Puntos_model->setNuevaAcreditacion($seis);
			$temp = array('id'=>$aux);
			array_push($datos, $temp);

			if ($nivel == 'diversificado') {
				foreach ($cuadros as $value) {
					foreach ($datos as $value2) {
						$this->Puntos_model->setNuevosPuntosC($value['id_cuadros_carreras'], $value2['id']);
					}
				}
			}
			else {
				foreach ($cuadros as $value) {
					foreach ($datos as $value2) {
						$this->Puntos_model->setNuevosPuntos($value['id_cuadros'], $value2['id']);
					}//fin del foreach
				}//fin del foreach

		}//fin del else
			$this->session->unset_userdata('cuadros');
			redirect('asignaciondocente/areas_asignadas','refresh');
		}
	}

	/**
	*metodo que busca las acreditaciones de un estudiante de un determinado bloque
	**/
	public function buscar_acreditacion()
	{
		$dato = $this->input->get('dato');
		$array = explode(',', $dato);
		$bloque = $array[0];
		$asignarea = $array[1];
		$estudiante = $array[2];
		$nivel = $array[3];
		$ciclo = date('Y-00-00');

		if ($nivel == 4) {
			$datos = $this->Puntos_model->findNotasEstudianteC($asignarea, $ciclo, $estudiante, $bloque);
		}
		else
		{
			$datos = $this->Puntos_model->findNotasEstudiante($asignarea, $ciclo, $estudiante, $bloque);
		}
		echo json_encode($datos);
	}

	/**
	* metodo que agrega una nueva nota de un estudiante de un determinado bloque en su zona
	**/
	public function agregar_nota()
	{
		$datos = $this->input->post('datos');
		$array = explode(',', $datos);
		$puntos = $this->input->post('puntos');
		$array2 = explode(',', $puntos);
		$nivel = $array[6];
		if ($nivel == 4) {
			for ($i=0; $i < 6; $i++) {
				if ($array2[$i] != '') {
					$this->Puntos_model->agregar_puntosc($array[$i], $array2[$i]);
				}
			}
		}
		else
		{
			for ($i=0; $i < 6; $i++) {
				if ($array2[$i] != '') {
					$this->Puntos_model->agregar_puntos($array[$i], $array2[$i]);
				}
			}
		}

	}

	/*
		metodo para mostrar las areas que tiene asignados el docente
	*/
	public function puntualidad_habitos()
	{
		//$persona = $_SESSION['nombreautenticado'];
		$persona = $_SESSION['nombreautenticado'];
		$id = $persona[0]['id'];

		$dato = $this->Docente_model->getTitular($id);
		$dato2 = $this->Docente_model->getTitularC($id);
		if (count($dato) == 0) {
			$data['permiso1'] = false;
		}else{
			$data['permiso1'] = true;
			$data['grado'] = $dato;
 		}
		if (count($dato2) == 0) {
			$data['permiso2'] = false;
		} else {
			$data['permiso2'] = true;
			$data['gradoD'] = $dato2;
		}




		$data['titulo'] = 'Puntualidad, asistencia, habitos';
		$data['activo'] = 'notas';
		$this->load->view('plantilla/header', $data);
		$this->load->view('secretaria/npuntualidad', $data);
		$this->load->view('plantilla/footer');
	}

	public function nomina_estudiantes()
	{
		$this->form_validation->set_rules('grado', 'Grado', 'trim|required');

		$this->form_validation->set_message('required', 'El campo %s es requerido, por favor seleccione una opcion');

		if ($this->form_validation->run() == FALSE) {
			$this->puntualidad_habitos();
		} else {
			$datos = $this->input->post('grado');
			$array = explode(',', $datos);
			$fecha = date('Y-m-d');
			$ciclo = date('Y').'-00-00';

			if ($array[0] == 4) {
				$data['estudiantes'] = $this->Estudiante_model->getNominaEstudiantesC($array[1], $array[2], $ciclo, $fecha);
			} else {
				$data['estudiantes'] = $this->Estudiante_model->getNominaEstudiantes($array[0], $array[1], $ciclo, $fecha);
			}
			$data['nivel'] = $array[0];
			$data['titulo'] = 'Agregar Puntualidad y Hábitos de Estudiante';
			$data['activo'] = 'notas';
			$this->load->view('plantilla/header', $data);
			$this->load->view('notas/npuntualidad', $data);
			$this->load->view('plantilla/footer');
		}
	}

	/*
		metodo para agregar una nueva puntuacion en puntualidad
	*/
	public function nueva_puntualidad()
	{
		$estudiante = $this->input->post('estudiante');
		$puntualidad = $this->input->post('puntualidad');
		$habitos = $this->input->post('habitos');

		$array = explode(',', $estudiante);
		if ($array[1] == 4) {
			for ($i=2; $i < count($array); $i++) {
			$this->Puntos_model->update_punt_habitosC($array[$i], $puntualidad, $habitos);
			}
		} else {
			for ($i=2; $i < count($array); $i++) {
			$this->Puntos_model->update_punt_habitos($array[$i], $puntualidad, $habitos);
			}
		}
	}//fin del metodo

	/*
		metodo que muestra el formulario para agregar las observaciónes del docente del bloque
		actual para un estudiante del nivel primario
	*/
	public function observaciones_bloque()
	{
		$persona = $_SESSION['nombreautenticado'];
		$id = $persona[0]['id'];
		$ciclo = date('Y').'-00-00';
		$fecha = date('Y-m-d');
		$dato = $this->Docente_model->getTitular($id);
		if (count($dato) == 0) {
			$data['bandera'] = false;
		} else {
			$data['bandera'] = true;
			$nivel = $dato[0]['id_nivel'];
			$grado = $dato[0]['id_grado'];
			$data['estudiantes'] = $this->Estudiante_model->getNominaEstudiantes($nivel, $grado, $ciclo, $fecha);
		}


		$data['titulo'] = 'Observaciones Bloque';
		$data['activo'] = 'notas';
		$this->load->view('plantilla/header', $data);
		$this->load->view('notas/observacionesbloque', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		metodo que muestra el formulario de edición del nombre de las acreditaciones del bloque
	*/
	public function editar_acreditaciones()
	{
		$persona = $_SESSION['nombreautenticado'];
		$id = $persona[0]['id'];
		$data['areas'] = $this->Asignaciondocente_model->findAreasAsignadasDocente($id);//areas asignadas de pre-primaria, primaria y básicos
		$data['areasD'] = $this->Asignaciondocente_model->findAreasAsignadasDocenteD($id);
		$data['bandera'] = false;
		$data['titulo'] = 'Editar Nombre de Acreditaciónes';
		$data['activo'] = 'notas';
		$this->load->view('plantilla/header', $data);
		$this->load->view('editar/editaracreditacion', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		metodo que busca y muestra las acreditaciónes de un bloque y área
		de un ciclo academico, para poder ser editadas
	*/
	public function buscar_acreditaciones()
	{
		$datos = $this->input->post('seleccion');
		$array = explode(',', $datos);
		$ciclo = date('Y').'-00-00';
		$fecha = date('Y-m-d');
		if ($array[0] == 'diversificado') {
			$acreditacion = $this->Puntos_model->getAcreditacionesC($array[1], $ciclo, $fecha);
		} else {
			$acreditacion = $this->Puntos_model->getAcreditaciones($array[1], $ciclo, $fecha);
		}
		$data['acredita'] = $acreditacion;
		$data['bandera'] = true;
		$data['titulo'] = 'Editar Nombre de Acreditaciónes';
		$data['activo'] = 'notas';
		$this->load->view('plantilla/header', $data);
		$this->load->view('editar/editaracreditacion', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		metodo para guardar la edición del nombre de la acreditación de bloque
	*/
	public function guardar_edicion_acreditacion()
	{
		$this->form_validation->set_rules('acred0', 'ACREDITACIÓN 1', 'required|trim|max_length[40]');
		$this->form_validation->set_rules('acred1', 'ACREDITACIÓN 2', 'max_length[40]|trim');
		$this->form_validation->set_rules('acred2', 'ACREDITACIÓN 3', 'max_length[40]|trim');
		$this->form_validation->set_rules('acred3', 'ACREDITACIÓN 4', 'max_length[40]|trim');
		$this->form_validation->set_rules('acred4', 'ACREDITACIÓN 5', 'max_length[40]|trim');
		$this->form_validation->set_rules('acred5', 'ACREDITACIÓN 6', 'max_length[40]|trim');

		$this->form_validation->set_message('required', 'El campo %s es requerido, por favor llene el campo');
		$this->form_validation->set_message('max_length', 'El campo %s no puede tener mas de %d caracteres');

		if ($this->form_validation->run() == false) {
				$this->buscar_acreditaciones();
		} else {
			$nomuno = $this->input->post('acred0');
			$nomdos = $this->input->post('acred1');
			$nomtres = $this->input->post('acred2');
			$nomcuatro = $this->input->post('acred3');
			$nomcinco = $this->input->post('acred4');
			$nomseis = $this->input->post('acred5');
			$keys = $this->input->post('keys');
			$array = explode(',', $keys);
			$nombre = array();
			$temp = array('nom'=>$nomuno);
			array_push($nombre, $temp);
			$temp = array('nom'=>$nomdos);
			array_push($nombre, $temp);
			$temp = array('nom'=>$nomtres);
			array_push($nombre, $temp);
			$temp = array('nom'=>$nomcuatro);
			array_push($nombre, $temp);
			$temp = array('nom'=>$nomcinco);
			array_push($nombre, $temp);
			$temp = array('nom'=>$nomseis);
			array_push($nombre, $temp);
			for ($i=0; $i < count($array)-1; $i++) {
				//echo $array[$i].' '.$nombre[$i]['nom'];
				$this->Puntos_model->updateAcreditacion($array[$i], $nombre[$i]['nom']);
			}
			$data['msg'] = 'Los datos fueron actualizados exitosamente. Ya puede realizar otra operación.';
			$data['titulo'] = 'Mensaje del sistema';
			$data['activo'] = '';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');
		}//fin del metodo


	}

}

/* End of file Notas.php */
/* Location: ./application/controllers/Notas.php */

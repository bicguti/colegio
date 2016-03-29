<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuadros extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Estudiante_model');
		$this->load->model('Bloque_model');
		$this->load->model('Asignacionarea_model');
		$this->load->model('Cuadros_model');
		$this->load->model('Gradocarrera_model');
		$this->load->model('Estudiantecarrera_model');
		$this->load->model('Asignaciondocente_model');
	}
	public function index()
	{
		$data['titulo'] = 'Crear Cuadros Ciclo Academico';
		$data['activo'] = 'cuadros';
		$this->load->view('plantilla/header', $data);
		$this->load->view('secretaria/ccuadros');
		$this->load->view('plantilla/footer');
	}

	public function cuadros_diversificado()
	{
		$data['titulo'] = 'Crear Cuadros Ciclo Academico';
		$data['activo'] = 'cuadros';
		$this->load->view('plantilla/header', $data);
		$this->load->view('secretaria/ccuadrosd', $data);
		$this->load->view('plantilla/footer');
	}

	public function crear_CuadrosPB()//crear un cuadro del nivel preprimario, primario y básico.
	{
		 $ciclo = date('Y');
		 $ciclo =$ciclo.'-00-00';
		 $bloque = $this->Bloque_model->getBloques();
		$estudiantes = $this->Estudiante_model->getEstudiantesPB();
		foreach ($estudiantes as $value) {
			//echo 'ID Estudiante: '.$value['id_estudiante'].'<br>';
			$IdAsignacion = $this->Asignacionarea_model->getIdAsignacionArea($value['id_nivel'], $value['id_grado']);
			//echo count($IdAsignacion).'<br>';
			foreach ($IdAsignacion as $value2) {
				//echo ' Asignacion: '.$value2['id_asignacion_area'].'<br>';
				foreach ($bloque as $value3) {
					//echo ' Bloque'.$value3['id_bloque'].'<br>';
					$this->Cuadros_model->setCuadrosPB($value['id_estudiante'], $value3['id_bloque'], $value2['id_asignacion_area'], $ciclo);	
					//echo 'ID Estudiante: '.$value['id_estudiante'].' Bloque'.$value3['id_bloque'].' Asignacion: '.$value2['id_asignacion_area'].' Ciclo: '.$ciclo.'<br/>';
					//echo 'ID Estudiante: '.$value['id_estudiante'].'<br>';
				}
			}

		}
		
		$data['titulo'] = 'Mensaje del Sistema';
		$data['msg'] = 'Se han creado los cuadros de este ciclo academico '.date('Y');
		$data['activo'] = 'ninguno';
		$this->load->view('plantilla/header', $data);
		$this->load->view('msg/listo', $data);
		$this->load->view('plantilla/footer');
	}

	public function crear_cuadrosD()//Metodo para crear un nuevo cuadro del nivel Diversificado.
	{
		$ciclo = date('Y');
		$ciclo = $ciclo.'-00-00';
		$bloque = $this->Bloque_model->getBloques();
		$estudiante = $this->Estudiante_model->getEstudiantesD();
		
		foreach ($estudiante as $value) {
			//echo $value['id_estudiante'].'<br>';
			$carrera = $this->Estudiantecarrera_model->getEstudianteCarrera($value['id_estudiante']);
			foreach ($carrera as $value2) {
				$gradoCarrera = $this->Gradocarrera_model->getGradoCarrera($value['id_grado'],$value2['id_carrera']);
				foreach ($gradoCarrera as $value5) {
					$asignacionAreaC = $this->Asignacionarea_model->getIdAsignacionAreaD($value5['id_grado_carrera']);
					foreach ($asignacionAreaC as $value3) {
						foreach ($bloque as $value4) {
							//echo 'bloque: '.$value4['id_bloque'].' aArea: '.$value3['id_asignacion_areac'].' eCarrera: '.$value2['id_estudiante_carrera'].' grado'.$value['id_grado'].' estudiante: '.$value['id_estudiante'].'<br/>';
							$this->Cuadros_model->setCuadrosD($value3['id_asignacion_areac'], $value4['id_bloque'], $value2['id_estudiante_carrera'], $ciclo);
						}//fin del foreach
					}//fin del foreach
				}//fin del foreach
			}//fin del foreach
		}//fin del foreach


		$data['msg'] = 'Se crearon los cuadros del nivel diversificado del ciclo '.date('Y');
		$data['titulo'] = 'Mensaje del Sistema';
		$data['activo'] = 'ninguno';
		$this->load->view('plantilla/header', $data);
		$this->load->view('msg/listo', $data);
		$this->load->view('plantilla/footer');

	}//fin del metodo

	public function notas_evaluacion($value='')
	{
		$persona = $_SESSION['nombreautenticado'];
		foreach ($persona as $value) {
			$id = $value['id'];
		}
		$data['areas'] = $this->Asignaciondocente_model->findAreasAsignadasDocente($id);//areas asignadas de pre-primaria, primaria y básicos
		$data['areasD'] = $this->Asignaciondocente_model->findAreasAsignadasDocenteD($id);
		$data['titulo'] = 'Notas';
		$data['activo'] = 'notas';
		$this->load->view('plantilla/header', $data);
		$this->load->view('notas/edocentes', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		Busca a los estudiantes de un determinado curso en un determinado bloque,
		para la asignacion de notas de evaluacion
	*/
	public function buscar_estudiantes()
	{
		$area = $this->input->post('area');
		$array = explode(",", $area);//convertimos el estring en un array
		$fecha = date('Y-m-d');
		$anio = date('Y-00-00');

		if ($array[0] == 'diversificado') {
			$data['estudiante'] = $this->Cuadros_model->findCuadrosEstudiantesC($array[1], $fecha, $anio);
		} else {
			$data['estudiante'] = $this->Cuadros_model->findCuadrosEstudiantes($array[1], $fecha, $anio);
		}

		$data['titulo'] = 'Notas Evaluacion Estudiante';
		$data['activo'] = 'notas';
		$this->load->view('plantilla/header', $data);
		$this->load->view('notas/eestudiante', $data);
		$this->load->view('plantilla/footer');
		
	}

	/*
		metodo que se encarga de busca la nota de evaluacion de un determinado estudiante para ser 
		editado, de un determinado bloque, en una determinado area y en el ciclo que se encuentre
	*/
	public function buscar_nexamen()
	{
		$dato = $this->input->get('dato');
		$array = explode(',', $dato);
		$bloque = $array[0];
		$asignarea = $array[1];
		$estudiante = $array[2];
		$nivel = $array[3];
		$ciclo = date('Y-00-00');

		if ($nivel == 4) {
			$datos = $this->Cuadros_model->findCuadroEvaluacionEC($asignarea, $ciclo, $estudiante, $bloque);
		}
		else
		{
			$datos = $this->Cuadros_model->findCuadroEvaluacionE($asignarea, $ciclo, $estudiante, $bloque);	
		}
		echo json_encode($datos);
	}

	public function guardar_examen()
	{
		$examen = $this->input->post('nota');
		$temp = $this->input->post('dato');
		$array = explode(',', $temp);
		if ($array[1] == 4) {//actualizacion de notas para el nivel diversificado
			$this->Cuadros_model->setNotaExamenC($array[0], $examen);
		} else {//actualizacion de notas para el nivel pre-primario, primario y básico
			$this->Cuadros_model->setNotaExamen($array[0], $examen);
		}
		
	}
}

/* End of file Cuadros.php */
/* Location: ./application/controllers/Cuadros.php */
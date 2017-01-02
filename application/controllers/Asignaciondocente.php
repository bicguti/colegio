<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asignaciondocente extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Nivel_model');
		$this->load->model('Asignaciondocente_model');
		$this->load->model('Persona_model');
		$this->load->model('Asignacionarea_model');
	}
	public function index()
	{
		$data['nivel'] = $this->Nivel_model->getNivel();
		$dato['titulo'] = 'Nueva Asignacion Docente - Area';
		$dato['activo'] = 'docente';
		$this->load->view('plantilla/header', $dato);
		$this->load->view('secretaria/nasignaciond', $data, FALSE);	
		$this->load->view('plantilla/footer');

	}

	public function buscar_docente()
	{
		$this->form_validation->set_rules('apellido', 'Apellido', 'trim|required');
		$this->form_validation->set_message('required', 'El campo %s es obligatorio.');

		if ($this->form_validation->run() == FALSE) 
		{
			$this->index();
		} 
		else 
		{
			$ape = $this->input->post('apellido');
			$data['ddocente'] = $this->Persona_model->findDocente($ape);
			$data['nivel'] = $this->Nivel_model->getNivel();
			$dato['titulo'] = 'Nueva Asignación Docente - Area';
			$dato['activo'] = 'docente';
			$this->load->view('plantilla/header', $dato);
			$this->load->view('secretaria/nasignaciond', $data, FALSE);	
			$this->load->view('plantilla/footer');	
		}
		
	}
	public function nueva_asignacion()
	{
		
		if ($this->session->has_userdata('asignacionD')) //verificar que existe la session
		{		
			$datos = $_SESSION['asignacionD'];
			$persona = $_SESSION['IdPersona'];
			$fecha = date('Y-m-d H:i:s');
			$idAsignacion = $this->Asignaciondocente_model->setAsignacion($fecha, $persona);
			for ($i=0; $i < count($datos); $i++) 
			{
				if ($datos[$i]['id_nivel'] == 4) 
				{
				 	$this->Asignaciondocente_model->setDetalleAsignacionD($idAsignacion, $datos[$i]['id_asignacion_area']);
				} 
				else
				{
					$this->Asignaciondocente_model->setDetalleAsignacion($idAsignacion, $datos[$i]['id_asignacion_area']);
				}
			}

			$this->session->unset_userdata('IdPersona');
			$this->session->unset_userdata('asignacionD');
			$this->session->unset_userdata('docente');
			$this->session->unset_userdata('dasignacion');

			$data['activo'] = 'ninguno';
			$data['titulo'] = 'Mensaje del Sistema';
			$data['msg'] = 'Listo!!!. Asignación finalizada, ahora el docente puede agregar notas a cada estudiante.';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');	
		}
		else
		{
			$data['activo'] = 'ninguno';
			$data['titulo'] = 'Mensaje del Sistema';
			$data['msg'] = 'No se pudo guardar nada porque todavía no hay datos, para guardar, seleccione primero que cursos asignara y luego al boton guardar.';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');
		}
		
	}

	public function areas_primariaBasico()//metodo para obtener todas las areas correspondientes a un grado y al nivel preprimario, primario y básico
	{
		$nivel = $this->input->get('nivel');
		$grado = $this->input->get('grado');
		$datos = $this->Asignaciondocente_model->getAreasPB($nivel, $grado);
		echo json_encode($datos);
	}

	public function areas_diversificado()//metodo para obtener todas las areas correspondientes a cada carrera y grado 
	{
		$grado = $this->input->get('grado');
		$carrera = $this->input->get('carrera');
		$datos = $this->Asignaciondocente_model->getAreasD($grado, $carrera);
		echo json_encode($datos);
	}

	public function mi_asignacion()//metodo para crear la session donde se almacenaran los datos de asignacion al docente
	{
		$this->form_validation->set_rules('nivel', 'Nivel', 'trim|required');
		$this->form_validation->set_rules('grados', 'Grado', 'trim|required');
		$this->form_validation->set_rules('area[]', 'Area', 'trim|required');
		$this->form_validation->set_message('required', 'El campo %s es obligatorio, seleccione una opción.');
		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$nivel = $this->input->post('nivel');
			if($nivel == 4)//si el nivel es diversificado verificamos que haya seleccionado una opcion valida de carrera.
			{
				$this->form_validation->set_rules('carrera', 'Carrera', 'trim|required');
			}
				
				if ($this->form_validation->run() == FALSE) {
					$this->index();
				} 
				else 
				{
					$grado = $this->input->post('grados');
					$area = $this->input->post('area[]');
					$carrera = $this->input->post('carrera');
					if ($this->session->has_userdata('asignacionD')) 
					{
						$datos=$this->session->userdata('asignacionD');
						$datosasignacion = $this->session->userdata('dasignacion');
						for ($i=0; $i < count($area); $i++) 
						 { 
						 	$arreglo = array('id_nivel'=>$nivel,'id_asignacion_area'=>$area[$i]);
						 	
						 	if (in_array($arreglo, $datos) == false)//buscamos en el array si existe es ta combinacion 
						 	{										//si existe no agregamos nada a los arrays
						 		array_push($datos, $arreglo);
						 	
							 	if ($nivel == 4) {
							 		$temp = $this->Asignacionarea_model->getDatosasignacionD($area[$i]);
							 		
							 	} else {
							 		$temp = $this->Asignacionarea_model->getDatosasignacion($area[$i]); 
							 		
							 	}//fin del if else
							 	foreach ($temp as $value) {
							 		$a = $value['nombre_area'];
							 		$g = $value['nombre_grado'];
							 		if ($nivel == 4) {
							 			$c = $value['nombre_carrera'];
							 			$n = 'diversificado';
							 		} else {
							 			$n = $value['nombre_nivel'];
							 			$c = 'ninguno';
							 		}//fin del if else
							 		
							 		$aux = array('area'=>$a, 'grado'=>$g, 'nivel'=>$n, 'carrera'=>$c);
							 	}//fin del foreach

							 	array_push($datosasignacion, $aux);
						 	}//fin del if
						 }//fin del for
						
						$this->session->set_userdata('asignacionD',$datos);
						$this->session->set_userdata('dasignacion', $datosasignacion);
					}//fin del if
					else
					{
						$datos=array();
						$datosasignacion = array();
						for ($i=0; $i < count($area); $i++) 
						{ 
							$arreglo = array('id_nivel'=>$nivel,'id_asignacion_area'=>$area[$i]);
							array_push($datos, $arreglo);
							if ($nivel == 4) {
						 		$temp = $this->Asignacionarea_model->getDatosasignacionD($area[$i]);
						 		
						 	} else {
						 		$temp = $this->Asignacionarea_model->getDatosasignacion($area[$i]); 
						 		
						 	}//fin del if else
						 	foreach ($temp as $value) {
						 		$a = $value['nombre_area'];
						 		$g = $value['nombre_grado'];
						 		if ($nivel == 4) {
						 			$c = $value['nombre_carrera'];
						 			$n = 'diversificado';
						 		} else {
						 			$n = $value['nombre_nivel'];
						 			$c = 'ninguno';
						 		}//fin del if else
						 		
						 		$aux = array('area'=>$a, 'grado'=>$g, 'nivel'=>$n, 'carrera'=>$c);
						 	}//fin del foreach

						 	array_push($datosasignacion, $aux);
						}//fin del for
						
						$this->session->set_userdata('asignacionD', $datos );
						$this->session->set_userdata('dasignacion', $datosasignacion );
					}//fin del else

					
				}
				
			
			$this->index();
		}
	}

	public function agregar_persona()//Metodo que se encarga de crear una session para el id de la persona
	{
		$this->form_validation->set_rules('persona', 'Seleccionar', 'trim|required');
		$this->form_validation->set_message('required','Debe seleccionar una persona %s, este campo es obligatorio');
	
		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {

			if (isset($_SESSION['IdPersona'])) 
			{
				$dato['activo'] = 'docente';
				$data['nivel'] = $this->Nivel_model->getNivel();
				$dato['titulo'] = 'Nueva Asignacion Docente - Area';
				$this->load->view('plantilla/header', $dato);
				$this->load->view('secretaria/nasignaciond', $data);
				$this->load->view('plantilla/footer');
			}
			else
			{
				$id = $this->input->post('persona');
				$this->session->set_userdata('IdPersona',$id);
				$datos = $this->Persona_model->nomapeDocente($id);
				
				foreach ($datos as $value) {
					$docente = array($value['nombre_persona'], $value['apellidos_persona']);	
				}

				$this->session->set_userdata('docente',$docente);
				$dato['activo'] = 'docente';
				$data['nivel'] = $this->Nivel_model->getNivel();
				$dato['titulo'] = 'Nueva Asignacion Docente - Area';
				$this->load->view('plantilla/header', $dato);
				$this->load->view('secretaria/nasignaciond', $data);
				$this->load->view('plantilla/footer');
			}
		}
		
	}

	public function cancelar_asignacion()//metodo para cancelar una asignación, borra las sesiones involucradas en una asignacion
	{
		$this->session->unset_userdata('IdPersona');
		$this->session->unset_userdata('asignacionD');
		$this->session->unset_userdata('docente');
		$this->session->unset_userdata('dasignacion');
		$this->index();	
	}

	public function areas_asignadas()
	{
		//if (isset($_SESSION['nombreautenticado'])) {
		$persona = $_SESSION['nombreautenticado'];
		foreach ($persona as $value) {
			$id = $value['id'];
		}
		$data['areas'] = $this->Asignaciondocente_model->findAreasAsignadasDocente($id);//areas asignadas de pre-primaria, primaria y básicos
		$data['areasD'] = $this->Asignaciondocente_model->findAreasAsignadasDocenteD($id);
		$data['titulo'] = 'Notas';
		$data['activo'] = 'notas';
		$this->load->view('plantilla/header', $data);
		$this->load->view('notas/ndocentes', $data);
		$this->load->view('plantilla/footer');
		//}
		//else{
		//	redirect('autenticacion','refresh');
		//}
	}

	/*
		metodo que muestra el formulario de edición de asignación de docente
	*/
	public function editar_asignacion()
	{	
		$data['titulo'] = 'Editar Asignación Docente';
		$data['activo'] = 'docente';
		$this->load->view('plantilla/header', $data);
		$this->load->view('editar/editarasignaciondoc', $data);
		$this->load->view('plantilla/footer');
	}

}

/* End of file Asignaciondocente.php */
/* Location: ./application/controllers/Asignaciondocente.php */
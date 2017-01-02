<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estudiante extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Genero_model');
		$this->load->model('Nivel_model');
		$this->load->model('Grado_model');
		$this->load->model('Estadoestudiantes_model');
		$this->load->model('Estudiante_model');
		$this->load->model('Carrera_model');
		$this->load->model('Estudiantecarrera_model');
	}
	public function index()
	{
		$data['grado'] = $this->Grado_model->getGrado();
		$data['nivel'] = $this->Nivel_model->getNivel2();
		$data['genero'] = $this->Genero_model->getGenero();
		$data['titulo'] = "Nuevo Estudiante P-B";
		$data['activo'] = 'estudiante';
		$this->load->view('plantilla/header', $data);
		$this->load->view('secretaria/nestudiante', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		metodo para agregar un nuevo estudiante de nivel pre-primaria, primaria y básico
	*/
	public function nuevo_estudiante()
	{
		$this->form_validation->set_rules('nombres', 'Nombres', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('apellidos', 'Apellidos', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('codigo', 'Código', 'max_length[20]');
		$this->form_validation->set_rules('cui', 'CUI', 'max_length[13]');
		$this->form_validation->set_rules('fechanacimiento', 'Fecha de nacimiento', 'trim|required');
		$this->form_validation->set_rules('genero', 'Genero', 'trim|required');
		$this->form_validation->set_rules('nivel', 'Nivel', 'trim|required');
		$this->form_validation->set_rules('grado', 'Grado', 'trim|required');
		$this->form_validation->set_message('required', 'El campo %s es obligatorio no puede estar en blanco o sin seleccionarse una opcion validad');
		$this->form_validation->set_message('max_length', 'El campo %s no puede superar los %d caracteres');
		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$nombres = mb_strtolower($this->input->post('nombres'));
			$apellidos = mb_strtolower($this->input->post('apellidos'));
			$codigo = mb_strtolower($this->input->post('codigo'));
			$fechanacimiento = mb_strtolower($this->input->post('fechanacimiento'));
			$cui = $this->input->post('cui');
			$genero = $this->input->post('genero');
			$nivel = $this->input->post('nivel');
			$grado = $this->input->post('grado');

			$fechactual = date('Y-m-d');
			$edad = $fechactual - $fechanacimiento;

			$estado = $this->Estadoestudiantes_model->getIdestadoestudiantes();//obtenemos el id para el estado inscrito ya que es la primera vez que se registra al estudiante
			$data['msg'] = $this->Estudiante_model->setEstudiante($genero, $estado, $codigo, $nombres, $apellidos, $fechanacimiento, $edad, $nivel, $grado, $cui);


			$data['titulo'] = "Mensaje del sistema";
			$data['activo'] = 'ninguno';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');

		}
	}

	/*
		metodo para mostrar el formulario de agregar nuevo estudiante de carrera
	*/
	public function estudiante_carrera()
	{
		$data['carrera'] = $this->Carrera_model->getCarrera();
		$data['grado'] = $this->Grado_model->findDiversificado();
		$data['genero'] = $this->Genero_model->getGenero();
		$data['titulo'] = "Nuevos Estudiante-Carrera";
		$data['activo'] = 'estudiante';
		$this->load->view('plantilla/header', $data);
		$this->load->view('secretaria/nestudiantec', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		metodo para guardar a un nuevo estudiante de carrera
	*/
	public function nuevo_estudiantec()
	{
		$this->form_validation->set_rules('nombres', 'Nombres', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('apellidos', 'Apellidos', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('codigo', 'Código', 'max_length[20]');
		$this->form_validation->set_rules('fechanacimiento', 'Fecha de nacimiento', 'trim|required');
		$this->form_validation->set_rules('genero', 'Genero', 'trim|required');
		$this->form_validation->set_rules('grados', 'Grado', 'trim|required');
		$this->form_validation->set_rules('carrera', 'Carrera', 'trim|required');
		$this->form_validation->set_rules('cui', 'CUI', 'max_length[13]');
		$this->form_validation->set_message('required', 'El campo %s es obligatorio no puede estar en blanco o sin seleccionarse una opcion valida');
		$this->form_validation->set_message('max_length', 'El campo %s no puede superar los %d caracteres');

		if ($this->form_validation->run() == FALSE) {
			$this->estudiante_carrera();//si alguno de los campos no cumple con los requerimientos entonces se vuelve a cargar el formulario
		} else {
			$nombres = mb_strtolower($this->input->post('nombres'));
			$apellidos = mb_strtolower($this->input->post('apellidos'));
			$codigo = mb_strtolower($this->input->post('codigo'));
			$fechanacimiento = $this->input->post('fechanacimiento');
			$genero = $this->input->post('genero');
			$cui = $this->input->post('cui');
			$nivel = 4;//este es el id del nivel diversificado
			$grado = $this->input->post('grados');
			$carrera = $this->input->post('carrera');
			$fechactual =date('Y-m-d');
			$edad = $fechactual - $fechanacimiento;

			$estado = $this->Estadoestudiantes_model->getIdestadoestudiantes();//obtenemos el id para el estado inscrito ya es la primera vez que se registra al estudiante
			$idestudiante = $this->Estudiante_model->setEstudiantec($genero, $estado, $codigo, $nombres, $apellidos, $fechanacimiento, $edad, $nivel, $grado, $cui);

			if ($idestudiante == 0) {
				$data['msg'] = 'No se pudo registrado al(la) estudiante: '.$nombres.' '.$apellidos.', porque ya existe en la base de datos';

			$data['titulo'] = "Mensaje del sistema";
			$data['activo'] = 'ninguno';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');
			}
			else
			{
			$dato = $this->Estudiantecarrera_model->setEstudiantecarrera($idestudiante, $carrera);

				$data['msg'] = 'Se a registrado exitosamente al(la) estudiante: '.$nombres.' '.$apellidos.', en la base de datos';

			$data['titulo'] = "Mensaje del sistema";
			$data['activo'] = 'ninguno';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');


		}
		}
	}

	/*
		metodo que devuelve un json de los identificadores de los cuadros y
		las notas asignadas a las acreditaciones de asistencia a clases así como
		de los hábitos de orden
	*/
	public function buscar_punt_habit()
	{
		$estudiante = $this->input->get('estudiante');
		//echo $estudiante;
		$array = explode(',', $estudiante);
		$ciclo = date('Y').'-00-00';
		$fecha = date('Y-m-d');

		if ($array[1] == 4) {
			$datos = $this->Estudiante_model->buscar_punt_habitosC($array[0], $ciclo, $fecha);
		} else {
			if ($array[1] == 5) {//para el nivel básico por madurez
					$datos = $this->Estudiante_model->buscar_punt_habitosM($array[0], $ciclo, $fecha);
			} else {//para el resto de niveles
					$datos = $this->Estudiante_model->buscar_punt_habitos($array[0], $ciclo, $fecha);
			}//fin del if else
		}//fin del if else
		echo json_encode($datos);
	}

	/*
		metodo para mostrar el formulario de edicion de datos de estudiante
		de nivel pre-primaria, preprimaria y básico
	*/
	public function editar_estudiante()
	{
		$data['nivel'] = $this->Nivel_model->getNivel2();
		$data['titulo'] = 'Editar Estudiantes';
		$data['activo'] = 'estudiante';
		$this->load->view('plantilla/header', $data);
		$this->load->view('editar/editarestudiante', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		metodo para mostrar el formulario de edicion de datos de estudiante
		de nivel diversificado
	*/
	public function editar_estudiantec()
	{
		$data['carrera'] = $this->Carrera_model->getCarrera();
		$data['titulo'] = 'Editar Estudiantes';
		$data['activo'] = 'estudiante';
		$this->load->view('plantilla/header', $data);
		$this->load->view('editar/editarestudiantec', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		metodo para buscar a todos los estudiantes de un grado
		de nivel primaria para ser editado esto develovera
		un json que sera solicitado por medio de ajax
	*/
	public function buscar_estudiantes()
	{
		$nivel = $this->input->get('nivel');
		$grado = $this->input->get('grado');
		$datos = $this->Estudiante_model->buscar_estudiantes($nivel, $grado);
		echo json_encode($datos);
	}

	/*
		metodo que muestra el formulario para subir un archivo de .xlxs o .xlx (hoja de calculo)
		para cargar los datos de este archivo a la base de datos
	*/
	public function cargar_archivo($value= '')
	{
		$data['error'] = $value;
		$data['nivel'] = $this->Nivel_model->getNivel();
		$data['titulo'] = 'Exportar Datos de Excel';
		$data['activo'] = 'estudiante';
		$this->load->view('plantilla/header', $data);
		$this->load->view('secretaria/cargararchivo', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		metodo que sube el archivo para leerlo y guardar los datos en la base de datos
	*/
	public function subir_archivo()
	{
		$this->form_validation->set_rules('nivel', 'Nivel', 'trim|required');
		$this->form_validation->set_rules('grado', 'Grado', 'trim|required');
		//$this->form_validation->set_rules('archivo', 'Archivo', 'trim|required');

		$this->form_validation->set_message('required', 'El campo %s es requerido, por favor seleccione una opción valida.');

		if ($this->form_validation->run() == FALSE) {
			$this->cargar_archivo();
		} else {

				$config['upload_path'] = './archivos/';
		        $config['allowed_types'] = 'xlsx|xls';
		        $config['overwrite'] = true;
		        $config['max_size'] = 3000;

		        $this->load->library('upload', $config);
		        if ( ! $this->upload->do_upload('archivo'))
		        {
		            $this->cargar_archivo($this->upload->display_errors());
		        }
		        else
		        {
		        	/*$datos = $this->upload->data();
		        	foreach ($datos as $item => $value) {
		        		echo $item.' '.$value.'<br>';
		        	}*/

		        	$nArchivo = $this->upload->data('file_name');
		        	//echo $nArchivo;
		       		$nivel = $this->input->post('nivel');
					$grado = $this->input->post('grado');
					//$archivo = $this->input->post('archivo');
					$carrera = '';
					if ($nivel == 4) {
						$carrera = $this->input->post('carrera');
					}
					$this->leer_datos_hoja($nArchivo, $nivel, $grado, $carrera);

					/*$data['msg'] = 'Listo!!! Los datos de la hoja de calculo han sido cargados a la base de datos. Ya puede realizar otra operación.';
					$data['titulo'] = 'Mensaje del Sistema';
					$data['activo'] = '';
					$this->load->view('plantilla/header', $data);
					$this->load->view('msg/listo', $data);
					$this->load->view('plantilla/footer');*/
		        }//fin del if else

		}//fin del if else
	}

	/*
		metodo privado que lee un archivo .xlsx o .xls y envia los datos a la base de datos
	*/
	private function leer_datos_hoja($archivo, $nivel, $grado, $carrera)
	{
		$this->load->library('Excel');
		$file = './archivos/'.$archivo;
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

		$genero = '';
		$nombres = $apellidos = $codigo = $cui = '';
		$nacimiento = date('Y-m-d');
		$estado = 1;
		$edad = 5;
		$aux = '';
		$msgs = array();
		if ($nivel == 4) {
			foreach ($cell_collection as $cell) {
				    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				    //$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				    //echo 'Columna: '.$column.' Indice'.$row.'<br>';
				    $caracter = ',';
				    $existe = stripos($data_value, $caracter);
				    if ($existe == true) {
				    $array = explode(',', $data_value);
				    $nombres = mb_strtolower($array[1]);
				    $apellidos = mb_strtolower($array[0]);
				    //echo $nombres.' '.$apellidos.'<br>';
				    //echo 'Apellidos: '.mb_strtoupper($array[0]).' Nombres: '.mb_strtoupper($array[1]).$nivel.$grado.$carrera.'<br>';
				    }//fin del if
				    if ($column == 'B') {
				    	//echo 'Genero: '.$data_value.'<br>';
				    	$genero = $data_value;
				    	if ($genero != '' && is_numeric($genero)) {
				    		$idestudiante = $this->Estudiante_model->setEstudiantec($genero, $estado, $codigo, $nombres, $apellidos, $nacimiento, $edad, $nivel, $grado, $cui);

				    		if ($idestudiante == 0) {
									$aux = 'No se pudo registrado al(la) estudiante: '.$nombres.' '.$apellidos.', porque ya existe en la base de datos';
							}
							else
							{
								$dato = $this->Estudiantecarrera_model->setEstudiantecarrera($idestudiante, $carrera);

									$aux = 'Se a registrado exitosamente al(la) estudiante: '.$nombres.' '.$apellidos.', en la base de datos';

							}//fin del if else



				    		$temp = array('msg'=>$aux);
				    		array_push($msgs, $temp);
				    	}//fin del if

					}//fin del if
					//$genero = $apellidos = $nombres = $codigo = $cui = '';

				}//fin del foreach
				$data['msg'] = $msgs;
				$data['titulo'] = 'Mensaje del Sistema';
				$data['activo'] = '';
				$this->load->view('plantilla/header', $data);
				$this->load->view('msg/msgupload.php', $data);
				$this->load->view('plantilla/footer');
		} else {

				foreach ($cell_collection as $cell) {
				    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				    //$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				    //echo 'Columna: '.$column.' Indice'.$row.'<br>';
				    $caracter = ',';
				    $existe = stripos($data_value, $caracter);
				    if ($existe == true) {
				    $array = explode(',', $data_value);
				    $nombres = mb_strtolower($array[1]);
				    $apellidos = mb_strtolower($array[0]);
				    //echo $nombres.' '.$apellidos.'<br>';
				    //echo 'Apellidos: '.mb_strtoupper($array[0]).' Nombres: '.mb_strtoupper($array[1]).$nivel.$grado.$carrera.'<br>';
				    }//fin del if
				    if ($column == 'B') {
				    	//echo 'Genero: '.$data_value.'<br>';
				    	$genero = $data_value;
				    	if ($genero != '' && is_numeric($genero)) {
				    		$msg = $this->Estudiante_model->setEstudiante($genero, $estado, $codigo, $nombres, $apellidos, $nacimiento, $edad, $nivel, $grado, $cui);
				    		//echo $msg.'<br>';
				    		$temp = array('msg'=>$msg);
				    		array_push($msgs, $temp);
				    	}

					}//fin del if
					//$genero = $apellidos = $nombres = $codigo = $cui = '';

				}//fin del foreach
				$data['msg'] = $msgs;
				$data['titulo'] = 'Mensaje del Sistema';
				$data['activo'] = '';
				$this->load->view('plantilla/header', $data);
				$this->load->view('msg/msgupload.php', $data);
				$this->load->view('plantilla/footer');

		}//fin del if else
	}

	/*
		metodo que muestra el formularaio de la nomina de estudiantes
	*/
	public function nomina_estudiantes()
	{
		$data['nivel'] = $this->Nivel_model->getNivel();
		$data['titulo'] = 'Nomina de Estudiantes Por Grado';
		$data['activo'] = 'estudiante';
		$this->load->view('plantilla/header', $data);
		$this->load->view('reportes/nominaestudiantes', $data);
		$this->load->view('plantilla/footer');
	}

	/*
		metodo para obtner a todos los estudiantes de un nivel y un grado de un ciclo academico
	*/
	public function listado_estudiantes()
	{
		$nivel = $this->input->get('nivel');
		$carrera = $this->input->get('carrera');
		$ciclo = date('Y').'-00-00';
		$grado = $this->input->get('grado');
		if ($nivel == 4) {
			$data = $this->Estudiante_model->getNominaEstudiantesGC($nivel, $carrera, $grado, $ciclo);
		} else {
			if ($nivel == 5) {
				//estudiantes de básico por madurez
				$data = $this->Estudiante_model->getNominaEstudiantesGM($nivel, $grado, $ciclo);
			}else {
				//estudiantes de nivel pre-primaria, primaria y básico
				$data = $this->Estudiante_model->getNominaEstudiantesG($nivel, $grado, $ciclo);
			}
		}
		echo json_encode($data);
	}

	/*
	nomina para buscar a los estudiantes de un grado de una carrera
	*/
	public function nomina_estudiantesc()
	{
		$carrera = $this->input->get('carrera');
		$ciclo = date('Y').'-00-00';
		$grado = $this->input->get('grado');
		$nivel = 4;
		$data = $this->Estudiante_model->getNominaEstudiantesGC($nivel, $carrera, $grado, $ciclo);
		echo json_encode($data);
	}

	/*
	metodo para buscar los datos de un estudiante por su id
	*/
	public function buscar_estudianteId()
	{
		$id = $this->input->get('id');
		$datos = $this->Estudiante_model->findEstudianteId($id);
		echo json_encode($datos);
	}//fin del metodo

	/*
			metodo para actulizar los datos de un estudiante por medio de una peticion ajax
	*/
	public function actualizar_estudianteId()
	{
		$id = $this->input->post('id');
		$nombre = $this->input->post('nombre');
		$apellidos = $this->input->post('apellidos');
		$codigo  = $this->input->post('codigo');
		$cui = $this->input->post('cui');
		$nacimiento = $this->input->post('nacimiento');
		$genero = $this->input->post('genero');
		$result = $this->Estudiante_model->updateEstudiante($id, $nombre, $apellidos, $nacimiento, $genero, $codigo, $cui);
		echo $result->msg;
	}//fin del metodo
}

/* End of file Estudiante.php */
/* Location: ./application/controllers/Estudiante.php */

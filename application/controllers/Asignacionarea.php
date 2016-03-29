<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asignacionarea extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Area_model');
		$this->load->model('Nivel_model');
		$this->load->model('Asignacionarea_model');
		$this->load->model('Carrera_model');
		$this->load->model('Grado_model');
		$this->load->model('Gradocarrera_model');
	}
	public function index()
	{
		if ( ! file_exists(APPPATH.'/views/secretaria/nasignacionarea.php'))
        {
                // si no existe el recurso mostramos el mensaje de error 404
                show_404();
        }
        $data['nivel'] = $this->Nivel_model->getNivel2();
        $data['area'] = $this->Area_model->getArea();
        $dato['titulo'] ="Nueva asignacion - area";
        $dato['activo'] = 'asignacion area';
		$this->load->view('plantilla/header', $dato);
		$this->load->view('secretaria/nasignacionarea', $data);
		$this->load->view('plantilla/footer');
	}

	public function nueva_asignacion()
	{
		$this->form_validation->set_rules('area[]', 'Area', 'trim|required');
		$this->form_validation->set_rules('nivel', 'Nivel', 'trim|required');
		$this->form_validation->set_rules('grados[]', 'Grado', 'trim|required');
		$this->form_validation->set_message('required','Debe de seleccionar o checkear al menos una opcion del campo %s');
		
		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$area = $this->input->post('area[]');
			$nivel = $this->input->post('nivel');
			$grados = $this->input->post('grados[]');

			$contador = 0;
			for ($i=0; $i < count($grados); $i++) 
			{ 
				for ($j=0; $j < count($area); $j++) 
				{
					$codigo = $j +1;
					$valor = $this->Asignacionarea_model->setAsignacionarea($area[$j], $nivel, $grados[$i], $codigo);
					if ($valor == 0) {
						$contador++;
					}
				}
			}
			if ($contador > 0) {
				$data['msg'] = 'Una o mas asignaciones no se pudieron registrar porque ya existen';
			}
			else
			{
				$data['msg'] = 'Todas las asignaciónes se han realizado exitosamente';
			}

			$data['titulo'] = 'Mensaje del sistema';
			$data['activo'] = 'ninguno';
			$this->load->view('plantilla/header', $data);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');	
		}
	}

	public function asignacionc()
	{
		if (! file_exists(APPPATH.'views/secretaria/nasignacionc.php')) 
		{
			# si no existe el recurso mostramos el mensaje de erro 404
			show_404();
		}
		$data['carrera'] = $this->Carrera_model->getCarrera();
		$data['area'] = $this->Area_model->getArea(); 
		$dato['titulo'] = 'Nueva asignación - area';
		$dato['activo'] = 'asignacion area';
		$this->load->view('plantilla/header', $dato);
		$this->load->view('secretaria/nasignacionc', $data);
		$this->load->view('plantilla/footer');
	}
	public function nueva_asignacionc()
	{
		$this->form_validation->set_rules('carrera', 'Carrera', 'trim|required');
		$this->form_validation->set_rules('grados', 'Grado', 'trim|required');
		$this->form_validation->set_rules('areas[]', 'Area', 'trim|required');
		$this->form_validation->set_message('required', 'El campo %s es obligatorio debe seleccionar o chequear al menos una opcion segun sea el caso');

		if ($this->form_validation->run() == FALSE) {
			$this->asignacionc();
		} else {
			$carrera = $this->input->post('carrera');
			$grado = $this->input->post('grados');
			$area = $this->input->post('areas[]');

			$idGradoCarrera = $this->Gradocarrera_model->setGradocarrera($grado, $carrera);

			$contador = 0;
			for ($i=0; $i < count($area); $i++) 
			{ 
				$codigo = $i+1;
				$resultado = $this->Asignacionarea_model->setAsignacionareac($area[$i], $idGradoCarrera, $codigo);
				if ($resultado == 0) 
				{
					$contador++;
				}	
			}
			if ($contador > 0) 
			{
				$data['msg'] = 'Algunas Asignaciones se omitieron porque ya existen';
			}
			else
			{
				$data['msg'] = 'Todas las asignaciones se realizaron con exito';
			}
			$dato['titulo'] = 'Mensaje del sistema';
			$dato['activo'] = 'ninguno';
			$this->load->view('plantilla/header', $dato);
			$this->load->view('msg/listo', $data);
			$this->load->view('plantilla/footer');
			
		}
	}
}

/* End of file Asignacionarea.php */
/* Location: ./application/controllers/Asignacionarea.php */
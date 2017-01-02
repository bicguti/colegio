<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendariocuadros extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Calendario_model', 'calendario');
  }

  function index()
  {
    //$data['datos'] = $this->calendario->getCalendario();
    $data['titulo'] = 'Calendario Entrega de Cuadros';
    $data['activo'] = 'cuadros';
    $this->load->view('plantilla/header', $data);
    $this->load->view('editar/editarcalendarios', $data);
    $this->load->view('plantilla/footer');
  }

  /*
    metodo que muestra el formulario para editar la fecha de entrega de los cuadros en cada bloque
  */
  public function editar_calendarios()
  {
    $valor = $this->input->post('calendario');
    $data['datos'] = $this->calendario->getCalendario();
    $data['opcion'] = $valor;
    $data['titulo'] = 'Calendario de Entrega de Cuadros';
    $data['activo'] = 'cuadros';
    $this->load->view('plantilla/header', $data);
    $this->load->view('editar/editarcalendario', $data);
    $this->load->view('plantilla/footer');
  }

  /*
    metodo que guarda las nuevas fechas de entrega de cuadros de cada bloque
  */
  public function guardar_fechas()
  {
    $this->form_validation->set_rules('uno', 'Bloque I', 'required|trim|max_length[40]');
    $this->form_validation->set_rules('dos', 'Bloque II', 'required|trim|max_length[40]');
    $this->form_validation->set_rules('tres', 'Bloque III', 'required|trim|max_length[40]');
    $this->form_validation->set_rules('cuatro', 'Bloque IV', 'required|trim|max_length[40]');
    if ($this->form_validation->run() == false) {
      $this->editar_calendarios();
    } else {
      $buno = $this->input->post('uno');
      $bdos = $this->input->post('dos');
      $btres = $this->input->post('tres');
      $bcuatro = $this->input->post('cuatro');
      $opcion = $this->input->post('opcion');
      switch ($opcion) {
        case 1:
          $this->calendario->updateCalendarioComple($buno, $bdos, $btres, $bcuatro);
          $data['msg'] = 'Se ha editado la fecha de entrega de los cuadros del nivel Pre-Primario y Primario de las áreas complementarias';
          break;
        case 2:
          $this->calendario->updateCalendarioPrinci($buno, $bdos, $btres, $bcuatro);
          $data['msg'] = 'Se ha editado la fecha de entrega de los cuadros del nivel Pre-Primario y Primario de las áreas principales';
          break;
        case 3:
          $this->calendario->updateCalendarioBD($buno, $bdos, $btres, $bcuatro);
          $data['msg'] = 'Se ha editado la fecha de entrega de los cuadros del nivel Básico y Diversificado';
          break;
        case 4:
          # code...
          break;
      }//fin del case
    }//fin del if else
    $data['titulo'] = 'Mensaje del Sistema';
    $data['activo'] = '';
    $this->load->view('plantilla/header', $data);
    $this->load->view('msg/listo', $data);
    $this->load->view('plantilla/footer');
  }

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Escala_valores extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {
    $data['titulo'] = 'Escala de Valores Humanos';
    $data['activo'] = 'notas';
    $this->load->view('plantilla/header', $data);
    $this->load->view('escala/index', $data);
    $this->load->view('plantilla/footer');
  }

}

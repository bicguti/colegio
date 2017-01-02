<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendario_model extends CI_Model{
  public function getCalendario()
  {
    $query = $this->db->get('CALENDARIO_ENTREGA_CUADROS');
    return $query->result_array();
  }

  /*
    metodo para editar las fechas de entrega de los cuadros para
    el ciclo academico actual
  */
  public function updateCalendarioComple($b1, $b2, $b3, $b4)
  {
    $this->db->query('call editar_calendario_complementarios("'.$b1.'", "'.$b2.'", "'.$b3.'", "'.$b4.'");');
  }

  /*
    metodo para editar las fechas de entrega de los cuadros de las
    areas complementarias del ciclo academico actual
  */
  public function updateCalendarioPrinci($b1, $b2, $b3, $b4)
  {
    $this->db->query('call editar_calendario_principales("'.$b1.'", "'.$b2.'", "'.$b3.'", "'.$b4.'");');
  }

  /*
    metodo para editar las fechas de entrega de los cuadros de
    todas las areas de básico y diversificado
  */
  public function updateCalendarioBD($b1, $b2, $b3, $b4)
  {
    $this->db->query('call editar_calendario_DB("'.$b1.'", "'.$b2.'", "'.$b3.'", "'.$b4.'");');
  }
  
}

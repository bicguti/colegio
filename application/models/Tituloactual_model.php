<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tituloactual_model extends CI_Model {
	/*
		metodo que obtiene todos los titulos academicos que estan registrados en la base de datos
	*/
	public function getTituloactual()
	{
		$query=$this->db->get('TITULO_ACTUAL');
		return $query->result_array();
	}
	
	/*
		metodo para registrar un nuevo nombre de titulo academico
	*/
	public function setTitulo($nombre)
	{
		$query = $this->db->query('call nuevo_titulo_aca("'.$nombre.'");');
		$aux = $query->row();
		return $aux->msg;
	}

	/*
		metodo para editar el nombre de un título en la base de datos
	*/
	public function update_titulo($titulo, $nombre)
	{
		$this->db->query('call editar_titulo('.$titulo.', "'.$nombre.'")');
	}

}

/* End of file Tituloactual_model.php */
/* Location: ./application/models/Tituloactual_model.php */
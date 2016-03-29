<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asignacionarea_model extends CI_Model {
	public function setAsignacionarea($area, $nivel, $grado, $codigoarea)//asignacion de cursos para el nivel preprimario, primario y diversificado.
	{
		$query = $this->db->query('call nueva_asignacionarea('.$area.','.$nivel.','.$grado.','.$codigoarea.');');
		$aux = $query->row();
		$dato = $aux->val;
		$query->next_result();
		return $dato;
	}
	
	public function setAsignacionareac($area, $gradocarrera, $codigoarea)//nueva asignación para el area para el nivel diversificado
	{
		$query = $this->db->query('call nueva_asignacionareac('.$area.', '.$gradocarrera.','.$codigoarea.');');
		$aux = $query->row();
		$dato = $aux->valor;
		$query->next_result();
		return $dato;
	}

	public function getDatosasignacion($asignacionarea)//obtiene el nombre del area, nombre del grado y nombre del nivel 
	{
		$query = $this->db->query('select a.nombre_area, g.nombre_grado, n.nombre_nivel 
from ASIGNACION_AREA aa inner join AREAS a
on aa.id_area = a.id_area inner join GRADO g
on aa.id_grado = g.id_grado inner join NIVEL n
on aa.id_nivel = n.id_nivel
where aa.id_asignacion_area = '.$asignacionarea.';');
		return $query->result_array();
	}

	public function getDatosasignacionD($asignacionarea)//obtiene el area, nombre del grado y carrera del nivel diversificado
	{
		$query = $this->db->query('select a.nombre_area, g.nombre_grado, c.nombre_carrera
from ASIGNACION_AREA_CARRERA aac inner join GRADO_CARRERA gc
on aac.id_grado_carrera = gc.id_grado_carrera inner join CARRERA c
on gc.id_carrera = c.id_carrera inner join GRADO g
on gc.id_grado = g.id_grado inner join AREAS a
on aac.id_area = a.id_area
where aac.id_asignacion_areac = '.$asignacionarea.';');
		return $query->result_array();
	}

	public function getIdAsignacionArea($nivel, $grado)//obtiene el id de asignacion de area del nivel preprimario, primario y básico.
	{
		$query = $this->db->query('select id_asignacion_area from ASIGNACION_AREA where id_nivel = '.$nivel.' and id_grado = '.$grado.';');
		return $query->result_array();
	}

	public function getIdAsignacionAreaD($gradocarrera)
	{
		$query = $this->db->get_where('ASIGNACION_AREA_CARRERA', array('id_grado_carrera'=>$gradocarrera));
		return $query->result_array();
	}

}

/* End of file Asignacionarea_model.php */
/* Location: ./application/models/Asignacionarea_model.php */
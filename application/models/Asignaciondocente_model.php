<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asignaciondocente_model extends CI_Model {
	public function getAreasPB($nivel, $grado)//obtiene todas las areas de primeria y basico correspondientes a un grado
	{
		$query = $this->db->query('call obtener_cursosgradoPB('.$nivel.','.$grado.');');
		return $query->result_array();
	}
	
	public function getAreasD($grado, $carrera)//obtiene todas las areas de un grado y carrera en especifico.
	{
		$query = $this->db->query('call obtener_cursosgradoD('.$grado.','.$carrera.')');
		return $query->result_array();
	}

	public function setAsignacion($fecha, $persona)//Agrega una nueva asignacion
	{
		$query = $this->db->query('call nueva_asignacionDocente("'.$fecha.'",'.$persona.');');
		$aux = $query->row();
		$dato = $aux->id;
		$query->next_result();
		return $dato;
	}

	public function setDetalleAsignacion($asignacion, $asignacionarea)//agrega el detalle de la asignacion para el nivel, preprimario, primario y básico
	{
		$query = $this->db->query('call nuevo_detalleAsignacionD('.$asignacion.','.$asignacionarea.');');
	}

	public function setDetalleAsignacionD($asignacion, $areacarrera)//agrega el detalle de la asignacion para el nivel diversificado
	{
		$query = $this->db->query('call nuevo_detalleAsignacionDC('.$asignacion.','.$areacarrera.');');
	}


	public function findAreasAsignadasDocente($persona)//busca los cursos que ternga asignado un docente del nivel pre-primario, primario y básico
	{
		$this->db->select('n.nombre_nivel, g.nombre_grado, a.nombre_area, aa.id_asignacion_area');
		$this->db->from('ASIGNACION_DOCENTE ad');
		$this->db->join('DETALLE_ASIGNACION_DOCENTE dad', 'ad.id_asignacion = dad.id_asignacion', 'inner');
		$this->db->join('ASIGNACION_AREA aa', 'dad.id_asignacion_area = aa.id_asignacion_area', 'inner');
		$this->db->join('AREAS a', 'aa.id_area = a.id_area', 'inner');
		$this->db->join('NIVEL n', 'aa.id_nivel = n.id_nivel', 'inner');
		$this->db->join('GRADO g', 'aa.id_grado = g.id_grado', 'inner');
		$this->db->where('ad.id_persona', $persona);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function findAreasAsignadasDocenteD($persona)//metodo que busca los cursos que tenga asignado un docente del niver diversificado
	{
		$this->db->select('n.nombre_nivel, g.nombre_grado, c.nombre_carrera, a.nombre_area, aac.id_asignacion_areac');
		$this->db->from('ASIGNACION_DOCENTE ad');
		$this->db->join('DETALLE_ASIGNACION_DOCENTE_C dadc', 'ad.id_asignacion = dadc.id_asignacion', 'inner');
		$this->db->join('ASIGNACION_AREA_CARRERA aac', 'dadc.id_asignacion_areac = aac.id_asignacion_areac', 'inner');
		$this->db->join('AREAS a', 'aac.id_area = a.id_area', 'inner');
		$this->db->join('GRADO_CARRERA gc', 'aac.id_grado_carrera = gc.id_grado_carrera', 'inner');
		$this->db->join('CARRERA c', 'gc.id_carrera = c.id_carrera', 'inner');
		$this->db->join('GRADO g', 'gc.id_grado = g.id_grado', 'inner');
		$this->db->join('NIVEL_PLAN np', 'c.id_nivel_plan = np.id_nivel_plan', 'inner');
		$this->db->join('NIVEL n', 'np.id_nivel = n.id_nivel', 'inner');
		$this->db->where('ad.id_persona', $persona);
		$query = $this->db->get();
		return $query->result_array();
	}

	
}

/* End of file Asignaciondocente_model.php */
/* Location: ./application/models/Asignaciondocente_model.php */
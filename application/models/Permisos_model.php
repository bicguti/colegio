<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permisos_model extends CI_Model {
	public function setPermisos($idusuario, $idopcion)//agerga los permisos para las opciones que tendra disponible
	{
		$query = $this->db->query('call nuevos_permisosUsuario('.$idusuario.', '.$idopcion.');');
	}
	
	public function setSubPermisos($permisoUsuario, $subopcion)//agrega las subopciones que seran las opciones que podra utilizar
	{
		$query = $this->db->query('call nuevos_subpermisosUsuario('.$permisoUsuario.', '.$subopcion.');');
	}

	public function getPermisosUsuario($usuario)//busca todas las opciones asignadas de un determinado usuario
	{
		$query = $this->db->get_where('PERMISOS_USUARIO', array('id_usuario'=>$usuario));
		return $query->result_array();
	}

	public function getDatosPermisos($subopcion, $opcion)
	{
		$this->db->select('nombre_opcion, nombre_sub_opcion');
		$this->db->from('SUB_OPCIONES so');
		$this->db->join('OPCIONES o', 'so.id_opcion = o.id_opcion', 'inner');
		$this->db->where('so.id_sub_opcion', $subopcion);
		$this->db->where('so.id_opcion', $opcion);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function findSubPermisosUsuario($usuario)//busca todos los sub permisos asignado al usuario
	{												//selecciona todo aquellos que esten activos.
		$this->db->select('u.id_persona, o.nombre_opcion, so.nombre_sub_opcion, so.url_subopcion');
		$this->db->from('USUARIOS u');
		$this->db->join('PERMISOS_USUARIO pu', 'u.id_usuario = pu.id_usuario', 'inner');
		$this->db->join('SUB_PERMISOS_USUARIO spu', 'pu.id_permiso_usuario = spu.id_permiso_usuario', 'inner');
		$this->db->join('SUB_OPCIONES so', 'spu.id_sub_opcion = so.id_sub_opcion', 'inner');
		$this->db->join('OPCIONES o', 'so.id_opcion = o.id_opcion', 'inner');
		$this->db->where('u.id_usuario', $usuario);
		$this->db->where('spu.estado_sub_permiso', TRUE);
		$this->db->order_by('so.id_sub_opcion', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}
}

/* End of file Permisos_model.php */
/* Location: ./application/models/Permisos_model.php */
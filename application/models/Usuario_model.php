<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {
	public function setUsuario($usuario, $contrasena, $persona)
	{
		$query = $this->db->query('call nuevo_usuario("'.$usuario.'", "'.$contrasena.'", '.$persona.');');
		$aux = $query->row();
		$dato = $aux->id;
		$query->next_result();
		return $dato;
	}

	public function getUsuario($nombre)//busca los datos del nombre de usuario que se envia como parametro
	{
		$this->db->select('*');
		$this->db->from('USUARIOS');
		$this->db->where('nombre_usuario', $nombre);
		$this->db->where('estado_usuario', TRUE);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*metodo que busca el nombre de usuario de la persona autenticada*/
	public function findUsuario($persona)
	{
		$this->db->select('*');
		$this->db->from('USUARIOS');
		$this->db->where('id_persona', $persona);
		$query = $this->db->get();
		return $query->result_array();
	}

	/*metodo para modificar la contraseña de un usuario*/
	public function updateContrasena($persona, $npass)
	{
		$this->db->query('call editar_contrasena_usuario('.$persona.', "'.$npass.'");');
	}

	/*
	 	metodo que busca todos los permisos asignados a una persona con su usuario
	*/
	 public function findPermisosUsuario($persona)
	 {
	 	$this->db->select('u.id_usuario, p.apellidos_persona, p.nombre_persona, o.nombre_opcion, so.nombre_sub_opcion, spu.estado_sub_permiso, spu.id_subpermisos_usuario');
	 	$this->db->from('PERSONA p');
	 	$this->db->join('USUARIOS u', 'p.id_persona = u.id_persona', 'inner');
	 	$this->db->join('PERMISOS_USUARIO pu', 'u.id_usuario = pu.id_usuario', 'inner');
	 	$this->db->join('SUB_PERMISOS_USUARIO spu', 'pu.id_permiso_usuario = spu.id_permiso_usuario', 'inner');
	 	$this->db->join('SUB_OPCIONES so', 'spu.id_sub_opcion = so.id_sub_opcion', 'inner');
	 	$this->db->join('OPCIONES o', 'pu.id_opcion = o.id_opcion', 'inner');
	 	$this->db->where('p.id_persona', $persona);
	 	$query = $this->db->get();
	 	return $query->result_array();
	 }

	 /*
			metodo para editar el estado de un permiso que tenga asignado un usuario
			ya se para habilitar o deshabilitar
	 */
		public function updatePermiso($id, $estado)
		{
			$query = $this->db->query('call editar_permiso_usuario('.$id.', '.$estado.');');
			$aux = $query->row();
			return $aux->msg;
		}

		/*
			metodo que busca si la opción ya esta asignada al usuario, entonces obtiene
			el id_permiso_usuario
		*/
		public function searchPermisoUsuario($usuario, $opcion)
		{
			$this->db->select('pu.id_permiso_usuario');
			$this->db->from('PERMISOS_USUARIO pu');
			$this->db->where('pu.id_usuario', $usuario);
			$this->db->where('pu.id_opcion', $opcion);
			$query = $this->db->get();
			return $query->result_array();
		}
}

/* End of file Usuario_model.php */
/* Location: ./application/models/Usuario_model.php */

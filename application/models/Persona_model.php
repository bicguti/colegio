<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persona_model extends CI_Model {
	public function setPersona($puesto, $nombres, $apellidos, $dpi, $tel1, $tel2, $correo, $nit, $genero, $direccion, $nacimiento, $nacionalidad, $lateralidad, $estadoCivil, $titulo, $institucionTitulo, $fechaInicio)
	{
		$query=$this->db->query('CALL nueva_persona('.$puesto.', "'.$nombres.'", "'.$apellidos.'", "'.$dpi.'", "'.$tel1.'", "'.$tel2.'", "'.$correo.'", "'.$nit.'", '.$genero.', '.$direccion.', '.$nacimiento.', '.$nacionalidad.', '.$lateralidad.', '.$estadoCivil.', '.$titulo.', "'.$institucionTitulo.'", "'.$fechaInicio.'");');
		
	}
	public function existePersona($dpi)//verificar si existe una persona en la base de datos con el dpi especificado
	{
		$query=$this->db->query('select buscar_existencia_persona("'.$dpi.'") as existe');
		$aux = $query->row();
		$dato=$aux->existe;
		return $dato;
	}
	public function setNacimiento($fecha, $municipio)//insertar una nueva fecha de nacimiento y municipio de nacimiento
	{
		$query = $this->db->query('CALL nuevo_nacimiento("'.$fecha.'", '.$municipio.')');
		$aux = $query->row();
		$dato = $aux->nacimiento;
		$query->next_result();
		return $dato;
	}
	public function setDireccion($direccion, $municipio)//insertar una nueva direccion de residencia en la base de datos
	{
		$query = $this->db->query('CALL nueva_direccResi("'.$direccion.'", '.$municipio.')');
		$aux = $query->row();
		$dato = $aux->direccion;
		$query->next_result();
		return $dato;
	}

	public function findDocente($contiene)//metodo que busca una persona que tiene el puesto de docente, por su apellido y obtiene su id, nombres, apellidos y puesto.
	{
		$contiene = $contiene.'%';
		$query = $this->db->query('select p.id_persona, p.nombre_persona, p.apellidos_persona, pp.nombre_puesto 
	from PERSONA p inner join PUESTO pp
	on p.id_puesto = pp.id_puesto
	where pp.nombre_puesto = "docente" and p.apellidos_persona like concat("'.$contiene.'");');
		return $query->result_array();
	}

	public function nomapeDocente($id)//obtien los nombres y apellidos de una persona que es identificado con su id
	{
		$query = $this->db->query('select* from PERSONA p inner join PUESTO pp on p.id_puesto = pp.id_puesto where id_persona = "'.$id.'";');
		return $query->result_array();
	}

	public function getPersonas($value='')//obtiene todos los registro de todas las persona que estan activas en el sistema
	{									//los datos que obtine son nombres, apellidos, telefono, correo, nit, dpi, fecha de inicio, puesto y el di de la persona.	
		$query = $this->db->query('call listado_personas();');
		return $query->result_array();
	}

	public function findPersona($iniciales)//metodo que busca una persona por las iniciales de su apellido 
	{
		$iniciales = $iniciales.'%';
		$query = $this->db->query('select p.id_persona, p.nombre_persona, p.apellidos_persona, pp.nombre_puesto 
from PERSONA p inner join PUESTO pp
on p.id_puesto = pp.id_puesto
where estado_persona = TRUE and apellidos_persona like "'.$iniciales.'";');
		return $query->result_array();
	}

	public function getPersona($id)//Metodo que busca a una persona por su identificador
	{
		$this->db->select('nombre_persona, apellidos_persona');
		$this->db->from('PERSONA');
		$this->db->where('id_persona', $id);
		$query = $this->db->get();
		return $query->result_array();
	}
}

/* End of file Persona_model.php */
/* Location: ./application/models/Persona_model.php */
<?php
 
class Model_modulo extends CI_Model {
 
	/**
	* Obtiene los datos de todos los módulos de la base de datos
	*
	* Se crea la consulta y luego se ejecuta ésta. Luego con un ciclo se va extrayendo la información de cada módulo y se va guardando en un arreglo de dos dimensiones
	* Finalmente se retorna la lista con los datos. 
	*
	* @return array $lista Contiene la información de todos los módulos del sistema
	*/	
	public function profesEditarModulo($cod_equipo){
		$this->db->select('*');
		$this->db->from('profesor');
		$query = $this->db->get();	
		$datos = $query->result();
		$contador = 0;
		$profes = array();
		foreach ($datos as $row) {  
			$profes[$contador] = array();
			$profes[$contador][0] = "";
			$profes[$contador][1] = $row->RUT_USUARIO2;
			$profes[$contador][2] = $row->NOMBRE1_PROFESOR;
			$profes[$contador][3] = $row->NOMBRE2_PROFESOR;
			$profes[$contador][4] = $row->APELLIDO1_PROFESOR;
			$profes[$contador][5] = $row->APELLIDO2_PROFESOR;
			$profes[$contador][6] = 0;
			$contador = $contador + 1;
		}
		
		$this->db->select('*');
		$this->db->from('profe_equi_lider');
		$query = $this->db->get();	
		$datos = $query->result();
		
		$contador = 0;
		$lista = array();
		foreach ($datos as $row) {  
			$lista[$contador] = array();
			$lista[$contador][0] = $row->COD_EQUIPO;
			$lista[$contador][1] = $row->RUT_USUARIO2;
			$lista[$contador][2] = $row->LIDER_PROFESOR;
			$contador = $contador + 1;
		}
		$contador = 0;
		$contador2 = 0;
		while($contador < count($profes)){
			while($contador2 < count($lista)){
				if($profes[$contador][1] == $lista[$contador2][1]){
					$profes[$contador][0] = $lista[$contador2][0];
					if($lista[$contador2][2] == 1){
						$profes[$contador][6] = 1;
					}
				}
				$contador2++;
			}
			$contador2 = 0;
			$contador++;
		}
		return $profes;
	}
	
	public function VerModulos(){
		$query = $this->db->get('modulo_tematico');
		if ($query == FALSE) {
			return array();
		}
		$datos = $query->result();
		$contador = 0;
		$lista = array();
		foreach ($datos as $row) {  
			$lista[$contador] = array();
			$lista[$contador][0] = $row->COD_MODULO_TEM;
			$lista[$contador][2] = $row->COD_EQUIPO;
			$lista[$contador][3] = $row->NOMBRE_MODULO;
			$lista[$contador][4] = $row->DESCRIPCION_MODULO;
			$contador = $contador + 1;
		}
		return $lista;
	}
	
	public function VerEquipoModulo(){
		$this->db->select('*');
		$this->db->from('profesor');
		$this->db->join('profe_equi_lider', 'profe_equi_lider.rut_usuario2 = profesor.rut_usuario2');
		$query = $this->db->get();
		if ($query == FALSE) {
			return array();
		}
		$datos = $query->result();
		$contador = 0;
		$lista = array();
		foreach ($datos as $row) { 
			$lista[$contador] = array();
			$lista[$contador][0] = $row->COD_EQUIPO;
			$lista[$contador][1] = $row->RUT_USUARIO2;
			$lista[$contador][2] = $row->NOMBRE1_PROFESOR;
			$lista[$contador][3] = $row->NOMBRE2_PROFESOR;
			$lista[$contador][4] = $row->APELLIDO1_PROFESOR;
			$lista[$contador][5] = $row->APELLIDO2_PROFESOR;
			$contador = $contador + 1;
		}
		return $lista;
	}
	
	
	public function VerRequisitoModulo(){
		$this->db->select('*');
		$this->db->from('requisito_modulo');
		$this->db->join('requisito', 'requisito.cod_requisito = requisito_modulo.cod_requisito');
		$query = $this->db->get();	
		if ($query == FALSE) {
			return array();
		}
		
		$datos = $query->result();
		$contador = 0;
		$lista = array();
		foreach ($datos as $row) {  
			$lista[$contador] = array();
			$lista[$contador][0] = $row->COD_MODULO_TEM;
			$lista[$contador][1] = $row->COD_REQUISITO;
			$lista[$contador][2] = $row->NOMBRE_REQUISITO;
			$contador = $contador + 1;
		}
		return $lista;
	}
		
	public function listaNombreModulos(){	
  		$query = $this->db->get('modulo_tematico');	
		if ($query == FALSE) {
			return array();
		}
		$datos = $query->result();
   		$lista = array();
   		$contador = 0;
   		foreach ($datos as $row) {
   			$lista[$contador] = $row->NOMBRE_MODULO;
            $contador++;
   		}
   		return $lista;  	
	}
	
	public function listaSesionesParaAddModulo(){
		$query = $this->db->get('sesion');	
		if ($query == FALSE) {
			return array();
		}
		$datos = $query->result(); 
		$contador = 0;
		$lista = array();
		foreach ($datos as $row) { 
			$lista[$contador] = array();
			$lista[$contador][0] = $row->COD_SESION;
			$lista[$contador][1] = $row->COD_MODULO_TEM;
			$lista[$contador][2] = $row->DESCRIPCION_SESION;
			$lista[$contador][3] = $row->NOMBRE_SESION;
			$contador = $contador + 1;
		}
		return $lista;
	}
	
	public function listaRequisitosParaAddModulo(){
		$query = $this->db->get('requisito');	
		$datos = $query->result(); 
		$contador = 0;
		$lista = array();
		foreach ($datos as $row) { 
			$lista[$contador] = array();
			$lista[$contador][0] = $row->COD_REQUISITO;
			$lista[$contador][1] = $row->NOMBRE_REQUISITO;
			$lista[$contador][2] = $row->DESCRIPCION_REQUISITO;
			$contador = $contador + 1;
		}
		return $lista;
	}

	public function listaRequisitosParaEditarModulo($cod_mod){
		
		$query = $this->db->get('requisito');	
		$datos = $query->result(); 
		$contador = 0;
		$lista_r = array();
		foreach ($datos as $row) { 
			$lista_r[$contador] = array();
			$lista_r[$contador][0] = $row->COD_REQUISITO;
			$lista_r[$contador][1] = $row->NOMBRE_REQUISITO;
			$lista_r[$contador][2] = $row->DESCRIPCION_REQUISITO;
			$lista_r[$contador][3] = 0;
			$contador = $contador + 1;
		}
		
		$this->db->select('COD_REQUISITO');
		$this->db->select('COD_MODULO_TEM');
		$this->db->from('requisito_modulo');
		$query = $this->db->get();	
	    $datos = $query->result();
		$contador = 0;
		$lista = array();
		if($query->num_rows() > 0){
			foreach ($datos as $row) {  
				$lista[$contador] = array();
				$lista[$contador][0] = $row->COD_MODULO_TEM;
				$lista[$contador][1] = $row->COD_REQUISITO;
				$contador = $contador + 1;
			}
		}
		
		$contador = 0;
		$contador2 = 0;
		while($contador < count($lista_r)){
			while($contador2 < count($lista)){
				if($listar[$contador][0] == $lista[$contador2][1] && $cod_mod == $lista[$contador2][0]){
					$listar[$contador][3] = 1;
				}
				$contador2++;
			}
			$contador2 = 0;
			$contador++;
		}
		return $lista_r;
	}
	

	public function InsertarModulo($nombre_modulo,$sesiones,$descripcion_modulo,$profesor_lider,$equipo_profesores,$requisitos){
			//0 insertar modulo
			$data = array(					
					'NOMBRE_MODULO' => $nombre_modulo ,
					'DESCRIPCION_MODULO' => $descripcion_modulo 
					);
			$confirmacion0 = $this->db->insert('modulo_tematico',$data);
			//
			$cod_modulo = $this->db->insert_id();
			
			//1 insertar equipo
			$data = array(					
					'COD_MODULO_TEM' => $cod_modulo
				);
			$confirmacion1 = $this->db->insert('equipo_profesor',$data);
			//
			$cod_equipo = $this->db->insert_id();	
			
			//actualizar mod_tem 4
			$data = array(					
					'COD_EQUIPO'=>$cod_equipo
			);
			$this->db->where('COD_MODULO_TEM', $cod_modulo);
			$confirmacion4 = $this->db->update('modulo_tematico',$data);
			//
			
			//2 insertar equipo profesores			
			$contador = 0;
			$confirmacion2 = true;
			while ($contador<count($equipo_profesores)){
			$data = array(					
					'RUT_USUARIO2' => $equipo_profesores[$contador],
					'COD_EQUIPO' => $cod_equipo,
					'LIDER_PROFESOR' => 0 
					);
			$datos = $this->db->insert('profe_equi_lider',$data);
				if($datos != true){
					$confirmacion2 = false;
				}
	
			$contador = $contador + 1;
			}
			$data = array(					
					'RUT_USUARIO2' => $profesor_lider,
					'COD_EQUIPO' => $cod_equipo,
					'LIDER_PROFESOR' => 1 
					);
			$datos = $this->db->insert('profe_equi_lider',$data);
			
			//3 asignar modulo a sesiones
			$contador = 0;
			$confirmacion3 = true;
			while ($contador<count($sesiones)){
			$data = array(					
					'COD_MODULO_TEM' => $cod_modulo
					);
					$this->db->where('COD_SESION', $sesiones[$contador]);
					$datos = $this->db->update('sesion',$data);

				if($datos != true){
					$confirmacion3 = false;
				}
	
				$contador = $contador + 1;
			}
			//5 insertar requisito modulo		
			$contador = 0;
			$confirmacion5 = true;
			while ($contador<count($requisitos)){
			$data = array(					
					'COD_REQUISITO' => $requisitos[$contador],
					'COD_MODULO_TEM' => $cod_modulo
					);
			$datos = $this->db->insert('requisito_modulo',$data);
				if($datos != true){
					$confirmacion5 = false;
				}
	
			$contador = $contador + 1;
			}
			//fin inserciones
			if($confirmacion0 == false || $confirmacion1 == false || $confirmacion2 == false || $confirmacion3 == false || $confirmacion4 == false || $confirmacion5 == false){
				return -1;
				}
			return 1;
	}
	


	public function EliminarModulo($cod_modulo)
    {
		$this->db->where('cod_modulo_tem', $cod_modulo);
		$datos = $this->db->delete('modulo_tematico'); 		
		if($datos == true){
			return 1;
		}
		else{
			return -1;
		}
    }
	public function getAllModulos()
	{
		$this->db->select('COD_MODULO_TEM AS cod_mod');
		$this->db->select('COD_EQUIPO AS cod_equipo');
		$this->db->select('NOMBRE_MODULO AS nombre_mod');
		$this->db->select('DESCRIPCION_MODULO AS descripcion');
		$this->db->order_by('NOMBRE_MODULO','asc');
		$query = $this->db->get('modulo_tematico');
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}

	public function EditarModulo($nombre_modulo,$sesiones,$descripcion_modulo,$profesor_lider,$equipo_profesores,$requisitos,$cod_equipo,$cod_mod){
		//0 insertar modulo
		$data = array(					
				'NOMBRE_MODULO' => $nombre_modulo ,
				'DESCRIPCION_MODULO' => $descripcion_modulo 
				);
		$this->db->where('cod_modulo_tem', $cod_mod);
		$confirmacion0 = $this->db->update('modulo_tematico',$data);

		//2 actualizar equipo profesores
		$this->db->delete('profe_equi_lider', array('cod_equipo' => $cod_equipo)); 
		
		
		$contador = 0;
		$confirmacion2 = true;
		while ($contador<count($equipo_profesores)){
		$data = array(					
				'RUT_USUARIO2' => $equipo_profesores[$contador],
				'COD_EQUIPO' => $cod_equipo,
				'LIDER_PROFESOR' => 0 
				);
		$datos = $this->db->insert('profe_equi_lider',$data);
			if($datos != true){
				$confirmacion2 = false;
			}

		$contador = $contador + 1;
		}
		$data = array(					
				'RUT_USUARIO2' => $profesor_lider,
				'COD_EQUIPO' => $cod_equipo,
				'LIDER_PROFESOR' => 1 
				);
		$datos = $this->db->insert('profe_equi_lider',$data);
		
		//3 asignar modulo a sesiones
		$this->db->select('COD_SESION');
		$this->db->select('COD_MODULO_TEM');
		$this->db->from('sesion');
		$query = $this->db->get();	
		$datos = $query->result(); 
		$contador = 0;
		$lista = array();
		foreach ($datos as $row) { 
			$lista[$contador] = array();
			$lista[$contador][0] = $row->COD_SESION;
			$lista[$contador][1] = $row->COD_MODULO_TEM;
			$contador = $contador + 1;
		}
		$contador = 0;
		while($contador < count($lista)){
			if($lista[$contador][1] == $cod_mod){
				$data = array(		
					'COD_MODULO_TEM' => "NULL"
				);
				$this->db->where('COD_SESION', $lista[$contador]);
				$this->db->update('sesion',$data);		
			}
			$contador++;
		}
		//
		$contador = 0;
		$confirmacion3 = true;
		while ($contador<count($sesiones)){
		$data = array(					
				'COD_MODULO_TEM' => $cod_mod
				);
				$this->db->where('COD_SESION', $sesiones[$contador]);
				$datos = $this->db->update('sesion',$data);

			if($datos != true){
				$confirmacion3 = false;
			}

			$contador = $contador + 1;
		}

		//5 insertar requisito modulo
		//$sup_req = true;
		//while($sup_req){
			$sup_req = $this->db->delete('requisito_modulo', array('cod_modulo_tem' => $cod_mod)); 
	//	}
		$contador = 0;
		$confirmacion5 = true;
		while ($contador<count($requisitos)){
		$data = array(					
				'COD_REQUISITO' => $requisitos[$contador],
				'COD_MODULO_TEM' => $cod_mod
				);
		$datos = $this->db->insert('requisito_modulo',$data);
			if($datos != true){
				$confirmacion5 = false;
			}

		$contador = $contador + 1;
		}

		//fin inserciones
		if( $confirmacion0 == false  || $confirmacion2 == false || $confirmacion3 == false || $confirmacion5 == false){
			return -1;
			}
		return 1;
	}

	public function listaSesionesParaVerModulo($cod_mod){
		$query = $this->db->get_where('sesion', array('cod_modulo_tem' => $cod_mod));
		if ($query == FALSE) {
			return array();
		}
		return $query->result();	
	}
	public function listaProfesoresVerModulo($cod_equipo){
		$this->db->select('*');
		$this->db->from('profesor');
		$this->db->join('profe_equi_lider', 'profe_equi_lider.rut_usuario2 = profesor.rut_usuario2');
		$this->db->where('profe_equi_lider.cod_equipo', $cod_equipo); 
		$query = $this->db->get();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}
	public function listaRequisitosVerModulo($cod_mod){
		$this->db->select('*');
		$this->db->from('requisito');
		$this->db->join('requisito_modulo', 'requisito_modulo.cod_requisito = requisito.cod_requisito');
		$this->db->where('requisito_modulo.cod_modulo_tem', $cod_mod); 
		$query = $this->db->get();
		if ($query == FALSE) {
			return array();
		}
		return $query->result();
	}
}
?>
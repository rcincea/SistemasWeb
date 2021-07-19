<?php

namespace es\ucm\fdi\aw;

class Protectora
    {
		public static function nuevaProtectora($nombre, $direccion, $telefono)
		{	
		   $protectora = new Protectora(0, $nombre, $direccion, $telefono);   
		   return self::insertaProtectora($protectora);
		}

		public static function actualizar($id, $nombre, $direccion, $telefono)
		{	
			$protectora = new Protectora($id, $nombre, $direccion, $telefono); 
			return self::actualizaProtectora($protectora);  
			return $protectora;
		}
		
        public static function buscaProtectoraPorId($id){
			$app = Aplicacion::getSingleton();
			$conn = $app->conexionBd();
            $query = sprintf("SELECT * FROM protectoras WHERE id='%s' ", $id); 
            $rs = $conn->query($query);
            if($rs && $rs->num_rows == 1){
                $fila = $rs->fetch_assoc();
               
                $user = new Protectora($id, $fila['nombre'], 
                                     $fila['direccion'], $fila['telefono']
                                    );
             $rs->free();
             return $user;
            }
            return false;
        }

		public static function getProtectoras()
		{
			$app = Aplicacion::getSingleton();
			$conn = $app->conexionBd();
			$query = sprintf("SELECT * FROM protectoras ORDER BY ID ASC"); 
			$rs = $conn->query($query);
			if($rs && ($rs->num_rows >0)){
				$resultado = [];
				while($fila=$rs->fetch_assoc()){
					$protectora = new Protectora($fila['ID'], $fila['nombre'], 
					$fila['direccion'], $fila['telefono']);
					array_push($resultado, $protectora);              
				}
				$rs->free();
				return $resultado;
			}
			//$rs->free();
			return false; 
		}
    
    
    private $id;
    private $nombre;
    private $direccion;
    private $telefono;


    private function __construct($id, $nombre, $direccion, $telefono){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
    }
    
	public static function insertaProtectora($protectora)
{
	$result = false;

	$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
	
	$query = sprintf("INSERT INTO protectoras (nombre, direccion, telefono) VALUES ('%s', '%s', %d)"
		  , $conn->real_escape_string($protectora->nombre)
		  , $conn->real_escape_string($protectora->direccion)
		  , $conn->real_escape_string($protectora->telefono));
		
	$result = $conn->query($query);
		
	if ($result) {
	  $result = $protectora;
	  $protectora->id=$conn->insert_id;
	} else {
	  error_log($conn->error); 
	  return false;
	}
	
	return true;
}

/**
 * update protectora
 */ 
  
public static function actualizaProtectora($protectora)
{
	$result = false;

	$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
		
	$query = sprintf("UPDATE protectoras SET  nombre = '%s', direccion = '%s', telefono = %d WHERE ID = %d"

		  , $conn->real_escape_string($protectora->nombre)
		  , $conn->real_escape_string($protectora->direccion)
		  , $conn->real_escape_string($protectora->telefono)
		  , $conn->real_escape_string($protectora->id));

		$result = $conn->query($query);
		if (!$result) {
		  error_log($conn->error);  
		} else if ($conn->affected_rows != 1) {
		  error_log("Se han actualizado los datos '$conn->affected_rows' !");
		}
	return $result;
}
	
	
	
	
    /**
     * Get the value of id
     */ 
    public function getID()
    {
        return $this->id;
    }
    

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Get the value of direccion
     */ 
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Get the value of telefono
     */ 
    public function getTelefono()
    {
        return $this->telefono;
    }
	
	public function guarda()
	{
		if (!self::buscaProtectoraPorId($this->id)) {
		  self::insertaProtectora($this);
		} else {
		  self::actualizaProtectora($this);
		}

		return $this;
	}
    }



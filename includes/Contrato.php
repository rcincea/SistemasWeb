<?php

namespace es\ucm\fdi\aw;

class Contrato
{
	public static function crea($id_usuario, $id, $formulario)
	{
	   $contract = new Contrato($id_usuario, $id, $formulario,"EnTramite", date('Y-m-d'));
	   return $contract;
	}
	  
    public static function buscaPorIDeID($idUsuario,$idAnimal)
    {
       $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
       $query = sprintf("SELECT * FROM contrato_adopcion WHERE ID_usuario=%d AND ID=%d ", $idUsuario, $idAnimal); 
       $rs = $conn->query($query);
       if($rs && $rs->num_rows == 1){
           $fila = $rs->fetch_assoc();
           $contract = new Contrato($fila['ID_usuario'], $fila['ID'], 
                                $fila['formulario'], $fila['estado'], $fila['fecha']);
        $rs->free();
        return $contract;
       }
       return false;
    }
	
	public static function getContratosID($idUsu)
	{
		$app = Aplicacion::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT * FROM contrato_adopcion WHERE ID_usuario=%d ORDER BY ID ASC", $idUsu); 
		$rs = $conn->query($query);
		if($rs && ($rs->num_rows >0)){
			$resultado = [];
			while($fila=$rs->fetch_assoc()){
				$cont = new Contrato($fila['ID_usuario'], $fila['ID'], $fila['formulario'], $fila['estado'], $fila['fecha']);
				array_push($resultado, $cont);              
			}
			$rs->free();
			return $resultado;
		}
		return false; 
	}
	
	public static function rechazaContratos($id_animal){
		$app = Aplicacion::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("UPDATE contrato_adopcion SET estado='Rechazado' WHERE ID=%d",$id_animal); 
		$result = $conn->query($query);
		
		if (!$result) {
		  error_log($conn->error);
		} else if ($conn->affected_rows != 1) {
		  error_log("Se han actualizado los datos '$conn->affected_rows' !");
		}
		return $result;		
	}

private $id_usuario;
private $id;
private $formulario;
private $estado;
private $fecha;
private $nombreUsuario;
private $nombreAnimal;

private function __construct($id_usuario, $id, $formulario, $estado, $fecha)
{
    $this->id_usuario = $id_usuario;
    $this->id = $id;
    $this->formulario = $formulario;
    $this->estado = $estado;
    $this->fecha = $fecha;
}

/**
 * Get the value of dni
 */ 
public function getID_usuario()
{
return $this->id_usuario;
}

/**
 * Get the value of id
 */ 
public function getId()
{
return $this->id;
}

/**
 * Get the value of formulario
 */ 
public function getFormulario()
{
return $this->formulario;
}

/**
 * Get the value of estado
 */ 
public function getEstado()
{
return $this->estado;
}

/**
 * Get the value of fecha
 */ 
public function getFecha()
{
return $this->fecha;
}

/**
 * set the value of formulario
 */ 
public function setFormulario($formulario)
{
$this->formulario = $formulario;
return true;
}

/**
 * set the value of estado
 */ 
public function setEstado($estado)
{
$this->estado = $estado;
return true;
}

/**
 * insert a new contract in DB
 */ 
 
public static function insertaContrato($contract)
{
	$result = false;
	$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
	$query = sprintf("INSERT INTO contrato_adopcion (ID_usuario, ID, formulario, estado, fecha) VALUES (%d, %d, '%s', '%s', '%s')"
	  , $conn->real_escape_string($contract->id_usuario)
	  , $conn->real_escape_string($contract->id)
	  , $conn->real_escape_string($contract->formulario)
	  , $conn->real_escape_string($contract->estado)
	  , $conn->real_escape_string($contract->fecha));
	$result = $conn->query($query);
	if ($result) {
	  $result = $contract;
	} else {
	  error_log($conn->error); 
	}
	
	return $result;
}

/**
 * update the state of a contract
 */ 
  
public static function actualizaContrato($contract)
{
	$result = false;

	$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
	$query = sprintf("UPDATE contrato_adopcion SET formulario = '%s', estado = '%s', fecha = '%s' WHERE ID_usuario = %d AND ID = %d"
	  , $conn->real_escape_string($contract->formulario)
	  , $conn->real_escape_string($contract->estado)
	  , $conn->real_escape_string($contract->fecha)
	  , $conn->real_escape_string($contract->id_usuario)
	  , $conn->real_escape_string($contract->id));
	$result = $conn->query($query);
	if (!$result) {
	  error_log($conn->error);  
	} else if ($conn->affected_rows != 1) {
	  error_log("Se han actualizado '$conn->affected_rows' !");
	}

	return $result;
}

/**
 * remove a contract
 */ 
 
public static function borraContratoPorDNIeID($idUsuario,$idAnimal)
{
    $result = false;

    $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
    $query = sprintf("DELETE FROM contrato_adopcion WHERE ID_usuario = %d AND ID = %d", $idUsuario, $idAnimal);
    $result = $conn->query($query);
    if (!$result) {
      error_log($conn->error);
    } else if ($conn->affected_rows != 1) {
      error_log("Se han borrado '$conn->affected_rows' !");
    }

    return $result;
}

/**
 * save or update a contract
 */ 
 
public function guarda()
  {
    if (!self::buscaPorIDeID($this->id_usuario,$this->id)) {
      self::insertaContrato($this);
    } else {
      self::actualizaContrato($this);
    }
    return $this;
  }

public function ComprobarEnProceso()
{
	return $this->estado == "EnTramite";
}
/*
public static function getSolicitudes()
 {
	 $solicitudes = array();
	 $conn = getConexionBD();
	 $query = sprintf("SELECT DNI, ID FROM contrato_adopcion"); 
	 $rs = $conn->query($query);
	 
	 for($i = 0; $i < $rs->num_rows*2; $i+=2){
           $fila = $rs->fetch_assoc();
		   $solicitudes[$i] = $fila['DNI'];
		   $solicitudes[$i+1] = $fila['ID'];
	 }
	 $rs->free();
	 
	 return $solicitudes;
 }
*/
/*
public static function getSolicitudes()
 {
       $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
         $query = sprintf("SELECT * FROM contrato_adopcion ORDER BY fecha DESC"); 
         $rs = $conn->query($query);
         if($rs && ($rs->num_rows >0)){
            $resultado = [];
            while($fila=$rs->fetch_assoc()){
               $contrato = new Contrato($fila['ID_usuario'], $fila['ID'], 
               $fila['formulario'], $fila['estado'], $fila['fecha']);
               array_push($resultado, $contrato);              
            }
			 $rs->free();
            return $resultado;
         }
		 $rs->free();
        return false; 
 }
*/
public static function getSolicitudes()
 {
       $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
         $query = sprintf('SELECT C.ID_usuario, C.ID, C.formulario, C.estado, C.fecha , U.nombre as "usuario", A.nombre as "animal" FROM contrato_adopcion C JOIN usuarios U ON C.ID_usuario=U.ID JOIN animales A ON A.ID=C.ID ORDER BY fecha DESC'); 
         $rs = $conn->query($query);
         if($rs && ($rs->num_rows >0)){
            $resultado = [];
            while($fila=$rs->fetch_assoc()){
               $contrato = new Contrato($fila['ID_usuario'], $fila['ID'], 
               $fila['formulario'], $fila['estado'], $fila['fecha']);
			   $contrato->nombreAnimal = $fila['animal'];
			   $contrato->nombreUsuario = $fila['usuario'];
               array_push($resultado, $contrato);              
            }
			 $rs->free();
            return $resultado;
         }
		 $rs->free();
        return false; 
 }
public function getNombreUsuario()
{
return $this->nombreUsuario;
}
public function getNombreAnimal()
{
return $this->nombreAnimal;
}
}

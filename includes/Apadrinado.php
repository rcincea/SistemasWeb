<?php

namespace es\ucm\fdi\aw;

class Apadrinado
{	
    public static function buscaPorID_usuario($ID_usuario)
    {
	   $app = Aplicacion::getSingleton();
       $conn = $app->conexionBd();
       $query = sprintf("SELECT * FROM apadrinados WHERE ID_usuario='%s' ", $ID_usuario); 
       $rs = $conn->query($query);
       if($rs && $rs->num_rows == 1){
           $fila = $rs->fetch_assoc();
           $user = new Apadrinado($fila['ID_usuario'], $fila['ID'], $fila['cantidad'], $fila['numero_tarjeta']);
        $rs->free();
        return $user;
       }
       return false;
    }
	
    public static function buscaPorUsuarioAnimal($usuario, $animal)
    {
	   $app = Aplicacion::getSingleton();
       $conn = $app->conexionBd();
       $query = sprintf("SELECT * FROM apadrinados WHERE ID_usuario='%s' AND ID='%s' ", $usuario, $animal); 
       $rs = $conn->query($query);
       if($rs && $rs->num_rows == 1){
           $fila = $rs->fetch_assoc();
           $user = new Apadrinado($fila['ID_usuario'], $fila['ID'], $fila['cantidad'], $fila['numero_tarjeta']);
        $rs->free();
        return $user;
       }
       return false;
    }

    public static function register($usuario, $animal, $cantidad, $numero_tarjeta)
    {	
		$userAnimal = self::buscaPorUsuarioAnimal($usuario, $animal);
		if ($userAnimal) {
			$userAnimal = self::actualiza($usuario, $animal, $cantidad, $numero_tarjeta);
			return self::actualizaApadrinado($userAnimal);
		}
		$user = new Apadrinado($usuario, $animal, $cantidad, $numero_tarjeta);
		return self::inserta($user);
    }
    
    private static function inserta($apadrinado)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO apadrinados (ID_usuario, ID, cantidad, numero_tarjeta)
			VALUES(%d, %d, %f, %d)"
            , $conn->real_escape_string($apadrinado->ID_usuario)
            , $conn->real_escape_string($apadrinado->ID)
            , $conn->real_escape_string($apadrinado->cantidad)
            , $conn->real_escape_string($apadrinado->numero_tarjeta));
        if ( $conn->query($query) ) {
			return $apadrinado;
		}
		else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }
    
	public static function actualiza($usuario, $animal, $cantidad, $numero_tarjeta){
        $ap = new Apadrinado($usuario, $animal, $cantidad, $numero_tarjeta);
        return $ap;
    }
	
    public static function actualizaApadrinado($apadrinado)
	{
		$result = false;

		$app = Aplicacion::getSingleton();
			$conn = $app->conexionBd();
		  $query = sprintf("UPDATE apadrinados SET cantidad = '%s', numero_tarjeta = '%s' WHERE ID_usuario='%s' AND ID='%s'"
		  , $conn->real_escape_string($apadrinado->cantidad)
		  , $conn->real_escape_string($apadrinado->numero_tarjeta)
		  , $conn->real_escape_string($apadrinado->ID_usuario)
		  , $conn->real_escape_string($apadrinado->ID));
		$result = $conn->query($query);
		if (!$result) {
		  error_log($conn->error);  
		} else if ($conn->affected_rows != 1) {
		  error_log("Se han actualizado los datos '$conn->affected_rows' !");
		}
		return $apadrinado;
	}

	public static function getApadrinados(){
		
		$app = Aplicacion::getSingleton();
		$conn = $app->conexionBd();
		$result = [];
		$query = sprintf("SELECT * FROM apadrinados");
		$rs = $conn->query($query);
		if ($rs) {
			while($fila = $rs->fetch_assoc()) {
				$apadrinamiento = new Apadrinado($fila['ID_usuario'], $fila['ID'], $fila['cantidad'], $fila['numero_tarjeta']);
				array_push($result, $apadrinamiento);              
			}
			$rs->free();
		}
		return $result;
	}


	private $ID_usuario;
	private $ID;
	private $cantidad;
	private $numero_tarjeta;

	private function __construct($usuario, $animal, $cantidad, $numero_tarjeta)
	{
		$this->ID_usuario = $usuario;
		$this->ID = $animal;
		$this->cantidad = $cantidad;
		$this->numero_tarjeta = $numero_tarjeta;
	}

	/**
	 * Get the value of ID_usuario
	 */ 
	public function getID_usuario()
	{
	return $this->ID_usuario;
	}
	/**
	 * Get the value of ID
	 */ 
	public function getID()
	{
	return $this->ID;
	}
	/**
	 * Get the value of cantidad
	 */ 
	public function getCantidad()
	{
	return $this->cantidad;
	}
	/**
	 * Get the value of ID
	 */ 
	public function getNumTarjeta()
	{
	return $this->numero_tarjeta;
	}
}

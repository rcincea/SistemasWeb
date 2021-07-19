<?php

namespace es\ucm\fdi\aw;

class Transaccion
{	
    public static function buscaPorTarjeta($tarjeta)
    {
	   $app = Aplicacion::getSingleton();
       $conn = $app->conexionBd();
       $query = sprintf("SELECT * FROM transacciones WHERE ID='%s' ", $tarjeta); 
       $rs = $conn->query($query);
       if($rs && $rs->num_rows == 1){
           $fila = $rs->fetch_assoc();
           $user = new Transaccion($fila['ID'], $fila['ID_usuario'], $fila['cantidad'], $fila['tarjeta'], $fila['ID_animal'], $fila['fecha']);
        $rs->free();
        return $user;
       }
       return false;
    }
	
	
	public static function getTransacciones()
	{
		$app = Aplicacion::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT * FROM transacciones ORDER BY ID ASC"); 
		$rs = $conn->query($query);
		if($rs && ($rs->num_rows >0)){
			$resultado = [];
			while($fila=$rs->fetch_assoc()){
				$trans = new Transaccion($fila['ID'], $fila['ID_usuario'], $fila['cantidad'], $fila['tarjeta'], $fila['ID_animal'], $fila['fecha']);
				array_push($resultado, $trans);              
			}
			$rs->free();
			return $resultado;
		}
		return false; 
	}

    public static function register($usuario, $cantidad, $numero_tarjeta, $animal)
    {	
		//Guardamos $protectora como la fecha-h-m-s-microsegundo(6 decimales)
		//$date = DateTime::createFromFormat('U.u', microtime(TRUE));
		//$protectora = $date->format('YmdHisu');

		$user = new Transaccion(0, $usuario, $cantidad, $numero_tarjeta, $animal, 0);
		
		if($animal == NULL){
			return self::insertaConNull($user);
		}
		else{
			return self::inserta($user);
		}
    }
    
    private static function inserta($transaccion)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO transacciones (ID_usuario, tarjeta, cantidad, ID_animal, fecha)
			VALUES('%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($transaccion->ID_usuario)
            , $conn->real_escape_string($transaccion->numero_tarjeta)
            , $conn->real_escape_string($transaccion->cantidad)
			, $conn->real_escape_string($transaccion->ID_animal)
			, $conn->real_escape_string(date('Y-m-d')));
        if ( $conn->query($query) ) {
            $transaccion->ID = $conn->insert_id;
		}
		else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $transaccion;
    }
	
	private static function insertaConNull($transaccion)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO transacciones (ID_usuario, tarjeta, cantidad, fecha)
			VALUES('%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($transaccion->ID_usuario)
            , $conn->real_escape_string($transaccion->numero_tarjeta)
            , $conn->real_escape_string($transaccion->cantidad)
			, $conn->real_escape_string(date('Y-m-d')));
        if ( $conn->query($query) ) {
            $transaccion->ID = $conn->insert_id;
		}
		else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $transaccion;
    }

	private $ID;
	private $ID_usuario;
	private $cantidad;
	private $numero_tarjeta;
	private $ID_animal;
	private $fecha;

	private function __construct($id, $usuario, $cantidad, $tarjeta, $animal, $fecha)
	{
		$this->ID = $id;
		$this->ID_usuario = $usuario;
		$this->cantidad = $cantidad;
		$this->numero_tarjeta = $tarjeta;
		$this->ID_animal = $animal;
		$this->fecha = $fecha;
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
	 * Get the value of num tarjeta
	 */ 
	public function getNumTarjeta()
	{
	return $this->numero_tarjeta;
	}
	
	public function getID_animal()
	{
	return $this->ID_animal;
	}
	
	public function getFecha()
	{
	return $this->fecha;
	}
}

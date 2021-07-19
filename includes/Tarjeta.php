<?php

namespace es\ucm\fdi\aw;

class Tarjeta
{	
    public static function buscaPorID_usuario($ID_usuario)
    {
	   $app = Aplicacion::getSingleton();
       $conn = $app->conexionBd();
       $query = sprintf("SELECT * FROM tarjetas WHERE ID_usuario='%s' ", $ID_usuario); 
       $rs = $conn->query($query);
       if($rs && $rs->num_rows == 1){
           $fila = $rs->fetch_assoc();
           $user = new Tarjeta($fila['ID_usuario'], $fila['numero_tarjeta'], $fila['caducidad'], $fila['cvv']);
        $rs->free();
        return $user;
       }
       return false;
    }

    public static function register($usuario, $numero_tarjeta, $caducidad, $cvv)
    {	
		$user = self::buscaPorID_usuario($usuario);
		if ($user) {
			$user = self::actualiza($usuario, $numero_tarjeta, $caducidad, $cvv);
			return self::actualizaTarjeta($user);
		}
		$user = new Tarjeta($usuario, $numero_tarjeta, $caducidad, $cvv);
		return self::inserta($user);
    }
    
    private static function inserta($tarjeta)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO tarjetas (ID_usuario, numero_tarjeta, caducidad, cvv)
			VALUES(%d, %d, '%s', %d)"
            , $conn->real_escape_string($tarjeta->ID_usuario)
            , $conn->real_escape_string($tarjeta->numero_tarjeta)
            , $conn->real_escape_string($tarjeta->caducidad)
            , $conn->real_escape_string($tarjeta->cvv));
        if ( $conn->query($query) ) {
            return $tarjeta;
		}
		else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }
    
	public static function actualiza($usuario, $numero_tarjeta, $caducidad, $cvv){
        $ap = new Tarjeta($usuario, $numero_tarjeta, $caducidad, $cvv);
        return $ap;
    }
	
    public static function actualizatarjeta($tarjeta)
	{
		$result = false;

		$app = Aplicacion::getSingleton();
			$conn = $app->conexionBd();
		  $query = sprintf("UPDATE tarjetas SET  ID_usuario = %d,numero_tarjeta = %d, caducidad = '%s', cvv = %d"
		  , $conn->real_escape_string($tarjeta->ID_usuario)
		  , $conn->real_escape_string($tarjeta->numero_tarjeta)
		  , $conn->real_escape_string($tarjeta->caducidad)
		  , $conn->real_escape_string($tarjeta->cvv));
		$result = $conn->query($query);
		if (!$result) {
		  error_log($conn->error);  
		} else if ($conn->affected_rows != 1) {
		  error_log("Se han actualizado los datos '$conn->affected_rows' !");
		}
		return $tarjeta;
	}    


	private $ID_usuario;
	private $numero_tarjeta;
	private $caducidad;
	private $cvv;

	public function __construct($usuario, $numero_tarjeta, $caducidad, $cvv)
	{
		$this->ID_usuario = $usuario;
		$this->numero_tarjeta = $numero_tarjeta;
		$this->caducidad = $caducidad;
		$this->cvv = $cvv;
	}

	/**
	 * Get the value of ID_usuario
	 */ 
	public function getID_usuario()
	{
	return $this->ID_usuario;
	}
	/**
	 * Get the value of caducidad
	 */ 
	public function getCaducidad()
	{
	return $this->caducidad;
	}
	/**
	 * Get the value of numero tarjeta
	 */ 
	public function getNumTarjeta()
	{
	return $this->numero_tarjeta;
	}
}

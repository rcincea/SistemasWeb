<?php
namespace es\ucm\fdi\aw;

class Entrada
{
	private $id_usuario;
	private $numero;
	private $id_hilo;
	private $comentario;
	private $fecha;
	
	private function __construct($id_usuario, $numero, $id_hilo, $comentario, $fecha)
	{
		$this->id_usuario = $id_usuario;
		$this->numero = $numero;
		$this->id_hilo = $id_hilo;
		$this->comentario = $comentario;
		$this->fecha = $fecha;
	}
	
	public static function getEntradasPorHilo($id_hilo){
		$app = Aplicacion::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT * FROM entradas WHERE hilo = %d ORDER BY fecha ASC",$id_hilo); 
		$rs = $conn->query($query);
		if($rs && ($rs->num_rows >0)){
			$resultado = array();
			while($fila=$rs->fetch_assoc()){
				$hilo = new Entrada($fila['ID_usuario'], $fila['numero'], $fila['hilo'], $fila['comentario'], $fila['fecha']);
				array_push($resultado, $hilo);
			}   
			$rs->free();
			return $resultado;
		}
		return false;     
	}
	
	public static function nuevaEntrada($id_usuario,$id_hilo,$comentario,$fecha){
		$existeHilo = Hilo::getHilo($id_hilo);
		$existeUsuario = Usuario::buscaPorID_usuario($id_usuario);
		if (!$existeHilo || !$existeUsuario) return false;
		return self::inserta(new Entrada($id_usuario,0,$id_hilo,$comentario,$fecha));
	}
	
	public static function inserta($entrada){
		$app = Aplicacion::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("INSERT into entradas(ID_usuario, hilo, comentario, fecha) VALUES (%d, %d, '%s', '%s')", $entrada->id_usuario, 
																													$entrada->id_hilo, 
																													$conn->real_escape_string($entrada->comentario),
																									$entrada->fecha); 
		if ( $conn->query($query) ) {
            $entrada->numero = $conn->insert_id;
		}
		else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return true;		
	}
		
	public function getID_usuario()
	{
		return $this->id_usuario;
	}
	public function getNumero()
	{
		return $this->numero;
	}
	public function getFecha()
	{
		return $this->fecha;
	}
	public function getID_hilo()
	{
		return $this->id_hilo;
	}
	public function getComentario()
	{
		return $this->comentario;
	}
	public function setComentario($comentario)
	{
		$this->comentario = $comentario;
		return true;
	}
}
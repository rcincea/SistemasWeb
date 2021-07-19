<?php

namespace es\ucm\fdi\aw;

class Colabora
{
	public static function add($id_usuario, $comentario)
	{	
	   $comentario = new Colabora(0, $id_usuario, $comentario);   
	   return $comentario;
	}
	
    public static function buscaPorID($ID)
    {
	   $app = Aplicacion::getSingleton();
       $conn = $app->conexionBd();
       $query = sprintf("SELECT * FROM colabora WHERE ID=%d ", $ID); 
       $rs = $conn->query($query);
       if($rs && $rs->num_rows == 1){
           $fila = $rs->fetch_assoc();
          
           $comentario = new Colabora($fila['ID'], $fila['ID_usuario'], $fila['comentario']);
        $rs->free();
        return $comentario;
       }
       return false;
    }
    
    public static function inserta($colabora)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO colabora (ID_usuario, comentario)
			VALUES(%d, '%s')"
            , $conn->real_escape_string($colabora->id_usuario)
            , $conn->real_escape_string($colabora->comentario));
        if ( $conn->query($query) ) {
            $colabora->id = $conn->insert_id;
		}
		else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $colabora;
    }

	public static function getComentarios()
		{
			$app = Aplicacion::getSingleton();
			$conn = $app->conexionBd();
			$query = sprintf("SELECT * FROM colabora ORDER BY ID ASC"); 
			$rs = $conn->query($query);
			if($rs && ($rs->num_rows >0)){
				$resultado = [];
				while($fila=$rs->fetch_assoc()){
					$comentario = new Colabora($fila['ID'], $fila['ID_usuario'], $fila['comentario']);
					array_push($resultado, $comentario);              
				}
				$rs->free();
				return $resultado;
			}
			return false; 
		}

private $id;
private $id_usuario;
private $comentario;

private function __construct($id, $id_usuario, $comentario)
{
    $this->id = $id;	
    $this->id_usuario = $id_usuario;
    $this->comentario = $comentario;
}

/**
 * Get the value of id
 */ 
public function getID_usuario()
{
return $this->id;
}
/**
 * Get the value of id_usuario
 */ 
public function getTipo()
{
return $this->id_usuario;
}
/**
 * Get the value of comentario
 */ 
public function getID()
{
return $this->comentario;
}

}

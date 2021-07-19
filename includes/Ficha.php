<?php

namespace es\ucm\fdi\aw;

class Ficha
    {
        public static function add($id, $vacunas, $observaciones)
        {
            $ficha = new Ficha($id, $vacunas, $observaciones);
            return $ficha;
        }

        public static function getFichas(){

            $app = Aplicacion::getSingleton();
			$conn = $app->conexionBd();
			$query = sprintf("SELECT * FROM fichas ORDER BY ID ASC"); 
			$rs = $conn->query($query);
			if($rs && ($rs->num_rows >0)){
				$resultado = [];
				while($fila=$rs->fetch_assoc()){
					$ficha = new Ficha($fila['ID'], $fila['vacunas'], 
					$fila['observaciones']);
					array_push($resultado, $ficha);              
				}
				$rs->free();
				return $resultado;
			}
			//$rs->free();
			return false; 

        }


        public static function buscaFichaPorId($id){
			$app = Aplicacion::getSingleton();
			$conn = $app->conexionBd();
            $query = sprintf("SELECT * FROM fichas WHERE ID='%s' ", $id); 
            $rs = $conn->query($query);
            if($rs && $rs->num_rows == 1){
                $fila = $rs->fetch_assoc();
               
                $ficha = new Ficha($id, $fila['vacunas'], 
                                     $fila['observaciones']);
             $rs->free();
             return $ficha;
            }
            return false;
        }



public static function crearFicha($ficha)
{
	$result = false;

	$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
	
	$query = sprintf("INSERT INTO fichas (ID, vacunas, observaciones) VALUES (%d, '%s', '%s')"
	  , $conn->real_escape_string($ficha->id)
	  , $conn->real_escape_string($ficha->vacunas)
	  , $conn->real_escape_string($ficha->observaciones));
	  
	$result = $conn->query($query);
	
	if ($result) {
	  $result = $ficha;
	} else {
	  error_log($conn->error); 
	}
	
	return $result;
}


public static function actualizaFicha($ficha){
  $result = false;

	$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
	
	$query = sprintf("UPDATE fichas SET ID ='%s', vacunas ='%s', observaciones = '%s' WHERE ID ='%s'"
	  , $conn->real_escape_string($ficha->id)
	  , $conn->real_escape_string($ficha->vacunas)
	  , $conn->real_escape_string($ficha->observaciones));
	  
	$result = $conn->query($query);
	
	if ($result) {
	  $result = $ficha;
	} else {
	  error_log($conn->error); 
	}
	
	return $result;
}

        private $id;
        private $vacunas;
        private $observaciones;

        private function __construct($id, $vacunas, $observaciones){
            $this->id = $id;
            $this->vacunas = $vacunas;
            $this->observaciones = $observaciones;
        }




        /**
         * Get the value of vacunas
         */ 
        public function getVacunas()
        {
                return $this->vacunas;
        }

        /**
         * Get the value of observaciones
         */ 
        public function getObservaciones()
        {
                return $this->observaciones;
        }

        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        public function crear(){
            if (!self::buscaFichaPorId($this->id)) {
                self::crearFicha($this);
              }
            else{
                self::actualizaFicha($this);
            }
        }
    }

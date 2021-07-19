<?php

namespace es\ucm\fdi\aw;

class Animal
{
	
	public static function nuevoAnimal($nombre, $nacimiento, $tipo, $raza, $sexo, $peso, $ingreso, $protectora)
	{	
	   $animal = new Animal(0,$nombre, $nacimiento, $tipo, $raza, $sexo, $peso, $ingreso, $protectora, NULL, NULL,0);   
	   return self::insertaAnimal($animal);
	}
	
	public static function actualizar($idAnimal, $nombre, $nacimiento, $tipo, $raza, $sexo, $peso, $ingreso ,$protectora,$historia_feliz, $urgente)
	{	
	   $animal = new Animal($idAnimal, $nombre, $nacimiento, $tipo, $raza, $sexo, $peso, $ingreso, $protectora, $historia_feliz, NULL, $urgente); 
	   return self::actualizaAnimal($animal);  
	}
	
    public static function buscaPorID($idAnimal)
    {
       $app = Aplicacion::getSingleton();
       $conn = $app->conexionBd();
       $query = sprintf("SELECT * FROM animales WHERE ID=%d ", $idAnimal); 
       $rs = $conn->query($query);
       if($rs && $rs->num_rows == 1){
           $fila = $rs->fetch_assoc();
           $animal = new Animal($fila['ID'], $fila['nombre'], 
                                $fila['nacimiento'], $fila['tipo'], $fila['raza'],
                                $fila['sexo'], $fila['peso'], 
                                $fila['ingreso'], $fila['protectora'], 
                                $fila['historia'], $fila['ID_usuario'], $fila['urgente']);
        $rs->free();
        return $animal;
       }
       return false;
    }

   public static function getAdoptados($idUsuario){
      $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
         $query = sprintf("SELECT * FROM animales WHERE ID_usuario=%d ",$idUsuario); 
         $rs = $conn->query($query);
         if($rs && ($rs->num_rows >0)){
            $resultado = [];
            while($fila=$rs->fetch_assoc()){
               $animal = new Animal($fila['ID'], $fila['nombre'], 
               $fila['nacimiento'], $fila['tipo'], $fila['raza'],
               $fila['sexo'], $fila['peso'], 
               $fila['ingreso'], $fila['protectora'], 
               $fila['historia'], $fila['ID_usuario'], $fila['urgente']);
               array_push($resultado, $animal);
               
            }
			$rs->free();           
            return $resultado;
         }
		 $rs->free();
         return false;     
  }

  public static function getApadrinados($idUsuario){
   $app = Aplicacion::getSingleton();
   $conn = $app->conexionBd();
   $query = sprintf("SELECT anim.ID, anim.nombre, anim.nacimiento, anim.tipo,anim.raza, anim.sexo, anim.peso, anim.ingreso, anim.protectora,anim.historia, anim.ID_usuario, anim.urgente
    FROM animales anim JOIN apadrinados apa ON anim.ID = apa.ID JOIN usuarios usu ON apa.ID_usuario = usu.ID   WHERE usu.ID=%d ",$idUsuario); 
   $rs = $conn->query($query);
   if($rs && ($rs->num_rows >0)){
      $resultado = [];
      while($fila=$rs->fetch_assoc()){
         $animal = new Animal($fila['ID'], $fila['nombre'], 
         $fila['nacimiento'], $fila['tipo'], $fila['raza'],
         $fila['sexo'], $fila['peso'], 
         $fila['ingreso'], $fila['protectora'], 
         $fila['historia'], $fila['ID_usuario'], $fila['urgente']);
         array_push($resultado, $animal);
         
      }
	  $rs->free();
      return $resultado;
        
   }
	$rs->free(); 
   return false;     

  }

 public static function getEnAdopcion()
 {
	 $animales = array();
	 $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
	 $query = sprintf("SELECT ID, nombre FROM animales WHERE ID_usuario IS NULL");
	 $rs = $conn->query($query);
	 for($i = 0; $i < $rs->num_rows*2; $i+=2){
           $fila = $rs->fetch_assoc();
		   $animales[$i] = $fila['ID'];
		   $animales[$i+1] = $fila['nombre'];
	 }
	 $rs->free();
	 return $animales;
 }
 
 public static function getUrgentes()
 {
	 $animales = array();
	 $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
	 $query = sprintf("SELECT ID, nombre FROM animales WHERE ID_usuario IS NULL AND urgente != '0' ");
	 $rs = $conn->query($query);
	 for($i = 0; $i < $rs->num_rows*2; $i+=2){
           $fila = $rs->fetch_assoc();
		   $animales[$i] = $fila['ID'];
		   $animales[$i+1] = $fila['nombre'];
	 }
	 $rs->free();
	 return $animales;
 }
 
 public static function getUltimosAcogidos($tipoAnimal)
 {
	 $animales = array();
	 $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
	 $query = sprintf("SELECT ID, nombre FROM animales WHERE ID_usuario IS NULL AND tipo = '%s' ORDER BY ingreso DESC", $tipoAnimal);
	 $rs = $conn->query($query);
	 for($i = 0; $i < $rs->num_rows*2; $i+=2){
           $fila = $rs->fetch_assoc();
		   $animales[$i] = $fila['ID'];
		   $animales[$i+1] = $fila['nombre'];
	 }
	 $rs->free();
	 return $animales;
 }
 
 public static function buscaAnimales($nombreAnimal,$tipoAnimal)
 {
	 $animales = array();
	 $app = Aplicacion::getSingleton();
     $conn = $app->conexionBd();
	 $result = [];
	 /*
	 if ($nombreAnimal == null && $tipoAnimal == "Todos") $result = self::getAnimalsNameAndID();
	 else {*/
	   $query = sprintf("SELECT ID, nombre FROM animales WHERE ");
	   if ($nombreAnimal != null) $query .= "nombre LIKE '%".$nombreAnimal."%' AND ";
	   if ($tipoAnimal != "Todos") $query .= "tipo = '".$tipoAnimal."' AND ";
	   $query .= "ID_usuario IS NULL ORDER BY nombre ASC";
	   $rs = $conn->query($query);
		 if ($rs) {
		  $i = 0;
		  while($fila = $rs->fetch_assoc()) {
			   $result[$i] = $fila['ID'];
			   $result[$i+1] = $fila['nombre'];
			   $i += 2;
		  }
		 $rs->free();
		 }
	
    //}

    return $result;
 }
   public static function getAnimalesAdoptados()
 {
	 $animales = array();
	 $app = Aplicacion::getSingleton();
     $conn = $app->conexionBd();
	 $result = [];
	 $query = sprintf("SELECT ID, nombre FROM animales WHERE ID_usuario IS NOT NULL ORDER BY ingreso DESC");
	 //$query .= "DNI IS NULL ORDER BY nombre ASC";
	 $rs = $conn->query($query);
	 if ($rs) {
		$i = 0;
		while($fila = $rs->fetch_assoc()) {
			 $result[$i] = $fila['ID'];
			 $result[$i+1] = $fila['nombre'];
			 $i += 2;
		}
		$rs->free();
	 }
    return $result;
 }

public static function insertaAnimal($animal)
{
	$result = false;

	$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
	
	$query = sprintf("INSERT INTO animales (nombre, nacimiento, tipo, raza, sexo, peso, ingreso, protectora, urgente) VALUES ('%s', '%s', '%s', '%s', '%s', %f, '%s', %d, 0)"
	  , $conn->real_escape_string($animal->nombre)
	  , $conn->real_escape_string($animal->nacimiento)
	  , $conn->real_escape_string($animal->tipo)
	  , $conn->real_escape_string($animal->raza)
	  , $conn->real_escape_string($animal->sexo)
	  , $conn->real_escape_string($animal->peso)
	  , $conn->real_escape_string($animal->fecha_ingreso)
	  , $conn->real_escape_string($animal->protectora));
	  	
	$result = $conn->query($query);

	if ($result) {
	  $result = $animal;
	  $animal->id = $conn->insert_id;
	} else {
	  error_log($conn->error);
		return false;	  
	}
	
	return true;
}

/**
 * update animal
 */ 

public static function actualizaAnimal($animal)
{
	$result = false;

	$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
		
	$query = sprintf("UPDATE animales SET nombre = '%s', nacimiento = '%s', tipo = '%s', raza = '%s', sexo = '%s', peso = '%s', protectora = %d, historia = '%s', urgente= '%s' WHERE ID = %d"
	
	  , $conn->real_escape_string($animal->nombre)
	  , $conn->real_escape_string($animal->nacimiento)
	  , $conn->real_escape_string($animal->tipo)
	  , $conn->real_escape_string($animal->raza)
	  , $conn->real_escape_string($animal->sexo)
	  , $conn->real_escape_string($animal->peso)
	  , $conn->real_escape_string($animal->protectora)
	  , $conn->real_escape_string($animal->historia_feliz)
	  , $conn->real_escape_string($animal->urgente)
	  , $conn->real_escape_string($animal->id));
	  
	$result = $conn->query($query);
	
	if (!$result) {
	  error_log($conn->error);
	} else if ($conn->affected_rows != 1) {
	  error_log("Se han actualizado los datos '$conn->affected_rows' !");
	}
	return $result;
}
	
public static function getAnimales()
{
	$app = Aplicacion::getSingleton();
	$conn = $app->conexionBd();
	$query = sprintf("SELECT * FROM animales ORDER BY nombre ASC"); 
	$rs = $conn->query($query);
	if($rs && ($rs->num_rows >0)){
		$resultado = [];
		while($fila=$rs->fetch_assoc()){
			$animal = new Animal($fila['ID'], $fila['nombre'], 
			$fila['nacimiento'], $fila['tipo'], $fila['raza']
			, $fila['sexo'], $fila['peso'], $fila['ingreso']
			, $fila['protectora'], $fila['historia'], $fila['ID_usuario']
			, $fila['urgente']);
			array_push($resultado, $animal);              
		}
		$rs->free();
		return $resultado;
	}
	return false; 
}
	
	public static function adoptarAnimal($id_animal,$id_usuario){
		$app = Aplicacion::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("UPDATE animales SET ID_usuario=%d WHERE ID=%d",$id_usuario,$id_animal); 
		$result = $conn->query($query);
		
		if (!$result) {
		  error_log($conn->error);
		} else if ($conn->affected_rows != 1) {
		  error_log("Se han actualizado los datos '$conn->affected_rows' !");
		}
		return $result;
	}

private $id;
private $nombre;
private $nacimiento;
private $tipo;
private $raza;
private $sexo;
private $peso;
private $fecha_ingreso;
private $protectora;
private $historia_feliz;
private $id_propietario;
private $urgente;
private $imagen;

private function __construct($id, $nombre, $nacimiento,
                             $tipo, $raza, $sexo, $peso,
                             $fecha_ingreso, $protectora,
                              $historia_feliz, $id_propietario, $urgente)
                            
{
   $this->id = $id;
   $this->nombre = $nombre;
   $this->nacimiento = $nacimiento;
   $this->tipo = $tipo;
   $this->raza = $raza;
   $this->sexo = $sexo;
   $this->peso = $peso;
   $this->fecha_ingreso = $fecha_ingreso;
   $this->protectora = $protectora;
   $this->historia_feliz = $historia_feliz;
   $this->id_propietario = $id_propietario;
   $this->urgente = $urgente;
   $this->imagen = NULL;
}

/**
 * Get the value of id
 */ 
public function getId()
{
return $this->id;
}

/**
 * Set the value of id
 *
 * @return  self
 */ 
public function setId($id)
{
$this->id = $id;

return $this;
}

/**
 * Get the value of nombre
 */ 
public function getNombre()
{
return $this->nombre;
}

/**
 * Set the value of nombre
 *
 * @return  self
 */ 
public function setNombre($nombre)
{
$this->nombre = $nombre;

return $this;
}

/**
 * Get the value of nacimiento
 */ 
public function getNacimiento()
{
return $this->nacimiento;
}

/**
 * Set the value of nacimiento
 *
 * @return  self
 */ 
public function setNacimiento($nacimiento)
{
$this->nacimiento = $nacimiento;

return $this;
}

/**
 * Get the value of tipo
 */ 
public function getTipo()
{
return $this->tipo;
}

/**
 * Set the value of tipo
 *
 * @return  self
 */ 
public function setTipo($tipo)
{
$this->tipo = $tipo;

return $this;
}

/**
 * Get the value of raza
 */ 
public function getRaza()
{
return $this->raza;
}

/**
 * Set the value of raza
 *
 * @return  self
 */ 
public function setRaza($raza)
{
$this->raza = $raza;

return $this;
}

/**
 * Get the value of sexo
 */ 
public function getSexo()
{
return $this->sexo;
}

/**
 * Set the value of sexo
 *
 * @return  self
 */ 
public function setSexo($sexo)
{
$this->sexo = $sexo;

return $this;
}

/**
 * Get the value of peso
 */ 
public function getPeso()
{
return $this->peso;
}

/**
 * Set the value of peso
 *
 * @return  self
 */ 
public function setPeso($peso)
{
$this->peso = $peso;

return $this;
}

/**
 * Get the value of fecha_ingreso
 */ 
public function getFecha_ingreso()
{
return $this->fecha_ingreso;
}

/**
 * Set the value of fecha_ingreso
 *
 * @return  self
 */ 
public function setFecha_ingreso($fecha_ingreso)
{
$this->fecha_ingreso = $fecha_ingreso;

return $this;
}

/**
 * Get the value of protectora
 */ 
public function getProtectora()
{
return $this->protectora;
}

/**
 * Set the value of protectora
 *
 * @return  self
 */ 
public function setProtectora($protectora)
{
$this->protectora = $protectora;

return $this;
}

/**
 * Get the value of historia_feliz
 */ 
public function getHistoria_feliz()
{
return $this->historia_feliz;
}

/**
 * Set the value of historia_feliz
 *
 * @return  self
 */ 
public function setHistoria_feliz($historia_feliz)
{
$this->historia_feliz = $historia_feliz;

return $this;
}

/**
 * Get the value of id_propietario
 */ 
public function getId_propietario()
{
return $this->id_propietario;
}

/**
 * Set the value of id_propietario
 *
 * @return  self
 */ 
public function setId_propietario($id_propietario)
{
$this->id_propietario = $id_propietario;

return $this;
}


/**
 * Get the value of urgente
 *
 * @return  self
 */ 

public function getUrgente(){
	return $this->urgente;
}

/**
 * Set the value of urgente
 *
 * @return  self
 */ 
 
 public function setUrgente($urgente)
{
$this->urgente = $urgente;

return $this;
}

public static function getPerrosEnAdopcion()
 {
	 $animales = array();
	 $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
	 $query = sprintf("SELECT ID, nombre FROM animales WHERE tipo = 'perro' AND ID_usuario IS NULL"); 
	 $rs = $conn->query($query);
	 
	 for($i = 0; $i < $rs->num_rows; $i+=1){
           $fila = $rs->fetch_assoc();
		   $animales[$i] = $fila['ID'];
	 }
	 $rs->free();
	 
	 return $animales;
 }
  public static function getPerrosAdopdatos()
 {
	 $animales = array();
	 $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
	 $query = sprintf("SELECT ID, nombre FROM animales WHERE tipo = 'perro' AND ID_usuario IS NOT NULL"); 
	 $rs = $conn->query($query);
	 
	 for($i = 0; $i < $rs->num_rows; $i+=1){
           $fila = $rs->fetch_assoc();
		   $animales[$i] = $fila['ID'];
	 }
	 $rs->free();
	 
	 return $animales;
 }
  public static function getGatosEnAdopcion()
 {
	 $animales = array();
	 $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
	 $query = sprintf("SELECT ID, nombre FROM animales WHERE tipo = 'gato' AND ID_usuario IS NULL"); 
	 $rs = $conn->query($query);
	 
	 for($i = 0; $i < $rs->num_rows; $i+=1){
           $fila = $rs->fetch_assoc();
		   $animales[$i] = $fila['ID'];
	 }
	 $rs->free();
	 
	 return $animales;
 }
 
  public static function getGatosAdoptados()
 {
	 $animales = array();
	 $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
	 $query = sprintf("SELECT ID, nombre FROM animales WHERE tipo = 'gato' AND ID_usuario IS NOT NULL"); 
	 $rs = $conn->query($query);
	 
	 for($i = 0; $i < $rs->num_rows; $i+=1){
           $fila = $rs->fetch_assoc();
		   $animales[$i] = $fila['ID'];
	 }
	 $rs->free();
	 
	 return $animales;
 }

 public function guarda()
  {
    if (!self::buscaPorID($this->id)) {
      self::insertaAnimal($this);
    } else {
      self::actualizaAnimal($this);
    }

    return $this;
  }
  public function actualiza(){
    if (self::buscaPorID($this->id)) {
		self::actualizaAnimal($this);
	  } 
    }
 

}

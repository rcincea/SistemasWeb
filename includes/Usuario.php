<?php
namespace es\ucm\fdi\aw;
class Usuario
{
	 public static function actualiza($id, $dni, $nombre, $apellido, $telefono, $email, $contraseña, $nacimiento, $direccion){
		return self::editaUsuario(new Usuario($id, $dni, $nombre, $apellido, $telefono, $email, $contraseña, $nacimiento, $direccion, NULL, NULL));
    	}

	public static function login($dni, $contraseña)
	{
		$user = self::buscaPorDNI($dni);
		if ($user && $user->compruebaContraseña($contraseña)) {
		return $user;
		}    
		return false;
	}
  
    public static function buscaPorDNI($dniUsuario)
    {
	   $app = Aplicacion::getSingleton();
       $conn = $app->conexionBd();
       $query = sprintf("SELECT * FROM usuarios WHERE DNI='%s' ", $dniUsuario); 
       $rs = $conn->query($query);
       if($rs && $rs->num_rows == 1){
           $fila = $rs->fetch_assoc();
          
           $user = new Usuario($fila['ID'],$fila['DNI'], $fila['nombre'], 
                                $fila['apellido'], $fila['telefono'], $fila['email'],
                                $fila['contraseña'], $fila['nacimiento'], 
                                $fila['direccion'], $fila['tipo'], $fila['creacion']);
        $rs->free();
        return $user;
       }
       return false;
    }
	
    public static function buscaPorID_usuario($ID_Usuario)
    {
	   $app = Aplicacion::getSingleton();
       $conn = $app->conexionBd();
       $query = sprintf("SELECT * FROM usuarios WHERE ID=%d ", $ID_Usuario); 
       $rs = $conn->query($query);
       if($rs && $rs->num_rows == 1){
           $fila = $rs->fetch_assoc();
          
           $user = new Usuario($fila['ID'], $fila['DNI'], $fila['nombre'], 
                                $fila['apellido'], $fila['telefono'], $fila['email'],
                                $fila['contraseña'], $fila['nacimiento'], 
                                $fila['direccion'], $fila['tipo'], $fila['creacion']);
        $rs->free();
        return $user;
       }
       return false;
    }

    public static function register($DNI, $nombre, $apellido, $telefono, $email, $contraseña, $nacimiento, $direccion,$creacion)
    {	
		$user = self::buscaPorDNI($DNI);
		if ($user) {
			return false;
		}
		$user = new Usuario(0,$DNI, $nombre, $apellido, $telefono, $email, self::hashPassword($contraseña), $nacimiento, $direccion, "normal", $creacion);
		return self::inserta($user);
  }

	private static function hashPassword($contraseña)
    {
        return password_hash($contraseña, PASSWORD_DEFAULT);
    }
    
    private static function inserta($usuario)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO usuarios (DNI, nombre, apellido, telefono, email, contraseña, nacimiento, direccion, tipo, creacion)
			VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->dni)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->apellido)
            , $conn->real_escape_string($usuario->telefono)
			, $conn->real_escape_string($usuario->email)
			, $conn->real_escape_string($usuario->contraseña)
			, $conn->real_escape_string($usuario->nacimiento)
			, $conn->real_escape_string($usuario->direccion)
			, $conn->real_escape_string($usuario->tipo)
			, $conn->real_escape_string($usuario->creacion));
        if ( $conn->query($query) ) {
            $usuario->id = $conn->insert_id;
		}
		else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $usuario;
    }
	
	public static function editaTipo($usuario, $tipo)
	{
		$result = false;

		$app = Aplicacion::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("UPDATE usuarios SET tipo = '%s' WHERE ID = %d"
		  , $conn->real_escape_string($tipo)
		  , $conn->real_escape_string($usuario->id));
		$result = $conn->query($query);
		if (!$result) {
		  error_log($conn->error);  
		} else if ($conn->affected_rows != 1) {
		  error_log("Se han actualizado los datos '$conn->affected_rows' !");
		}
		return $result;
	}
	
      public static function editaUsuario($usuario)
		{
			$result = false;

			$app = Aplicacion::getSingleton();
			$conn = $app->conexionBd();
			$contraseña = password_hash($usuario->contraseña, PASSWORD_DEFAULT);
			$query = sprintf("UPDATE usuarios SET nombre = '%s', apellido = '%s', telefono = %d, email = '%s', contraseña = '%s', nacimiento = '%s', direccion = '%s' WHERE ID = %d"
			
			  , $conn->real_escape_string($usuario->nombre)
			  , $conn->real_escape_string($usuario->apellido)
			  , $conn->real_escape_string($usuario->telefono)
			  , $conn->real_escape_string($usuario->email)
			  , $conn->real_escape_string($contraseña)
			  , $conn->real_escape_string($usuario->nacimiento)
			  , $conn->real_escape_string($usuario->direccion)
			  , $conn->real_escape_string($usuario->id));
			$result = $conn->query($query);
			if (!$result) {
			  error_log($conn->error);  
			} else if ($conn->affected_rows != 1) {
			  error_log("Se han actualizado los datos '$conn->affected_rows' !");
			}
			return $result;
		}
	
	public static function getUsuarios()
	{
		$app = Aplicacion::getSingleton();
		$conn = $app->conexionBd();
		$query = sprintf("SELECT * FROM usuarios ORDER BY ID ASC"); 
		$rs = $conn->query($query);
		if($rs && ($rs->num_rows >0)){
			$resultado = [];
			while($fila=$rs->fetch_assoc()){
				$user = new Usuario($fila['ID'], $fila['DNI'], $fila['nombre'], 
                                $fila['apellido'], $fila['telefono'], $fila['email'],
                                $fila['contraseña'], $fila['nacimiento'], 
                                $fila['direccion'], $fila['tipo'], $fila['creacion']);
				array_push($resultado, $user);              
			}
			$rs->free();
			return $resultado;
		}
		return false; 
	}

private $id;
private $dni;
private $nombre;
private $apellido;
private $telefono;
private $email;
private $contraseña;
private $nacimiento;
private $direccion;
private $tipo;
private $creacion;

private function __construct($id,$dni, $nombre, $apellido, $telefono,
                             $email, $contraseña, $nacimiento, $direccion , $tipo, $creacion)
{
    $this->id = $id;	
    $this->dni = $dni;
    $this->nombre = $nombre;
    $this->apellido = $apellido;
    $this->telefono = $telefono;
    $this->email = $email;
    $this->contraseña = $contraseña;
    $this->nacimiento = $nacimiento;
    $this->direccion = $direccion;
    $this->tipo = $tipo;
    $this->creacion = $creacion;
}

 
public function compruebaContraseña($contraseña){
    return password_verify($contraseña, $this->contraseña);
}

public function cambiacontraseña($nuevocontraseña)
{
  $this->contraseña = password_hash($nuevocontraseña, PASSWORD_DEFAULT);
}

/**
 * Get the value of tipo
 */ 
public function getID_usuario()
{
return $this->ID_usuario;
}
/**
 * Get the value of tipo
 */ 
public function getTipo()
{
return $this->tipo;
}
/**
 * Get the value of ID
 */ 
public function getID()
{
return $this->id;
}
/**
 * Get the value of dni
 */ 
public function getDni()
{
return $this->dni;
}

/**
 * Get the value of nombre
 */ 
public function getNombre()
{
return $this->nombre;
}

/**
 * Get the value of apellido
 */ 
public function getApellido()
{
return $this->apellido;
}

/**
 * Get the value of telefono
 */ 
public function getTelefono()
{
return $this->telefono;
}

/**
 * Get the value of email
 */ 
public function getEmail()
{
return $this->email;
}

/**
 * Get the value of nacimiento
 */ 
public function getNacimiento()
{
return $this->nacimiento;
}

/**
 * Get the value of direccion
 */ 
public function getDireccion()
{
return $this->direccion;
}
	
/**
 * Get the value of creacion
 */ 
public function getCreacion()
{
return $this->creacion;
}

/**
 * Set the value of telefono
 *
 * @return  self
 */ 
public function setTelefono($telefono)
{
$this->telefono = $telefono;

return $this;
}

/**
 * Set the value of email
 *
 * @return  self
 */ 
public function setEmail($email)
{
$this->email = $email;

return $this;
}

/**
 * Set the value of direccion
 *
 * @return  self
 */ 
public function setDireccion($direccion)
{
$this->direccion = $direccion;

return $this;
}


}

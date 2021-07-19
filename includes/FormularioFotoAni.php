<?php

namespace es\ucm\fdi\aw;

class FormularioFotoAni extends Form
{
    const EXTENSIONES_PERMITIDAS = array('gif','jpg','jpe','jpeg','png');
	
	private $id;
	
	public function __construct($Id) {
		$this->id = $Id;
		$opciones = array('action' => 'perfil_animal.php?id='. $this->id);
		parent::__construct("1", $opciones);
	  }
	
    protected function generaCamposFormulario($datos, $errores = array())
    {
        $html = <<<EOS
    <fieldset>
      <legend>Subida de archivo</legend>
      <p><label for="archivo">Imagen:</label><input type="file" name="archivo" id="archivo" /></p>
      <button type="submit">Cambiar</button>
    </fieldset>
EOS;
        return $html;
    }
    
    protected function procesaFormulario($datos)
    {
		$result = array();
		$ok = count($_FILES) == 1 && $_FILES['archivo']['error'] == UPLOAD_ERR_OK;
		
		if ( $ok ) {
		  $archivo = $_FILES['archivo'];
		  $nombre = $_FILES['archivo']['name'];
		  $idAni = $this->id;
		  
		  /* 1.a) Valida el nombre del archivo */
		  $ok = $this->check_file_uploaded_name($nombre) && $this->check_file_uploaded_length($nombre) ;
		  
		  /* 1.b) Sanitiza el nombre del archivo */
		  $ok = $this->sanitize_file_uploaded_name($nombre);
		  
		  /* 2. comprueba si la extensión está permitida*/
		  $ok = $ok && in_array(pathinfo($nombre, PATHINFO_EXTENSION), self::EXTENSIONES_PERMITIDAS);

		  /* 3. comprueba el tipo mime del archivo correspode a una imagen image/* */
		  $finfo = new \finfo(FILEINFO_MIME_TYPE);
		  $mimeType = $finfo->file($_FILES['archivo']['tmp_name']);
		  $ok = preg_match('/image\/*./', $mimeType);

		  if ( $ok ) {
			$tmp_name = $_FILES['archivo']['tmp_name'];

			if ( !move_uploaded_file($tmp_name, RUTA_IMGANI. "/{$idAni}.jpg") ) {
			  $result[] = 'Error al mover el archivo';
			}
			
			
		  }else {
			$result[] = 'El archivo tiene un nombre o tipo no soportado';
		  }
		} else {
		  $result[] = 'Error al subir el archivo.';
		}
		return $result;
    }
	
	private function check_file_uploaded_name ($filename) {
		return (bool) ((mb_ereg_match('/^[0-9A-Z-_\.]+$/i',$filename) === 1) ? true : false );
	}
	
	private function sanitize_file_uploaded_name($filename) {
		/* Remove anything which isn't a word, whitespace, number
		 * or any of the following caracters -_~,;[]().
		 * If you don't need to handle multi-byte characters
		 * you can use preg_replace rather than mb_ereg_replace
		 * Thanks @Łukasz Rysiak!
		 */
		$newName = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $filename);
		// Remove any runs of periods (thanks falstro!)
		$newName = mb_ereg_replace("([\.]{2,})", '', $newName);

		return $newName;
	}
  
	private function check_file_uploaded_length ($filename) {
		return (bool) ((mb_strlen($filename,'UTF-8') < 250) ? true : false);
	}
}

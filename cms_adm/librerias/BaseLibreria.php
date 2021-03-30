<?php
class BaseLibreria
{
  private $host;
  private $usuario;
  private $clave;
  private $nombre_base;
  private $conector;
  private $conexion;
  private $error;
  private $tiposcript;
  private $titulo;
  private $texto;
  private $tipoAlerta;
  private $texto_limpio;
  private $salt_chars;
  private $salt;

  public function __construct()
  {
    $this->host = null;
    $this->usuario = null;
    $this->clave = null;
    $this->nombre_base = null;
    $this->conector = null;
    $this->conexion = null;
    $this->error = null;
    $this->salt_chars = null;
    $this->salt = null;
  }
  protected function conectar()
  {
    $this->host = 'https://fgh-org.org/cms';
    $this->usuario = 'u960867815_edgoca1962';
    $this->clave = 'Fagohi1986';
    $this->nombre_base = 'u960867815_cms';
    $this->conector = 'mysql:host=' . $this->host . ";dbname=" . $this->nombre_base;
    $this->opciones = array(
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
      PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    try {
      $this->conexion = new PDO($this->conector, $this->usuario, $this->clave, $this->opciones);
      return $this->conexion;
    } catch (PDOException $error) {
      $this->error = $error->getMessage();
      exit();
    }
  }
  public function get_atributo_libreria($atributo)
  {
    return $this->$atributo;
  }
  public function set_atributo_libreria($atributo, $valor)
  {
    $this->$atributo = $valor;
  }

  public function get_alerta()
  {
    $this->tiposcript = $this->get_atributo_libreria("tiposcript");
    $this->titulo = $this->get_atributo_libreria("titulo");
    $this->texto = $this->get_atributo_libreria("texto");
    $this->tipoAlerta = $this->get_atributo_libreria("tipoAlerta");
    if ($this->tiposcript == "simple") {
      $this->alerta = "
            <script>
	            swal.fire(
	              '" . $this->titulo . "',
	              '" . $this->texto . "',
                '" . $this->tipoAlerta . "'
              );
	          </script>
	        ";
    } elseif ($this->tiposcript == "recargar") {
      $this->alerta = "
	          <script>
	            swal.fire({
	              title: '" . $this->titulo . "',
	              text: '" . $this->texto . "',
	              type: '" . $this->tipoAlerta . "',
	              confirmButtonText: 'Aceptar'
	            }).then(function(){
	              location.reload();
	            });
	          </script>
	        ";
    } elseif ($this->tiposcript == "limpiar") {
      $this->alerta = "
	          <script>
	            swal.fire({
	              title: '" . $this->titulo . "',
	              text: '" . $this->texto . "',
	              type: '" . $this->tipoAlerta . "',
	              confirmButtonText: 'Aceptar'
	            }).then(function(){
	              $('.FormularioAjax')[0].reset();
	            });
	            </script>
	        ";
    }
  }
  public function get_texto_limpio($texto)
  {
    $this->texto_limpio = trim($texto);
    $this->texto_limpio = stripslashes($texto);
    $this->texto_limpio = str_ireplace("<script>", "", $texto);
    $this->texto_limpio = str_ireplace("</script>", "", $texto);
    $this->texto_limpio = str_ireplace("<script src", "", $texto);
    $this->texto_limpio = str_ireplace("<script type=", "", $texto);
    $this->texto_limpio = str_ireplace("SELECT * FROM", "", $texto);
    $this->texto_limpio = str_ireplace("DELETE FROM", "", $texto);
    $this->texto_limpio = str_ireplace("INSERT INTO", "", $texto);
    $this->texto_limpio = str_ireplace("UPDATE", "", $texto);
    $this->texto_limpio = str_ireplace("http//", "", $texto);
    $this->texto_limpio = str_ireplace("https//", "", $texto);
    $this->texto_limpio = str_ireplace("<", "", $texto);
    $this->texto_limpio = str_ireplace("/>", "", $texto);
    $this->texto_limpio = str_ireplace("--", "", $texto);
    $this->texto_limpio = str_ireplace("^", "", $texto);
    $this->texto_limpio = str_ireplace("[", "", $texto);
    $this->texto_limpio = str_ireplace("]", "", $texto);
    $this->texto_limpio = str_ireplace("==", "", $texto);
    $this->texto_limpio = str_ireplace(";", "", $texto);
    return $this->texto_limpio;
  }
}

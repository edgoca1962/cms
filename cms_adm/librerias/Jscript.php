<?php
require_once "../librerias/NucleoLibreria.php";
$nucleo = new NucleoLibreria("Ajax");

/*
===========================================================
Todo esto es para el manejo de formularios.
Se capturan los campos del formulario incluidos archivos
(img, txt, pdf, xlxs, etc.) 
===========================================================
*/
$idSesion = "idSesion";
$id = $_POST["id_formulario"];
$boton = $_POST["id_boton"];
if ($id == "Ingreso") {
    $usuario = $_POST["loginUser"];
    $clave = $_POST["loginPassword"];
    $respuesta = ["tipo" => "2", "direccion" => "Inicio"];
} else {
    /* 
    Incluir esta rutina en el controlador Usuario
    para el registro de la nueva imagen que implica
    gurardar imagen en disco.
    
    $imgUsuarioNueva = $_POST["nuevoArchivo"];
    $imgUsuarioNuevaCortada = substr($imgUsuarioNueva, strpos($imgUsuarioNueva, ",") + 1);
    $imgUsuarioBase64 = base64_decode($imgUsuarioNuevaCortada);
    $imgUsuario = fopen('../vistas/img/usuarios/usr123456789.jpg', 'w');
    fwrite($imgUsuario, $imgUsuarioBase64);
    fclose($imgUsuario);
    */

    $respuesta = ["tipo" => "1", "mensaje" => "Crear procedimiento dinámico por controlador."];
}

/*
===========================================================
FIN DE PROCESAMIENTO DE FORMULARIOS 
Y MENSAJE TIPO 1,2 ó 3
===========================================================
 */


echo json_encode($respuesta);

/*
class Jscrip
{
    private $ingreso;
    private $parametros;
    private $usuario;
    private $id_usuario;
    private $sesion;
    private $respuesta;
    private $rutas;
    private $ruta_dominio;
    public function __construct($parametros = "")
    {
        switch ($parametros) {
            case 'frm_ingreso':
                $this->frm_ingreso();
                break;
            case 'cerrar_sesion':
                $this->cerrar_sesion();
                break;
            default:
                echo false;
                break;
        }
    }
    public function frm_ingreso()
    {
        $this->ingreso = new Ingreso;
        $this->parametros = ["usuario" => $_POST['usuario'], "clave" => $_POST['clave']];
        if ($this->ingreso->inicio($this->parametros)) {
            $this->respuesta = $this->ingreso->get_atributo("respuesta");
        } else {
            $this->respuesta = ["tipo" => 1, "mensaje" => "No se pudo crear una nueva sesión"];
        }
        $this->respuesta = json_encode($this->respuesta);
        echo $this->respuesta;
    }
    public function cerrar_sesion()
    {
        $this->usuario = new Usuario;
        if (isset($_POST['usuario'])) {
            $this->usuario->set_atributo("correo_usuario", $_POST['usuario']);
        }
        $this->usuario->get_usuario();
        $this->id_usuario = $this->usuario->get_atributo("id");
        $this->sesion = new Sesion;
        $this->sesion->set_atributo("id_usuario", $this->id_usuario);
        if ($this->sesion->cierra_sesion_ajax()) {
            $this->rutas = new Rutas;
            $this->ruta_dominio = $this->rutas->get_atributo("ruta_dominio");
            $this->respuesta = ["tipo" => 1, "direccion" => $this->ruta_dominio . "Ingreso"];
            $this->respuesta = json_encode($this->respuesta);
            echo $this->respuesta;
        } else {
            $this->respuesta = ["tipo" => 2, "mensaje" => "La sesión se encuentra cerrada."];
        }
    }
}
require_once "../librerias/NucleoLibreria.php";
$nucleo = new NucleoLibreria("Ajax");

if (isset($_POST["elemento"])) {
    $jscript = new Jscrip($_POST["elemento"]);
} else {
    if (isset($_POST['image'])) {
        // Falta proceso de registro con el nombre creado.
        $data = $_POST['image'];
        $image_array_1 = explode(";", $data);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        $image_path = '../vistas/img/usuarios/';
        $image_name = 'img_' . time() . '.png';
        file_put_contents($image_path . $image_name, $data);
        echo $image_name;
    }
    echo false;
}
*/
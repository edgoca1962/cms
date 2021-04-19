<?php
require_once "../librerias/NucleoLibreria.php";
$nucleo = new NucleoLibreria("Ajax");
$id = $_POST["id_formulario"];
$boton = $_POST["id_boton"];
$usuario = $_POST["loginUser"];
$clave = $_POST["loginPassword"];

$src = $_POST["src"];
if ($_FILES["archivo"]["name"] != "") {
    $img_nombre = $_FILES["archivo"]["name"];
    $img_tipo = $_FILES["archivo"]["type"];
    $img_tmp = $_FILES["archivo"]["tmp_name"];
    $img_error = $_FILES["archivo"]["error"];
    $img_tamano = $_FILES["archivo"]["size"];


    //Manejo de imagen
    // 1. Abrir la imagen creada temporalmente.
    // 2. Crear imagen destino
    // 3. Copiar origen en destino
    //    1-2 x-y desde donde copiar en el origen
    //    3-4 x-y destino
    //    5-6 x-y origen
    //    7-8 x-y ancho y alto destino
    //    9-10 x-y ancho y alto origen
    // 4. Exportar/guardar imagen modificada

    $origen = imagecreatefromjpeg($img_tmp);
    $anchoOrigenNatural = imagesx($origen);
    $altoOrigenNatural = imagesy($origen);
    //Mantener el ancho fijo y ajustar la altura manteniendo el ratio
    // $anchoDestino = 200;
    // $altoDestino = round($anchoDestino * $altoOrigenNatural / $anchoOrigenNatural);
    //Mantener el alto fijo y ajustar el ancho manteniendo el ratio
    $anchoDestino = round($altoDestino * $anchoDestino / $altoOrigenNatural);
    $altoDestino = 200;
    $destino = imagecreatetruecolor($anchoDestino, $altoDestino);
    $anchoOrigenDesde =  0;
    $altoOrigenDesde = 0;
    $anchoDestinoDesde =  0;
    $altoDestinoDesde = 0;
    $x = imagecopyresampled($destino, $origen, $anchoOrigenDesde, $altoOrigenDesde, $anchoDestinoDesde, $altoDestinoDesde, $anchoDestino, $altoDestino, $anchoOrigenNatural, $altoOrigenNatural);
    $carpetaDestino = "./" . $img_nombre;
    imagejpeg($destino, $carpetaDestino, 100);


    $respuesta = [
        "tipo" => "4",
        "carpetaDestino" => $carpetaDestino,
        "fuente" => $src
    ];
} else {
    $respuesta = ["tipo" => "1", "mensaje" => "Fuente elemento (src): $src"];
}

if ($id == "Ingreso") {
    $respuesta = ["tipo" => "2", "direccion" => "http://localhost/cms/cms_adm/Inicio"];
} else {
    $respuesta;
    /*$respuesta = ["tipo" => "1
    ", "mensaje" => "Formulario: $id, con imagen: $imagen, con dirección: $src, envió submit con el boton: $boton"];*/
}
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
<?php
class Ingreso extends IngresoModelo
{
   private $descripcion;
   private $palabras_claves;
   private $titulo;
   private $elementos;
   private $clave;
   private $usuario;
   private $sesion;
   private $correo_usuario;
   private $nombre_usuario;
   private $fecha_inicio;
   private $hora_inicio;
   private $estado_sesion;
   private $sesion_abierta;
   private $rutas;
   private $ruta_dominio;
   private $vista;
   private $respuesta;
   public function __construct()
   {
      $this->estado_sesion = 1;
      $this->sesion_abierta = false;
      $this->vista = get_class($this) . ".php";
   }
   public function inicio($parametros)
   {
      $this->get_datos_vista();
      if (!empty($parametros["usuario"]) || !empty($parametros["clave"])) {
         $this->correo_usuario = $parametros['usuario'];
         $this->correo_usuario = $this->get_texto_limpio($this->correo_usuario);
         $this->clave = $parametros['clave'];
         $this->clave = $this->get_texto_limpio($this->clave);
         $this->validar_credenciales();
         $this->conexion = null;
         return $this->respuesta;
      }
   }
   public function get_atributo($atributo)
   {
      return $this->$atributo;
   }
   public function set_atributo($atributo, $valor)
   {
      $this->$atributo = $valor;
   }
   public function get_datos_vista()
   {
      $this->elementos = new Elementos;
      $this->elementos->set_atributo("nombre_vista", get_class($this));
      if ($this->elementos->get_datos()) {
         $this->descripcion = $this->elementos->get_atributo("datos_elementos")[0]["descripcion"];
         $this->titulo = $this->elementos->get_atributo("datos_elementos")[0]["titulo"];
         $this->palabras_claves = $this->elementos->get_atributo("datos_elementos")[0]["palabras_claves"];
         $this->conexion = null;
         return true;
      } else {
         $this->conexion = null;
         return false;
      }
   }
   public function validar_credenciales()
   {
      $this->usuario = new Usuario;
      $this->usuario->set_atributo("correo_usuario", $this->correo_usuario);
      if ($this->usuario->get_usuario()) {
         if ($this->correo_usuario == $this->usuario->get_atributo('correo_usuario') && password_verify($this->clave, $this->usuario->get_atributo('clave'))) {
            $this->sesion = new Sesion;
            $this->sesion->set_atributo("id_usuario", $this->usuario->get_atributo("id"));
            if ($this->sesion->get_usuario_sesion()) {
               $this->respuesta = ["tipo" => 3, "mensaje" => "Este usuario tiene otra sesión abierta."];
            } else {
               session_start();
               session_regenerate_id();
               $this->sesion->set_atributo('id_usuario', $this->usuario->get_atributo('id'));
               $this->sesion->set_atributo('id_sesion', session_id());
               $this->sesion->set_atributo('estado_sesion', $this->estado_sesion);
               if ($this->sesion->set_datos_sesion()) {
                  $this->rutas = new Rutas;
                  if ($this->rutas->get_rutas()) {
                     $this->ruta_dominio = $this->rutas->get_atributo("ruta_dominio");
                     $this->respuesta = ["tipo" => 2, "direccion" => $this->ruta_dominio . "Inicio"];
                  } else {
                     $this->respuesta = ["tipo" => 1, "mensaje" => "No se encontró la ruta de dominio."];
                  }
               } else {
                  $this->respuesta = ["tipo" => 1, "mensaje" => "No se pudo crear una nueva sesión"];
               }
            }
         } else {
            $this->respuesta = ["tipo" => 1, "mensaje" => "La combinación ingresada de usuario y contraseña no se encuentra registrada."];
         }
      } else {
         $this->respuesta = ["tipo" => 1, "mensaje" => "La combinación ingresada de usuario y contraseña es incorrecta."];
      }
   }
}

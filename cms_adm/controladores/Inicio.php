<?php
class Inicio extends InicioModelo
{
   private $componente;
   private $palabras_claves;
   private $descripcion;
   private $titulo;
   private $datos_palabras_claves;
   private $datos_componentes;
   private $id_sesion;
   private $nombre_usuario;
   private $foto_usuario;
   private $elementos;
   private $rutas;
   private $ruta_dominio;
   private $sesion;
   private $vista;
   public function __construct()
   {
      parent::__construct();
      $this->vista = get_class($this) . ".php";
   }
   public function inicio($parametros)
   {
   }
   public function inicioOld($parametros)
   {
      $this->sesion->set_atributo("id_sesion", $this->id_sesion);
      if ($this->sesion->get_datos_sesion()) {
         if ($this->sesion->get_atributo("estado_sesion") == 0) {
            // $this->rutas = new Rutas;
            $this->ruta_dominio = $this->rutas->get_atributo("ruta_dominio");
            $this->conexion = null;
            header("Location: " . $this->ruta_dominio . "Ingreso");
            exit();
         } else {
            $this->nombre_usuario = $this->sesion->get_atributo("nombre_usuario");
            $this->tipo_usuario = $this->sesion->get_atributo("tipo_usuario");
            $this->foto_usuario = $this->sesion->get_atributo("foto_usuario");
            $this->get_componentes();
            $this->conexion = null;
         }
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
   public function get_componentes()
   {
      // $this->elementos = new Elementos;
      $this->elementos->set_atributo("nombre_vista", get_class($this));
      if ($this->elementos->get_datos()) {
         $this->descripcion = $this->elementos->get_atributo("datos_elementos")[0]["descripcion"];
         $this->titulo = $this->elementos->get_atributo("datos_elementos")[0]["titulo"];
         $this->datos_palabras_claves = $this->elementos->get_atributo("datos_elementos")[0]["palabras_claves"];
         return true;
      } else {
         return false;
      }
   }
}

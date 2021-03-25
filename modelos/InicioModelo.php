<?php
class InicioModelo extends BaseLibreria
{
   private $vista;
   private $componente;
   private $palabras_clave;
   private $descripcion;
   private $titulo;
   private $consultas;
   private $datos_consulta;

   protected function __construct()
   {
   }
   protected function get_atributo_modelo($atributo)
   {
      return $this->$atributo;
   }
   protected function set_atributo_modelo($atributo, $valor)
   {
      $this->$atributo = $valor;
   }
   protected function get_datos_modelo()
   {
   }
}

<?php
class Resize
{
   private $image;
   private $width;
   private $height;
   private $imageResized;
   private $fileName;
   private $nombreImagen;
   private $extension;
   private $nuevaImagen;
   private $imgPrefijo;

   private $vista;
   private $descripcion;
   private $titulo;
   private $palabras_claves;
   private $sesion;
   private $rutas;
   private $ruta_dominio;
   private $conexion;

   function __construct($parametros)
   {
      /*
      $this->fileName = $parametros[0];
      $this->image    = $this->openImage($this->fileName);
      $this->width    = imagesx($this->image);
      $this->height   = imagesy($this->image);
      $this->resizeImage(intval($parametros[1]), intval($parametros[2]), $parametros[3]);
      // $this->resizeImage(400, 400, "crop");

      $this->imageResized = imagecreatetruecolor(400, 400);
      imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, 400, 400, $this->width, $this->height);

      $this->saveImage(" ", 100);
      // imagejpeg($this->imageResized, 100);


      $this->nuevaImagen = $this->imgPrefijo . base64_encode(file_get_contents($this->fileName));

      // return $this->imageResized;

      $this->vista = "Pruebas.php";
      $this->descripcion = "Pruebas";
      $this->titulo = "Pruebas";
      $this->palabras_claves = "Pruebas";
      $this->sesion = new Sesion;
      $this->id_sesion = session_id();
      */
   }
   public function cortarCuadrado($parametros)
   {
      $this->fileName = $parametros[0];
      $this->imgPrefijo = "data:image/jpg;base64,";
      $this->image = imagecreatefromjpeg($this->fileName);
      $this->width    = imagesx($this->image);
      $this->height   = imagesy($this->image);
      $this->imageResized = imagecreatetruecolor(intval($parametros[1]), intval($parametros[2]));
      imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $parametros[1], $parametros[2], $this->width, $this->height);
      $this->nueImg = imagejpeg($this->imageResized, 100);

      $this->nuevaImagen = "prueba";
      // $this->nuevaImagen = $this->imgPrefijo . base64_encode(file_get_contents($this->fileName));
      // $this->nuevaImagen = "./vistas/img/prueba.jpg";
   }
   public function inicio()
   {
      /*
      $this->sesion->set_atributo("id_sesion", $this->id_sesion);
      if ($this->sesion->get_datos_sesion()) {
         if ($this->sesion->get_atributo("estado_sesion") == 0) {
            $this->rutas = new Rutas;
            $this->ruta_dominio = $this->rutas->get_atributo("ruta_dominio");
            $this->conexion = null;
            header("Location: " . $this->ruta_dominio . "Ingreso");
            exit();
         } else {
            $this->nombre_usuario = $this->sesion->get_atributo("nombre_usuario");
            $this->tipo_usuario = $this->sesion->get_atributo("tipo_usuario");
            $this->foto_usuario = $this->sesion->get_atributo("foto_usuario");
            $this->conexion = null;
         }
      }
      */
   }
   public function get_atributo($atributo)
   {
      return $this->$atributo;
   }
   public function set_atributo($atributo, $valor)
   {
      $this->$atributo = $valor;
   }

   private function openImage($file)
   {
      if (!is_file($file)) {
         throw new Exception("File {$file} doesn't exists");
      }

      // switch ($this->extension) {
      switch (pathinfo($file, PATHINFO_EXTENSION)) {
         case 'jpg':
         case 'jpeg':
            $this->imgPrefijo = "data:image/jpg;base64,";
            return imagecreatefromjpeg($file);
         case 'gif':
            $this->imgPrefijo = "data:image/gif;base64,";
            return imagecreatefromgif($file);
         case 'png':
            $this->imgPrefijo = "data:image/png;base64,";
            return imagecreatefrompng($file);
      }

      throw new Exception("Invalid image extension for {$file}. Acceptable image types are jpg,jpeg,gif,png");
   }

   public function resizeImage($newWidth, $newHeight, $option)
   {
      list($width, $height) = $this->getDimensions($newWidth, $newHeight, $option);

      $this->imageResized = imagecreatetruecolor($width, $height);
      imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $width, $height, $this->width, $this->height);

      if ($option == 'crop') {
         $this->crop($width, $height, $newWidth, $newHeight);
      }
   }

   private function getDimensions($width, $height, $option)
   {
      switch ($option) {
         case 'portrait':
            return array($this->getSizeByFixedHeight($height),  $height);
         case 'landscape':
            return array($width, $this->getSizeByFixedWidth($width));
         case 'auto':
            return $this->getSizeByAuto($width, $height);
         case 'crop':
            return $this->getOptimalCrop($width, $height);
         case 'exact':
         default:
            return array($width, $height);
      }
   }

   private function getSizeByFixedHeight($height)
   {
      return ($this->width / $this->height) * $height;
   }

   private function getSizeByFixedWidth($width)
   {
      return ($this->height / $this->width) * $width;
   }

   private function getSizeByAuto($width, $height)
   {
      if ($this->height < $this->width) {
         return array($width, $this->getSizeByFixedWidth($width));
      }

      if ($this->height > $this->width) {
         return array($this->getSizeByFixedHeight($height), $height);
      }

      if ($height < $width) {
         return array($width, $this->getSizeByFixedWidth($width));
      }

      if ($height > $width) {
         return array($this->getSizeByFixedHeight($height), $height);
      }

      return array($width, $height);
   }

   private function getOptimalCrop($width, $height)
   {
      $ratio = min($this->height / $height, $this->width /  $width);
      return array(
         $this->width  / $ratio,
         $this->height / $ratio
      );
   }

   private function crop($optimalWidth, $optimalHeight, $width, $height)
   {
      $x = ($optimalWidth  / 2) - ($width  / 2);
      $y = ($optimalHeight / 2) - ($height / 2);

      $crop = $this->imageResized;

      $this->imageResized = imagecreatetruecolor($width, $height);
      imagecopyresampled($this->imageResized, $crop, 0, 0, $x, $y, $width, $height, $width, $height);
   }

   public function saveImage($savePath, $imageQuality = "100")
   {
      switch (pathinfo($savePath, PATHINFO_EXTENSION)) {
         case 'jpg':
         case 'jpeg':
            if (imagetypes() & IMG_JPG) {
               // imagejpeg($this->imageResized, $savePath, $imageQuality);
               imagejpeg($this->imageResized, $imageQuality);
            }
            break;

         case 'gif':
            if (imagetypes() & IMG_GIF) {
               // imagegif($this->imageResized, $savePath);
               imagegif($this->imageResized);
            }
            break;

         case 'png':
            if (imagetypes() & IMG_PNG) {
               // Scale quality from 0-100 to 0-9
               // Invert quality setting as 0 is best, not 9
               $invertScaleQuality = 9 - round(($imageQuality / 100) * 9);
               // imagepng($this->imageResized, $savePath, $invertScaleQuality);
               imagepng($this->imageResized, $invertScaleQuality);
            }
            break;
      }

      imagedestroy($this->imageResized);
   }
}

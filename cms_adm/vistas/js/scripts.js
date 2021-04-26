/*Rutina para el trasiego de información al MVC */
const form = document.querySelector(".needs-validation");
let srcEncoded;
if (form) {
  ["click", "submit"].forEach((type) => {
    form.addEventListener(type, (e) => {
      const idFrm = form.getAttribute("id");
      const idBtn = e.target.getAttribute("id");
      if (e.target.getAttribute("type") == "submit") {
        e.preventDefault();
        if (!form.checkValidity()) {
          e.stopPropagation();
        } else {
          const datos = new FormData(form);
          datos.append("id_formulario", idFrm);
          datos.append("id_boton", idBtn);
          datos.append("nuevoArchivo", srcEncoded);
          fetch("./librerias/Jscript.php", {
            method: "POST",
            body: datos,
          })
            .then((response) => response.json())
            .then((data) => {
              switch (data.tipo) {
                case "1":
                  console.log(data.mensaje);
                  break;
                case "2":
                  window.location.href = data.direccion;
                  break;
                case "3":
                  Swal.fire({
                    icon: "error",
                    title: "Datos incorrectos",
                    text: data.mensaje,
                    confirmButtonText:
                      '<i class="far fa-frown" style="font-size:2rem"></i>',
                  });
                  break;
                default:
                  break;
              }
            })
            .catch((error) => {
              console.error("Error:", error);
            });
        }
        form.classList.add("was-validated");
      }
    });
  });
}
/*Rutina para marcar la opción de menu seleccionada */
const menu = document.getElementById("menu");
if (menu) {
  const opciones = document.querySelector(".nav").querySelectorAll("a");
  const opcionSeleccionada = location.href;
  for (let i = 0; i < opciones.length; i++) {
    opciones[i].classList.remove("active");
    opciones[i].classList.remove("menu-open");
    if (opciones[i].href === opcionSeleccionada) {
      opciones[i].classList.add("active");
      const menuOpcion = opciones[i].parentElement.parentElement.parentElement;
      menuOpcion.classList.add("menu-open");
      const menuActivado = menuOpcion.children[0];
      menuActivado.classList.add("active");
    }
  }
}
/*
Captura imagen de usuario por medio de drag y 
sombreado de campo en drag and drop y dispositivos móbiles. 
*/
const imagenOverlay = document.getElementById("imagenOverlay");
if (imagenOverlay) {
  ["dragenter", "dragover"].forEach((type) => {
    imagenOverlay.addEventListener(type, (e) => {
      e.preventDefault();
      imagenOverlay.classList.add("dragOver");
    });
  });
  ["dragleave", "dragend"].forEach((type) => {
    imagenOverlay.addEventListener(type, (e) => {
      imagenOverlay.classList.remove("dragOver");
    });
  });
  imagenOverlay.addEventListener("drop", (e) => {
    e.preventDefault();
    imagenOverlay.classList.remove("dragOver");
    const archivo = e.dataTransfer.files[0];
    const imgDimension = archivo.size;
    if (parseInt(imgDimension) <= 20000000) {
      cambiarDimensionImgUsr(archivo);
    } else {
      Swal.fire({
        icon: "error",
        title: "Datos incorrectos",
        text: "El archivo NO puede ser superior a los 2MB.",
        confirmButtonText:
          '<i class="far fa-frown" style="font-size:2rem"></i>',
      });
    }
  });
  imagenOverlay.addEventListener("touchstart", () => {
    imagenOverlay.classList.add("imgOverMobile");
  });
  imagenOverlay.addEventListener("touchend", () => {
    imagenOverlay.classList.remove("imgOverMobile");
  });
}
/* Captura imagen de usuario por medio de click*/
const archivoInput = document.getElementById("archivo");
if (archivoInput) {
  archivoInput.addEventListener("change", (e) => {
    const datosImg = new FormData(form);
    const imgDimension = datosImg.get("archivo").size;
    const archivo = datosImg.get("archivo");
    if (parseInt(imgDimension) <= 20000000) {
      cambiarDimensionImgUsr(archivo);
    } else {
      Swal.fire({
        icon: "error",
        title: "Datos incorrectos",
        text: "El archivo NO puede ser superior a los 2MB.",
        confirmButtonText:
          '<i class="far fa-frown" style="font-size:2rem"></i>',
      });
    }
  });
}
function cambiarDimensionImgUsr(archivo) {
  const imgTipo = archivo.type;
  const MAX_WIDTH = 400;
  const lector = new FileReader();
  lector.readAsDataURL(archivo);
  lector.onload = function (evento) {
    const imagen = new Image();
    imagen.src = evento.target.result;
    imagen.onload = function (element) {
      const canva = document.createElement("canvas");
      let sx, sy, sw, sh;
      const dx = 0;
      const dy = 0;
      if (element.target.width < element.target.height) {
        ratio = MAX_WIDTH / element.target.height;
        canva.width = MAX_WIDTH;
        canva.height = element.target.height * ratio;
        sx = 0;
        sy = element.target.height / 2 - element.target.width / 2;
        sw = element.target.width;
        sh = element.target.width;
      } else if (element.target.width > element.target.height) {
        ratio = MAX_WIDTH / element.target.width;
        canva.width = element.target.width * ratio;
        canva.height = MAX_WIDTH;
        sx = element.target.width / 2 - element.target.height / 2;
        sy = 0;
        sw = element.target.height;
        sh = element.target.height;
      } else {
        sx = 0;
        sy = 0;
        sw = element.target.width;
        sh = element.target.height;
        canva.width = MAX_WIDTH;
        canva.height = MAX_WIDTH;
      }
      const ctx = canva.getContext("2d");
      ctx.drawImage(
        element.target,
        sx,
        sy,
        sw,
        sh,
        dx,
        dy,
        canva.width,
        canva.height
      );
      srcEncoded = ctx.canvas.toDataURL(element.target, imgTipo, 1.0);
      document.getElementById("imagen").src = srcEncoded;
    };
  };
}

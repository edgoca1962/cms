/*Rutina para el trasiego de información al MVC */
var form = document.querySelector(".needs-validation");
if (form) {
  form.addEventListener("submit", validarEjecutar, false);
  form.addEventListener("click", validarEjecutar, false);
  function validarEjecutar(e) {
    var idFrm = form.getAttribute("id");
    var idBtn = e.target.getAttribute("id");
    if (e.target.getAttribute("type") == "submit") {
      e.preventDefault();
      if (!form.checkValidity()) {
        e.stopPropagation();
      } else {
        var datos = new FormData(form);
        datos.append("id_formulario", idFrm);
        datos.append("id_boton", idBtn);
        datos.append("nuevoArchivo", srcEncodedExport);
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
  }
}
/*Rutina para marcar la opción de menu seleccionada */
var menu = document.getElementById("menu");
if (menu) {
  var opciones = document.querySelector(".nav").querySelectorAll("a");
  var opcionSeleccionada = location.href;
  for (let i = 0; i < opciones.length; i++) {
    opciones[i].classList.remove("active");
    opciones[i].classList.remove("menu-open");
    if (opciones[i].href === opcionSeleccionada) {
      opciones[i].classList.add("active");
      var menuOpcion = opciones[i].parentElement.parentElement.parentElement;
      menuOpcion.classList.add("menu-open");
      var menuActivado = menuOpcion.children[0];
      menuActivado.classList.add("active");
    }
  }
}
/*Rutina para el sombreado de campo en dispositivos móbiles. */
var imagenOverlay = document.getElementById("imagenOverlay");
if (imagenOverlay) {
  imagenOverlay.addEventListener("touchstart", () => {
    imagenOverlay.classList.add("imgOverMobile");
  });
  imagenOverlay.addEventListener("touchend", () => {
    imagenOverlay.classList.remove("imgOverMobile");
  });
}
/* Rutina para el manejo de la imágen de Usuario */
var archivo = document.getElementById("archivo");
var srcEncoded, srcEncodedExport;
if (archivo) {
  var fuenteImagen = document.getElementById("imagen");
  archivo.addEventListener("change", (e) => {
    var imagen = document.getElementById("imagen");
    var frmData = new FormData(form);
    if (parseInt(frmData.get("archivo").size) <= 2000000) {
      var archivo = frmData.get("archivo");
      var tipoArchivo = frmData.get("type");
      var fuente = fuenteImagen.getAttribute("src");
      var src = URL.createObjectURL(archivo);
      if (archivo.name == "") {
        imagen.setAttribute("src", fuente);
      } else {
        let reader = new FileReader();
        reader.readAsDataURL(archivo);
        reader.onload = function (event) {
          let imgElement = document.createElement("img");
          imgElement.src = event.target.result;
          imgElement.onload = function (e) {
            let canvas = document.createElement("canvas");
            let MAX_WIDTH = 400;
            let ctx = canvas.getContext("2d");
            var sx, sy, sw, sh, dx, dy, dw, dh;
            if (e.target.height == e.target.width) {
              sx = 0;
              sy = 0;
              sw = e.target.width;
              sh = e.target.height;
              canvas.width = MAX_WIDTH;
              canvas.height = MAX_WIDTH;
              dw = MAX_WIDTH;
              dh = MAX_WIDTH;
            } else {
              if (e.target.height > e.target.width) {
                sx = e.target.width / 8;
                anchoAlto = e.target.width - 2 * sx;
                sy = e.target.height / 2 - anchoAlto / 2;
                sw = anchoAlto;
                sh = anchoAlto;
                canvas.width = MAX_WIDTH;
                canvas.height = e.target.height * (MAX_WIDTH / e.target.height);
                dw = MAX_WIDTH;
                dh = e.target.height * (MAX_WIDTH / e.target.height);
              } else {
                sy = e.target.height / 8;
                anchoAlto = e.target.height - 2 * sy;
                sx = e.target.width / 2 - anchoAlto / 2;
                sw = anchoAlto;
                sh = anchoAlto;
                canvas.width = e.target.width * (MAX_WIDTH / e.target.width);
                canvas.height = MAX_WIDTH;
                dw = MAX_WIDTH;
                dh = e.target.width * (MAX_WIDTH / e.target.width);
              }
            }
            dx = 0;
            dy = 0;
            ctx.drawImage(e.target, sx, sy, sw, sh, dx, dy, dw, dh);
            srcEncoded = ctx.canvas.toDataURL(e.target, tipoArchivo);
            document.querySelector("#imagen").src = srcEncoded;
            srcEncodedExport = ctx.canvas.toDataURL().split(",")[1];
          };
        };
      }
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

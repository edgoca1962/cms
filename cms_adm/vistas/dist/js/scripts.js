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
        var src = document.getElementById("imagen");
        if (src) {
          var fuente = src.getAttribute("src");
          datos.append("src", fuente);
        }
        // console.log(datos.get("archivo"));
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
                });
                break;
              case "4":
                console.log("Carpeta:", data.carpetaDestino);
                /*
                console.log(
                  "Nombre",
                  data.img_nombre,
                  "Tipo",
                  data.img_tipo,
                  "tmp_name",
                  data.img_tmp,
                  "Error",
                  data.img_error,
                  "Tamaño",
                  data.img_tamano
                );
                */
                console.log(data.fuente);
                break;
              default:
                console.log(data.mensaje);
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
var imagenOverlay = document.getElementById("imagenOverlay");
if (imagenOverlay) {
  imagenOverlay.addEventListener("touchstart", () => {
    imagenOverlay.classList.add("imgOverMobile");
  });
  imagenOverlay.addEventListener("touchend", () => {
    imagenOverlay.classList.remove("imgOverMobile");
  });
}

var archivo = document.getElementById("archivo");
if (archivo) {
  var fuenteImagen = document.getElementById("imagen");
  archivo.addEventListener("change", (e) => {
    var imagen = document.getElementById("imagen");
    var frmData = new FormData(form);
    var archivo = frmData.get("archivo");
    var fuente = fuenteImagen.getAttribute("src");
    var src = URL.createObjectURL(archivo);

    console.log("Alto: ", src);
    if (archivo.name == "") {
      imagen.setAttribute("src", fuente);
    } else {
      imagen.setAttribute("src", src);
    }
  });
}
/*
var canvas, ctx;
var canvas = document.getElementById("canvas");
if (canvas) {
  ctx = canvas.getContext("2d");
  canvas.width = 400;
  canvas.height = 400;
  let imgObj = new Image();
  imgObj.onload = function () {
    let nw = imgObj.naturalWidth;
    let nh = imgObj.naturalHeight;
    // let aspect = nw / nh;
    // let w = canvas.width;
    // let h = canvas.width / aspect;
    let ratio = Math.min(nw / 400, nh / 400);
    let w = nw / ratio;
    let h = nh / ratio;
    console.log("ancho: ", w, "altura: ", h, nw, nh, "ratio: ", ratio);
    canvas.height = h;

    let sx = nw / 4;
    let sy = nh / 4;
    let sw = nw / 2;
    let sh = nh / 2;
    console.log(sx, sy, sw, sh);
    let dx = 0;
    let dy = 0;
    let dw = w;
    let dh = h;
    // ctx.drawImage(imgObj, 0, 0, w, h);
    ctx.drawImage(imgObj, sx, sy, sw, sh, dx, dy, dw, dh);
  };
  imgObj.src = "./vistas/dist/img/prueba_original.jpg";
}
*/

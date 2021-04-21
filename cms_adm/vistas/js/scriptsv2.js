class Comportamiento_vistas {
  validar_campos() {
    const forms = document.querySelectorAll(".needs-validation");
    Array.prototype.slice.call(forms).forEach((form) => {
      form.addEventListener(
        "submit",
        (event) => {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add("was-validated");
        },
        false
      );
    });
  }
  activar_opciones() {
    const opciones = document.querySelector(".nav").querySelectorAll("a");
    const opcionSeleccionada = location.href;

    for (let i = 0; i < opciones.length; i++) {
      opciones[i].classList.remove("active");
      opciones[i].classList.remove("menu-open");
      if (opciones[i].href === opcionSeleccionada) {
        opciones[i].classList.add("active");
        const menuOpcion =
          opciones[i].parentElement.parentElement.parentElement;
        menuOpcion.classList.add("menu-open");
        const menuActivado = menuOpcion.children[0];
        menuActivado.classList.add("active");
      }
    }
  }
}
class Formularios {
  enviar_dato() {
    const formulario = document.querySelector("form");
    formulario.addEventListener("submit", function (e) {
      e.preventDefault();
      const datos = new FormData(formulario);
      fetch("./librerias/Jscrip.php", {
        method: "POST",
        body: datos,
      })
        .then(function (response) {
          return response.text();
        })
        .then(function (text) {
          console.log(text);
        })
        .catch(function (error) {
          console.log(error);
        });
    });
  }
}

// const comportamientos = new Comportamiento_vistas();
// comportamientos.validar_campos();
// comportamientos.activar_opciones();

const form = new Formularios();
form.enviar_dato();

/*
      fetch("../librerias/Jscrip.php", {
        method: "POST",
        body: formDatos,
      })
        .then(function (response) {
          return response;
        })
        .then(function (text) {
          console.log(text);
        })
        .catch(function (error) {
          console.error(error);
        });
      });
    */

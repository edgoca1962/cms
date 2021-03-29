class comportamiento_vistas {
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
        const menuOpcion = opciones[i].parentNode.parentNode.parentNode;
        menuOpcion.classList.add("menu-open");
        const menuActivado = menuOpcion.children[0];
        menuActivado.classList.add("active");
      }
    }
  }
}
const comportamientos = new comportamiento_vistas();
comportamientos.validar_campos();
comportamientos.activar_opciones();

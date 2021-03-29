// Example starter JavaScript for disabling form submissions if there are invalid fields
// Fetch all the forms we want to apply custom Bootstrap validation styles to
const forms = document.querySelectorAll(".needs-validation");

// Loop over them and prevent submission
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

function activaOpcion() {
  $(".nav .nav-item a").click(function (e) {
    // e.preventDefault();
    $("a").removeClass("active");
    $(this).addClass("active");
  });
}

// $(document).ready(function () {
//   $("nav ul li a").click(function () {
//     $(this).addClass("active").siblings().removeClass("active");
//   });
// });

/*
  var enlaceactivoinicial = $('.nav-treeview li a[href="Inicio"]');
  enlaceactivoinicial.removeClass("active");
  var menuprincipalinicial = $(enlaceactivoinicial).parents(".has-treeview");
  menuprincipalinicial.removeClass("menu-open");
  menuprincipalinicial.children("a").removeClass("active");

  var controlador = window.location.pathname.split("/").pop();
  var enlace = $('.nav-treeview li a[href="' + controlador + '"]');
  enlace.addClass("active");
  var menuprincipal = $(enlace).parents(".has-treeview");
  menuprincipal.addClass("menu-open");
  menuprincipal.children("a").addClass("active");
  */

// console.log($(enlace).parentsUntil(".nav-pills"));
// console.log($(enlace).parents(".has-treeview")[0]);

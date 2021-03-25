$(document).ready(function () {
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
});
// console.log($(enlace).parentsUntil(".nav-pills"));
// console.log($(enlace).parents(".has-treeview")[0]);
//   $(".nav-treeview li a").click(function () {
//     $(this).addClass("active").siblings().removeClass("active");
//   });

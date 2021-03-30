$(document).ready(function () {
  /*«««««««««««««««««««««««« * »»»»»»»»»»»»»»»»»»»»»»»»
   Cierre automático de sesión.
   ««««««««««««««««««««««««-»»»»»»»»»»»»»»»»»»»»»»»»*/
  if ($("#frm_ingreso").length == 0) {
    $("body").css("background-image", "url('')");
    var timoutWarning = 300000;
    var timoutNow = 330000;
    var warningTimer;
    var timeoutTimer;
    // Start timers.
    function StartTimers() {
      warningTimer = setTimeout(() => {
        Swal.fire({
          icon: "warning",
          title: "La sesión expirará en 30 segundos por inactividad.",
          showConfirmButton: false,
          timer: 5000,
        });
      }, timoutWarning);
      timeoutTimer = setTimeout(() => {
        // Logout the user.
        let datos = $("#frm_ingreso").serializeArray();
        datos.push({ name: "elemento", value: "cerrar_sesion" });
        $.ajax({
          type: "post",
          url: "./controladores/Jscript.php",
          data: datos,
          dataType: "json",
          success: function (respuesta) {
            if (respuesta.tipo == 1) {
              window.location.href = respuesta.direccion;
            }
          },
          error: function () {
            console.log("No se recibió una respuesta válida del servidor.");
          },
        });
      }, timoutNow);
    }
    // Reset timers.
    function ResetTimers() {
      console.log("reset");
      clearTimeout(warningTimer);
      clearTimeout(timeoutTimer);
      if ($("#frm_ingreso").length == 0) {
        StartTimers();
      }
    }
    /*---Code ends for checking if no activity, then display an alert on web page ----*/
    $(document).ready(function () {
      StartTimers();
      $(document).on("mousemove", function () {
        ResetTimers();
      });
    });
  } else {
    $("body").css({
      height: "100%",
      opacity: "0.8",
      "background-image": "url('./vistas/img/generales/fondo01.png')",
      "background-repeat": "no-repeat",
      "background-position": "center",
      "background-attachment": "fixed",
      "background-size": "cover",
    });
  }
  /*«««««««««««««««««««««««« * »»»»»»»»»»»»»»»»»»»»»»»»
    Formulario Ingreso - Usuario y Contraseña
   ««««««««««««««««««««««««-»»»»»»»»»»»»»»»»»»»»»»»»*/
  $("#frm_ingreso").submit(function (e) {
    e.preventDefault();
    let datos = $(this).serializeArray();
    datos.push({ name: "elemento", value: "frm_ingreso" });
    $.ajax({
      type: "post",
      url: "./controladores/Jscript.php",
      data: datos,
      dataType: "json",
      success: function (respuesta) {
        switch (respuesta.tipo) {
          case 2:
            window.location.href = respuesta.direccion;
            break;
          case 3:
            Swal.fire({
              title: "¿Desea cerrarla?",
              text: respuesta.mensaje,
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Sí, cerrar sesión!",
            }).then((result) => {
              if (result.isConfirmed) {
                let datos = $("#frm_ingreso").serializeArray();
                datos.push({ name: "elemento", value: "cerrar_sesion" });
                $.ajax({
                  type: "post",
                  url: "./controladores/Jscript.php",
                  data: datos,
                  dataType: "json",
                  success: function (respuesta) {
                    Swal.fire(
                      "Sesión Cerrada!",
                      "La sesión se cerró satisfactoriamente.",
                      "success"
                    );
                    window.location.href = respuesta.direccion;
                  },
                  error: function () {
                    console.log(
                      "No se recibió una respuesta válida del servidor."
                    );
                  },
                });
              }
            });

            break;
          default:
            Swal.fire("Alerta", respuesta.mensaje, "warning");
            break;
        }
      },
      error: function () {
        console.log("No se recibió una respuesta válida del servidor.");
      },
    });
  });
  /*«««««««««««««««««««««««« * »»»»»»»»»»»»»»»»»»»»»»»»
    Captura y ajusta imagen (crop)
   ««««««««««««««««««««««««-»»»»»»»»»»»»»»»»»»»»»»»»*/
  var $modal = $("#modal");
  var image = document.getElementById("sample_image");
  var cropper;
  $("#upload_image").change(function (event) {
    var files = event.target.files;
    var done = function (url) {
      image.src = url;
      $modal.modal("show");
    };
    if (files && files.length > 0) {
      reader = new FileReader();
      reader.onload = function (event) {
        done(reader.result);
      };
      reader.readAsDataURL(files[0]);
    }
  });
  $modal
    .on("shown.bs.modal", function () {
      cropper = new Cropper(image, {
        aspectRatio: 1,
        viewMode: 3,
        preview: ".preview",
      });
    })
    .on("hidden.bs.modal", function () {
      cropper.destroy();
      cropper = null;
    });
  $("#crop").click(function () {
    canvas = cropper.getCroppedCanvas({
      width: 400,
      height: 400,
    });
    canvas.toBlob(function (blob) {
      url = URL.createObjectURL(blob);
      var reader = new FileReader();
      reader.readAsDataURL(blob);
      reader.onloadend = function () {
        var base64data = reader.result;
        $.ajax({
          url: "./controladores/Jscript.php",
          method: "POST",
          data: {
            image: base64data,
          },
          success: function (data) {
            var image_path = "vistas/img/usuarios/";
            $modal.modal("hide");
            $("#uploaded_image").attr("src", image_path + data);
          },
        });
      };
    });
  });
  /*«««««««««««««««««««««««« * »»»»»»»»»»»»»»»»»»»»»»»»
    Formulario Usuario
   ««««««««««««««««««««««««-»»»»»»»»»»»»»»»»»»»»»»»»*/
  var foto_usuario;
  $("#foto_usuario").change(function () {
    foto_usuario = this.files[0];
    console.log(foto_usuario);
  });
  $("#frm_usuario").submit(function (e) {
    e.preventDefault();
    let datos = $(this).serializeArray();
    datos.push({ name: "elemento", value: "frm_usuario" });
    datos.push({ datos_imagen: foto_usuario });
  });
  /*«««««««««««««««««««««««« * »»»»»»»»»»»»»»»»»»»»»»»»
   Manejo de menues
   ««««««««««««««««««««««««-»»»»»»»»»»»»»»»»»»»»»»»»*/
  $(".nav-item").click(function () {
    console.log(this);
  });
  /*«««««««««««««««««««««««« * »»»»»»»»»»»»»»»»»»»»»»»»
   Gráfico de Ingresos y Egresos
   ««««««««««««««««««««««««-»»»»»»»»»»»»»»»»»»»»»»»»*/
  if ($("#ingresos-egresos").length != 0) {
    new Chart($("#ingresos-egresos"), {
      type: "line",
      data: {
        labels: [
          "Ene",
          "Feb",
          "Mar",
          "Abr",
          "May",
          "Jun",
          "Jul",
          "Ago",
          "Set",
          "Oct",
        ],
        datasets: [
          {
            label: "Ingresos",
            fill: true,
            lineTension: 0.1,
            borderColor: "rgba(75,192,192,0.4)",
            backgroundColor: "rgba(75,192,192,0.5)",
            borderCapStyle: "butt",
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: "miter",
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,0.6)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: [65, 69, 59, 80, 81, 56, 55, 40, 45, 63],
          },
          {
            label: "Egresos",
            fill: true,
            lineTension: 0.1,
            borderColor: "rgba(208,5,42,0.2)",
            backgroundColor: "rgba(208,5,42,0.6)",
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: "miter",
            pointBorderColor: "rgba(208,5,42,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(208,5,42,0.5)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: [55, 65, 49, 75, 77, 53, 65, 48, 43, 57],
          },
        ],
      },
      options: {
        responsive: true,
        scales: {
          yAxes: [
            {
              ticks: {
                min: 0,
              },
            },
          ],
        },
      },
    });
  }
  /*«««««««««««««««««««««««« * »»»»»»»»»»»»»»»»»»»»»»»»
   Gráfico de Egresos por tipo de rubro
   ««««««««««««««««««««««««-»»»»»»»»»»»»»»»»»»»»»»»»*/

  if ($("#egresos-rubro").length != 0) {
    new Chart($("#egresos-rubro"), {
      type: "doughnut",
      data: {
        labels: ["Alquiler", "Salarios", "Acción Social"],
        datasets: [
          {
            label: "My First Dataset",
            data: [300, 50, 100],
            backgroundColor: [
              "rgb(255, 99, 132)",
              "rgb(54, 162, 235)",
              "rgb(255, 205, 86)",
            ],
          },
        ],
      },
    });
  }
});

<div class="total" style="height:100%; background-image: url('vistas/dist/img/fondo02.jpg'); background-repeat:no-repeat; background-size: cover; background-position:center; background-attachment:fixed;">
   <div class="contenido-ingreso">
      <form action="Inicio" method="POST" class="ingreso campos">
         <img src="vistas/dist/img/generico.png" alt="">
         <h2>Ingreso</h2>
         <div class="input-group">
            <input type="text" name="loginUser" id="loginUser" required>
            <label for="loginUser">Usuario</label>
         </div>
         <div class="input-group">
            <input type="password" name="loginPassword" id="loginPassword" required>
            <label for="loginPassword">Contraseña</label>
         </div>
         <div class="input-group justify-content-center">
            <button type="submit" class="btn btn-primary">Ingresar</button>
         </div>
         <div class="input-group m-3">
            <a href="#olvidarclave" class="olvidarclave">¿Olvidé la contraseña?</a>
         </div>
      </form>
   </div>
   <div class="color-overlay"></div>
</div>
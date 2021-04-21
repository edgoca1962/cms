<form id="Usuario" class="campos needs-validation" novalidate>
   <div class="card-body">
      <div class="row justify-content-between">
         <div class="col-lg-3">
            <div class="input-group">
               <input type="text" name="nombre" id="nombre" required autofocus>
               <label for="nombre">Nombre de Usuario</label>
               <div class="invalid-feedback">El nombre no puede quedar en blanco</div>
            </div>
         </div>
         <div class="col-lg-3">
            <div class="input-group">
               <input type="text" name="apellido1" id="apellido1" required>
               <label for="apellido1">Primer Apellido</label>
               <div class="invalid-feedback">El apellido no puede quedar en blanco</div>
            </div>
         </div>
         <div class="col-lg-3">
            <div class="input-group">
               <input type="text" name="apellido2" id="apellido2" required>
               <label for="apellido2">Segundo Apellido</label>
               <div class="invalid-feedback">El segundo apellido no puede quedar en blanco</div>
            </div>
         </div>
      </div>
      <div class="editarImagen" id="editarImagen">
         <img src="./vistas/img/usuarios/generico.png" alt="Imágen de Usuario" name="imagen" class="img-thumbnail rounded-circle" id="imagen">
         <div class="imagenOverlay" id="imagenOverlay">
            <input type="file" name="archivo" class="capturaArchivo" id="archivo" accept=".jpg, .jpeg, .png">
            <label for="archivo" id="labelEditar"><i class="fas fa-pen-square"></i></label>
         </div>
      </div>
   </div>
   <div class="card-footer text-muted">
      <div class="btn-group mr-2" role="group" aria-label="Basic example">
         <div class="input-group mr-2">
            <button type="submit" id="Registrar" class="btn btn-primary">Registrar</button>
         </div>
         <div class="input-group mr-2">
            <button type="submit" id="Modificar" class="btn btn-primary">Modificar</button>
         </div>
         <div class="input-group mr-2">
            <button type="submit" id="Eliminar" class="btn btn-danger">Eliminar</button>
         </div>
      </div>
   </div>
</form>
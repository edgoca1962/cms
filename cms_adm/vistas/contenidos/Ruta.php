<div class="editarImagen">
   <img src="./vistas/dist/img/user1-128x128.jpg" alt="Imágen de Usuario" name="imagen" class="img-thumbnail rounded-circle">
   <label for="imagen" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-pen-square"></i></label>
   <!-- Modal -->
   <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Editar imágen de usuario</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-8 mx-auto d-block">
                     <div class=" editarImagenModal">
                        <img src="./vistas/dist/img/user1-128x128.jpg" alt="Imágen de Usuario" name="imagen" class="img-thumbnail rounded-circle" id="imagen">
                     </div>
                  </div>
                  <div class="col-4 d-flex align-items-center justify-content-center">
                     <input type="file" name="archivo" class="editarImagen" id="archivo">
                     <button type="button" class="btn btn-primary btn-sm"><label for="archivo">Cargar imágen</i></label>
                     </button>
                  </div>

               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
               <button type="button" class="btn btn-primary">Actualizar imagen</button>
            </div>
         </div>
      </div>
   </div>
</div>
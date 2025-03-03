<!-- Modal -->
<div class="modal fade" id="ProdModal" tabindex="-1" aria-labelledby="ProdModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="ProdModalLabel">Agregar Producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="Front/ogani/nuevoProducto.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" id='id' name="id">
                    <!-- Producto -->
                    <div class="mb-3">
                        <label for="producto" class="form-label">Producto</label>
                        <input type="text" id="producto" name="producto" class="form-control" required>
                    </div>
                    <!-- Precio -->
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="number" min="1" id="precio" name="precio" class="form-control" required>
                    </div>
                    <!-- Categorias -->
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categorias</label>
                        <select name="categoria" id="categoria" class="form-select" required>

                        <?php while ($row_Categoria = $categoria->fetch_assoc()) { ?>
                                <option value="<?php echo $row_Categoria["cat_id"]; ?>"> <?= $row_Categoria["cat_nombre"] ?> </option>
                            <?php }
                            ?>
                        </select>
                    </div>
                    <!-- Descripcion -->
                    <div class="mb-3" class="form-label">
                        <label for="descripcion">Descripcion: </label>
                        <textarea type="text" id="descripcion" name="descripcion" class="form-control"> </textarea>
                    </div>

                    <!-- imagenes -->
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen</label>
                        <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*">
                    </div>

                    <div class="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>

                </form>


            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
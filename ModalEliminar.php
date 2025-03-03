<!-- Modal -->
<div class="modal fade" id="EliminarModal" tabindex="-1" aria-labelledby="EliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="EliminarModalLabel">Aviso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                La baja del producto es logica.
                ¿Desea Eliminar el Registro?
            </div>

            <div class="modal-footer">
                <form action="funciones/eliminar.php" method="POST">
                    <input type="hidden" id="id" name="id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>